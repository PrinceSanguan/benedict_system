<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Project;
use App\Models\SdgReport;
use App\Models\SdgCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Log;
use Carbon\Carbon;

class AnalyticController extends Controller
{
    public function index() 
    {
        $topSdgCourse = DB::table(
                    DB::raw("(
                        SELECT sdg_approved, COUNT(*) as occurrence_count
                        FROM courses
                        WHERE sdg_approved IS NOT NULL
                        GROUP BY sdg_approved
                        
                        UNION ALL
                        
                        SELECT sdg_approved, COUNT(*) as occurrence_count
                        FROM projects
                        WHERE sdg_approved IS NOT NULL
                        GROUP BY sdg_approved
                    ) as combined")
                )
                ->select('sdg_approved', DB::raw('SUM(occurrence_count) as total_count'))
                ->groupBy('sdg_approved')
                ->orderByDesc('total_count')
                ->take(5)
                ->get();

        $department = [];
        $ICTCC = Course::where('department','ICTC')->where('status','2')->count();
        $ICTP = Project::where('department', 'ICTC')->where('status','2')->count();
        $totalICT= $ICTCC + $ICTP;
        $department['ICTC'] =  $totalICT;

        $CICSC = Course::where('department','CICS')->where('status','2')->count();
        $CICSP = Project::where('department', 'CICS')->where('status','2')->count();
        $totalCICS= $CICSC + $CICSP;
        $department['CICS'] =  $totalCICS;

        $CABEIGHMC = Course::where('department','CABEIGHM')->where('status','2')->count();
        $CABEIGHMP = Project::where('department', 'CABEIGHM')->where('status','2')->count();
        $totalCABEIGHM= $CABEIGHMC + $CABEIGHMP;
        $department['CABEIGHM'] =  $totalCABEIGHM;

        $CASC = Course::where('department','CAS')->where('status','2')->count();
        $CASP = Project::where('department', 'CAS')->where('status','2')->count();
        $totalCASP= $CASC + $CASP;
        $department['CAS'] =  $totalCASP;

        $CTEC = Course::where('department','CTE')->where('status','2')->count();
        $CTEP = Project::where('department', 'CTE')->where('status','2')->count();
        $totalCTE= $CTEC + $CTEP;
        $department['CTE'] =  $totalCTE;

        $sdgCriteria = SdgCriteria::all()->mapWithKeys(function ($item) {
            return [
                $item->title => [
                    'header_detail_1' => $item->header_detail_1,
                    'detail_1' => $item->detail_1,
                    'header_detail_2' => $item->header_detail_2,
                    'detail_2' => $item->detail_2,
                    'header_detail_3' => $item->header_detail_3,
                    'detail_3' => $item->detail_3,
                ],
            ];
        })->toArray();
        
        $allSdgs = DB::table(
            DB::raw("(
                SELECT sdg_approved, COUNT(*) as occurrence_count
                FROM courses
                WHERE sdg_approved IS NOT NULL
                GROUP BY sdg_approved
                
                UNION ALL
                
                SELECT sdg_approved, COUNT(*) as occurrence_count
                FROM projects
                WHERE sdg_approved IS NOT NULL
                GROUP BY sdg_approved
            ) as combined")
        )
        ->select('sdg_approved', DB::raw('SUM(occurrence_count) as total_count'))
        ->groupBy('sdg_approved')
        ->get();
        
        $leastSdgDetails = [];
        
        foreach ($sdgCriteria as $sdgTitle => $criteriaDetails) {
            $occurrence = $allSdgs->firstWhere('sdg_approved', $sdgTitle);
            $count = $occurrence ? $occurrence->total_count : 0; 
        
            $leastSdgDetails[] = [
                'title' => $sdgTitle,
                'details' => $criteriaDetails,
                'count' => $count,
            ];
        }
        
        usort($leastSdgDetails, function ($a, $b) {
            return $a['count'] <=> $b['count']; 
        });

        $leastFiveSdgs = array_slice($leastSdgDetails, 0, 4);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Get the first and last day of the current month
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $sdgResults = DB::table(
            DB::raw("(
                SELECT sdg_approved, COUNT(*) as occurrence_count
                FROM courses
                WHERE sdg_approved IS NOT NULL
                AND DATE(date_start) <= '$endOfMonth'  -- Events that start before the end of the month
                AND DATE(date_end) >= '$startOfMonth'  -- Events that end after the start of the month
                GROUP BY sdg_approved
                
                UNION ALL
                
                SELECT sdg_approved, COUNT(*) as occurrence_count
                FROM projects
                WHERE sdg_approved IS NOT NULL
                AND DATE(date_start) <= '$endOfMonth'  -- Events that start before the end of the month
                AND DATE(date_end) >= '$startOfMonth'  -- Events that end after the start of the month
                GROUP BY sdg_approved
            ) as combined")
        )
        ->select('sdg_approved', DB::raw('SUM(occurrence_count) as total_count'))
        ->groupBy('sdg_approved')
        ->orderByDesc('total_count')
        ->get();
        
        $currentMonthName = Carbon::now()->format('F');
            

        return view('sdg', compact('topSdgCourse','department','leastFiveSdgs', 'sdgResults','currentMonthName'));
    }

