<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Support\Facades\DB;
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

    function forumPostsAdmin(Request $request) {
        return DB::table('forum_posts')
            ->join('posts', 'forum_posts.post_id', '=', 'posts.id')
            ->where('forum_posts.title', 'like', '%'.$request->search.'%')
            ->orderBy('posted_at', 'desc')
            ->select('forum_posts.id', 'forum_posts.title', DB::raw("DATE_FORMAT(posts.posted_at, '%d/%m/%Y') as date"))
            ->paginate(6);
    }

    function userListAdmin(Request $request)
    {
        $users = User::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('username', 'like', '%' . $request->search . '%');
        })->paginate(6);


        foreach ($users as $key => $user) {
            $users[$key]['status'] = User::find($user['id'])->status();
        }

        return $users;
    }

    function hospitals(Request $request) {
        return Hospital::where('name','like','%'.$request->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
    }
}
