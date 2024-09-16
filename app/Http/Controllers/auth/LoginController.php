<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request){
        $data=$request->only(['email','password']);
        if(Auth::attempt($data)){
            if(Auth::user()->role != 'player'){
                if(Auth::user()->role == 'admin'){
                    Auth::guard('admin')->attempt($data);
                    
                }
                else if(Auth::user()->role == 'moderator'){
                    Auth::guard('moderator')->attempt($data);
                    return redirect()->route('home')->with('success','login successful');
                }
                else if(Auth::user()->role == 't_manager'){
                    Auth::guard('t_manager')->attempt($data);
                    return redirect()->route('team.manager.profile')->with('success','login successful');
                }
                else if(Auth::user()->role == 'c_manager'){
                    Auth::guard('c_manager')->attempt($data);
                    return redirect()->route('home')->with('success','login successful');
                }
                else{
                    Auth::guard('g_authority')->attempt($data);
                    return redirect()->route('home')->with('success','login successful');
                }
                Auth::logout();
                return redirect()->route('home')->with('success','login successful');
            }
            else{
                return redirect()->route('player.profile')->with('success','login successful');
            }
            
        }
        else return redirect()->route('login')->withInput()->with('error','Password is incorrect');
    }

    
    function logout() {
        if(Auth::guard('admin')->check())Auth::guard('admin')->logout();
        else if (Auth::guard('moderator')->check())Auth::guard('moderator')->logout();
        else if (Auth::guard('t_manager')->check())Auth::guard('t_manager')->logout();
        else if (Auth::guard('c_manager')->check())Auth::guard('c_manager')->logout();
        else if (Auth::guard('g_authority')->check())Auth::guard('g_authority')->logout();
        else Auth::logout();   
        return redirect()->route('home')->with('message','logout');
    }
    
}
