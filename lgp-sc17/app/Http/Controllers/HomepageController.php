<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomepageController extends Controller
{
    function index() {
        return Inertia::render('Home', [
            'posts' => LibraryPost::where('public','=', true)->orderBy('created_at', 'desc')->limit(8)->get()
        ]);
    }
}
