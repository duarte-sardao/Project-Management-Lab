<?php

namespace App\Http\Controllers;

use App\Http\Requests\HospitalPostUpdateRequest;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HospitalController extends Controller
{
    function create(HospitalPostUpdateRequest $request) {
        $request->user()->fill($request->validated());

        $hospital = new Hospital();
        $hospital->name = $request->name;
        $hospital->save();

        return to_route('admin.hospitals')->with(['success' => 'hospitalCreated']);
    }

    function delete($id, Request $request) {
        $post = Hospital::find($id);
        $post->delete();
        return to_route('admin.hospitals')->with(['success' => 'hospitalDeleted']);
    }
}
