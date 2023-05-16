<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
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
   * 
   */
  public function reply(User $user)
  {
    return Auth::check();
  }
  
}
