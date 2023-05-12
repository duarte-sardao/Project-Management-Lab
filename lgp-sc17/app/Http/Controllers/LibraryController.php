<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryPostUpdateRequest;
use App\Models\LibraryPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LibraryController extends Controller
{
    function index($id) {
        $post = LibraryPost::find($id);
        if (!$post->public) {
            return back();
        }
        return Inertia::render('Library/LibraryPost', [
            'post' => $post,
        ]);
    }

    function create(LibraryPostUpdateRequest $request) {
        $request->user()->fill($request->validated());

        $post = new LibraryPost();
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->content = $request->body_content;
        $post->public = $request->public;
        $post->save();

        return to_route('admin.library.post',['id' => $post->id])->with(['post' => $post]);
    }

    function edit($id, LibraryPostUpdateRequest $request) {
        $request->user()->fill($request->validated());

        $post = LibraryPost::find($id);
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->content = $request->body_content;
        $post->public = $request->public;
        $post->save();

        return back();
    }

    function delete($id, Request $request) {
        $post = LibraryPost::find($id);
        $post->delete();
        return to_route('admin.library');
    }
}
