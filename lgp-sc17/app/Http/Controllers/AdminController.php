<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    function index() {
        return Inertia::render('Admin/Dashboard');
    }

    function usersIndex() {
        return Inertia::render('Admin/Users/Users', [
            'users' => User::paginate(6)
        ]);
    }

    function userInfo($id) {

        $user = User::find($id);
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

        return Inertia::render('Admin/Users/UserInfo', [
            'user' => $user,
            'isGuest' => $user->isGuest(),
            'status' => $user->status(),
            'banned' => $user->isBanned(),
            'number' => $number,
            'hospital' => $hospital,
            'nextAppointment' => [
                'date' => '',
                'time' => ''
            ],
        ]);
    }

    function libraryIndex() {
        return Inertia::render('Admin/Library/Library', [
            'posts' => LibraryPost::orderBy('created_at', 'desc')->paginate(6)
        ]);
    }

    function libraryNew() {
        return Inertia::render('Admin/Library/LibraryNewPost');
    }

    function libraryPost($id) {
        return Inertia::render('Admin/Library/LibraryPost', [
            'post' => LibraryPost::find($id)
        ]);
    }

    function forumIndex() {
        return Inertia::render('Admin/Forum/Forum');
    }
}
