<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Announcement;
use App\Models\CarbonFootprint;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $events = Event::all();
        if(Auth::user()->role_id == 1){
            $announcement = Announcement::count();
            $carbon_footprint = CarbonFootprint::count();
            return view('dashboard', 
                compact(
                    'users','announcement','carbon_footprint','events'
                )
            );
        } else {
            $announcements = Announcement::with('user')->latest('id')->get();

            return view('dashboard', 
                compact(
                    'users','announcements','events'
                )
            );
        }
    
        
    }
}
