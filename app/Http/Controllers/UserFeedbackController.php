<?php

namespace App\Http\Controllers;

use App\Models\UserFeedback;
use Auth;
use Illuminate\Http\Request;

class UserFeedbackController extends Controller
{
    public function index(){
        
        return view("feedback");
    }

    private function guardcheck(){
        $guards = ["web","t_manager","c_manager","g_authority"];

        foreach($guards as $guard){
            if(Auth::guard($guard)->check()){
                return $guard;
            }
        }
        return null;
    }
    public function store(Request $request){
        $guard = $this->guardcheck();
        if($guard==null){
            return redirect()->back()->with("error","unauthorized request");
        }
        // dd($request->all());
        $feedbacks = new UserFeedback();
        $feedbacks->user_id = Auth::guard($guard)->user()->id;
        $feedbacks->feedback = $request->feedback;

        $feedbacks->save();
        return redirect()->back()->with("success","feedback send successfull");
    }
}
