<?php

namespace App\Http\Controllers;

use App\Models\MatchBattingBowling;
use App\Models\MatchBattingHistory;
use App\Models\MatchBowlingHistory;
use App\Models\Matches;
use App\Models\MatchPrediction;
use App\Models\TeamSquads;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $todayMatches = Matches::with(['teamOne', 'teamTwo'])
            ->whereDate('match_date', Carbon::now()->toDateString()) 
            ->orderBy('start_time')
            ->get();
        $previousMatches = Matches::with(['teamOne', 'teamTwo'])
            ->where('is_end', true) 
            ->orderBy('start_time')
            ->get();
        // dd($todayMatches);
        return view("index",compact('todayMatches','previousMatches'));
    }

    public function show_score($match_id)  {
        $batting_team = MatchBattingBowling::where('match_id',$match_id)->first()->batting_team;
        $bowling_team = MatchBattingBowling::where('match_id',$match_id)->first()->bowling_team;
        $match = Matches::with(['teamOne'],'teamTwo')->where('id',$match_id)->first(); 
        $teamAsq = TeamSquads::with('user')->where('team_id',$match->teamOne->id)->get();
        $teamBsq = TeamSquads::with('user')->where('team_id',$match->teamTwo->id)->get();
        $prediction_1_c = MatchPrediction::where('match_id',$match_id)->where('team_id',$match->teamOne->id)->count();
        $prediction_2_c = MatchPrediction::where('match_id',$match_id)->where('team_id',$match->teamTwo->id)->count();
        $prediction_1 = $prediction_1_c>0||$prediction_2_c>0?($prediction_1_c/($prediction_1_c+$prediction_2_c))*100:0;
        $prediction_2 = $prediction_1_c>0||$prediction_2_c>0?($prediction_2_c/($prediction_1_c+$prediction_2_c))*100:0;  
        // dd($prediction_1)
        if($batting_team){
            $batting_team_score = MatchBattingHistory::with('player')->where('match_id',$match_id)->where('team_id',$batting_team)->get();
            $bowling_history = MatchBowlingHistory::with('player')->where('match_id',$match_id)->where('team_id',$bowling_team)->get();
            // dd($bowling_history);
            $bowling_team_batting = MatchBattingHistory::with('player')->where('match_id',$match_id)->where('team_id',$bowling_team)->get();
            $batting_team_bowling = MatchBowlingHistory::with('player')->where('match_id',$match_id)->where('team_id',$batting_team)->get();
            return view('match_score_details',compact('batting_team','match','teamAsq','teamBsq','batting_team_score','bowling_history','bowling_team_batting','batting_team_bowling','prediction_1','prediction_2'));
        }
        else{
            return view('match_score_details',compact('batting_team','match','teamAsq','teamBsq'));
        }
        
    }
}
