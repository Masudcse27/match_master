<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClubManagerController extends Controller
{
    public function index()  {
        return view('club-manager');
    }
}
