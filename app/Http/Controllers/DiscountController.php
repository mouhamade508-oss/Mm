<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the discounts.
     */
    public function index()
    {
        $discounts = Discount::latest()->paginate(15);
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new discount.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.discounts.create', compact('products'));
    }

    /**
     * Store a newly created discount in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts|max:50',
            'description' => 'nullable|string|max:500',
            'percentage' => 'required|numeric|min:0.01|max:100',
            'type' => 'required|in:general,specific',
            'product_id' => 'required_if:type,specific|nullable|exists:products,id',
            'valid_from' => 'required|date_format:Y-m-d\TH:i',
            'valid_until' => 'required|date_format:Y-m-d\TH:i|after:valid_from',
            'usage_limit' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            Discount::create([
                'code' => strtoupper($validated['code']),
                'description' => $validated['description'],
                'percentage' => $validated['percentage'],
                'type' => $validated['type'],
                'product_id' => $validated['type'] === 'specific' ? $validated['product_id'] : null,
                'valid_from' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['valid_from']),
                'valid_until' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['valid_until']),
                'usage_limit' => $validated['usage_limit'],
                'used_count' => 0,
                'is_active' => $request->has('is_active'),
            ]);
            return redirect()->route('admin.discounts.index')
                ->with('success', 'تم إنشاء الكود الخصم بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified discount.
     */
    public function edit(Discount $discount)
    {
        $products = Product::all();
        return view('admin.discounts.edit', compact('discount', 'products'));
    }

    /**
     * Update the specified discount in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code,' . $discount->id . '|max:50',
            'description' => 'nullable|string|max:500',
            'percentage' => 'required|numeric|min:0.01|max:100',
            'type' => 'required|in:general,specific',
            'product_id' => 'required_if:type,specific|nullable|exists:products,id',
            'valid_from' => 'required|date_format:Y-m-d\TH:i',
            'valid_until' => 'required|date_format:Y-m-d\TH:i|after:valid_from',
            'usage_limit' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            $discount->update([
                'code' => strtoupper($validated['code']),
                'description' => $validated['description'],
                'percentage' => $validated['percentage'],
                'type' => $validated['type'],
                'product_id' => $validated['type'] === 'specific' ? $validated['product_id'] : null,
                'valid_from' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['valid_from']),
                'valid_until' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['valid_until']),
                'usage_limit' => $validated['usage_limit'],
                'is_active' => $request->has('is_active'),
            ]);
            return redirect()->route('admin.discounts.index')
                ->with('success', 'تم تحديث الكود الخصم بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified discount from storage.
     */
    public function destroy(Discount $discount)
    {
        try {
            $discount->delete();
            return redirect()->route('admin.discounts.index')
                ->with('success', 'تم حذف الكود الخصم بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()]);
        }
    }

    /**
     * Validate a discount code (for frontend use)
     */
    public function validate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'product_id' => 'sometimes|exists:products,id',
        ]);

        $discount = Discount::where('code', strtoupper($request->code))->first();

        if (!$discount) {
            return response()->json([
                'valid' => false,
                'message' => 'الكود غير صحيح',
            ]);
        }

        // Check if discount is valid
        if (!$discount->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'انتهت صلاحية الكود أو تم استخدامه بالكامل',
            ]);
        }

        // If product_id is provided, check if discount is applicable to this product
        if ($request->filled('product_id')) {
            if ($discount->type === 'specific' && $discount->product_id != $request->product_id) {
                return response()->json([
                    'valid' => false,
                    'message' => 'هذا الكود غير مطبق على هذا المنتج',
                ]);
            }
        } else {
            // If no product_id provided, only allow general discounts
            if ($discount->type === 'specific') {
                return response()->json([
                    'valid' => false,
                    'message' => 'هذا الكود خاص بمنتج معين فقط',
                ]);
            }
        }

        return response()->json([
            'valid' => true,
            'message' => 'كود صحيح',
            'percentage' => $discount->percentage,
            'discount_id' => $discount->id,
            'type' => $discount->type,
        ]);
    }
}
