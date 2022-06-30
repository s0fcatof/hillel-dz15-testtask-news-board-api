<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Upvote;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'max:80'],
            'link' => ['required', 'url'],
            'author_id' => ['required', 'exists:users,id']
        ]);

        Post::create([
            'title' => $data['title'],
            'link' => $data['link'],
            'author_id' => $data['author_id']
        ]);

        return response([
            'result' => 'Post was added successfully.'
        ]);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'max:80'],
            'link' => ['sometimes', 'url'],
            'author_id' => ['sometimes', 'exists:users,id']
        ]);

        $post->update($data);

        return response(["result" => "Post was successfully updated."]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response(["result" => "Post was successfully deleted."]);
    }

    public function upvote(Request $request, Post $post)
    {
        Upvote::create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'upvoted_at' => Carbon::now()
        ]);

        return response(["result" => "Post was successfully upvoted."]);
    }
}