    public function generateSdgReport(Request $request)
    {
        
        $data = $request->validate([
            'topSdgCourse' => 'required|array',
            'department' => 'required|array',
            'leastFiveSdgs' => 'required|array',
            'sdgResults' => 'required|array',
            'currentMonthName' => 'required|string',
        ]);
        Log::info('Generating SDG report with data: ', $data);

        try {
            Log::info('Generating SDG report with data: ', $data);
    
            $sdg = SdgReport::create([
                'topSdgCourse' => json_encode($request->topSdgCourse), 
                'department' => json_encode($request->department),
                'leastFiveSdgs' => json_encode($request->leastFiveSdgs),
                'sdgResults' => json_encode($request->sdgResults), 
                'currentMonthName' => $request->currentMonthName,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Report generated successfully!',
                'data' => $sdg 
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to generate SDG report: ' . $e->getMessage(), [
                'data' => $data 
            ]);
    
            // Return an error response to the client
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report. Please try again later.',
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function carbon_index()
    {
        $fuelData = DB::table('carbon_reports')
            ->select('id', 'report_title', 'fuel_value', 'fuel_unit', 'fuel_type', 'created_at')
            ->whereNotNull('fuel_value')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $waterData = DB::table('carbon_reports')
            ->select('id', 'report_title', 'water_value', 'water_unit', 'created_at')
            ->whereNotNull('water_value')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $electricityData = DB::table('carbon_reports')
            ->select('id', 'report_title', 'electricity_value', 'electricity_unit', 'created_at')
            ->whereNotNull('electricity_value')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $wasteData = DB::table('carbon_reports')
            ->select('id', 'report_title', 'waste_value', 'waste_unit', 'created_at')
            ->whereNotNull('waste_value')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            $fuelData = DB::table('carbon_reports')
            ->select('id', 'report_title', DB::raw('COALESCE(fuel_value, 0) as fuel_value'), 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    
        $waterData = DB::table('carbon_reports')
            ->select('id', 'report_title', DB::raw('COALESCE(water_value, 0) as water_value'), 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    
        $electricityData = DB::table('carbon_reports')
            ->select('id', 'report_title', DB::raw('COALESCE(electricity_value, 0) as electricity_value'), 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    
        $wasteData = DB::table('carbon_reports')
            ->select('id', 'report_title', DB::raw('COALESCE(waste_value, 0) as waste_value'), 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $carbonData = DB::table('carbon_reports')
            ->select('created_at', 
                DB::raw('COALESCE(fuel_value, 0) as fuel_value'),
                DB::raw('COALESCE(water_value, 0) as water_value'),
                DB::raw('COALESCE(electricity_value, 0) as electricity_value'),
                DB::raw('COALESCE(waste_value, 0) as waste_value'))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('carbon' , compact('fuelData', 'waterData', 'electricityData', 'wasteData','fuelData', 'waterData', 'electricityData', 'wasteData', 'carbonData'));
    }

}
