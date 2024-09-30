<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanelRegistrationRequest;
use App\Http\Requests\ManagerRegistrationRequest;
use App\Http\Requests\PlayerRegistrationRequest;
use App\Mail\PlayerRegistrationMail;
use App\Models\PlayerInfo;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function index_player($team_id){
        $roles = [
            "batter" => "Batter",
            "bowler" => "Bowler",
            "wk_batter" => "Wicket Keeper Batter",
            "batting_all"=> "Batting Allrounder",
            "bowling_all"=> "Bowling Allrounder",
        ];
        return view("auth.player_registration", ['role' => $roles, 'team_id' => $team_id]);
    }

    public function index_manager(){
        $roles = [
            "t_manager" => "Team Manager",
            "c_manager" => "Club Manager",
            "g_authority" => "Ground Authority"
        ];
        return view("auth.manager_registration", ['role' => $roles]);
    }

    public function index_admin_panel(){
        $roles = [
            "admin" => "Admin",
            "moderator" => "Moderator",
        ];
        return view("auth.admin_panel_registration", ['role' => $roles]);
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
        return redirect()->route('login')->with('Signup_success','Signup is successful');
    }

    public function admin_panel_register(AdminPanelRegistrationRequest $request){
        $pass = $this->generateRandomPassword();
        $user = new User();
        $user->name = $request->name." ".$pass;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($pass);
        $user->role = $request->role;
        $user->save();
        echo $pass;
        return redirect()->route('login')->with('Signup_success','Signup is successful');
    }

    public function player_register(PlayerRegistrationRequest $request, $id){
        $pass = $this->generateRandomPassword();
        $user = new User();
        $user->name = $request->name;
        $user->nid = $request->nid;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($pass);
        $user->role = 'player';
        $user->save();

        $playerinfo = new PlayerInfo();
        $playerinfo->player_id = $user->id;
        $playerinfo->player_type = $request->role;
        $playerinfo->address = $request->address;
        $playerinfo->save();
        Mail::to($user->email)->send(new PlayerRegistrationMail("Player registration successful",$user->name,$pass,Auth::guard("t_manager")->user()->name));
        return redirect()->route('team.details',$id)->with('Signup_success','player registration is successful');
        
    }
}
