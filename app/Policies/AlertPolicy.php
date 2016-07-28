<?php

namespace App\Policies;
use App\User;
use App\Alert;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlertPolicy
{
    use HandlesAuthorization;

    
    public function destroy(User $user, Alert $alert)
    {
        return $user->id === $alert->user_id;
    }
}
