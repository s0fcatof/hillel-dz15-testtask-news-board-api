<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'max:1000'],
            'post_id' => ['required', 'exists:posts,id']
        ]);

        Comment::create([
            'content' => $data['content'],
            'author_id' => $request->user()->id,
            'post_id' => $data['post_id']
        ]);

        return response([
            'result' => 'Comment was added successfully.'
        ]);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'content' => ['required', 'max:1000']
        ]);

        $comment->update($data);

        return response(["result" => "Comment was successfully updated."]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response(["result" => "Comment was successfully deleted."]);
    }
}
