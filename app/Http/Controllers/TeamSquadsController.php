<?php

namespace App\Http\Controllers;

use App\Models\TeamSquads;
use App\Models\Tournament;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamSquadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id){
       return view("add_player_in_team",["id"=> $id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id){
        $player = User::where("email", $request->email)->first();
        if(!$player) return redirect()->back()->with("error","there is no player with this email");
        if($player->role != "player") return redirect()->back()->with("error","there is no player with this email");
        $teamsquad = TeamSquads::where("player_id", $player->id)->first();
        if($teamsquad){
            if($teamsquad->team_id == $id) return redirect()->back()->with("error","allready player in your squad");
            else return redirect()->back()->with("error","player is allready in a team");
        }
        $squadPlayer = new TeamSquads();
        $squadPlayer->player_id = $player->id;
        $squadPlayer->team_id = $id;
        $squadPlayer->save();
        return redirect()->route('team.squads',['id' => $id])->with("success","player is added");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function list($id)
    {
        $teamSquads = TeamSquads::where("id", $id)->get();
        return view("team_squads_list",["teamSquads"=> $teamSquads]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamSquads $teamSquads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamSquads $teamSquads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamSquads $teamSquads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $teamSquad = TeamSquads::find($id);

    if ($teamSquad) {
        $teamSquad->delete();
        return redirect()->back()->with('success', 'Player deleted successfully.');
    }

    return redirect()->back()->with('error', 'Player not found.');
}
}
