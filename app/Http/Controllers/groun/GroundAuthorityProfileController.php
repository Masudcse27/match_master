<?php

namespace App\Http\Controllers\groun;

use App\Http\Controllers\Controller;
use App\Models\Ground;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class GroundAuthorityProfileController extends Controller
{
    public function index() {
        $authority = User::where("id", Auth::guard('g_authority')->user()->id)->first();
        $grounds = Ground::where('authority_id',Auth::guard('g_authority')->user()->id)->get();
        return view('ground-authority-profile', compact('authority','grounds'));
    }
}
