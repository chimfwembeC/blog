<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\LikeController;
use App\Models\Post;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);
Route::resource('shares', ShareController::class);


Route::post('likePost/{postId}', [LikeController::class, 'likePost'])->name('likePost');
Route::post('/comments/{comment}/like', 'LikeController@likeComment')->name('likeComment');
// Route::post('/shares/{share}', 'ShareController@sharePost')->name('shares.sharePost');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {      
    Route::get('/dashboard', function () {
        $posts = Post::latest()
        ->paginate(15);
        $postCount = Post::count();

        return view('dashboard', compact('posts'), compact('postCount'));
    })->name('dashboard');
});
