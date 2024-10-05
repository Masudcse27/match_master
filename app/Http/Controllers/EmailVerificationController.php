<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function index() {
        return view("mail.email-verification-view");
    }

    public function verify_email (Request $request) {
        $user_id = null;
        if(Auth::guard('t_manager')->check()){
            $user_id = Auth::guard("t_manager")->user()->id;
        }
        else{
            $user_id = Auth::guard("c_manager")->user()->id;
        }
        if(!$user_id){
            return redirect()->back()->with('error','unauthorized request');
        }
        $user = User::where('id',$user_id)->first();
        if($user->verification_code == $request->verificationCode){
            $user->is_email_verified = true;
            $user->save();
            return redirect()->route('team.manager.profile')->with('success', 'Email verified successfully!');
        }
        return redirect()->back()->with('error','Invalid verification code');
    }

    public function resend_code()  {
        $verification_code = mt_rand(100000, 999999);
        $user_id = null;
        if(Auth::guard('t_manager')->check()){
            $user_id = Auth::guard("t_manager")->user()->id;
        }
        else{
            $user_id = Auth::guard("c_manager")->user()->id;
        }
        if(!$user_id){
            return redirect()->back()->with('error','unauthorized request');
        }
        $user = User::where('id',$user_id)->first();
        $user->verification_code = $verification_code;
        $user->save();
        Mail::to($user->email)->send(new EmailVerification("Email Verification Code",$user->name,$verification_code,$user->role));
        return redirect()->back()->with("success","code is resend");
    }
}
