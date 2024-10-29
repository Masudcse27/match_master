<?php

namespace App\Http\Controllers;

use App\Models\Ground;
use App\Models\Matches;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(){
        $ground = Ground::all();
        return view("create_tournament", compact('ground'));
    }
    public function store(Request $request){

        if(Auth::guard("c_manager")->check()){
            $tournaments = Tournament::orderBy('end_date', 'desc')
                        ->where('manager_id',  Auth::guard("c_manager")->user()->id)->first();
            $start_date = $request->start_date;
            $tournamentStartDate = Carbon::parse($tournaments->start_date);
            $userStartDate = Carbon::parse($start_date);
            
            if ($tournamentStartDate->diffInYears($userStartDate) < 1) {
                return redirect()->back()->with("error","you can not create tournament more then one in a year");
            }
           
        }
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Check if any matches are scheduled at the venue within the given date range
        $isVenueBooked = Matches::where('venu_id', $request->venue)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('match_date', [$startDate, $endDate]);
            })
            ->exists();

        if ($isVenueBooked) {
            return redirect()->back()->with("error", "The venue is already booked for another match within the selected date range.");
        }
        
        $tournament = new Tournament();
        $tournament->name = $request->name;
        $tournament->description = $request->description;
        $tournament->manager_id = Auth::guard("t_manager")->check()?Auth::guard("t_manager")->user()->id :Auth::guard("c_manager")->user()->id;
        $tournament->registration_last_date = $request->registration_last_date;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->entry_fee = $request->entry_fee?$request->entry_fee:0;
        $tournament->is_club_manager_tournament = Auth::guard("c_manager")->check();
        $tournament->venue = $request->venue;
        $tournament->number_of_team = $request->number_of_team_slot;
        $tournament->save();
        
        if(Auth::guard("t_manager")->check()){
            return redirect()->route("team.manager.profile")->with("success","create successful");
        }    
        else return redirect()->route("club.manager.profile")->with("success","create successful");
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
        // dd($tournament_data);
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
    public function details($tournament_id,$teamId){
        $tournament_details = Tournament::where('id',$tournament_id)->with('manager')->first();
        $is_join = TournamentTeam::where('team_id', $teamId)
            ->where('tournaments_id', $tournament_id)
            ->exists();
        $total_team = Tournament::where('id', $tournament_id)->value('number_of_team');
        $tournament_total_team = TournamentTeam::where('tournaments_id',$tournament_id)->count();
        $is_full = $total_team<=$tournament_total_team;

        return view('tournament-details',compact('tournament_details','teamId','is_join','is_full'));
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

    public function join($id,$teamId){
        $total_team = Tournament::where('id', $id)->value('number_of_team');
        $tournament_total_team = TournamentTeam::where('tournaments_id',$id)->count();
        if($total_team<=$tournament_total_team)
            return redirect()->back()->with("error","tournament slot full");
        $tournamentTeam = new TournamentTeam();
        $tournamentTeam->team_id = $teamId;
        
        $tournamentTeam->tournaments_id = $id;
        $tournamentTeam->save();
        return redirect()->route('team.details',$teamId)->with("success","Tournament join successful");
    }

    public function join_store(Request $request,$id){
        $team = Team::where('t_name',$request->team_name)->first();
        // dd($team);
        // $tournament = Tournament::where('team_id',$team->id)->get();
        $tournamentTeam = new TournamentTeam();
        $tournamentTeam->team_id = $team->id;
        
        $tournamentTeam->tournaments_id = $id;
        $tournamentTeam->save();
        return redirect()->route('team.manager.profile')->with('success','');
    }

    public function manage_tournament($id)  {
        $tournament_details = Tournament::where('id',$id)->with('manager')->first();
        $teams = TournamentTeam::with('team')->where('tournaments_id',$id)->get();
        $matches = Matches::with(['teamOne','teamTwo'])->where('Tournament_id',$id)->get();
        return view('manage-tournament',compact('tournament_details','teams','matches'));
    }
    
    public function set_date(Request $request,$id)  {
        $match = Matches::where('id',$id)->first();
        $date = $request->date;
        $time = $request->time;
        if($date) $match->match_date = $date;
        if($time) $match->start_time = $time;
        $match->save();
        return redirect()->back();
    }

    public function add_team(Request $request,$id)  {
        $match = new TournamentTeam();
        $team = Team::where('t_name',$request->team_name)->first();
        
        $match->team_id = $team->id;
        $match->tournaments_id = $id;
        $match->save();
        return redirect()->back();
    }
}
