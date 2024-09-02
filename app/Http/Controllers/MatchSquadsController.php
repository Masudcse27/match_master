<?php

namespace App\Http\Controllers;

use App\Models\MatchSquads;
use App\Models\TeamSquads;
use Illuminate\Http\Request;

class MatchSquadsController extends Controller
{
    public function showSelectPlayers($teamId, $matchId)
    {
        $teamSquads = TeamSquads::where('team_id', $teamId)->get();

        return view('select_players', compact('teamSquads', 'matchId', 'teamId'));
    }


    public function savePlayers(Request $request, $teamId, $matchId)
    {
        $selectedPlayers = $request->input('players');

        if (count($selectedPlayers) != 11) {
            return redirect()->back()->with('error', 'You must select exactly 11 players.');
        }

        foreach ($selectedPlayers as $playerId) {
            MatchSquads::create([
                'player_id' => $playerId,
                'team_id' => $teamId,
                'match_id' => $matchId,
            ]);
        }

        return redirect()->back()->with('success', 'Match squad has been successfully saved.');
    }
}
