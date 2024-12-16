<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index() 
    {
        return view('event');
    }

    public function getData(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $query = Event::orderBy('id','desc');

        $orderColumnMapping = [
            0 => 'id',
            2 => 'title',
            3 => 'information',
            4 => 'date',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            2 => 'title',
            3 => 'information',
            4 => 'date',
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
                'photo' => $value->photo,
                'information' => $value->information,
                'attachment' => $value->attachment,
                'date' => $value->date
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
            'information' => 'required|max:4055',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|string|max:255',
        ]);
        try {

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

            $course = Event::create([
                'title' => $request->title,
                'information' =>  $request->information,
                'date' =>  $request->date,
                'photo' =>  $filePath,
                'attachment' => $filePath2,
                'user_id' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'Event Created Successfully'], 201);
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
}
