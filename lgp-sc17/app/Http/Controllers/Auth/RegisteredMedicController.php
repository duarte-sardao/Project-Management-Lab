<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Medic;
use App\Models\Hospital;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredMedicController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register/Medic');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:32|unique:'.User::class,
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'license_number' => 'required|integer|unique:'.Medic::class,
            'terms' => 'required|boolean',
        ]);

        if (!$request->terms) {
            return redirect()->back()->withErrors(['terms' => 'Required Field']);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Medic::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
        ]);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming registration request to an existing user
     *
     */
    public function storeFromUser(Request $request, $id)
    {

        Hospital::create([
            'name' => 'test_hosp',
        ]);

        Medic::create([
            'user_id' => $id,
            'license_number' => $request->license_number,
            'hospital_id' => 1,
        ]);

        return;
    }
}
