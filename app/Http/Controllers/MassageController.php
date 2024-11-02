<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Massage;

class MassageController extends Controller
{
    private function authentication_role(){
        $managerId = Auth::guard("t_manager")->check()
                    ? Auth::guard("t_manager")->user()->id
                    : Auth::guard("c_manager")->user()->id;
        return $managerId;
    }
    public function index($receiverId){
        $user_id = Auth::guard("t_manager")->check()
                ? Auth::guard("t_manager")->user()->id
                : Auth::guard("c_manager")->user()->id;
        $messages = Massage::where('sender_id', $user_id)
                ->where('receiver_id', $receiverId)
                ->orWhere(function ($query) use ($receiverId, $user_id) {
                    $query->where('sender_id', $receiverId)
                          ->where('receiver_id', $user_id);
                })->get();
        $sortedMessages = $messages->sortByDesc('created_at');
        return view('messages.index', compact('messages', 'receiverId'));
    }
    public function fetchMessages($receiverId){
        $user_id =Auth::guard("t_manager")->user()->id;
                
        $messages = Massage::where('sender_id', $user_id)
                ->where('receiver_id', $receiverId)
                ->orWhere(function ($query) use ($receiverId, $user_id) {
                    $query->where('sender_id', $receiverId)
                        ->where('receiver_id', $user_id);
                })->get();
        // $sortedMessages = $messages->sortByDesc('created_at');

        return response()->json($messages);
    }

    public function store(Request $request) {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|integer',
        ]);
    
        $user_id = Auth::guard("t_manager")->check()
            ? Auth::guard("t_manager")->user()->id
            : Auth::guard("c_manager")->user()->id;
    
        $message = Massage::create([
            'sender_id' => $user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
    
        return response()->json($message);
    }
}
