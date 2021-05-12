<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostLiked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    //this method will look at posts table and
    //search for the id of the liked post
    //the $post contains the post id and matched it to post table
    //this method uses route model binding
    public function likePost(Post $post, Request $request){

        // dd($post->likeBy($request->user()));
    //the $request->user()->id gets the id of the currently login user
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        //this will check if the user already liked the post
        //then send email if not.    
        if(!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()){
            //send mail
            //the mail accetps 2 argument
            //first the authenticated user
            //second the post that was liked
            //the $post->user was the users who owned the post
            Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
        }

        return back();
    }
    public function unlikePost(Post $post, Request $request){
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
