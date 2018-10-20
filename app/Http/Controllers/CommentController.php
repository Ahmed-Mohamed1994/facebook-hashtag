<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Request $request,Post $post)
    {
        if (!$post){
            return redirect()->back();
        }
        $this->validate($request,['comment' => 'required|max:1000']);
        // convert hash tag to link
        $url = '@(#)([a-zA-Z0-9-./_]+)@';
        $comment_body = preg_replace($url, '<a href="$0">$0</a>', $request->comment);
        Comment::create([
            'body' => $comment_body,
            'post_id' => $post->id,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->back()->with(['message' => 'Comment Created Successfully!']);
    }

    public function edit(Comment $comment){
        if (Auth::user()->id != $comment->user_id){
            return redirect()->back();
        }

//        overwrite html to string
        $comment->body = htmlspecialchars(trim(strip_tags($comment->body)));;
        return view('comments.edit',compact('comment'));
    }

    public function update(Request $request, Comment $comment){
        if (Auth::user()->id != $comment->user_id){
            return redirect()->back();
        }
        $this->validate($request,['comment' => 'required|max:1000']);
        // convert hash tag to link
        $url = '@(#)([a-zA-Z0-9-./_]+)@';
        $comment_body = preg_replace($url, '<a href="$0">$0</a>', $request->comment);
        $comment->update([
            'body' => $comment_body
        ]);
        return redirect()->route('showPost',['post' => $comment->post_id])->with(['message' => 'Comment updated Successfully!']);
    }

    public function destroy(Comment $comment){
        if (Auth::user()->id != $comment->user_id && Auth::user()->type == "USER"){
            return redirect()->back();
        }
        $comment->delete();
        return redirect()->back()->with(['message' => 'Comment Successfully deleted!']);
    }
}
