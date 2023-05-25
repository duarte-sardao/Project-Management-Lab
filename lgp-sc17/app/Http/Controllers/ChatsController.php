<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Patient;
use App\Models\Chat;
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


    public function fetchMessages() {
        return Message::with('user')->get();
    }

    public function fetchMessagesPatient() {
        $user = Auth::user();

        $patient_id = Patient::where('user_id','=',$user->getKey())->get('id');

        $messages = Message::where('patient_id','=',$patient_id[0]['id'])->get();

        foreach($messages as $message){
            $user_message = User::where('id','=', $message['user_id'])->get();
            $message['user'] = $user_message[0];
        }

        return $messages;
    }

    public function fetchMessagesMedic(Request $request) {
        $patient_user = $request->input('patient');

        $messages = Message::where('patient_id','=',$patient_user)->get();

        foreach($messages as $message){
            $user_message = User::where('id','=', $message['user_id'])->get();
            $message['user'] = $user_message[0];
        }

        return $message;
    }

    public function sendMessageMedic(Request $request) {
        $user = Auth::user();
        $patient_user = $request->input('patient');

        $patient_id = Patient::where('user_id','=',$patient_user)->get('id')[0]['id'];

        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'patient_id' => $patient_id
        ]);
        broadcast(new MessageSent($request->user(), $message))->toOthers();
    }

    public function sendMessagePatient(Request $request) {
        $user = Auth::user();

        $patient_id = Patient::where('user_id','=',$user->getKey())->get('id')[0]['id'];

        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'patient_id' => $patient_id
        ]);
        broadcast(new MessageSent($request->user(), $message))->toOthers();
    }
}
