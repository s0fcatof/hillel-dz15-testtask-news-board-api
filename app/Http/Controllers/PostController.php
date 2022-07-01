<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Upvote;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

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
        ]);

        Post::create([
            'title' => $data['title'],
            'link' => $data['link'],
            'author_id' => $request->user()->id
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
            'link' => ['sometimes', 'url']
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
