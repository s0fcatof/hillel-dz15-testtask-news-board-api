<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $user->id === $post->author_id
            ? Response::allow()
            : Response::deny('You cannot update other users\' posts.');
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->author_id
            ? Response::allow()
            : Response::deny('You cannot delete other users\' posts.');
    }

    public function upvote(User $user, Post $post)
    {
        $existing_upvote = Upvote::query()
            ->where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $post->id]
            ])->get()->first();

        return $existing_upvote === null
            ? Response::allow()
            : Response::deny('You have already upvoted this post.');
    }
}
