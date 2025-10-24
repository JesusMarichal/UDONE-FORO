<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Basic auth placeholder routes (prevent Route [login] / [register] not defined errors)
// These are simple views for now; replace with real auth controllers/scaffolding later.
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Admin routes for categories
Route::middleware(['auth'])->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Threads
Route::get('/threads/create', [ThreadController::class, 'create'])->middleware('auth')->name('threads.create');
Route::post('/threads', [ThreadController::class, 'store'])->middleware('auth')->name('threads.store');
Route::get('/threads/{thread:slug}', [ThreadController::class, 'show'])->name('threads.show');
Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->middleware('auth')->name('threads.edit');
Route::put('/threads/{thread}', [ThreadController::class, 'update'])->middleware('auth')->name('threads.update');
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->middleware('auth')->name('threads.destroy');
Route::post('/threads/{thread}/lock', [ThreadController::class, 'toggleLock'])->middleware('auth')->name('threads.lock');
Route::post('/threads/{thread}/pin', [ThreadController::class, 'togglePin'])->middleware('auth')->name('threads.pin');

// Posts
Route::post('/threads/{thread}/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
Route::post('/posts/{post}/solution', [PostController::class, 'markAsSolution'])->middleware('auth')->name('posts.solution');

// Users
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth')->name('users.update');
