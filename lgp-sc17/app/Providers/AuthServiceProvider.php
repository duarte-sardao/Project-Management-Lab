<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\ForumPost;
use App\Policies\ForumPolicy;
use App\Models\Topic;
use App\Policies\TopicPolicy;
use App\Models\Answer;
use App\Policies\AnswerPolicy;
use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => Post::class,
        ForumPost::class => ForumPolicy::class,
        Topic::class => TopicPolicy::class,
        Answer::class => AnswerPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
