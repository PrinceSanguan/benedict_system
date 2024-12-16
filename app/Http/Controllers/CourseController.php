<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\SdgCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\CarbonFootprintController;

class CourseController extends Controller
{
    protected $cfc;

    public function __construct(CarbonFootprintController $cfc)
    {
        $this->cfc = $cfc;
    }

    public function index() 
    {
        return view('course');
    }

    public function sec_index() 
    {
        return view('sec_course');
    }

    public function getData(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $query = Course::orderBy('id','desc');

        $orderColumnMapping = [
            0 => 'id',
            2 => 'title',
            3 => 'project_manager',
            4 => 'department',
            5 => 'event_information',
            6 => 'status',
            7 => 'sdg_approved',
            8 => 'date_start',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            2 => 'title',
            3 => 'project_manager',
            4 => 'department',
            5 => 'event_information',
            6 => 'status',
            7 => 'sdg_approved',
            8 => 'date_start',
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
            $dateStart = Carbon::parse($value->date_start)->format('F d, Y');
            $dateEnd = Carbon::parse($value->date_end)->format('F d, Y');
            $dateRange = $dateStart . " - " . $dateEnd;
            $data[] = [
                'id' => $value->id,
                'title' => $value->title,
                'project_manager' => $value->project_manager,
                'department' => $value->department,
                'photo' => $value->photo,
                'event_information' => $value->event_information,
                'attachment' => $value->attachment,
                'status' => $value->status,
                'sdg_approved' => $value->sdg_approved,
                'date' => $dateRange,
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

    public function getSecData(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir','desc');

        $query = Course::where('status', 0);

        $orderColumnMapping = [
            0 => 'id',
            1 => 'title',
            2 => 'project_manager',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            1 => 'title',
            2 => 'project_manager',
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
                'title' => $value->title,
                'project_manager' => $value->project_manager,
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

    public function getSecProcessedData(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $query = Course::where('status', '!=', 0);

        $orderColumnMapping = [
            0 => 'id',
            1 => 'title',
            2 => 'project_manager',
            3 => 'status',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            1 => 'title',
            2 => 'project_manager',
            3 => 'status',
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
                'title' => $value->title,
                'project_manager' => $value->project_manager,
                'status' => $value->status,
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

    public function create(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'project_manager' => 'required|string|max:255',
            'event_information' => 'required|max:4055',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_start' => 'required|string|max:255',
            'date_end' => 'required|string|max:255',
        ]);
        try {

            set_time_limit(300);
            $criteria = SdgCriteria::all();
            
            $data = [
                'sdg_id' => '',
                'comment' => ''
            ];

            $messages = [
                [
                    'role' => 'user',
                    'content' => "You are in a campus. You have Sustainable Development Goals in a university." .
                                    "Request: "  . json_encode($request->toArray() , JSON_PRETTY_PRINT) .
                                    "Data TO Fill: " . json_encode($data , JSON_PRETTY_PRINT) .
                                    "SDG Criteria: " . json_encode($criteria , JSON_PRETTY_PRINT) .
                                    "Based on the title and event information coming from the 'REQUEST', ".
                                    "I want you to select the exact, if not the exact atleast the closest SDG Title from the SDG Criteria i gave you,".
                                    "Also I want you to fill up the comment part on how you come up with the sdg choice you made. make it reasonable and logical.".
                                    "Fill Up The Data To Fill and return it to me as is. no other message needed. just the array"         
                ]
            ];

            $response =  $this->cfc->connectToOpenAi($messages);
            $body = json_decode($response->getBody(), true);
            $content = $body['choices'][0]['message']['content'] ?? 'No response from OpenAI';
            $cleanContent = preg_replace('/^```json\n|\n```$/', '', $content);
            $decodedContent = json_decode($cleanContent, true);

            $sdg_criteria_id = $decodedContent['sdg_id'];
            $comment = $decodedContent['comment'];

            $filePath = null;
            if ($request->hasFile('file')) {
                $filename = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('images', $filename, 'public');
            }

            $filePath2 = null;
            if ($request->hasFile('file2')) {
                $filename2 = Str::uuid() . '.' . $request->file('file2')->getClientOriginalExtension();
                $filePath2 = $request->file('file2')->storeAs('uploads', $filename2, 'public');
            }

            $sdg_criteria = SdgCriteria::find($sdg_criteria_id);
            $sdg_name = $sdg_criteria->title;
            $course = Course::create([
                'title' => $request->title,
                'project_manager' => $request->project_manager,
                'event_information' =>  $request->event_information,
                'date_start' =>  $request->date_start,
                'date_end' =>  $request->date_end,
                'photo' =>  $filePath,
                'sdg_name' => $sdg_name,
                'comment' => $comment,
                'department' => $request->department,
                'attachment' => $filePath2,
                'status' =>  0,
                'uploaded_by' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'SDG Course Created Successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCourseById($row_id)
    {
        try {
            $course = Course::find($row_id);
            $sdg_criteria = SdgCriteria::all();
            if ($course) {
                return view('modals.view_course_request', compact('course','sdg_criteria'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }   
    }

    public function getProcessedCourseById($row_id)
    {
        try {
            $course = Course::find($row_id);
            if ($course) {
                return view('modals.view_course_processed', compact('course'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }   
    }
    
    public function approve($row_id,$sdg_approved) 
    {
        $data = Course::find($row_id);
        if($data) {
            $data->status = 2;
            $data->sdg_approved = $sdg_approved;
            $data->save();
            return response()->json(['success' => 'Course approved successfully'], 204);
        }
        return response()->json(['error' => 'Failed to reject course'], 204);
    }

    public function reject($row_id) 
    {
        $data = Course::find($row_id);
        if($data) {
            $data->status = 1;
            $data->save();
            return response()->json(['success' => 'Course approved successfully'], 204);
        }
        return response()->json(['error' => 'Failed to reject course'], 204);
    }
}
