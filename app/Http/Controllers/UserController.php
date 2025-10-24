<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the specified user profile.
     */
    public function show(User $user): View
    {
        $threads = $user->threads()
            ->with('category')
            ->withCount('posts')
            ->latest()
            ->paginate(10);

        $posts = $user->posts()
            ->with(['thread', 'thread.category'])
            ->latest()
            ->paginate(10);

        return view('users.show', compact('user', 'threads', 'posts'));
    }

    /**
     * Show the form for editing the user profile.
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user profile.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'career' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}
