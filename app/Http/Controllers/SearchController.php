<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (empty(trim($query))) {
            return response()->json([
                'products' => [],
                'categories' => [],
            ]);
        }

        // Use Scout if available, fallback to LIKE
        try {
            $products = Product::search($query)
                ->where('parent_id', null)
                ->take(12)
                ->get();
        } catch (\Throwable $e) {
            $products = Product::where('parent_id', null)
                ->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                })->take(12)->get();
        }

        $categories = Category::where('name', 'like', '%' . $query . '%')->take(10)->get();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
