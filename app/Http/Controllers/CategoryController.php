<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia("Category/Index", ['categories' => Category::orderByDesc('created_at')->get(['id', 'name', 'code'])]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|min:2|max:255',
            'code' => 'numeric|unique:categories,code|max:255',
        ]);
        Category::createCategory($request);
        return back()->with('success', 'Category created!');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id.'|min:2|max:255',
            'code' => 'numeric|unique:categories,code,'.$category->id.'|max:255',
        ]);
        Category::updateCategory($request, $id);
        return back()->with('success', 'Category updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete();
        return back()->with('success', 'Category deleted!!');
    }
}
