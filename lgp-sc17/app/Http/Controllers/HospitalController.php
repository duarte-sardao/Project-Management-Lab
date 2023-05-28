<?php

namespace App\Http\Controllers;

use App\Http\Requests\HospitalPostUpdateRequest;
use App\Models\Hospital;
use App\Models\Medic;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    function create(HospitalPostUpdateRequest $request) {
        $request->user()->fill($request->validated());

        if (Hospital::where('name','=',$request->name)->exists()) {
            return to_route('admin.hospitals')->with(['error' => 'hospitalUniqueError']);
        }

        $hospital = new Hospital();
        $hospital->name = $request->name;
        $hospital->save();

        return to_route('admin.hospitals')->with(['success' => 'hospitalCreated']);
    }

    function delete($id, Request $request) {
        $hospital = Hospital::find($id);
        $users = User::all();
        foreach ($users as $user) {
            if ($user->isPatient()) {
                if (Patient::where('user_id','=',$user->id)->first()->hospital->id == $id) {
                    return to_route('admin.hospitals')->with(['error' => 'hospitalDeletedError']);
                }
            } else if ($user->isMedic()) {
                if (Medic::where('user_id','=',$user->id)->first()->hospital->id === $id) {
                    return to_route('admin.hospitals')->with(['error' => 'hospitalDeletedError']);
                }
            }
        }

        $hospital->delete();
        return to_route('admin.hospitals')->with(['success' => 'hospitalDeleted']);
    }
}
