<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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


// Route::get('/posts/{id}/show', function($id){

//     $post = [
//        1 => ["title" => "Learn Laravel 10"],
//        2 => ["title" => "Learn Vue Js"]
//     ];

//     return view('posts.show', ['data' => $post[$id]]);
// });

// Route::get('/', function () {
//     // return view('welcome');

// });
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/show/{id}', [HomeController::class, 'show'])->name('show');
Route::get('/secret', [HomeController::class, 'secret'])->name('secret')->middleware('can:secret.page');

Route::get('/posts/archive', [PostController::class, 'archive'])->name('posts-archive');
Route::get('/posts/all', [PostController::class, 'all'])->name('all-posts');
Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts-restore');
Route::delete('/posts/{id}/drop', [PostController::class, 'drop'])->name('posts-drop');
Route::resource('/posts', PostController::class);

Route::resource('posts.comments', PostCommentController::class)->only(['store']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);

Route::get('/posts/tag/{id}', [PostTagController::class, 'index'])->name('posts-tag-index');

Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
