<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClubManagerController extends Controller
{
    public function index()  {
        $user_id = Auth::guard('c_manager')->user()->id;
        $teams = Team::where("t_manager", $user_id)->get();
        $manager = User::where("id", $user_id)->first();
        $my_tournaments = Tournament::orderBy('created_at', 'desc')
                  ->where('manager_id', $user_id)->get();
        return view('manager.club-manager', compact('teams','manager','my_tournaments' ));
    }

}
