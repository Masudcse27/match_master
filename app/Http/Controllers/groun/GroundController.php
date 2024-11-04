<?php

namespace App\Http\Controllers\groun;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroundRequest;
use App\Models\Ground;
use Auth;
use Illuminate\Http\Request;

class GroundController extends Controller
{
   public function index(){
    return view("ground.add_ground");
   }
   public function create(GroundRequest $request){
      $ground = new Ground();
      $ground->name = $request->name;
      $ground->description = $request->description;
      $ground->ground_location = $request->ground_location;
      $ground->cost_per_day = $request->cost_per_day;
      $ground->authority_id = Auth::guard('g_authority')->user()->id;
      $ground->save();
      return redirect()->route('ground.authority.profile')->with('success','ground create successful');
   }

   public function update_view($id){
        $ground =Ground::findOrFail($id);
        return view('update-ground',compact('ground'));
   }
   public function update(Request $request, $id){
        // dd($id);
        $ground = Ground::find($id);
        
        if (!$ground) {
            return redirect()->back()->withErrors(['error' => 'Ground not found.']);
        }
        if(Auth::guard('g_authority')->user()->id!= $ground->authority_id){
            return redirect()->back()->withErrors(['error' => 'you are not alawed to change']);
        }
        $ground->name = $request->name;
        $ground->description = $request->description;
        $ground->cost_per_day = $request->cost_per_day;
        $ground->save();
        return redirect()->back();
   }
   public function retrive($id){
        $ground = Ground::find($id);
        if (!$ground) {
            return redirect()->back()->withErrors(['error' => 'Ground not found.']);
        }
        if ($ground->authority_id != Auth::guard('g_authority')->user()->id) {
            return redirect()->back()->withErrors(['error' => 'not othorize']);
        }
        return view('ground.show_ground',['ground'=> $ground])->with('success','');
   }

   public function destroy($id){
    $ground = Ground::find($id);
    if(Auth::guard('g_authority')->user()->id!= $ground->authority_id){
        return redirect()->back()->withErrors(['error' => 'you are not alawed to delete']);
    }
    if ($ground) {
        $ground->is_exist = false;
        return redirect()->back()->with(['succes' => 'deleted']);
    }
    else return redirect()->back()->withErrors(['error' => 'not found']);

   }
}
