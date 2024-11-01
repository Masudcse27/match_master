<?php

namespace App\Http\Controllers;

use App\Models\MatchBattingBowling;
use App\Models\MatchBattingHistory;
use App\Models\MatchBowlingHistory;
use App\Models\Matches;
use App\Models\MatchSquads;
use App\Models\Scoreboard;
use Illuminate\Http\Request;
use Validator;

class ScoreboardController extends Controller
{
    public function showScoreboard($matchId)
    {

        $match = MatchBattingBowling::with(['battingTeam','bowlingTeam','matches'])->where('match_id',$matchId)->first();
        // dd($match);
        if (is_null($match)) {
            $matches = Matches::with(['teamOne', 'teamTwo'])->where('id', $matchId)->first();
            return view('set-batting-team', compact('matches', 'matchId'))
                ->with('alert', 'Please set the batting team before viewing the scoreboard.');
        }
        $battingTeamSquad = MatchSquads::with('player')->where('team_id',$match->batting_team)->where('match_id',$matchId)->get();
        $bowlingTeamSquad = MatchSquads::with('player')->where('team_id',$match->bowling_team)->where('match_id',$matchId)->get();
        $playingBatters = MatchBattingHistory::where('match_id', $matchId)
            ->where('status', 'playing')
            ->pluck('player_id')
            ->toArray();
        $outBatters = MatchBattingHistory::where('match_id', $matchId)
            ->where('status', 'out')
            ->pluck('player_id')
            ->toArray();

        $currentBowler = MatchBowlingHistory::where('match_id', $matchId)
            ->where('is_current', true)
            ->first();

        return view('scoreboard_manage', compact('match', 'battingTeamSquad', 'bowlingTeamSquad', 'playingBatters', 'currentBowler','outBatters'));
    }

   
    public function updatePlayerStatus(Request $request){
    // dd($request);
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

    // Check if the status is 'playing' and limit to 2 players
    if ($status === 'playing') {
        $currentPlaying = MatchBattingHistory::where('match_id', $matchId)
            ->where('status', 'playing')
            ->count();

        if ($currentPlaying >= 2) {
            return response()->json(['success' => false, 'message' => 'Only two players can be marked as "Playing" at a time.'], 400);
        }
    }

    // Get the team_id from MatchBattingBowling
    $team = MatchBattingBowling::where('match_id', $matchId)->first()->batting_team;

    // Find the player in the match_batting_histories table
    $player = MatchBattingHistory::where('player_id', $playerId)
        ->where('match_id', $matchId)
        ->first();

    if ($player) {
        // Update player status if found
        
        if($status=='out'){
            $match = Matches::where('id',$matchId)->first();
        
            if($team==$match->team_1)
                $match->team_1_wickets += 1;
            else
                $match->team_2_wickets +=1;
            $match->save();
        }
        if($player->status=='out'&& $status!='out'){
            $match = Matches::where('id',$matchId)->first();
        
            if($team==$match->team_1)
                $match->team_1_wickets -= 1;
            else
                $match->team_2_wickets -=1;
            $match->save();
        }
        $player->status = $status;
        $player->save();
    } else {
        // Create a new entry if the player does not exist
        $player = new MatchBattingHistory();
        $player->player_id = $playerId;
        $player->match_id = $matchId;
        $player->team_id = $team;  // Assign the correct team_id
        $player->status = $status;
        $player->run = 0;
        $player->ball = 0;
        $player->save();
    }

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
        $player = MatchBowlingHistory::where('match_id',$matchId)->where('player_id',$playerId)->first();
        
        if($player){
            $player->is_current = true;
            $player->save();
        }
        else{
            $team = MatchBattingBowling::where('match_id', $matchId)->first()->bowling_team;
            $player = new MatchBowlingHistory();
            $player->player_id = $playerId;
            $player->match_id = $matchId;
            $player->team_id = $team;
            $player->over = 0;
            $player->run = 0;
            $player->wicket = 0;
            $player->is_current = true;
            $player->save();
        }

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

        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        // }

        $matchId = $request->input('match_id');
        $teamId = $request->input('team_id');
        $run = $request->input('run');
        $runType = $request->input('run_type');
        $facingPlayerId = $request->input('facing_player_id');
        $bowlerId = $request->input('bowler_id');

        $batting_team = MatchBattingBowling::where('match_id', $matchId)->first()->batting_team;
        $bowling_team = MatchBattingBowling::where('match_id', $matchId)->first()->bowling_team;
        
        $battingHistory = MatchBattingHistory::where('match_id', $matchId)
            ->where('player_id', $facingPlayerId)
            ->first();
        if ($battingHistory) {
            $battingHistory->run += $runType =='b'||$runType=='rw'?$run:0;
            $battingHistory->ball += $runType!='wd'?1:0;
            $battingHistory->save();
        }
        else {
            $history = new MatchBattingHistory();
            $history->player_id = $facingPlayerId;
            $history->match_id = $matchId;
            $history->team_id = $batting_team;
            $history->run = $runType =='b'||$runType=='rw'?$run:0;
            $history->ball = $runType!='wd'?1:0;
            $history->status = 'playing';
            $history->save();
        }

        $bowlingHistory = MatchBowlingHistory::where('match_id',$matchId)->where('player_id',$bowlerId)->first();
        if ($bowlingHistory) {
            $bowlingHistory->run += in_array($runType, ['lbw', 'wd','by'])?0:$run;
            if (!in_array($runType, ['wd', 'no'])) {
                $bowlingHistory->over += 1;
            }
            $bowlingHistory->wicket = $runType=='rw'||$runType=='lbw'||$runType=='w'? $bowlingHistory->wicket+1:$bowlingHistory->wicket;
            $bowlingHistory->save();
        }
        else {
            $history = new MatchBowlingHistory();
            $history->player_id = $bowlerId;
            $history->match_id = $matchId;
            $history->team_id = $bowling_team;
            $history->run = in_array($runType, ['lbw', 'wd','by'])?0:$run;
            $history->over = in_array($runType, ['wd',]) ? 0 : 1;
            $history->is_current = true;
            $history->wicket = $runType=='rw'||$runType=='lbw'||$runType=='w'? 1:0;
            $history->save();
        }
        $latestBallNumber = Scoreboard::where('match_id', $matchId)
            ->orderBy('created_at', 'desc')
            ->first();;
        $ballNumber = $latestBallNumber ? in_array($runType, ['wd', 'no']) ? $latestBallNumber->ball_number : $latestBallNumber->ball_number+1 : 1;
        $score = new Scoreboard();
        $score->match_id = $matchId;
        $score->team_id = $batting_team;
        $score->ball_number = $ballNumber;
        $score->run = $run;
        $score->run_type = $runType;
        $score->save();

        $match = Matches::where('id',$matchId)->first();
        
        if($batting_team==$match->team_1)
            $match->team_1_total_run =3;
        else
            $match->team_2_total_run +=$run;
        $match->save();
        return response()->json(['success' => true, 'message' => 'Ball completed successfully.']);

    //     \DB::beginTransaction();

    //     try {
    //         $battingHistory = MatchBattingHistory::where('match_id', $matchId)
    //             ->where('player_id', $facingPlayerId)
    //             ->first();

    //         if ($battingHistory) {
    //             $battingHistory->run += $run;
    //             $battingHistory->ball += 1;
    //             $battingHistory->save();
    //         } else {
    //             MatchBattingHistory::create([
    //                 'player_id' => $facingPlayerId,
    //                 'match_id' => $matchId,
    //                 'team_id' => $teamId,
    //                 'run' => $run,
    //                 'ball' => 1,
    //                 'status' => 'playing',
    //             ]);
    //         }

            
    //         $bowlingHistory = MatchBowlingHistory::where('match_id', $matchId)
    //             ->where('player_id', $bowlerId)
    //             ->first();

    //         if ($bowlingHistory) {
    //             $bowlingHistory->run += $run;
    //             if (!in_array($runType, ['w', 'no'])) {
    //                 $bowlingHistory->over += 1;
    //             }
    //             $bowlingHistory->save();
    //         } else {
    //             MatchBowlingHistory::create([
    //                 'player_id' => $bowlerId,
    //                 'match_id' => $matchId,
    //                 'team_id' => $teamId,
    //                 'over' => in_array($runType, ['w', 'no']) ? 0 : 1,
    //                 'run' => $run,
    //                 'wicket' => 0,
    //                 'is_current' => true,
    //             ]);
    //         }

            
    //         $latestBallNumber = Scoreboard::where('match_id', $matchId)->max('ball_number');
    //         $nextBallNumber = $latestBallNumber ? $latestBallNumber + 1 : 1;

    //         Scoreboard::create([
    //             'match_id' => $matchId,
    //             'team_id' => $teamId,
    //             'ball_number' => $nextBallNumber,
    //             'run' => $run,
    //             'run_type' => $runType,
    //         ]);

    //         \DB::commit();

    //         return response()->json(['success' => true, 'message' => 'Ball completed successfully.']);
    //     } catch (\Exception $e) {
    //         \DB::rollBack();
    //         return response()->json(['success' => false, 'message' => 'An error occurred while completing the ball.'], 500);
    //     }
    }

    public function set_batting_team(Request $request, $matchId){
        $match = Matches::where('id',$matchId)->first();
        $set_batting = new MatchBattingBowling();
        $set_batting->match_id = $matchId;
        $set_batting->batting_team = $request->team_id;
        $set_batting->bowling_team = $request->team_id==$match->team_1? $match->team_2:$match->team_1;
        $set_batting->save();
        return redirect()->route('scoreboard.show',$matchId);
    }
    public function complete_in($matchId){
        $match = MatchBattingBowling::where('match_id',$matchId)->first();
        $batting_team = $match->batting_team;
        $match->batting_team = $match->bowling_team;
        $match->bowling_team = $batting_team;
        $match->is_innings_complete = true;
        $match->save();
        return redirect()->route('scoreboard.show',$matchId);
    }
    public function match_end($matchId){
        $match = Matches::where('id',$matchId)->first();
        $match->is_end = true;
        $match->save();
        return redirect()->route('admin.profile');
    }
}
