<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ForumController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function posts(Request $request): Response
    {
        return Inertia::render('Forum/Forum');
    }

    public function post(Request $request): Response
    {
        return Inertia::render('Forum/Post');
    }
    
    public function create(Request $request): Response
    {
        return Inertia::render('Forum/CreatePost');
    }
}
