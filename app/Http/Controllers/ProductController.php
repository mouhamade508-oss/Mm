<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{


    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_digital' => 'boolean',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('digital_products', 'public');
            $validated['file_path'] = $filePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', '✅ تم إضافة المنتج بنجاح!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_digital' => 'boolean',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($product->file_path) {
                Storage::disk('public')->delete($product->file_path);
            }
            $filePath = $request->file('file_path')->store('digital_products', 'public');
            $validated['file_path'] = $filePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', '✅ تم تحديث المنتج بنجاح!');
    }

    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete digital file if exists
        if ($product->file_path) {
            Storage::disk('public')->delete($product->file_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', '✅ تم حذف المنتج بنجاح!');
    }
}
