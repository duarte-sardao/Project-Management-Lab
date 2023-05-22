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
   * Only logged users can create an answer
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Only logged users can like answers
     */
    public function like(User $user)
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
