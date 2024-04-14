<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('products.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);
        $image = $request->file('image');
        $destinationPath = public_path('uploads');
        $fileName = uniqid() . '_' . $image->getClientOriginalName();
        $image->move($destinationPath, $fileName);
        $data['image'] = '/uploads/' . $fileName;

        Product::create($data);

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'image|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('uploads');
            $fileName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $fileName);
            $data['image'] = '/uploads/' . $fileName;
            if ($product->image) {
                $oldImagePath = public_path($product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $product->update($data);

        return redirect()->route('products.index');
    }

    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }
}
