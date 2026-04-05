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
            'applies_to' => 'required|in:all,products,game_recharge',
            'product_id' => 'exclude_if:applies_to,game_recharge|required_if:type,specific|nullable|exists:products,id',
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
                'applies_to' => $validated['applies_to'],
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
            'applies_to' => 'required|in:all,products,game_recharge',
            'product_id' => 'exclude_if:applies_to,game_recharge|required_if:type,specific|nullable|exists:products,id',
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
                'applies_to' => $validated['applies_to'],
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
            'purpose' => 'sometimes|in:products,game_recharge',
        ]);

        $discount = Discount::where('code', strtoupper($request->code))->first();

        if (! $discount) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'الكود غير صحيح',
            ]);
        }

        // Determine whether this validation is for game recharge or product purchase
        $purpose = $request->get('purpose', $request->filled('product_id') ? 'products' : 'products');
        $productId = $request->input('product_id');

        if (! $discount->isValidForPurpose($purpose, $productId)) {
            if ($purpose === 'game_recharge') {
                $message = $discount->applies_to === 'products'
                    ? 'هذا الكود خاص بالمنتجات ولا يمكن استخدامه في شحن الألعاب'
                    : 'انتهت صلاحية الكود أو غير صالح لشحن الألعاب';
            } else {
                $message = $discount->applies_to === 'game_recharge'
                    ? 'هذا الكود خاص بشحن الألعاب ولا يمكن استخدامه هنا'
                    : 'انتهت صلاحية الكود أو غير صالح لهذا المنتج';
            }

            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => $message,
            ]);
        }

        return response()->json([
            'success' => true,
            'valid' => true,
            'message' => 'كود صحيح',
            'percentage' => $discount->percentage,
            'discount_id' => $discount->id,
            'type' => $discount->type,
            'discount' => [
                'id' => $discount->id,
                'percentage' => $discount->percentage,
                'type' => $discount->type,
            ],
        ]);
    }
}
