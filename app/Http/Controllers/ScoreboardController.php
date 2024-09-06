<?php

namespace App\Http\Controllers;

use App\Models\MatchBattingHistory;
use App\Models\MatchBowlingHistory;
use App\Models\Matches;
use App\Models\Scoreboard;
use Illuminate\Http\Request;
use Validator;

class ScoreboardController extends Controller
{
    public function showScoreboard($matchId)
    {
        $match = Matches::with(['battingTeam', 'bowlingTeam'])->findOrFail($matchId);

        $battingTeamSquad = $match->battingTeam->users()->get();
        $bowlingTeamSquad = $match->bowlingTeam->users()->get();

        $playingBatters = MatchBattingHistory::where('match_id', $matchId)
            ->where('status', 'playing')
            ->pluck('player_id')
            ->toArray();

        $currentBowler = MatchBowlingHistory::where('match_id', $matchId)
            ->latest('updated_at')
            ->first();

        return view('scoreboard', compact('match', 'battingTeamSquad', 'bowlingTeamSquad', 'playingBatters', 'currentBowler'));
    }

   
    public function updatePlayerStatus(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'playerId' => 'required|exists:users,id',
            'status' => 'required|in:playing,out,not_play',
            'match_id' => 'required|exists:matches,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $playerId = $request->input('playerId');
        $status = $request->input('status');
        $matchId = $request->input('match_id');

        
        if ($status === 'playing') {
            $currentPlaying = MatchBattingHistory::where('match_id', $matchId)
                ->where('status', 'playing')
                ->count();

            if ($currentPlaying >= 2) {
                return response()->json(['success' => false, 'message' => 'Only two players can be marked as "Playing" at a time.'], 400);
            }
        }

        MatchBattingHistory::updateOrCreate(
            [
                'player_id' => $playerId,
                'match_id' => $matchId,
            ],
            [
                'status' => $status,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Player status updated successfully.']);
    }

    
    public function updateBowlingStatus(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'playerId' => 'required|exists:users,id',
            'match_id' => 'required|exists:matches,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $playerId = $request->input('playerId');
        $matchId = $request->input('match_id');

        MatchBowlingHistory::where('match_id', $matchId)->update(['is_current' => false]);

        MatchBowlingHistory::updateOrCreate(
            [
                'player_id' => $playerId,
                'match_id' => $matchId,
            ],
            [
                'is_current' => true,
                'over' => 0,
                'run' => 0,
                'wicket' => 0,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Bowler status updated successfully.']);
    }

    
    public function completeBall(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'match_id' => 'required|exists:matches,id',
            'team_id' => 'required|exists:teams,id',
            'run' => 'required|integer|min:0|max:6',
            'run_type' => 'required|in:no,lb,w,lbw,rw,b',
            'facing_player_id' => 'required|exists:users,id',
            'bowler_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $matchId = $request->input('match_id');
        $teamId = $request->input('team_id');
        $run = $request->input('run');
        $runType = $request->input('run_type');
        $facingPlayerId = $request->input('facing_player_id');
        $bowlerId = $request->input('bowler_id');

        
        \DB::beginTransaction();

        try {
            $battingHistory = MatchBattingHistory::where('match_id', $matchId)
                ->where('player_id', $facingPlayerId)
                ->first();

            if ($battingHistory) {
                $battingHistory->run += $run;
                $battingHistory->ball += 1;
                $battingHistory->save();
            } else {
                
                MatchBattingHistory::create([
                    'player_id' => $facingPlayerId,
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'run' => $run,
                    'ball' => 1,
                    'status' => 'playing',
                ]);
            }

            
            $bowlingHistory = MatchBowlingHistory::where('match_id', $matchId)
                ->where('player_id', $bowlerId)
                ->first();

            if ($bowlingHistory) {
                $bowlingHistory->run += $run;
                if (!in_array($runType, ['w', 'no'])) {
                    $bowlingHistory->over += 1;
                }
                $bowlingHistory->save();
            } else {
                MatchBowlingHistory::create([
                    'player_id' => $bowlerId,
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'over' => in_array($runType, ['w', 'no']) ? 0 : 1,
                    'run' => $run,
                    'wicket' => 0,
                    'is_current' => true,
                ]);
            }

            
            $latestBallNumber = Scoreboard::where('match_id', $matchId)->max('ball_number');
            $nextBallNumber = $latestBallNumber ? $latestBallNumber + 1 : 1;

            Scoreboard::create([
                'match_id' => $matchId,
                'team_id' => $teamId,
                'ball_number' => $nextBallNumber,
                'run' => $run,
                'run_type' => $runType,
            ]);

            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Ball completed successfully.']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'An error occurred while completing the ball.'], 500);
        }
    }
}
