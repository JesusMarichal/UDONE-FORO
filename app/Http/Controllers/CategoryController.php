<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->withCount('threads')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its threads.
     */
    public function show(Category $category): View
    {
        $threads = $category->threads()
            ->with(['user', 'category'])
            ->withCount('posts')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('categories.show', compact('category', 'threads'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $this->authorize('create', Category::class);
        
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_active'] = true;
        $validated['order'] = Category::max('order') + 1;

        $category = Category::create($validated);

        return redirect()
            ->route('categories.show', $category)
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        $category->update($validated);

        return redirect()
            ->route('categories.show', $category)
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
