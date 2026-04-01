<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{


    public function index(Request $request)
    {
        $query = Product::whereNull('parent_id');

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

    public function create(Request $request)
    {
        $categories = Category::all();
        $selectedCategoryId = $request->query('category_id');
        return view('admin.products.create', compact('categories', 'selectedCategoryId'));
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
            try {
                $uploadResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'products',
                    'resource_type' => 'auto',
                ]);
                $validated['image'] = $uploadResult['secure_url'] ?? $uploadResult['url'];
            } catch (\Throwable $e) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }
        }

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('digital_products', 'public');
            $validated['file_path'] = $filePath;
        }

        Product::create($validated);

        // If category_id from query string, redirect to section show page
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category && $category->section_id) {
                $section = $category->section;
                return redirect()->route('admin.sections.show', $section)->with('success', '✅ تم إضافة المنتج بنجاح!');
            }
        }

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
            try {
                $uploadResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'products',
                    'resource_type' => 'auto',
                ]);
                $validated['image'] = $uploadResult['secure_url'] ?? $uploadResult['url'];
            } catch (\Throwable $e) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }
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

    // Variant management methods
    public function variants(Product $product)
    {
        $variants = $product->variants;
        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    public function createVariant(Product $product)
    {
        return view('admin.products.variants.create', compact('product'));
    }

    public function storeVariant(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_digital' => 'boolean',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240',
        ]);

        $validated['category_id'] = $product->category_id;
        $validated['parent_id'] = $product->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('digital_products', 'public');
            $validated['file_path'] = $filePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products.variants', $product)->with('success', '✅ تم إضافة المتغير بنجاح!');
    }

    public function editVariant(Product $product, Product $variant)
    {
        // Ensure the variant belongs to the product
        if ($variant->parent_id !== $product->id) {
            abort(404);
        }

        return view('admin.products.variants.edit', compact('product', 'variant'));
    }

    public function updateVariant(Request $request, Product $product, Product $variant)
    {
        // Ensure the variant belongs to the product
        if ($variant->parent_id !== $product->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_digital' => 'boolean',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($variant->file_path) {
                Storage::disk('public')->delete($variant->file_path);
            }
            $filePath = $request->file('file_path')->store('digital_products', 'public');
            $validated['file_path'] = $filePath;
        }

        $variant->update($validated);

        return redirect()->route('admin.products.variants', $product)->with('success', '✅ تم تحديث المتغير بنجاح!');
    }

    public function destroyVariant(Product $product, Product $variant)
    {
        // Ensure the variant belongs to the product
        if ($variant->parent_id !== $product->id) {
            abort(404);
        }

        // Delete image if exists
        if ($variant->image) {
            Storage::disk('public')->delete($variant->image);
        }

        // Delete digital file if exists
        if ($variant->file_path) {
            Storage::disk('public')->delete($variant->file_path);
        }

        $variant->delete();

        return redirect()->route('admin.products.variants', $product)->with('success', '✅ تم حذف المتغير بنجاح!');
    }
}
