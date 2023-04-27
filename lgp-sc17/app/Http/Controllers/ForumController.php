<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Post;
use App\Models\ForumPost;
use App\Models\Like;
use App\Models\Follow;
use App\Models\Answer;
use App\Models\Topic;
use App\Models\TopicPost;


class ForumController extends Controller
{

    /**
     * Get the elapsed time between two timestamps
     */
    private static function getTimeString(Carbon $from, Carbon $to)
    {
        $days_elapsed = $to->diffInDays($from);
        if ($days_elapsed > 0) return $days_elapsed . " day" . (($days_elapsed != 1) ? "s ":" ") . "ago";
        
        $hours_elapsed = $to->diffInHours($from);
        if ($hours_elapsed > 0) return $hours_elapsed . " hour" . (($hours_elapsed != 1) ? "s ":" ") . "ago";

        $minutes_elapsed = $to->diffInMinutes($from);
        if ($minutes_elapsed > 0) return $minutes_elapsed . " minute"  . (($minutes_elapsed != 1) ? "s ":" ") . "ago";
        return "Some seconds ago";
    }

    /**
     * Display the forum page
     */
    public function posts(Request $request): Response
    {
        $topics_followed = Auth::user()->follow;
        $forum_posts = ForumPost::all();
        $result = array();
        foreach($forum_posts as $forum_post) {
            array_push($result, [
                'id' => $forum_post->id,
                'title'=> $forum_post->title,
                'content'=> $forum_post->post->content,
                'posted_at'=> $forum_post->post->posted_at,
                'author' => [
                    'username' => $forum_post->post->user->username,
                    'image' => '/svg_icons/profile1.svg',
                ],
                'topics' => $forum_post->topics,
                'answers' => [
                    'quantity' => count($forum_post->answers),
                    'profile_pictures' => [],
                ],
                'follows' => count($topics_followed->intersect($forum_post->topics)) > 0,
            ]);
        }

        $topics = Topic::select('id', 'topic', 'color')->get();
        foreach ($topics as $topic) {
            $topic->follows = false; # TODO: check if the logged user follows this topic
        }

        return Inertia::render('Forum/Forum', ['posts' => $result, 'topics' => $topics]);
    }

        /**
     * Display the page of a specific forum post
     */
    public function post(Request $request, $id): Response
    {
        $user = Auth::user();
        $temp = ForumPost::find($id);
        if ($temp == null) {
            return back()->withErrors(['post' => "There is no forum post with id: " . $id])->with(['error' => 'An error has occurred']);
        }
        
        $forum_post = $temp->first();

        $topics = array();
        foreach ($forum_post->topics as $topic) {
            array_push($topics, [
                'topic_id' => $topic->id,
                'topic' => $topic->topic,
                'color' => $topic->color,
                'userFollows' =>  $topic->userFollows($user->id) != null,
            ]);
        }
    
        $answers = array();
        foreach($forum_post->answers as $answer) {
            $answer->content = $answer->post->content;
            $answer->elapsed_time = ForumController::getTimeString(now(), $answer->post->posted_at);
            $answer->user = [
                'username' => $answer->post->user->username,
                'image' => '/svg_icons/profile1.svg',
                'role' => 'Patient',
            ];
            $answer->likes = count($answer->post->likes);
            $answer->userLikes = $answer->post->userLikes($user->id);
            array_push($answers, $answer);
        }
    
        return Inertia::render('Forum/Post', ['post' => [
            'id' => $forum_post->id,
            'title'=> $forum_post->title,
            'content'=> $forum_post->post->content,
            'elspsed_time'=> ForumController::getTimeString(now(), $forum_post->post->posted_at),
            'author' => [
                'username' => $forum_post->post->user->username,
                'image' => '/svg_icons/profile1.svg',
            ],
            'topics' => $topics,
            'answers' => $answers,
            'likes' => count($forum_post->post->likes),
            'userLikes' => $forum_post->post->userLikes(Auth::user()->id),
        ]]);
    }

    /**
     * Display the create post page
     */
    public function create(Request $request): Response
    {

        return Inertia::render('Forum/CreatePost');
    }

    /**
     * Handle an incoming post request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $post = new Post();
        $this->authorize('create', $post);

        $request->validate([
            'title' => 'required|string|max:64',
            'content' => 'required|string',
            'topics' => 'required|array',
        ]);

        if (count($request->topics) > 4) {
            return back()->withErrors(['topics' => "Invalid number of topics"])->with(['error' => 'An error has occurred']);
        }

        $post->content = $request->content;
        $post->posted_at = now();
        $post->author = Auth::user()->id;
        $post->save();

        $forum_post = ForumPost::create([
            'title' => $request->title,
            'post_id' => $post->id,
        ]);


        foreach ($request->topics as $topic) {
            $topic_obj = Topic::create([
                'topic' => $topic['topic'],
                'color' => $topic['color'],
            ]);

            $topic_post = TopicPost::create([
                'forum_post_id' => $forum_post->id,
                'topic_id' => $topic_obj->id,
            ]);
        }

        return Redirect::route('forum')->with(['success' => 'Post created with success']);
    }

    /**
     * Handle an incoming answer request
     */
    public function answer(Request $request, $id): RedirectResponse
    {
        $answer = new Post();
        $this->authorize('reply', $answer);

        if (!ForumPost::find($id)) {
            return back()->withErrors(['answer' => "There is no forum post with id: " . $id])->with(['error' => 'An error has occurred']);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $answer->content = $request->content;
        $answer->posted_at = now();
        $answer->author = Auth::user()->id;

        $answer->save();

        Answer::create([
            'post_id' => $answer->id,
            'forum_post_id' => $id,
        ]);

        return Redirect::route('forum.post', $id)->with(['success' => 'Post replied with success']);
    }

    /**
     * Handles the like/unlike request of a forum post
     */
    public function like(Request $request, $id) 
    {

        $user = Auth::user();
        $forum_post = ForumPost::find($id);
        if ($forum_post == null) {
            return response("There is no post with id: " . $id, 404);
        }

        $userLikes = $forum_post->post->userLikes($user->id);
        if ($userLikes != null) {
            $userLikes->delete();
            return response()->json(['action' => 'unlike', 'likes' => count($forum_post->post->likes)]);
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $forum_post->post->id,
        ]);
        return response()->json(['action' => 'like', 'likes' => count($forum_post->post->likes)]);
    }

    /**
     * Handles the like/unlike request of a forum post answer
     */
    public function likeAnswer(Request $request, $id) 
    {
        $user = Auth::user();
        $answer = Answer::find($id);
        if ($answer == null) {
            return response("There is no answer post with id: " . $id, 404);
        }

        $userLikes = $answer->post->userLikes($user->id);
        if ($userLikes != null) {
            $userLikes->delete();
            return response()->json(['action' => 'unlike', 'likes' => count($answer->post->likes)]);
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $answer->post->id,
        ]);
        return response()->json(['action' => 'like', 'likes' => count($answer->post->likes)]);
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
        if ($userFollows != null) {
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
