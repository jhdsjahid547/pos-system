<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Product/Index', [
            'products' => Product::with('category:id,name')->orderByDesc('created_at')->get(),
            'categories' => Category::all()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|numeric|unique:products,barcode',
            'sell_price' => 'required|numeric',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048'
        ]);
        Product::createProduct($request);
        return back()->with('success', 'Product Created!');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|numeric|unique:products,barcode,'.$id,
            'sell_price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048'
        ]);
        Product::updateProduct($request, $id);
        return back()->with('success', 'Product Updated');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return back()->with('success', 'Product deleted!!');
    }
}
