<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function libraryPosts(Request $request) {
        return LibraryPost::where('public','=',true)
            ->where(function ($query) use ($request) {
                $query->where('title','like','%'.$request->search.'%')
                    ->orWhere('subtitle','like','%'.$request->search.'%')
                    ->orWhere('content','like','%'.$request->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);
    }

    function libraryPostsAdmin(Request $request) {
        return LibraryPost::where(function ($query) use ($request) {
            $query->where('title','like','%'.$request->search.'%')
                ->orWhere('subtitle','like','%'.$request->search.'%')
                ->orWhere('content','like','%'.$request->search.'%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(6);
    }
}