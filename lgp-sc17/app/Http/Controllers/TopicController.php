<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Response as HttpResponse;

use App\Models\User;
use App\Models\Follow;
use App\Models\Topic;

class TopicController extends Controller
{
    /**
     * Display the create topic page
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Admin/Forum/CreateTopic');
    }

    /**
     * Display the edit topic page
     */
    public function edit(Request $request, $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            abort(404, "Invalid topic id");
        }
        return Inertia::render('Admin/Forum/CreateTopic', ['topic' => $topic]);
    }

    /**
     * Handle the incoming edit topic request
     */
    public function update(Request $request, $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            abort(404, "Invalid topic id");
        }

        if(Auth::user()->cannot('edit', $topic)) {
            abort(401, "User not allowed to edit a topic");
        }

        $request->validate([
            'topic' => 'required|string|max:32',
            'color' => 'required|string|max:7',
        ]);

        if ($request->topic != null && $request->topic != $topic->topic && !Topic::where('topic', $request->topic)->get()->isEmpty()) {
            return back()->withErrors(['topic' => "topicExists"]);
        }

        if ($request->color != null && $request->color != $topic->color && !Topic::where('color', $request->color)->get()->isEmpty()) {
            return back()->withErrors(['color' => "colorError"]);
        }

        if ($request->topic != null) {
            $topic->topic = $request->topic;
        }
        if ($request->color != null) {
            $topic->color = $request->color;
        }

        $topic->save();

        return Redirect::route('admin.forum')->with(['success' => 'topicSuccessfullyUpdated']);
    } 

    /**
     * Handle an incoming topic request
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $topic = new Topic();

        if(Auth::user()->cannot('create', $topic)) {
            abort(401, "User not allowed to create a topic");
        }

        $request->validate([
            'topic' => 'required|string|max:32',
            'color' => 'required|string|max:7',
        ]);

        if (!Topic::where('topic', $request->topic)->get()->isEmpty()) {
            return back()->withErrors(['topic' => "topicExists"]);
        }

        if (!Topic::where('color', $request->color)->get()->isEmpty()) {
            return back()->withErrors(['color' => "colorError"]);
        }

        $topic->topic = $request->topic;
        $topic->color = $request->color;
        $topic->save();

        return Redirect::route('admin.forum')->with(['success' => 'topicSuccessfullyCreated']);
    }

    /**
     * Handle the request to delete a specific topic
     */
    public function delete(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $topic = Topic::find($id);
        
        if ($topic == null) {
            abort(404, "Invalid topic id");
        }
        
        if ($user->cannot('delete', $topic)) {
            abort(401, "User not allowed to delete topic " . $id);
        }

        $topic->delete();
        return Redirect::route('admin.forum')->with(['success' => 'topicSuccessfullyDeleted']);
    }

    /**
     * Handle the follow/unfollow request of a specific topic
     */
    public function follow(Request $request, $id)
    {
        $user = Auth::user();
        $topic = Topic::find($id);
        if ($topic == null) {
            abort(404, "There is no topic with id: " . $id);
        }

        if($user->cannot('follow', $topic)) {
            abort(401, "User is not allowed to follow a topic");
        }

        $userFollows = $topic->userFollows($user->id);
        if (!is_null($userFollows)) {
            $userFollows->delete();
            return response()->json(['action' => 'unfollow']);
        }

        Follow::create([
            'user_id' => $user->id,
            'topic_id' =>$id,
        ]);
        return response()->json(['action' => 'follow']);
    }
}
