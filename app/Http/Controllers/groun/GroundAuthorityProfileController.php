<?php

namespace App\Http\Controllers\groun;

use App\Http\Controllers\Controller;
use App\Models\Ground;
use App\Models\Tournament;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroundAuthorityProfileController extends Controller
{
    public function index() {
        $authority = User::where("id", Auth::guard('g_authority')->user()->id)->first();
        $grounds = Ground::where('authority_id',Auth::guard('g_authority')->user()->id)->get();
        return view('ground-authority-profile', compact('authority','grounds'));
    }

    public function all_booking($id)  {
        $bookings = Tournament::where('venue', $id)
            ->where('end_date', '>=', Carbon::today())
            ->get();
        return view('show-allbooking',compact('bookings'));
    }
}
