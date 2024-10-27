<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchPrediction;
use Illuminate\Http\Request;

class MatchPredictionController extends Controller
{
    public function index($id) {
        $matches = Matches::where('id',$id)->with(['teamOne', 'teamTwo'])->first();
        return view('match-prediction',compact('matches'));
    }

    public function store(Request $request, $id) {
        $prediction = new MatchPrediction();
        $prediction->match_id = $id;
        $prediction->team_id = $request->team;
        $prediction->save();
        return redirect()->route('score', $id);
    }
}
