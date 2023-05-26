<?php

namespace App\Http\Controllers;

use App\Models\PatientMedics;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Patient;
use App\Models\Chat;
use App\Models\Medic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    function index() {
        $current_user = Auth::user();

        $user_is_medic = Medic::where('user_id','=', $current_user['id']);
        if($user_is_medic->exists()) {
            $has_patients = PatientMedics::where('medic_id','=',$user_is_medic->get()[0]['id'])->exists();
        
            if($has_patients) {
                return Inertia::render('Chat/ChatMedic');
            }
            return Inertia::render('ErrorPage', ['code' => 404]);
        } else {
            $patient = Patient::where('user_id','=', $current_user['id'])->get();

            $has_medics = PatientMedics::where('patient_id','=',$patient[0]['id'])->exists();

            if($has_medics) {
                return Inertia::render('Chat/ChatPatient');
            }
            return Inertia::render('ErrorPage', ['code' => 404]);
        }
    }

    function fetchMedics() {
        $current_user = Auth::user();

        $patient = Patient::where('user_id','=', $current_user['id'])->get();

        $medics = PatientMedics::where('patient_id','=',$patient[0]['id'])->get();

        $user_array= [];

        $i = 0;
        foreach($medics as $medic) {
            $medic_table = Medic::where('id', '=', $medic['medic_id'])->get()[0];
            $user_medic = User::where('id', '=', $medic_table['user_id']);
            $user_array[$i] = $user_medic->get();
            $i = $i + 1;
        }

        return $user_array;
    }

    function fetchPatients() {
        $current_user = Auth::user();

        $medic = Medic::where('user_id', '=', $current_user['id'])->get();

        $patients = PatientMedics::where('medic_id','=',$medic[0]['id'])->get();

        $user_array= [];

        $i = 0;
        foreach($patients as $patient) {
            $patient_table = Patient::where('id', '=', $patient['patient_id'])->get()[0];
            $user_medic = User::where('id', '=', $patient_table['user_id']);
            $user_array[$i] = $user_medic->get();
            $i = $i + 1;
        }

        return $user_array;
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

        $patient_id = Patient::where('user_id', '=', $patient_user)->get();

        $messages = Message::where('patient_id','=',$patient_id[0]['id'])->get();

        foreach($messages as $message){
            $user_message = User::where('id','=', $message['user_id'])->get();
            $message['user'] = $user_message[0];
        }

        return $messages;
    }

    public function sendMessageMedic(Request $request) {
        $user = Auth::user();

        $patient_user = $request->input('patient');

        $patient_id = Patient::where('user_id', '=', $patient_user)->get();

        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'patient_id' => $patient_id[0]['id']
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
