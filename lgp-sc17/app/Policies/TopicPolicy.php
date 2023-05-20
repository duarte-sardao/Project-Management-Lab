<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TopicPolicy
{
  use HandlesAuthorization;

  /**
   * 
   */
  public function create(User $user)
  {
    return Auth::check() && $user->is_admin;
  }

  /**
   * Only an admin user can delete a post
   */
  public function delete(User $user)
  {
    return Auth::check() && $user->is_admin;
  }
}
