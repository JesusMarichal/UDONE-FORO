<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThreadController extends Controller
{
    /**
     * Show the form for creating a new thread.
     */
    public function create(Request $request): View
    {
        $categoryId = $request->query('category_id');
        $categories = Category::where('is_active', true)->orderBy('order')->get();

        return view('threads.create', compact('categories', 'categoryId'));
    }

    /**
     * Store a newly created thread in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['view_count'] = 0;

        $thread = Thread::create($validated);

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', 'Hilo creado exitosamente.');
    }

    /**
     * Display the specified thread.
     */
    public function show(Thread $thread): View
    {
        $thread->incrementViewCount();
        
        $thread->load(['user', 'category']);
        
        $posts = $thread->posts()
            ->with('user')
            ->orderBy('is_solution', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('threads.show', compact('thread', 'posts'));
    }

    /**
     * Show the form for editing the specified thread.
     */
    public function edit(Thread $thread): View
    {
        $this->authorize('update', $thread);
        
        $categories = Category::where('is_active', true)->orderBy('order')->get();

        return view('threads.edit', compact('thread', 'categories'));
    }

    /**
     * Update the specified thread in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        $thread->update($validated);

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', 'Hilo actualizado exitosamente.');
    }

    /**
     * Remove the specified thread from storage.
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);

        $category = $thread->category;
        $thread->delete();

        return redirect()
            ->route('categories.show', $category)
            ->with('success', 'Hilo eliminado exitosamente.');
    }

    /**
     * Lock or unlock a thread.
     */
    public function toggleLock(Thread $thread)
    {
        $this->authorize('moderate', $thread);

        $thread->update(['is_locked' => !$thread->is_locked]);

        $message = $thread->is_locked ? 'Hilo bloqueado.' : 'Hilo desbloqueado.';

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', $message);
    }

    /**
     * Pin or unpin a thread.
     */
    public function togglePin(Thread $thread)
    {
        $this->authorize('moderate', $thread);

        $thread->update(['is_pinned' => !$thread->is_pinned]);

        $message = $thread->is_pinned ? 'Hilo fijado.' : 'Hilo desfijado.';

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', $message);
    }
}
