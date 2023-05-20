<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumPost;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ForumPolicy
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
  public function delete(User $user, ForumPost $forum_post)
  {
    return Auth::check() && ($user->is_admin || $forum_post->post->isAuthor($user->id));
  }
}
