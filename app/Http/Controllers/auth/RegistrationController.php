<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanelRegistrationRequest;
use App\Http\Requests\ManagerRegistrationRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    private function generateRandomPassword($length = 12) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialCharacters = '!@#$%^&*()-_=+[]{}|;:,.<>?';
    
        $allCharacters = $characters . $numbers . $specialCharacters;
        $password = '';
        
        $password .= $characters[rand(0, strlen($characters) - 1)];
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        $password .= $specialCharacters[rand(0, strlen($specialCharacters) - 1)];
    
        for ($i = 3; $i < $length; $i++) {
            $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }
        return str_shuffle($password);
    }
    public function index_manager(){
        $roles = [
            "t_manager" => "Team Manager",
            "c_manager" => "Club Manager",
            "g_authority" => "Ground Authority"
        ];
        return view("auth.manager_registration", ['role' => $roles]);
    }
    public function manager_register(ManagerRegistrationRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->nid = $request->nid;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return redirect()->route('home')->with('Signup_success','Signup is successful');
    }

    public function admin_panel_register(AdminPanelRegistrationRequest $request){
        $pass = $this->generateRandomPassword();
        $user = new User();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($pass);
        $user->role = $request->role;
        $user->save();
        return view('index', ['password' => $pass]);
    }

    public function player_register(ManagerRegistrationRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->nid = $request->nid;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($this->generateRandomPassword());
        $user->role = 'player';
        $user->save();
        return redirect()->route('home')->with('Signup_success','Signup is successful');
    }
}
