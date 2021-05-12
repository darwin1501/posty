<?php

namespace App\Http\Controllers;

use App\Mail\PostLiked;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\support\Facades\Mail;
class DashboardController extends Controller
{
    public function index()
    {
        //send mail testing
        // $user = auth()->user();
        // Mail::to($user)->send(new PostLiked());
        // dd(auth()->user()->post);
        return view('dashboard');
        // dd(auth()->user()->email);
    }
}
