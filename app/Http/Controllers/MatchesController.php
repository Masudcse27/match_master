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
        $teams = TournamentTeam::where('tournament_id', $tournamentId)->get();
        $teamPairs = $this->generateTeamPairs($teams);

        return view('create_feature', compact('teamPairs', 'tournamentId'));
    }

    public function saveMatches(Request $request, $tournamentId)
    {
        $matches = $request->input('matches');

        foreach ($matches as $match) {
            Matches::create([
                'team_1' => $match['team_1'],
                'team_2' => $match['team_2'],
                'tournament_id' => $tournamentId,
            ]);
        }

        return redirect()->route('tournament.show', $tournamentId)->with('success', 'Matches saved successfully.');
    }


    private function generateTeamPairs($teams)
    {
        $pairs = [];

        for ($i = 0; $i < count($teams) - 1; $i++) {
            for ($j = $i + 1; $j < count($teams); $j++) {
                $pairs[] = ['team_1' => $teams[$i]->id, 'team_2' => $teams[$j]->id];
            }
        }

        shuffle($pairs);

        return $pairs;
    }

    public function details( $match_id,$team_id){
        $match = Matches::where('id', $match_id)->first();
        $tournament = Tournament::where('id', $match->tournamentId)->first();
        $teams = Team::whereIn('id', [$match->team1, $match->team2])->get();
        $my_team = $teams->where('id', $team_id)->first();
        $opponent_team = $teams->where('id', '!=', $team_id)->first();
        $my_team_squads = MatchSquads::where('match_id', $match->id)
            ->where('team_id', $my_team->id)
            ->with(['player', 'player.playerInfo']) 
            ->get();
        $opponent_team_squads = MatchSquads::where('match_id', $match->id)
            ->where('team_id', $opponent_team->id)
            ->with(['player', 'player.playerInfo'])
            ->get();
        return view('match-details', compact('match','tournament','my_team','opponent_team','my_team_squads','opponent_team_squads'));
    }

    public function create_friendly_match(Request $request, $team_id) {
        $request_team = Team::where('t_name', $request->team_name)->first();
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
