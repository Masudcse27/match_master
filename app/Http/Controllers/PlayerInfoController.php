<?php

namespace App\Http\Controllers;

use App\Models\PlayerInfo;
use Illuminate\Http\Request;

class PlayerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $player = PlayerInfo::with('user')->findOrFail($id);
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
    public function show(PlayerInfo $playerInfo)
    {
        //
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
    public function update(Request $request, PlayerInfo $playerInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlayerInfo $playerInfo)
    {
        //
    }
}
