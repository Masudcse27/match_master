<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(){
        return view("create_tournament");
    }
    public function store(Request $request){
        $tournament = new Tournament();
        $tournament->name = $request->name;
        $tournament->description = $request->description;
        $tournament->manager_id = Auth::guard("t_manager")->check()?Auth::guard("t_manager")->user()->id :Auth::guard("c_manager")->user()->id;
        $tournament->registration_last_date = $request->registration_last_date;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->save();
        return redirect()->route("tournaments.store")->with("success","create successfull");
    }
    public function list(){
        // $tournaments = Tournament::all();
        // dd($tournaments);
        $managerId = Auth::guard("t_manager")->check()
                    ? Auth::guard("t_manager")->user()->id
                    : Auth::guard("c_manager")->user()->id;

        $tournaments = Tournament::whereDate('registration_last_date', '>=', Carbon::today()->toDateString())
                        ->where('manager_id', '!=', $managerId)->get();
        $tournament_data = [];
        foreach ($tournaments as $tournament){
            $teamCount = $tournament->teams()->count();
            $isTournamentInTeams = $tournament->teams()->where('tournaments_id', $tournament->id)->exists();

            if($teamCount < $tournament->number_of_team && ! $isTournamentInTeams){
                $tournament_data[] = [
                    'id'=> $tournament->id,
                    'name'=> $tournament->name,
                    'number_of_team_registration'=>$teamCount,
                    'registration_last_date' => $tournament->registration_last_date,
                    'start_date'=> $tournament->start_date,
                ];
            }
        }  
        // dd($tournaments);
        return view('show_tournament_for_join', ['tournaments'=> $tournament_data]);
    }

    public function list_for_manager(){
        $managerId = Auth::guard("t_manager")->check()
                    ? Auth::guard("t_manager")->user()->id
                    : Auth::guard("c_manager")->user()->id;
        $tournament = Tournament::where('manager_id', $managerId)->get();
        return view('show_tournament_for_join',['tournaments' => $tournament]);
    }

    public function retrieve($id){
        $tournament = Tournament::find($id);
        return view('', ['tournament'=> $tournament]);
    }
    public function update(Request $request, $id){
        $tournament = Tournament::find($id);
        $tournament->name = $request->name;
        $tournament->description = $request->description;
        $tournament->registration_last_date = $request->registration_last_date;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->save();
    }

    public function join($id){
        return view('tournament_join', ['id'=> $id]);
    }

    public function join_store(Request $request,$id){
        $team = Team::where('t_name',$request->team_name)->first();
        // dd($team);
        // $tournament = Tournament::where('team_id',$team->id)->get();
        $tournamentTeam = new TournamentTeam();
        $tournamentTeam->team_id = $team->id;
        
        $tournamentTeam->tournaments_id = $id;
        $tournamentTeam->save();
        return redirect()->route('tournaments')->with('success','');
    }

    
}
