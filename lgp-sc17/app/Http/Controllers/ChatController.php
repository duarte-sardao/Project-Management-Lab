<?php

namespace App\Http\Controllers;

use App\Models\Medic;
use App\Models\Patient;
use App\Models\PatientMedics;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    function chatMedics($patient_id, Request $request) {
        $patients = Patient::select('patients.*', 'users.name', 'users.username')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->orderBy('patients.created_at', 'desc')
            ->paginate(6);

        $medics = Medic::select('medics.*', 'users.name')
            ->join('users', 'users.id', '=', 'medics.user_id')
            ->orderBy('medics.created_at', 'desc')
            ->paginate(6);

        $patients_medics = PatientMedics::where('patient_id','=',$patient_id)->get();

        foreach ($medics as $medic) {
            $medic['state'] = 'associated_false';
            foreach ($patients_medics as $patients_medic) {
                if ($patients_medic->medic_id == $medic->id) {
                    $medic['state'] = 'associated_true';
                    break;
                }
            }
        }

        return Inertia::render('Admin/Chat', [
            'patients' => $patients,
            'medics' => $medics,
            'patient_id' => $patient_id
        ]);
    }

    function addMedicToPatient($patient_id, $medic_id, Request $request) {
        if (!Patient::where('id','=',$patient_id)->exists() || !Medic::where('id','=',$medic_id)->exists()) {
            return to_route('admin.chat', ['patient_id' => $patient_id]);
        }
        $patient_medic = new PatientMedics();
        $patient_medic->patient_id = $patient_id;
        $patient_medic->medic_id = $medic_id;
        $patient_medic->save();
        return to_route('admin.chat.medics', ['patient_id' => $patient_id]);
    }

    function removeMedicToPatient($patient_id, $medic_id, Request $request) {
        if (!Patient::where('id','=',$patient_id)->exists() || !Medic::where('id','=',$medic_id)->exists()) {
            return to_route('admin.chat', ['patient_id' => $patient_id]);
        }
        $patient_medic = PatientMedics::where('patient_id','=',$patient_id)
            ->where('medic_id','=',$medic_id)->first();
        $patient_medic->delete();
        return to_route('admin.chat.medics', ['patient_id' => $patient_id]);
    }
}
