<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarbonFootprint;
use App\Models\CarbonReport;
use App\Models\CarbonSolution;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Log;



class CarbonFootprintController extends Controller
{
    public function index()
    {
        return view ('carbon_footprint');
    }

    public function getCarbonData(Request $request)
    {
        // Get the current user's role_id
        $roleId = auth()->user()->role_id;
    
        // Define the fields to select
        $columns = ['campus', 'category', 'month', 'quarter', 'year', 'prev_reading', 'total_amount'];
    
        // Start the query builder
        $query = null;
    
        // Check the role_id and adjust the query accordingly
        if ($roleId == 5) {
            $query = DB::table('water_consumption')
                ->select($columns)
                ->union(
                    DB::table('electricity')
                        ->select($columns)
                )
                ->union(
                    DB::table('solid_waste')
                        ->select($columns)
                );
        } elseif ($roleId == 6) {
            $query = DB::table('fuel_consumption')->select($columns);
        }
    
        // If no query is applicable (e.g., invalid role_id), return an empty response
        if (is_null($query)) {
            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ]);
        }
    
        // Wrap the combined query for further operations
        $query = DB::table(DB::raw("({$query->toSql()}) as combined_data"))->mergeBindings($query);
    
        // Get total records (before filtering)
        $totalData = $query->count();
        $totalFiltered = $totalData;
    
        // Apply search filter if provided
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('campus', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }
    
        // Apply pagination
        $start = intval($request->input('start', 0)); // Default to 0
        $length = intval($request->input('length', 10)); // Default to 10
        $query->offset($start)->limit($length);
    
        // Fetch data
        $data = $query->get();
    
        // Build JSON response
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }

    public function getCarbonDataAll(Request $request, $table = null)
    {
        // Valid tables to prevent SQL injection
        $validTables = ['water_consumption', 'electricity', 'solid_waste', 'fuel_consumption'];
    
        // Default table or validate the table parameter
        if ($table && !in_array($table, $validTables)) {
            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ]);
        }
    
        // Set the table based on the parameter or default to fetching all tables
        $columns = ['campus', 'category', 'month', 'quarter', 'year', 'prev_reading', 'total_amount'];
        if ($table) {
            $query = DB::table($table)->select($columns);
        } else {
            $query = DB::table('water_consumption')
                ->select($columns)
                ->union(
                    DB::table('electricity')->select($columns)
                )
                ->union(
                    DB::table('solid_waste')->select($columns)
                )
                ->union(
                    DB::table('fuel_consumption')->select($columns)
                );
        }
    
        // Total records and filtering logic remains unchanged
        $totalData = $query->count();
        $totalFiltered = $totalData;
    
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('campus', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }
    
        $start = intval($request->input('start', 0));
        $length = intval($request->input('length', 10));
        $query->offset($start)->limit($length);
    
        $data = $query->get();
    
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }

    public function sdg_index() 
    {
        return view('carbon_footprint_all');
    }

    public function calculator_index() 
    {
        return view('carbon_footprint_calculator');
    }


    public function getCarbonAllData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $query = CarbonFootprint::with(['user'])
                                ->join('users', 'carbon_footprints.user_id', '=', 'users.id');

        $orderColumnMapping = [
            0 => 'carbon_footprints.id',
            1 => 'users.lastname',
            2 => 'carbon_footprints.carbon_type',
            3 => 'carbon_footprints.description',
        ];

        $searchableColumnsMapping = [
            0 => 'carbon_footprints.id',
            1 => DB::raw('CONCAT(users.lastname, " ", users.firstname)'),
            2 => 'carbon_footprints.carbon_type',
            3 => 'carbon_footprints.description',
        ];

        $query->orderBy($orderColumnMapping[$orderColumn], $orderDir);
        
        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($query) use ($searchableColumnsMapping, $search) {
                foreach ($searchableColumnsMapping as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        $recordsTotal = $query->count();

        $dataQuery = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($dataQuery as $value) {
       
            $data[] = [
                'id' => $value->id,
                'carbon_type' => $value->carbon_type,
                'description' => $value->description,
                'attachment' => $value->attachment,
                'uploaded_by' => $value->user->firstname . " " . $value->user->lastname,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $data,
        ];

        return response()->json($response);
    }

    public function calculate(Request $request) 
    {
        try {
            set_time_limit(300);
            $data = [
                [
                    'calculated_carbon_footprint' => '',
                    'solutions' => [
                        [
                            'title' => 'water',
                            'description' => '',
                        ],
                        [
                            'title' => 'fuel',
                            'description' => '',
                        ],
                        [
                            'title' => 'waste',
                            'description' => '',
                        ]
                    ],
                    'comment' => '',
                ]
            ];

            $calculate = [];
            if($request->fuel) {
                $calculate['Category: Fuel Value'] = $request->fuel;
                $calculate['Fuel Type'] = $request->fuel_type;
                $calculate['Fuel Unit'] = $request->fuel_unit;
            }
            if($request->electricity) {
                $calculate['Category: Electricty  Value'] = $request->electricity;
                $calculate['Electricty Unit'] = $request->electricity_unit;
            }
            if($request->water) {
                $calculate['Category: Water  Value'] = $request->water;
                $calculate['Water Unit'] = $request->water_unit;
            }
            if($request->waste) {
                $calculate['Category: Waste  Value'] = $request->waste;
                $calculate['Waste Unit'] = $request->waste_unit;
            }
            $messages = [
                [
                    'role' => 'user',
                    'content' => "You are in a campus. You have Sustainable Development Goals in a university." .
                                    "Data to Fill: " . json_encode($data , JSON_PRETTY_PRINT) .
                                    "To Calculate: "  . json_encode($calculate , JSON_PRETTY_PRINT) .
                                    "Using values from the To Calculate array, create a carbon footprint calculator and provide possible solutions for the SDG." . 
                                    "On the data to fill, fill up the data; the calculated value should go to calculated_carbon_footprint, and the possible solutions should go to the nested solutions." .
                                    "Then provide 4 solutions for each category THE CATEGORIES CAN BE LOOKED AT THE TO CALCULATE VALUES. Put them all into nested solutions. Provide a title and description" .
                                    "ONLY PROVIDE A SOLUTION ON THE ONES THAT I SENT YOU!, IF IT IS WATER, THEN RETURN 4 WATER SOLUTIONS, IF IT IS WASTE, THEN RETURN 4 WASTE SOLUTIONS, IF IT IS ELECTRICITY, THEN RETURN 4 ELECTRICITY SOLUTIONS, IF IT IS FUEL, THEN RETURN 4 FUEL SOLUTIONS, ".
                                    "DO NOT RETURN ANY SOLUTIONS IF YOU DID NOT SEE THE CATEGORY INCLUDED IN THE 'TO CALCULATE'".
                                    "STRICTLY PROVIDE SOLUTIONS ON THE DATA AND CATEGORIES THAT I HAVE SENT YOU! 4 solutions for each category".
                                    "IF I HAVE 1 CATEGORY PRESENT, I AM EXPECTING 4 SOLUTIONS".
                                    "IF I HAVE 2 CATEGORIES PRESENT, I AM EXPECTING 8 SOLUTIONS 4 EACH".
                                    "IF I HAVE 3 CATEGORIES PRESENT, I AM EXPECTING 12 SOLUTIONS  4 EACH".
                                    "IF I HAVE 4 CATEGORIES PRESENT, I AM EXPECTING 16 SOLUTIONS  4 EACH".
                                    "YOU WILL CALCULATE ALL AND PUT IT IN THE calculated_carbon_footprint, THEN ALL THE SOLUTIONS GENERATED, PUT THEM IN THE NESTED ARRAY OF SOLUTIONS".               
                                    "PROVIDE A COMMENT ON HOW DID YOU COME UP WITH IT AND WHAT CATEGORIES HAVE NUMERICAL VALUES. MAKE SURE ALL THE CATEGORIES INCLUDED WITH NUMERICAL VALUES ARE ADDED TO CALCULATION! THE VALUES WILL BE ON THE CATEGORY: <TYPE OF CATEGORY> AND MAKE SURE YOU HAVE THE CORRECT VALUES OF SOLUTIONS but only describe in the comments on how you come up with it and the solutions. Make it a detailed computation with all the variables".
                                    "I NOTICED THAT SOME CATEGORIES ARE BEING NEGLECTED. ENSURE YOU ARE READING THE TO CALCULATE CAREFULLY AND 4 SOLUTIONS EACH CATEGORIES. I SAID 4 EACH! 4 SOLUTIONS ON EVERY PRESENT CATEGORIES! I ALSO NOTICED WHEN I TRIED 4 CATEGORIES, YOU ONLY RETURN 12 INSTEAD OF 16".
                                    "LOOK CAREFULLY FROM THE TO CALCULATE CATEGORIES ARRAY!! AND MAKE SURE THAT ALL CATEGORIES PRESENT HAVE 4 SOLUTIONS EACH. Also summarize in the comments the 4 solutions you come up in each categories present. MOSTLY THE ELECTRICITY IS BEING NEGLECTED EVEN IF IT HAS SOME VALUE.".
                                    "RETURN THE VALUE OF DATA TO FILL AND FILL IT UP! NO OTHER MESSAGES NEEDED ALSO INCLUDE THE UNIT OF THE CARBON FOOTPRINT AND MAKE SURE TO CALCULATE IT PROPERLY. I NOTICED DIFFERENT RESULTS WITH SAME VALUES EVERYTIME I TRIED IT"
                                    
                ]
            ];

            $response =  $this->connectToOpenAi($messages);
            $body = json_decode($response->getBody(), true);
            $content = $body['choices'][0]['message']['content'] ?? 'No response from OpenAI';
            $cleanContent = preg_replace('/^```json\n|\n```$/', '', $content);
            $decodedContent = json_decode($cleanContent, true);
            return view('components.solutions',compact('decodedContent'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function connectToOpenAi($messages) 
    {
        $client = new Client();
        $apiKey = env('OPENAPI_API_KEY');

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o-mini',  
                'messages' => $messages,
                'max_tokens' => 8000, 
                'temperature' => 0.7 
            ],
        ]);

        return $response;
    }

    public function carbonCreateReport(Request $request)
    {
        $validatedData = $request->validate([
            'report_title' => 'required|string|max:255'
        ]);
        try {

            $filePath = null;
            if ($request->hasFile('file')) {
                $filename = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('files', $filename, 'public');
            }
            
            $carbonReport = CarbonReport::create([
                'report_title' => $request->report_title,
                'supporting_document' => $request->filePath,
                'calculated_data' => $request->calculated_data,
                'comment' => $request->comment,
                'fuel_value' => $request->fuel,
                'fuel_type' => $request->fuel_type,
                'fuel_unit' => $request->fuel_unit,
                'water_value' => $request->water,
                'water_unit' => $request->water_unit,
                'electricity_value' => $request->electricity,
                'electricity_unit' => $request->electricity_unit,
                'waste_value' => $request->waste,
                'waste_unit' => $request->waste_unit
            ]);

            $titles = $request->input('title'); 
            $descriptions = $request->input('desription'); 
        
            foreach ($titles as $index => $title) {
                CarbonSolution::create([
                    'carbon_report_id' => $carbonReport->id,
                    'title' => $title,
                    'description' => $descriptions[$index], 
                ]);
            }

            return response()->json(['success' => 'Carbon Report Created Successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addWater(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'campus' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'prev_reading' => 'required|string|max:255',
            'current_reading' => 'required|string|max:255',
            'consumption_cubic' => 'required|string|max:255',
            'consumption_liter' => 'required|string|max:255',
            'total_amount' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'quarter' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'semi_annually' => 'nullable|string|max:255',
            'annually' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Insert data into the database
        DB::insert('INSERT INTO water_consumption (
            campus, date, category, prev_reading, current_reading,
            consumption_cubic, consumption_liter, total_amount, price, month, quarter, year,
            semi_annually, annually, remarks
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('campus'),
            $request->input('date'),
            $request->input('category'),
            $request->input('prev_reading'),
            $request->input('current_reading'),
            $request->input('consumption_cubic'),
            $request->input('consumption_liter'),
            $request->input('total_amount'),
            $request->input('price'),
            $request->input('month'),
            $request->input('quarter'),
            $request->input('year'),
            $request->input('semi_annually'),
            $request->input('annually'),
            $request->input('remarks'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Water consumption record inserted successfully!');
    }

    public function addSolidWaste(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'campus' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'prev_reading' => 'required|string|max:255',
            'total_amount' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'waste_type' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'remarks' => 'nullable|string',
            'annually' => 'nullable|string|max:255',
            'semi_annually' => 'nullable|string|max:255',
            'quarter' => 'nullable|string|max:255',
        ]);

        // Insert data into the database
        DB::insert(
            'INSERT INTO solid_waste (campus, category, prev_reading, total_amount, month, year, waste_type, quantity, remarks, annually, semi_annually, quarter) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->input('campus'),
                $request->input('category'),
                $request->input('prev_reading'),
                $request->input('total_amount'),
                $request->input('month'),
                $request->input('year'),
                $request->input('waste_type'),
                $request->input('quantity'),
                $request->input('remarks'),
                $request->input('annually'),
                $request->input('semi_annually'),
                $request->input('quarter'),
            ]
        );

        // Redirect back with success message
        return redirect()->back()->with('success', 'Solid waste record inserted successfully!');
    }

    public function addElectricity(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'campus' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'month' => 'nullable|string|max:255',
            'quarter' => 'nullable|string|max:255',
            'annually' => 'nullable|string|max:255',
            'semi_annually' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:255',
            'prev_reading' => 'nullable|string|max:255',
            'current_reading' => 'nullable|string|max:255',
            'consumption' => 'nullable|string|max:255',
            'multiplier' => 'nullable|string|max:255',
            'total_consumption' => 'nullable|string|max:255',
            'total_amount' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Insert data into the database
        DB::insert(
            'INSERT INTO electricity 
            (campus, category, month, quarter, annually, semi_annually, year, prev_reading, current_reading, consumption, multiplier, total_consumption, total_amount, price, remarks) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
            [
                $request->campus,
                $request->category,
                $request->month,
                $request->quarter,
                $request->annually,
                $request->semi_annually,
                $request->year,
                $request->prev_reading,
                $request->current_reading,
                $request->consumption,
                $request->multiplier,
                $request->total_consumption,
                $request->total_amount,
                $request->price,
                $request->remarks
            ]
        );

        // Redirect back with success message
        return redirect()->back()->with('success', 'Electricity record inserted successfully!');
    }
    
    public function addFuel(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'campus' => 'nullable|string|max:255',
            'date' => 'nullable|string|max:255',
            'driver' => 'nullable|string|max:255',
            'vehicle' => 'nullable|string|max:255',
            'plate_no' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'item_description' => 'nullable|string|max:255',
            'transaction_no' => 'nullable|string|max:255',
            'odometer' => 'nullable|string|max:255',
            'quantity' => 'nullable|string|max:255',
            'total_amount' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'month' => 'nullable|string|max:255',
            'prev_reading' => 'nullable|string|max:255',
            'quarter' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:255',
            'annually' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'semi_annually' => 'nullable|string|max:255',
        ]);

        // Insert data into the database
        DB::insert(
            'INSERT INTO fuel_consumption 
            (campus, date, driver, vehicle, plate_no, category, fuel_type, item_description, transaction_no, odometer, quantity, total_amount, price, month, prev_reading, quarter, year, annually, remarks, semi_annually) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
            [
                $request->campus,
                $request->date,
                $request->driver,
                $request->vehicle,
                $request->plate_no,
                $request->category,
                $request->fuel_type,
                $request->item_description,
                $request->transaction_no,
                $request->odometer,
                $request->quantity,
                $request->total_amount,
                $request->price,
                $request->month,
                $request->prev_reading,
                $request->quarter,
                $request->year,
                $request->annually,
                $request->remarks,
                $request->semi_annually,
            ]
        );

        // Redirect back with success message
        return redirect()->back()->with('success', 'Fuel consumption record inserted successfully!');
    }
}
