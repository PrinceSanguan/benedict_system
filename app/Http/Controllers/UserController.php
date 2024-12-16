<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() 
    {
        return view('user');
    }

    public function getUserData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $query = User::where('role_id','!=',1)->orderBy('id','desc');

        $orderColumnMapping = [
            0 => 'id',
            1 => 'lastname',
            2 => 'email',
            3 => 'role_id',
        ];

        $searchableColumnsMapping = [
            0 => 'id',
            1 => 'firstname',
            2 => 'lastname',
            3 => 'email',
        ];

        $query->orderBy($orderColumnMapping[$orderColumn], $orderDir);

        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($query2) use ($searchableColumnsMapping, $search) {
                foreach ($searchableColumnsMapping as $column) {
                    $query2->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        $recordsTotal = $query->count();

        $dataQuery = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($dataQuery as $value) {
            $data[] = [
                'id' => $value->id,
                'name' => $value->lastname . ", " . $value->firstname ,
                'email' => $value->email,
                'role_id' => $value->role_id,
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'role_id' => 'required',
        ]);

        try {
            $user = User::create([
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'role_id' => $validatedData['role_id'],
                'password' => '123',
            ]);

            return response()->json(['success' => 'Created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
