<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('courses')->latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active'   => ['boolean'],
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active'   => ['boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete a category that has courses. Reassign or delete courses first.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    public function toggle(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        $label = $category->is_active ? 'activated' : 'deactivated';
        return back()->with('success', '"' . $category->name . '" ' . $label . '.');
    }
}