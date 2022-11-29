<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function store(Request $request){
        $comment = new Comment;
        $comment->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        $comment->comment = $request->comment_body;       
        $post->comments()->save($comment);

        return back();

    }
    function getComment($id){
        $comment = Comment::find($id);
        return response($comment);

    }
}
