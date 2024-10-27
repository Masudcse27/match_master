<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function index()  {
        $matches = Matches::whereDate('match_date', '>=', Carbon::today()->toDateString())->get();
        $admin  = User::where("id", Auth::guard('admin')->user()->id)->first();
        return view('admin_profile', compact('matches','admin'));
    }
}
