<?php

namespace App\Http\Controllers;


use App\Models\Team;
use Auth;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("manager.create_team");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            't_name' => 'required|string|max:100|unique:teams',
            't_description'=> 'required|string|max:250',
            't_title'=> 'string|max:250',
        ]);
        $team = new Team();
        $team->name = $request->name;
        $team->description = $request->description;
        $team->t_title = $request->t_title;
        $team->t_manager = Auth::guard('t_manager')->user()->id;
        $team->save();
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
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $team = Team::find($id);
        return view('manager.edit_team_info', ['team_data'=> $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            't_description'=> 'required|string|max:250',
            't_title'=> 'string|max:250',
        ]);
        $team = Team::find($id);
        $team->description = $request->description;
        $team->t_title = $request->t_title;
        $team->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        $team->delete();
    }
}
