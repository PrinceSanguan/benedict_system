<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SdgReport;
use App\Models\CarbonReport;
use App\Models\CarbonSolution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports');
    }

    public function sdgReport(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir','desc');

        $query = SdgReport::orderBy('id','desc');

        $orderColumnMapping = [
            0 => 'id',
            1 => 'created_at',
            2 => 'currentMonthName',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            1 => 'created_at',
            2 => 'currentMonthName',
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
                'created_at' =>  \Carbon\Carbon::parse($value->created_at)->format('F d, Y'),
                'currentMonthName' => $value->currentMonthName
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

    public function carbonReport(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir','desc');

        $query = CarbonReport::orderBy('id','desc');

        $orderColumnMapping = [
            0 => 'id',
            1 => 'created_at',
            2 => 'report_title',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            1 => 'created_at',
            2 => 'report_title',
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
                'created_at' =>  \Carbon\Carbon::parse($value->created_at)->format('F d, Y'),
                'report_title' => $value->report_title,
                'supportng_document' => $value->supportng_document
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

    public function sdgReportView($report_id) 
    {
        $sdgReport = SdgReport::find($report_id);

        if (!$sdgReport) {
            return response()->json(['message' => 'Report not found'], 404);
        }
        $department = json_decode($sdgReport->department, true);
        $topSdgCourse = json_decode($sdgReport->topSdgCourse, true);
        $leastFiveSdgs = json_decode($sdgReport->leastFiveSdgs, true);
        $sdgResults = json_decode($sdgReport->sdgResults, true);

        return view('sdg_report_view',compact('sdgReport','topSdgCourse','leastFiveSdgs','sdgResults','department'));
    }

    public function sdgCarbonView($report_id) 
    {
        $carbonReport = CarbonReport::find($report_id);

        if (!$carbonReport) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $carbonSolution = CarbonSolution::where('carbon_report_id',$carbonReport->id)->get();

        return view('carbon_report_view',compact('carbonReport','carbonSolution'));
    }


}
