<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required']
        ]);
        Category::create($validated);
    }

    public function update($id, Request $request)
    {
        $categories = Category::findOrFail($id);
        $validated = $request->validate(['name' => ['required']]);
        $categories->update(['name' => $validated['name']]);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
    }
}
