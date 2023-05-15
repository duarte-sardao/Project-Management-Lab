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

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;

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

    public function createTopic(Request $request): Response
    {
        return Inertia::render('Admin/CreateTopic');
    }

    public function storeTopic(Request $request): RedirectResponse
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

        return Redirect::route('forum')->with(['success' => 'Post created with success']);
    }



    /**
     * Get the elapsed time between two timestamps
     */
    private static function getTimeString(Carbon $from, Carbon $to)
    {
        $days_elapsed = $to->diffInDays($from);
        if ($days_elapsed > 0) return ["quantity" => $days_elapsed, "type"=> "day" . (($days_elapsed != 1) ? "s":"") ];
        
        $hours_elapsed = $to->diffInHours($from);
        if ($hours_elapsed > 0) return ["quantity" => $hours_elapsed, "type" => "hour" . (($hours_elapsed != 1) ? "s":"") ];

        $minutes_elapsed = $to->diffInMinutes($from);
        if ($minutes_elapsed > 0) return ["quantity" => $minutes_elapsed, "type" => "minute"  . (($minutes_elapsed != 1) ? "s":"")];
        return ["type" => "seconds"];
    }

    /**
     * Paginate a collection of items
     */
    private static function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Order a collection of posts in a specific order
     */
    private static function orderPosts($collection, $order)
    {
        switch ($order) {
            case 'latestFirst':
                return $collection->sortByDesc('posted_at');
            case 'oldestFirst':
                return $collection->sortBy('posted_at');
            case 'mostLikesFirst':
                return $collection->sortByDesc('likes');
            case 'lessLikesFirst':
                return $collection->sortBy('likes');                
        }
    }

    /**
     * Retrieve the data of each post given a collection of posts
     */
    private static function getForumPostsData($forum_posts)
    {
        $topics_followed = Auth::user()->follow;
        $result = collect([]);
        foreach($forum_posts as $forum_post) {
            $answers = $forum_post->answers;
            $profile_pictures = array();
            $quantity = min(count($answers), 4);
            for ($i = 0; $i < $quantity; $i++) {
                array_push($profile_pictures, '/svg_icons/profile4.svg');
            }

            $content = $forum_post->post->content;
            if (strlen($content > 180)) {
                $content = substr($content, 0, 177) . '...';
            }

            $result->push([
                'id' => $forum_post->id,
                'title'=> $forum_post->title,
                'content'=> $content,
                'posted_at'=> $forum_post->post->posted_at,
                'author' => [
                    'username' => $forum_post->post->user->username,
                    'image' => '/svg_icons/profile1.svg',
                ],
                'topics' => $forum_post->topics,
                'answers' => [
                    'quantity' => count($answers),
                    'profile_pictures' => $profile_pictures,
                ],
                'likes' => count($forum_post->post->likes),
                'userLikes' => $forum_post->post->userLikes(Auth::user()->id),
                'follows' => count($topics_followed->intersect($forum_post->topics)) > 0,
            ]);
        }
        return $result;
    }

    /**
     * Retrieve a specific page of a collection of posts ordered as specified
     */
    private static function getPaginator($forum_posts, $order, $page)
    {
        $paginator = ForumController::paginate(
            ForumController::orderPosts(
                ForumController::getForumPostsData($forum_posts),
                $order
            ),
            5,
            $page
        );

        return [
            "currentPagePosts" => array_values($paginator->items()),
            "currentPage" => $paginator->currentPage(),
            "lastPage" => $paginator->lastPage(),
        ];
    }

    /**
     * Get the forum page according to some filters
     */
    private static function getPosts(Request $request, $forum_posts, $currentForum = null, $currentTopic = null)
    {
        $order = "latestFirst";
        if ($request->selected) {
            $order = $request->selected;
        }

        $page = null;
        if ($request->page) {
            $page = $request->page;
        }

        $paginator = ForumController::getPaginator($forum_posts, $order, $page);

        $topics = Topic::select('id', 'topic', 'color')->orderBy('topic')->get();

        $result = [
            'posts' => $paginator['currentPagePosts'],
            'currentPage' => $paginator['currentPage'],
            'lastPage' => $paginator['lastPage'],
            'topics' => $topics,
            'order' => $order
        ];
        if (!is_null($currentForum)) $result['currentForum'] = $currentForum;
        else $result['currentTopic'] = $currentTopic;
        
        if (!is_null($request->search)) $result['search'] = $request->search;

        return Inertia::render('Forum/Forum', $result);
    }

    /**
     * Get forum posts according to a specific query
     */
    public function search(Request $request)
    {
        $searchContent = $request->search;
        $ids = DB::table('forum_posts')
                    ->leftJoin('topic_post', 'forum_posts.id', '=', 'topic_post.forum_post_id')
                    ->leftJoin('topics', 'topic_post.topic_id', '=', 'topics.id')
                    ->join('posts', 'forum_posts.post_id', '=', 'posts.id')
                    ->join('users', 'posts.author', '=', 'users.id')
                    ->where('title', 'like', '%' . $searchContent . '%')
                    ->orWhere('content', 'like', '%' . $searchContent . '%')
                    ->orWhere('username', 'like', '%' . $searchContent . '%')
                    ->orWhere('name', 'like', '%' . $searchContent . '%')
                    ->orWhere('topic', 'like', '%' . $searchContent , '%')
                    ->get('forum_posts.id')
                    ->unique();

        $forum_posts = collect([]);
        foreach($ids as $forum_post) {
            $forum_posts->push(ForumPost::find($forum_post->id));
        }

        return ForumController::getPosts($request, $forum_posts, -1);
    }

    /**
     * Get the forum page
     */
    public function posts(Request $request): Response
    {
        return ForumController::getPosts($request, ForumPost::all(), 0);
    }

    /**
     * Get the forum page, displaying only forum posts associated with the topics which the user follows
     */
    public function following_posts(Request $request): Response
    {
        $topics_followed = Auth::user()->follow;
        $result = collect([]);
        foreach ($topics_followed as $topic) {
            $forum_posts = $topic->posts;
            $result = $result->merge($forum_posts);
        }
        $result = $result->unique('id');

        return ForumController::getPosts($request, $result, 1);
    }

    /**
     * Get the forum posts, displaying only the forum posts authored by the user
     */
    public function my_discussions(Request $request): Response
    {
        return ForumController::getPosts($request, Auth::user()->posts, 2);
    }

    /**
     * Get the forum posts, displaying only the forum posts associated with a specific topic
     */
    public function topic_posts(Request $request, $id): Response
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return back()->withErrors(['topic' => "There is no topic with id: " . $id])->with(['error' => 'An error has occurred']);
        }

        return ForumController::getPosts($request, $topic->posts, currentTopic:$id);
    }

    /**
     * Display the page of a specific forum post
     */
    public function post(Request $request, $id): Response
    {
        $order = "latestFirst";
        if ($request->selected) {
            $order = $request->selected;
        }

        $user = Auth::user();
        $forum_post = ForumPost::find($id);
        if ($forum_post == null) {
            return back()->withErrors(['post' => "There is no forum post with id: " . $id])->with(['error' => 'An error has occurred']);
        }

        $currentTopic = $request->get('currentTopic');
        $topics = array();
        foreach ($forum_post->topics as $index => $topic) {
            if ($currentTopic == null && !is_null($topic->userFollows($user->id))) {
                $currentTopic = $index;
            } else if ($topic->id == $request->get('currentTopic')) {
                $currentTopic = $index;
            }
            array_push($topics, [
                'topic_id' => $topic->id,
                'topic' => $topic->topic,
                'color' => $topic->color,
                'userFollows' =>  !is_null($topic->userFollows($user->id)),
                'selected' => false,
            ]);
        }

        $quantityTopics = count($topics);
        if ($quantityTopics) {
            if ($currentTopic > $quantityTopics || $currentTopic < 0 || $currentTopic == null) {
                $currentTopic = 0;
            }
            $topics[$currentTopic]['selected'] = true;
        }
    
        $answers = collect([]);
        foreach($forum_post->answers as $answer) {
            $answer->content = $answer->post->content;
            $answer->posted_at = $answer->post->posted_at; // used to order the answers
            $answer->elapsed_time = ForumController::getTimeString(now(), $answer->post->posted_at);
            $answer->user = [
                'username' => $answer->post->user->username,
                'image' => '/svg_icons/profile1.svg',
                'role' => 'Patient',
            ];
            $answer->likes = count($answer->post->likes);
            $answer->userLikes = $answer->post->userLikes($user->id);
            $answers->push($answer);
        }
    
        return Inertia::render('Forum/Post', ['currentTopic' => $currentTopic, 'order' => $order, 'post' => [
            'id' => $forum_post->id,
            'title'=> $forum_post->title,
            'content'=> $forum_post->post->content,
            'elspsed_time'=> ForumController::getTimeString(now(), $forum_post->post->posted_at),
            'author' => [
                'username' => $forum_post->post->user->username,
                'image' => '/svg_icons/profile1.svg',
            ],
            'topics' => $topics,
            'answers' => ForumController::orderPosts($answers, $order),
            'likes' => count($forum_post->post->likes),
            'userLikes' => $forum_post->post->userLikes(Auth::user()->id),
        ]]);
    }

    /**
     * Display the create post page
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Forum/CreatePost', [
            'topics' => Topic::all()->map(function ($topic) { return array_merge($topic->only(['topic', 'color']), ['selected' => false]); })
        ]);
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
            'topics' => 'array',
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
            $topic_obj = Topic::where('topic', $topic['topic'])->first();
            if ($topic_obj == null) {
                $topic_obj = Topic::create([
                    'topic' => $topic['topic'],
                    'color' => $topic['color'],
                ]);
            }

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
        if (!is_null($userLikes)) {
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
        if (!is_null($userLikes)) {
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
