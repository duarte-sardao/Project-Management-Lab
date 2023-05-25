<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Medic;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    function index() {
        $user_is_medic = Medic::where('user_id','=',Auth::user())->exists();
        if($user_is_medic) {
            return Inertia::render('Chat/ChatMedic');
        }
        return Inertia::render('Chat/ChatPatient');
    }

    function createChat() {
        $user_is_medic = Medic::where('user_id','=',Auth::user())->exists();

        if(!$user_is_medic) {
            
        }
    }

    public function fetchMessages() {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request) {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message'),
        ]);
        broadcast(new MessageSent($request->user(), $message))->toOthers();
    }
}
