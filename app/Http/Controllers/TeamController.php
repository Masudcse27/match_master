<?php

namespace App\Http\Controllers;


use App\Models\FriendlyMatch;
use App\Models\Matches;
use App\Models\Team;
use App\Models\TeamSquads;
use App\Models\Tournament;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("manager.create_team");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            't_name' => 'required|string|max:100|unique:teams',
            't_description'=> 'required|string|max:250',
            't_title'=> 'string|max:250',
        ]);
        $user_id = null;
        if(Auth::guard('t_manager')->check()){
            $user_id = Auth::guard("t_manager")->user()->id;
        }
        else{
            $user_id = Auth::guard("c_manager")->user()->id;
        }
        $team = new Team();
        $team->t_name = $request->t_name;
        $team->t_description = $request->t_description;
        $team->t_title = $request->t_title;
        $team->t_manager = $user_id;
        $team->save();
        return redirect()->route('team.manager.profile')->with('success','team create success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $team = Team::find($id);
        return view('manager.edit_team_info', ['team_data'=> $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            't_description'=> 'required|string|max:250',
            't_title'=> 'string|max:250',
        ]);
        $team = Team::find($id);
        $team->description = $request->description;
        $team->t_title = $request->t_title;
        $team->save();
    }

    public function details($team_id){
        $user_id = null;
        if(Auth::guard('t_manager')->check()){
            $user_id = Auth::guard("t_manager")->user()->id;
        }
        else{
            $user_id = Auth::guard("c_manager")->user()->id;
        }
        $team = Team::find($team_id);
        $squad = TeamSquads::with('user') // Eager load the related player data
        ->where('team_id', $team_id)
        ->get();
        $matches = Matches::whereDate('match_date', '>=', Carbon::today()->toDateString())
        ->where(function($query)use($team_id){
        $query->where('team_1', $team_id)
        ->orwhere('team_2', $team_id);})->get();

        $match_request = FriendlyMatch::where('team_2',$team_id)->with('teamOne')->get();
        
        $tournaments = Tournament::whereDate('registration_last_date', '>=', Carbon::today()->toDateString())
                  ->where('manager_id', '!=', $user_id)->where('is_club_manager_tournament',false)->get();
        return view('team-details', compact('team','squad','matches','match_request','team_id','tournaments'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        $team->delete();
        if(Auth::guard("t_manager")->check())
            return redirect()->route('team.manager.profile');
        else return redirect()->route('club.manager.profile');
    }
    public function show_all_team()  {
        $teams = Team::with('manager')
            ->where('t_manager', '!=', Auth::guard('t_manager')->user()->id)
            ->whereHas('manager', function ($query) {
            $query->where('role', 't_manager');})
            ->get();
        return view('all-team',compact('teams'));
    }
}
