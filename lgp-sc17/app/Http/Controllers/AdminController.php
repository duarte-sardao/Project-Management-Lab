<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    function index() {
        return Inertia::render('Admin/Dashboard');
    }

    function usersIndex() {
        return Inertia::render('Admin/Users');
    }

    function libraryIndex() {
        return Inertia::render('Admin/Library');
    }

    function libraryNew() {
        return Inertia::render('Admin/LibraryNewPost');
    }

    function forumIndex() {
        return Inertia::render('Admin/Forum');
    }

    public function uploadImage(Request $request){
        $file = $request->file('file');
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . date("YmdHms") .'.'. $file->extension();
        $file->move(public_path('/images'), $fileName);
        return response()->json(['location'=>'/images/'.$fileName]);
    }
}
