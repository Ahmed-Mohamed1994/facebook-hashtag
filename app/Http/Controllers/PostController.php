<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Request $request){
        $this->validate($request,['post' => 'required|max:1000']);
        // convert hash tag to link
        $url = '@(#)([a-zA-Z0-9-./_]+)@';
        $post_body = preg_replace($url, '<a href="$0">$0</a>', $request->post);
        Post::create([
           'body' => $post_body,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->back()->with(['message' => 'Post Created Successfully!']);
    }

    public function show(Post $post){
        return view('posts.index',compact('post'));
    }

    public function edit(Post $post){
        if (Auth::user()->id != $post->user_id){
            return redirect()->back();
        }

//        overwrite html to string
        $post->body = htmlspecialchars(trim(strip_tags($post->body)));;
        return view('posts.edit',compact('post'));
    }

    public function update(Request $request, Post $post){
        if (Auth::user()->id != $post->user_id){
            return redirect()->back();
        }
        $this->validate($request,['post' => 'required|max:1000']);
        // convert hash tag to link
        $url = '@(#)([a-zA-Z0-9-./_]+)@';
        $post_body = preg_replace($url, '<a href="$0">$0</a>', $request->post);
        $post->update([
            'body' => $post_body
        ]);
        return redirect()->route('showPost',['post' => $post->id])->with(['message' => 'Post updated Successfully!']);
    }

    public function destroy(Post $post){
        if (Auth::user()->id != $post->user_id && Auth::user()->type == "USER"){
            return redirect()->back();
        }
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('home')->with(['message' => 'Post Successfully deleted!']);
    }
}
