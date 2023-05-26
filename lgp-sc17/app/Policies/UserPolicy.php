<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
  use HandlesAuthorization;

  /**
   * 
   */
  public function manageAdmins(User $user)
  {
    return Auth::check() && $user->is_admin;
  }
}
