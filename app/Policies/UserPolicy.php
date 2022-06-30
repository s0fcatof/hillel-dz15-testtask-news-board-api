<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model)
    {
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('You cannot update other users.');
    }

    public function delete(User $user, User $model)
    {
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('You cannot delete other users.');
    }
}
