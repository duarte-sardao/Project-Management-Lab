<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Medic;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use function Termwind\renderUsing;

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
        $hospital = null;
        if ($user->isPatient()) {
            $patient = Patient::where('user_id','=',$user->id)->first();
            $number = $patient->healthcare_number;
            $hospital = $patient->hospital->name;
        } elseif ($user->isMedic()) {
            $medic = Medic::where('user_id','=',$user->id)->first();
            $number = $medic->license_number;
            $hospital = $medic->hospital->name;
        }

        return Inertia::render('Profile/Profile', [
            'isGuest' => $user->isGuest(),
            'status' => $user->status(),
            'number' => $number,
            'hospital' => $hospital,
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

        $user = User::find(Auth::id());
        $user->name = $request->name;

        if ((intval($request->phone_number) <= 0)) {
            return back()->withErrors(['phone_number' => "Phone number invalid"])->with(['error' => 'An error has occurred']);
        }
        $user->phone_number = $request->phone_number;

        $imageExtensions = ['jpg', 'jpeg', 'jpe', 'gif', 'png', 'svg', 'ico'];
        if (sizeof($request->files) == 1 && in_array($request->file('profile_img')->getClientOriginalExtension(), $imageExtensions)) {
            if ($user->profile_img_url != null) {
                File::delete(public_path($user->profile_img_url));
            }

            $fileName = $user->username.'.'.$request->file('profile_img')->getClientOriginalExtension();
            $request->file('profile_img')->move(public_path('/img/users/'), $fileName);

            $user->profile_img_url = '/img/users/'.$fileName;
        }

        $user->save();
        return Redirect::route('profile')->with(['success' => 'Profiled updated with success']);
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
