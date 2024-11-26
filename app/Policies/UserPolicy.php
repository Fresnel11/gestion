<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Déterminer si l'utilisateur peut gérer les autres utilisateurs.
     */
    public function manage(User $user)
    {
        return $user->role === 'admin';
    }
}
