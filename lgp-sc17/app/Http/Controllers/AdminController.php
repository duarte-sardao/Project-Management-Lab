<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Topic;
use App\Models\LibraryPost;

use Illuminate\Support\Facades\DB;

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
                ->select('forum_posts.id', 'title', DB::raw("DATE_FORMAT(posted_at, '%d/%m/%Y') as date"))
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

    function ban($id) {

        $user = User::find($id);
        $user->setBan(True);
    }

    
    function unban($id) {

        $user = User::find($id);
        $user->setBan(False);
    }

    function updateUser(Request $request, $id) {
        switch ($request->action) {
            case 'ban':
                $this->ban($id);
                break;
            case 'unban':
                $this->unban($id);
                break;
            case 'register_patient': //patient may already exist, update? //doctor may exist, delete?
                Patient::create([
                    'user_id' => $id,
                    'healthcare_number' => $request->healthcare_number,
                    'hospital_id' => $request->hospital_id,
                ]);
                break;
            case 'register_medic': //same issue as patient
                Medic::create([
                    'user_id' => $id,
                    'license_number' => $request->license_number,
                    'hospital_id' => $request->hospital_id,
                ]);
                break;
        }
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
                ->select('forum_posts.id', 'title', DB::raw("DATE_FORMAT(posted_at, '%d/%m/%Y') as date"))
                ->paginate(6),
            ];

        $message = $request->session()->get('success');
        if (!is_null($message)) $result['message'] = $message;

        return Inertia::render('Admin/Forum/Forum', $result);
    }
}
