<?php

namespace App\Http\Controllers;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    function chatMedics($patient_id, Request $request) {
        $medics = Medic::join('users', 'users.id', '=', 'medics.user_id')
            ->orderBy('medics.created_at', 'desc')
            ->paginate(6);

        return Inertia::render('Admin/Chat', [
            'patients' => Patient::join('users', 'users.id', '=', 'patients.user_id')->orderBy('patients.created_at', 'desc')->paginate(6),
            'medics' => $medics
        ]);
    }
}
