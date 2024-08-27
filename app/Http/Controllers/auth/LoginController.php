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
                }
                else if(Auth::user()->role == 't_manager'){
                    Auth::guard('t_manager')->attempt($data);
                }
                else if(Auth::user()->role == 'c_manager'){
                    Auth::guard('c_manager')->attempt($data);
                }
                else{
                    Auth::guard('g_authority')->attempt($data);
                    return redirect()->route('home')->with('success','login successful');
                }
                Auth::logout();
            }
            
        }
        else return redirect()->route('login')->withInput()->with('error','Password is incorrect');
    }

    
    function logout() {
        if(Auth::user()->role='player'){
            if(Auth::user()->role== 'admin'){
                Auth::guard('admin')->logout();
            }
            else if(Auth::user()->role== 'moderator'){
                Auth::guard('moderator')->logout();
            }
            else if(Auth::user()->role== 't_manager'){
                Auth::guard('t_manager')->logout();
            }
            else if(Auth::user()->role== 'c_manager'){
                Auth::guard('c_manager')->logout();
            }
            else{
                Auth::guard('g_authority')->logout();
            }
        }
        else Auth::logout();
    }
    
}