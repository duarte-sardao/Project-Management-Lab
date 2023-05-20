<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * 
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Only an admin user can delete a post
     */
    public function delete(User $user, Answer $answer)
    {
        return Auth::check() && ($user->is_admin || $user->id == $answer->post->author);
    }
}
