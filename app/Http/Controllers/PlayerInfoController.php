<?php

namespace App\Http\Controllers;

use App\Models\MatchBattingHistory;
use App\Models\MatchBowlingHistory;
use App\Models\MatchSquads;
use App\Models\PlayerInfo;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class PlayerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $player = PlayerInfo::with('user')->where('player_id', Auth::user()->id)->firstOrFail();
        // dd(Auth::user()->id);
        $all_run = MatchBattingHistory::where('player_id',Auth::user()->id)->sum('run');
        $total_ball = MatchBattingHistory::where('player_id',Auth::user()->id)->sum('ball');
        $total_given_run = MatchBowlingHistory::where('player_id',Auth::user()->id)->sum('run');
        $total_wicket = MatchBowlingHistory::where('player_id',Auth::user()->id)->sum('wicket');
        $total_out = MatchBattingHistory::where('player_id',Auth::user()->id)->where('status', 'out')->count();
        $playing_match = MatchSquads::where('player_id',Auth::user()->id)->count();
        return view('player_profile', compact('player','all_run','total_ball','total_given_run','total_wicket','total_out','playing_match'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($player_id)
    {
        $player = PlayerInfo::with('user')->where('player_id', $player_id)->firstOrFail();
        // dd($player);
        return view('player-info', ['player' => $player]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlayerInfo $playerInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $player_id = Auth::user()->id;
        $player = PlayerInfo::where('player_id', $player_id)->first();
        $user = User::find($player_id);
    
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);
    
        // Update user details
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        if (!$user->save()) {
            return response()->json(['message' => 'Failed to update user details.'], 500);
        }
    
        // Update player info
        $player->address = $request->address;
        if (!$player->save()) {
            return response()->json(['message' => 'Failed to update player information.'], 500);
        }
    
        return response()->json(['message' => 'Player profile updated successfully!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlayerInfo $playerInfo)
    {
        //
    }
}
