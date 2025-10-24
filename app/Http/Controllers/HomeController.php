<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the forum homepage.
     */
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->withCount('threads')
            ->get();

        $recentThreads = Thread::with(['user', 'category'])
            ->withCount('posts')
            ->latest()
            ->take(10)
            ->get();

        $popularThreads = Thread::with(['user', 'category'])
            ->withCount('posts')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('categories', 'recentThreads', 'popularThreads'));
    }
}
