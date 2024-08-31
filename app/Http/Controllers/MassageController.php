<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Massage;

class MassageController extends Controller
{
    public function index($userId){
        $messages = Massage::where('sender_id', Auth::guard('t_manager')->user()->id)
                ->where('receiver_id', $userId)
                ->orWhere(function ($query) use ($userId) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', Auth::guard('t_manager')->user()->id);
                })->get();
        $sortedMessages = $messages->sortByDesc('created_at');
        return view('messages.index', compact('messages', 'userId'));
    }
    public function fetchMessages($userId){
        $messages = Massage::where('sender_id', Auth::guard('t_manager')->user()->id)
                ->where('receiver_id', $userId)
                ->orWhere(function ($query) use ($userId) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', Auth::guard('t_manager')->user()->id);
                })->get();
        // $sortedMessages = $messages->sortByDesc('created_at');

        return response()->json($messages);
    }

    public function store(Request $request){
        $message = Massage::create([
            'sender_id' => Auth::guard('t_manager')->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }
}
