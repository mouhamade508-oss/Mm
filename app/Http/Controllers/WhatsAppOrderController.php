<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WhatsAppOrder;
use Illuminate\Http\Request;

class WhatsAppOrderController extends Controller
{
    /**
     * Show electronics products
     */
    public function electronics()
    {
        $electronicsCategory = \App\Models\Category::where('slug', 'electronics-devices')->first();
        
        if (!$electronicsCategory) {
            abort(404, 'قسم الإلكترونيات غير موجود');
        }

        $products = Product::where('category_id', $electronicsCategory->id)
            ->where('is_digital', false)
            ->paginate(12);

        return view('electronics.index', compact('products', 'electronicsCategory'));
    }

    /**
     * Show product details with WhatsApp ordering option
     */
    public function show(Product $product)
    {
        if (!$product->requires_whatsapp || !$product->whatsapp_phone) {
            abort(404, 'هذا المنتج لا يتم طلبه عبر WhatsApp');
        }

        return view('electronics.show', compact('product'));
    }

    /**
     * Create WhatsApp order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->requires_whatsapp || !$product->whatsapp_phone) {
            return response()->json(['error' => 'هذا المنتج لا يتم طلبه عبر WhatsApp'], 400);
        }

        $total_price = $product->price * $validated['quantity'];

        $order = WhatsAppOrder::create([
            'product_id' => $product->id,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'quantity' => $validated['quantity'],
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        $whatsappLink = $order->generateWhatsAppLink();
        $order->update(['whatsapp_link' => $whatsappLink, 'status' => 'sent']);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء طلبك بنجاح. سيتم فتح WhatsApp الآن.',
            'whatsapp_link' => $whatsappLink,
        ]);
    }

    /**
     * Get WhatsApp order status (for admin)
     */
    public function getOrders()
    {
        $this->authorize('admin', auth()->user());

        $orders = WhatsAppOrder::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.whatsapp-orders.index', compact('orders'));
    }

    /**
     * Update WhatsApp order status (for admin)
     */
    public function updateStatus(Request $request, WhatsAppOrder $order)
    {
        $this->authorize('admin', auth()->user());

        $validated = $request->validate([
            'status' => 'required|in:pending,sent,confirmed,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'تم تحديث حالة الطلب');
    }
}
