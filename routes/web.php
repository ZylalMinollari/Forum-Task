<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Pages\TagController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ReplyController;
use App\Http\Controllers\Pages\ThreadController;
use App\Http\Controllers\Pages\ProfileController;

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
require 'admin.php';

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'threads', 'as' => 'threads.'], function () {
    /* Name: Threads
     * Url: /threads/*
     * Route: threads.*
     */
    Route::get('/', [ThreadController::class, 'index'])->name('index');
    Route::get('create', [ThreadController::class, 'create'])->name('create');
    Route::post('/', [ThreadController::class, 'store'])->name('store');
    Route::get('/{category:slug}/{thread:slug}', [ThreadController::class, 'show'])->name('show');
    Route::get('/{thread:slug}/edit', [ThreadController::class, 'edit'])->name('edit');
    Route::post('/{thread:slug}', [ThreadController::class, 'update'])->name('update');
    Route::get('/{category:slug}/{thread:slug}', [ThreadController::class, 'show'])->name('show');
    
    Route::group(['as' => 'tags.'], function () {
        Route::get('/{tag:slug}', [TagController::class, 'index'])->name('index');
    });
});

Route::group(['prefix' => 'replies', 'as' => 'replies.'], function () {
    /* Name: Replies
     * Url: /replies/*
     * Route: replies.*
     */
    Route::post('/', [ReplyController::class, 'store'])->name('store');
    Route::get('reply/{id}/{type}', [ReplyController::class, 'redirect'])->name('replyAble');
});

Route::get('/category/discussion/topic', [PageController::class, 'single'])->name('single');
Route::get('dashboard/users', [PageController::class, 'users'])->name('users');

Route::get('/dashboard/categories/index', [PageController::class, 'categoriesIndex'])->name('categories.index');
Route::get('/dashboard/categories/create', [PageController::class, 'categoriesCreate'])->name('categories.create');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
