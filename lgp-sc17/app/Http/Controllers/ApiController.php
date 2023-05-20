<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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

    function forumPostsAdmin(Request $request) {
        return DB::table('forum_posts')
            ->join('posts', 'forum_posts.post_id', '=', 'posts.id')
            ->select('forum_posts.id', 'forum_posts.title', DB::raw("DATE_FORMAT(posts.posted_at, '%d/%m/%Y') as date"))
            ->where('forum_posts.title', 'like', '%'.$request->search.'%')
            ->orderBy('date')->get();
    }
}
