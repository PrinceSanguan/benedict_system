<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index() 
    {
        return view('announcement');
    }

    public function getAnnouncementData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $query = Announcement::with(['user']);

        $orderColumnMapping = [
            0 => 'id',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            1 => 'subject',
            2 => 'details',
            3 => 'status',
            4 => 'created_at',
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
                'subject' => $value->subject,
                'details' => $value->details,
                'status' => $value->status,
                'created_at' => $value->created_at->format('F d, Y'),
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
            'subject' => 'required|string|max:255',
            'details' => 'required|string|max:4055',
            'status' => 'required|max:255',
        ]);
        try {

            $announcement = Announcement::create([
                'subject' => $request->subject,
                'details' => $request->details,
                'status' =>  $request->status,
                'submitted_by' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'Announcement published successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
