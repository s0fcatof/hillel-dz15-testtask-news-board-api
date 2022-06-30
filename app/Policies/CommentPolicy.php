<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id
            ? Response::allow()
            : Response::deny('You cannot update other users\' comments.');
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id
            ? Response::allow()
            : Response::deny('You cannot delete other users\' comments.');
    }
}
