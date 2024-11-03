<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function markMessagesAsSeen($receiverId,$user_id) {    
        Massage::where('sender_id', $receiverId)
               ->where('receiver_id', $user_id)
               ->where('is_seen', false)
               ->update(['is_seen' => true]);
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
        $this->markMessagesAsSeen($receiverId,$user_id);
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
        $this->markMessagesAsSeen($receiverId,$user_id);
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
            'is_seen' => false,
        ]);
    
        return response()->json($message);
    }

    public function fetchManagersMessages()
    {
        $userId = Auth::guard("t_manager")->check()
            ? Auth::guard("t_manager")->user()->id
            : Auth::guard("c_manager")->user()->id;

        // Get all managers with the role 't_manager'
        $managers = User::where('role', 't_manager')->get()->map(function($manager) use ($userId) {
            $manager->unseenMessagesCount = Massage::where('sender_id', $manager->id)
                ->where('receiver_id', $userId)
                ->where('is_seen', false)
                ->count();
            return $manager;
        });

        // Total unseen messages count
        $unseenMessagesCount = $managers->sum('unseenMessagesCount');

        return response()->json([
            'managers' => $managers,
            'unseenMessagesCount' => $unseenMessagesCount,
        ]);
    }
    
}
