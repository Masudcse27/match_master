<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamManagerProfile extends Controller
{
    public function index() {
        $user_id = Auth::guard("t_manager")->user()->id;
        $teams = Team::where("t_manager", $user_id)->get();
        $manager = User::where("id", $user_id)->first();
        $teamsManaged = $teams->pluck('id');
        $matches = Matches::whereDate('match_date', '>=', Carbon::today()->toDateString())
                  ->where(function($query) use ($teamsManaged) {
                      $query->whereIn('team_1', $teamsManaged)
                            ->orWhereIn('team_2', $teamsManaged);
                  })
                  ->get();
        $tournaments = Tournament::whereDate('registration_last_date', '>=', Carbon::today()->toDateString())
                  ->where('manager_id', '!=', $user_id)->get();

        return view('manager.team-manager-profile',compact('teams','manager','matches','tournaments'));
    }
}
