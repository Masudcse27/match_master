<?php

namespace App\Http\Controllers;

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
        // dd($player);
        return view('player_profile', ['player' => $player]);
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
        $player = PlayerInfo::where('player_id',$player_id)->first();
        $user = User::find($player_id);

        $request->validate([
            'name' => 'required|string|max:255',
            // 'player_type' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $player->user->save();

        // $player->player_type = $request->player_type;
        $player->address = $request->address;
        $player->save();

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
