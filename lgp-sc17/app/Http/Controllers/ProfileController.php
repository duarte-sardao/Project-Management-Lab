<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function visualize(Request $request): Response
    {
        /* TODO: nextAppointment date
        $nextAppointment = date_create("25-09-1989 12:50 GMT");

        'nextAppointment' => [
            'date' => date_format($nextAppointment, 'd-m-Y'),
            'time' => date_format($nextAppointment, 'h\hi')
        ],
        */

        $user = Auth::getUser();
        $number = null;
        if ($user->isPatient()) {
            $number = Patient::where('user_id','=',$user->id)->first()->healthcare_number;
        } elseif ($user->isMedic()) {
            $number = Medic::where('user_id','=',$user->id)->first()->license_number;
        }

        return Inertia::render('Profile/Profile', [
            'isGuest' => $user->isGuest(),
            'status' => $user->status(),
            'number' => $number,
            'hospital' => $user->hospital->name,
            'nextAppointment' => [
                'date' => '',
                'time' => ''
            ],
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        $user = Auth::getUser();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;

        if (sizeof($request->files) == 1) {
            $fileName = $user->username.'.'.$request->file('profile_img')->getClientOriginalExtension();
            $request->file('profile_img')->move(public_path('/img/users/'), $fileName);
            $user->profile_img_url = '/img/users/'.$fileName;
        }

        $user->save();

        return Redirect::route('profile');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
