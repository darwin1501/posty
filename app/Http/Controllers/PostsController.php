<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->only(['post', 'deletePost']);
    }
    //show all post
    public function index(){
        // $post = Post::get();

        //paginate data
        //uses eager loading with(['name of table', 'name of table'])
        //use eager loading when table relationship has been used
        //put the name of the tables with relationship in with() method
        $post = Post::with(['user', 'likes'])->orderBy('created_at', 'desc')
                ->paginate(3);
                
        return view('posts.index', [
            'posts' => $post
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show',[
            'posts' => $post
        ]);
    }

    public function post(Request $request)
    {
        //validate request
        $this->validate($request, [
            'body' => 'required'
        ]);

        //create post and grab user id at users table and
        // store it to user_id field on posts table 
        //post() method is a post model
        //create() method store the post at post table
        // $request->user()->post()->create([
        //     'body' => $request->body
        // ]);

        //short hand method if only one field
        // to be filled up.
        $request->user()->post()->create($request->only('body'));
         
        //return to the current page
        return back();
    }

    public function deletePost(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        // dd($post);
        return back();
    }
}
