<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\SdgCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function index() 
    {
        $sdg_criterias = SdgCriteria::all();
        $role_id = Auth::user()->role_id;
        return view('feedback',compact('sdg_criterias','role_id'));
    }

    public function getData(Request $request) 
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir','desc');

        $query = Feedback::with(['user'])
                        ->join('users', 'feedbacks.user_id', '=', 'users.id')
                        ->select(
                            'feedbacks.id',
                            'feedbacks.sdg',
                            'feedbacks.details',
                            'feedbacks.created_At',
                            'users.firstname',
                            'users.lastname',

                        );


        if(Auth::user()->role_id != 2) {
            $query->where('user_id', Auth::user()->id);
        }
        $orderColumnMapping = [
            0 => 'feedbacks.id',
            1 => 'sdg',
            2 => 'details',
        ];

        $searchableColumnsMapping = [
            0 => 'feedbacks.id',
            1 => 'sdg',
            2 => 'details',
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
                'sdg' => $value->sdg,
                'details' => $value->details,
                'user' => $value->firstname . " " . $value->lastname,
                'created_at' =>  \Carbon\Carbon::parse($value->created_at)->format('F d, Y'),
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
            'sdg' => 'required|string|max:255',
            'details' => 'required|max:4055',
        ]);
        try {

            $feedback = Feedback::create([
                'sdg' => $request->sdg,
                'details' =>  $request->details,
                'user_id' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Feedback Submitted Successfully'], 201);
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
