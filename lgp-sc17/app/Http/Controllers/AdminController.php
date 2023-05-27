<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Topic;
use App\Models\LibraryPost;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Patient;
use App\Models\Medic;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisteredPatientController;
use App\Http\Controllers\Auth\RegisteredMedicController;

class AdminController extends Controller
{
    function index() {
        $users = User::orderBy('created_at', 'desc')->limit(4)->get();
        foreach ($users as $user) {
            $user['status'] = $user->status();
        }

        return Inertia::render('Admin/Dashboard', [
            'users' => $users,
            'library_posts' => LibraryPost::orderBy('created_at', 'desc')->limit(4)->get(),
            'forum_posts' => ForumPost::join('posts', 'post_id', '=', 'posts.id')
                ->orderBy('posted_at', 'desc')
                ->select('forum_posts.id', 'title', DB::raw("DATE_FORMAT(posted_at, '%d-%m-%Y %h:%i:%s') as date"))
                ->limit(4)->get()
        ]);
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
        $questionnaire = null;
        $appointment = null;
        if ($user->isPatient()) {
            $patient = Patient::where('user_id','=',$user->id)->first();
            $number = $patient->healthcare_number;
            $hospital = $patient->hospital->name;
            $questionnaire = $patient->questionnaire;
            $appointment = $patient->nextAppointment();
        } elseif ($user->isMedic()) {
            $medic = Medic::where('user_id','=',$user->id)->first();
            $number = $medic->license_number;
            $hospital = $medic->hospital->name;
            $appointment = $medic->nextAppointment();
        }

        $hosps = Hospital::orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/Users/UserInfo', [
            'user' => $user,
            'isGuest' => $user->isGuest(),
            'status' => $user->status(),
            'banned' => $user->isBanned(),
            'number' => $number,
            'hospital' => $hospital,
            'questionnaire' => $questionnaire,
            'nextAppointment' => $appointment,
            'hospital_list' => $hosps
        ]);
    }

    function ban(Request $request, $id) {

        $user = User::find($id);
        if ($user == null) {
            abort(404, 'User not found');
        }

        if (Auth::user()->cannot('manageBans', $user)) {
            abort(401, 'User not allowed manage bans');
        }
        $user->setBan(True);
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
    }

    
    function unban(Request $request, $id) {

        $user = User::find($id);
        if ($user == null) {
            abort(404, 'User not found');
        }

        if (Auth::user()->cannot('manageBans', $user)) {
            abort(401, 'User not allowed manage bans');
        }
        $user->setBan(False);
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
    }

    function registerPatient(Request $request, $id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, 'User not found');
        }
        if (Auth::user()->cannot('manageStatus', $user)) {
            abort(401, 'User not allowed to manage status');
        }

        $medic = Medic::whereHas(
            'user',
            function($q) use ($id) {
                return $q->where('id', '=', $id);
            }
        )->first();
        if ($medic != null) {
            $medic->delete();
        }

        Patient::updateOrCreate(
            ['user_id' => $id],
            [
                'healthcare_number' => $request->healthcare_number,
                'hospital_id' => intval($request->hospital_id),
                'date' => '',
                'time' => ''
            ]
        );
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
    }

    function registerMedic(Request $request, $id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, 'User not found');
        }
        if (Auth::user()->cannot('manageStatus', $user)) {
            abort(401, 'User not allowed to manage status');
        }

        $patient = Patient::whereHas(
            'user',
            function($q) use ($id) {
                return $q->where('id', '=', $id);
            }
        )->first();
        if ($patient != null) {
            $patient->delete();
        }
        
        Medic::updateOrCreate(
            ['user_id' => $id],
            [
                'license_number' => $request->license_number,
                'hospital_id' => intval($request->hospital_id),
                'date' => '',
                'time' => ''
            ]
        );
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
    }

    function setDate(Request $request, $id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, 'User not found');
        }
        if (Auth::user()->cannot('manageAppointments', $user)) {
            abort(401, 'User not allowed to manage appointments');
        }

        $usr = Patient::whereHas(
            'user',
            function($q) use ($id) {
                return $q->where('id', '=', $id);
            }
        )->first();
        if ($usr == null) {
            $usr = Medic::whereHas(
                'user',
                function($q) use ($id) {
                    return $q->where('id', '=', $id);
                }
            )->first();
        }

        if ($usr == null) {
            abort(404, 'Non-Guest user not found');
        }

        $usr->setDate($request->date, $request->time);
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
    }

    function setAdmin(Request $request, $id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, '');
        }

        if (Auth::user()->cannot('manageAdmins', $user)) {
            return;
        }

        $user->is_admin = true;
        $user->save();
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
    }

    function unsetAdmin(Request $request, $id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, 'User not found');
        }

        if (Auth::user()->cannot('manageAdmins', $user)) {
            abort(401, 'User not allowed to manage admins');
        }

        if (Auth::user()->id == $id) {
            abort(403, 'An admin cannot unset itself from the admin list');
        }

        if (count(User::where('is_admin', '=', true)->get()) <= 1) {
            abort(401, 'It must always exist an admin in the admin list');
        }

        $user->is_admin = false;
        $user->save();
        return Redirect::route('admin.users.info', $id)->with(['success' => 'userUpdatedWithSuccess']);
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

    function forumIndex(Request $request) {
        $result = [
            'topics' => Topic::select('id', 'topic', 'color')->get(),
            'posts' => ForumPost::join('posts', 'post_id', '=', 'posts.id')
                ->orderBy('posted_at', 'desc')
                ->select('forum_posts.id', 'title', DB::raw("DATE_FORMAT(posted_at, '%d-%m-%Y %h:%i:%s') as date"))
                ->paginate(6),
            ];

        $message = $request->session()->get('success');
        if (!is_null($message)) $result['message'] = $message;

        return Inertia::render('Admin/Forum/Forum', $result);
    }

    function hospitalsIndex(Request $request) {
        return Inertia::render('Admin/Hospitals', [
            'hospitals' => Hospital::orderBy('created_at', 'desc')->paginate(6)
        ]);
    }
}
