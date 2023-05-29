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

  public function manageStatus(User $user)
  {
    return Auth::check() && $user->is_admin;
  }

  public function manageBans(User $user)
  {
    return Auth::check() && $user->is_admin;
  }

  public function manageAppointments(User $user)
  {
    return Auth::check() && $user->is_admin;
  }

  public function manageQuestionnaire(User $user)
  {
    return Auth::check() && $user->is_admin;
  }
}
