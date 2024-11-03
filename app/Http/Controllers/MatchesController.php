<?php

namespace App\Http\Controllers;

use App\Models\FriendlyMatch;
use App\Models\Matches;
use App\Models\MatchSquads;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Http\Request;

class MatchesController extends Controller
{

    public function createFeature($tournamentId)
    {
        $teams = TournamentTeam::with('team')->where('tournaments_id', $tournamentId)->get();
        $teamPairs = $this->generateTeamPairs($teams);
        // dd($teams);
        return view('feature_create', compact('teamPairs', 'tournamentId'));
    }

    public function saveMatches(Request $request, $tournamentId)
    {
        $matches = json_decode($request->input('matches'), true);
        $tournament = Tournament::where('id',$tournamentId)->first();
        foreach ($matches as $match) {
            $team_1 = Team::where('t_name',$match['team_1'])->first()->id;
            $team_2 = Team::where('t_name',$match['team_2'])->first()->id;
            Matches::create([
                'team_1' => $team_1,
                'team_2' => $team_2,
                'Tournament_id' => $tournamentId,
                'venu_id' => $tournament->venue
            ]);
        }

        return redirect()->route('tournament.manage', $tournamentId)->with('success', 'Matches saved successfully.');
    }


    private function generateTeamPairs($teams)
    {
        $pairs = [];

        for ($i = 0; $i < count($teams) - 1; $i++) {
            for ($j = $i + 1; $j < count($teams); $j++) {
                $pairs[] = ['team_1' => $teams[$i]->team->t_name, 'team_2' => $teams[$j]->team->t_name];
            }
        }

        shuffle($pairs);

        return $pairs;
    }

    public function details( $match_id,$team_id){
        $match = Matches::where('id', $match_id)->first();
        $tournament = Tournament::where('id', $match->tournamentId)->first();
        $teams = Team::whereIn('id', [$match->team_1, $match->team_2])->get();
        // dd($teams);
        $my_team = $teams->where('id', $team_id)->first();
        // dd($my_team);
        $opponent_team = $teams->where('id', '!=', $team_id)->first();
        // $opponent_team = Team::where('id', $opponent_team_id)->first();
        // dd($opponent_team);
        $my_team_squads = MatchSquads::where('match_id', $match_id)
            ->where('team_id', $team_id)
            ->with(['player', 'player.playerInfo']) 
            ->get();
        $opponent_team_squads = MatchSquads::where('match_id', $match_id)
            ->where('team_id', $opponent_team->id)
            ->with(['player', 'player.playerInfo'])
            ->get();
        return view('match-details', compact('match','tournament','my_team','opponent_team','my_team_squads','opponent_team_squads'));
    }

    public function create_friendly_match(Request $request, $team_id) {
        $request_team = Team::where('t_name', $request->team_name)->first();
        if($request->id == $team_id)
            return redirect()->back()->with('error', 'can not create match with this time');

        $friendly_match = new FriendlyMatch();
        $friendly_match->team_1 = $team_id;
        $friendly_match->team_2 = $request_team->id;
        $friendly_match->match_date = $request->date;
        $friendly_match->start_time = $request->time;
        $friendly_match->save();
        return redirect()->back()->with('success', 'Friendly Match Request successfully.');
    }

    public function accept_friendly_match_request($request_id) {
        $match_request = FriendlyMatch::where('id',$request_id)->first();
        $match = new Matches();
        $match->team_1 = $match_request->team_1;
        $match->team_2 = $match_request->team_2;
        $match->match_date = $match_request->match_date;
        $match->start_time = $match_request->start_time;
        $match->save();
        $match_request->delete();
        return redirect()->back()->with('success', 'Friendly Match Request Accepted');
    }

    public function reject_friendly_match_request($request_id) {
        $match_request = FriendlyMatch::where('id',$request_id)->first();
        $match_request->delete();
        return redirect()->back()->with('success', 'Friendly Match Request Rejected');
    }

}
