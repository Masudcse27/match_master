<?php

namespace App\Http\Controllers;

use App\Models\Matches;
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

}
