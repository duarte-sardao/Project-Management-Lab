<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use App\Models\User;
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

    function userListAdmin(Request $request) {
        return User::where(function ($query) use ($request) {
            $query->where('name','like','%'.$request->search.'%')
            ->orWhere('username','like','%'.$request->search.'%');
        })->paginate(6); //idfk como adicionar o status aqui
    }
}
