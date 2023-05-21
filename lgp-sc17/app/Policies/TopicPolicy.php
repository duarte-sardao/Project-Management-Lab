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
   * Only an admin user can create topics
   */
  public function create(User $user)
  {
    return Auth::check() && $user->is_admin;
  }

  /**
   * Only logged users can follow topics 
   */
  public function follow(User $user)
  {
    return Auth::check();
  }

  /**
   * Only an admin user can delete topics
   */
  public function delete(User $user)
  {
    return Auth::check() && $user->is_admin;
  }
}
