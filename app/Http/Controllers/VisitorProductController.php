<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Game;
use Illuminate\Http\Request;

class VisitorProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::whereNull('parent_id');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        // Get all categories
        $categories = Category::all();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('welcome', compact('products', 'categories', 'generalDiscounts'));
    }

    public function digitalProducts(Request $request)
    {
        $query = Product::where('is_digital', true)->whereNull('parent_id');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        // Get all categories
        $categories = Category::all();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('products.digital-index', compact('products', 'categories', 'generalDiscounts'));
    }

    public function gamesAndApps(Request $request)
    {
        $query = Game::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        // Get all categories
        $categories = Category::all();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('games.index', compact('products', 'categories', 'generalDiscounts'));
    }

    public function show(Product $product)
    {
        // If this is a variant, redirect to parent
        if ($product->parent_id) {
            return redirect()->route('product.show', $product->parent);
        }

        // Get the product's category
        $category = $product->category;

        // Get product variants
        $variants = $product->variants;

        // Get other products in the same category (excluding variants)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->whereNull('parent_id')
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('products.show', compact('product', 'category', 'variants', 'relatedProducts', 'generalDiscounts'));
    }

    public function showGame(Game $game)
    {
        // تحميل فئات اللعبة النشطة فقط
        $categories = $game->activeCategories()->get();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('games.show', compact('game', 'categories', 'generalDiscounts'));
    }
}

