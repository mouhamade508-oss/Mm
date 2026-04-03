<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\BundleProduct;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bundles = Bundle::with('bundleProducts.product')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.bundles.index', compact('bundles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bundles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'bundle_price' => 'required|numeric|min:0|lt:original_price',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'products' => 'required|array|min:1'
        ]);

        $bundle = Bundle::create($request->only([
            'name', 'description', 'original_price', 'bundle_price', 'discount_percentage', 'is_active'
        ]));

        // Add products to bundle
        if ($request->has('products')) {
            foreach ($request->products as $productId => $productData) {
                if (isset($productData['selected']) && $productData['selected']) {
                    BundleProduct::create([
                        'bundle_id' => $bundle->id,
                        'product_id' => $productId,
                        'quantity' => $productData['quantity'] ?? 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.bundles.index')
            ->with('success', 'تم إضافة الباقة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bundle $bundle)
    {
        $bundle->load('bundleProducts.product');
        return view('admin.bundles.edit', compact('bundle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bundle $bundle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'bundle_price' => 'required|numeric|min:0|lt:original_price',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'products' => 'required|array|min:1'
        ]);

        $bundle->update($request->only([
            'name', 'description', 'original_price', 'bundle_price', 'discount_percentage', 'is_active'
        ]));

        // Remove existing bundle products
        $bundle->bundleProducts()->delete();

        // Add new products to bundle
        if ($request->has('products')) {
            foreach ($request->products as $productId => $productData) {
                if (isset($productData['selected']) && $productData['selected']) {
                    BundleProduct::create([
                        'bundle_id' => $bundle->id,
                        'product_id' => $productId,
                        'quantity' => $productData['quantity'] ?? 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.bundles.index')
            ->with('success', 'تم تحديث الباقة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bundle $bundle)
    {
        $bundle->bundleProducts()->delete(); // Delete related bundle products
        $bundle->delete();

        return redirect()->route('admin.bundles.index')
            ->with('success', 'تم حذف الباقة بنجاح');
    }
}
