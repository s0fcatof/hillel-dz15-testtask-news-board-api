<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

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
        return DB::table('upvotes')
            ->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->doesntExist()
            ? Response::allow()
            : Response::deny('You have already upvoted this post.');
    }
}
