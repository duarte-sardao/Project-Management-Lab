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
     * Handle an incoming post request
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $topic = new Topic();
        $this->authorize('create', $topic);

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
     * Handle the request to destroy a specific topic
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $topic = Topic::find($id);
        
        if ($topic == null) {
            return back()->withErrors(['topic' => "Invalid topic id"]);
        }
        
        if ($user->cannot('delete', $topic)) {
            return back()->withErrors(['topic' => "User not allowed to delete topic " . $id]);
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
            return response("There is no topic with id: " . $id, 404);
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
