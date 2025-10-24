<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request, Thread $thread)
    {
        if ($thread->is_locked) {
            return redirect()
                ->route('threads.show', $thread)
                ->with('error', 'Este hilo está bloqueado y no acepta nuevas respuestas.');
        }

        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['thread_id'] = $thread->id;

        $post = Post::create($validated);

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', 'Respuesta publicada exitosamente.');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()
            ->route('threads.show', $post->thread)
            ->with('success', 'Respuesta actualizada exitosamente.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $thread = $post->thread;
        $post->delete();

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', 'Respuesta eliminada exitosamente.');
    }

    /**
     * Mark a post as the solution.
     */
    public function markAsSolution(Post $post)
    {
        $thread = $post->thread;
        
        $this->authorize('markAsSolution', $post);

        $post->markAsSolution();

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', 'Respuesta marcada como solución.');
    }
}
