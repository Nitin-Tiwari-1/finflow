<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function accessDashboard(User $user)
    {
        return $user->isAdmin() || $user->isUser();
    }

    public function manageProfile(User $user)
    {
        return $user->isAdmin() || $user->isUser();
    }
}
