<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\PostLikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function(){
    return view('home');
})->name('home');

Route::get('/register', [RegisterController::class, 'index'])
    ->name('register')
    ->middleware('guest');

Route::get('/user/{user:username}/posts', [UserPostController::class, 'usersPost'])->name('users.post');

Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'logOut'])->name('logout');

Route::get('/login', [LoginController::class, 'index'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'verifyUser']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

//Post
Route::get('/post', [PostsController::class, 'index'])->name('post');
Route::get('/post/{post}', [PostsController::class, 'show'])->name('post.show');
Route::post('/post', [PostsController::class, 'post']);
Route::delete('/post/{post}', [PostsController::class, 'deletePost'])->name('post.destroy');

// pass the user id at route
// Route::post('/post/{id}/likes', [PostLikeController::class, 'likePost'])->name('post.like');

//route model binding
//pass the variable id at PostLikeController
Route::post('/post/{post}/likes', [PostLikeController::class, 'likePost'])->name('post.like');
Route::delete('/post/{post}/likes', [PostLikeController::class, 'unlikePost'])->name('post.like');
// Route::get('/', function () {
//     return view('posts.index');
// })->name('post');
