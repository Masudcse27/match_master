<?php

namespace App\Http\Controllers;

use App\Models\MatchSquads;
use App\Models\TeamSquads;
use Illuminate\Http\Request;

class MatchSquadsController extends Controller
{
    public function showSelectPlayers($teamId, $matchId)
    {
        $teamSquads = TeamSquads::where('team_id', $teamId)->with(['user', 'user.playerInfo'])->get();
        $selectedPlayers = MatchSquads::where('team_id', $teamId)
                                    ->where('match_id', $matchId)
                                    ->pluck('player_id')
                                    ->toArray();
        return view('select_playing_eleven', compact('teamSquads', 'selectedPlayers', 'teamId', 'matchId'));
    }


    public function savePlayers(Request $request, $teamId, $matchId)
    {
        // Validate that exactly 11 players are selected
        // $validatedData = $request->validate([
        //     'players' => 'required|array|size:11',  // Ensure exactly 11 players are selected
        //     'players.*' => 'exists:players,id',     // Ensure each selected player exists in the players table
        // ], [
        //     'players.size' => 'You must select exactly 11 players.',
        // ]);

        MatchSquads::where('team_id', $teamId)
                    ->where('match_id', $matchId)
                    ->delete();

        foreach ($request->players as $playerId) {
            MatchSquads::create([
                'team_id' => $teamId,
                'match_id' => $matchId,
                'player_id' => $playerId,
            ]);
        }

        return redirect()->route('match.details', ['match_id' => $matchId, 'team_id' => $teamId])->with('success', 'Squad saved successfully!');
    }

}
