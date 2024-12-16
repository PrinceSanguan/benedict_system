<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>'Please fill out allthe fields']);   
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
        
            if ($validator->fails()) {
                return $this->exceptionError('Not a proper email format');
            }

            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                return $this->userNotFoundError('Email does not exist');
            }

            $loginSuccess = Auth::attempt($credentials);

            if ($loginSuccess) {
                return response()->json(['success' => true]);   
            }

            return response()->json(['error' => 'Invalid credentials'], 200);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
 
    private function userNotFoundError($message)
    {
        return response()->json(['error' => $message], 200);
    }

    private function exceptionError($message)
    {
        return response()->json(['error' => $message], 200);
    }
    
    public function change_password(Request $request) 
    {
        try {
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string',
                'confirm_password' => 'required|string',
            ]);
    
            
            $user = User::findOrFail(Auth::user()->id);
            if (Hash::check($request->current_password, $user->password)) {
                if($request->new_password === $request->confirm_password){
                    $user->password = $request->new_password;
                    $user->save();
                    
                    return response()->json(['message' => 'Password Change Successfully'], 200);
                } else {
                    return response()->json(['errors' => 'Password and Confirm Password Does not match!'], 200);
                }
            } else {
                return response()->json(['errors' => 'Incorrect Current Password'], 200);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 200);
        }

    }
}
