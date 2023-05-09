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

    function forumIndex() {
        return Inertia::render('Admin/Forum');
    }
}
