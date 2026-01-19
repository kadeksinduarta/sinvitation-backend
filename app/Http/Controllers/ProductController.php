<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function indexPublic()
    {
        $products = Product::where('status', 'active')->orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'has_photo' => 'required|boolean',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'preview_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/products', 'public');
            $validated['image'] = $path;
        }

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'has_photo' => 'required|boolean',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'preview_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('uploads/products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
