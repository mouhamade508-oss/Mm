<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class QuickViewController extends Controller
{
    /**
     * عرض بيانات المنتج بصيغة JSON للعرض السريع
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image_url' => $product->image_url,
                'category' => $product->category ? $product->category->name : 'غير محدد',
                'active' => $product->active,
                'discount' => $product->getActiveDiscount() ? [
                    'percentage' => $product->getActiveDiscount()->percentage,
                    'final_price' => $product->getActiveDiscount()->calculateFinalPrice($product->price)
                ] : null
            ]
        ]);
    }
}
