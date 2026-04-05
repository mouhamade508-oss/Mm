<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use App\Models\Discount;
use App\Models\Game;
use App\Models\News;
use App\Models\FlashSale;
use App\Models\Bundle;
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

        // Get active news for ticker
        $activeNews = News::active()->get();

        // Get active flash sales
        $activeFlashSales = FlashSale::where('is_active', true)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->with('product')
            ->get();

        // Get active bundles
        $activeBundles = Bundle::where('is_active', true)->get();

        return view('welcome', compact('products', 'categories', 'generalDiscounts', 'activeNews', 'activeFlashSales', 'activeBundles'));
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
        // إدارة كود الإحالة - فقط عدّل إذا كان هناك ref جديد أو كوكيز
        if ($request->filled('ref')) {
            // إذا كان هناك ref parameter جديد، احفظه
            session(['referral_code' => $request->ref]);
            setcookie('referral_code', $request->ref, time() + 600, '/'); // 10 دقائق
        } elseif ($request->cookie('referral_code') && !session('referral_code')) {
            // إذا لم يكن هناك ref جديد لكن يوجد كوكيز، استخدمه
            session(['referral_code' => $request->cookie('referral_code')]);
        }
        // إذا لم يكن هناك ref جديد ولا كوكيز جديد، احتفظ بالجلسة الموجودة

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

        return view('games.index', compact('products', 'categories', 'generalDiscounts'))->with('currentReferralCode', session('referral_code'));
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

    public function showGame(Game $game, Request $request)
    {
        \Log::info('ShowGame called', ['url_ref' => $request->ref, 'cookie_ref' => $request->cookie('referral_code'), 'session_ref' => session('referral_code')]);
        
        // إدارة كود الإحالة - فقط عدّل إذا كان هناك ref جديد أو كوكيز
        if ($request->filled('ref')) {
            // إذا كان هناك ref parameter جديد، احفظه
            session(['referral_code' => $request->ref]);
            setcookie('referral_code', $request->ref, time() + 600, '/'); // 10 دقائق
            \Log::info('Set referral code from URL', ['ref' => $request->ref]);
        } elseif ($request->cookie('referral_code') && !session('referral_code')) {
            // إذا لم يكن هناك ref جديد لكن يوجد كوكيز، استخدمه
            session(['referral_code' => $request->cookie('referral_code')]);
            \Log::info('Set referral code from cookie', ['ref' => $request->cookie('referral_code')]);
        }
        // إذا لم يكن هناك ref جديد ولا كوكيز جديد، احتفظ بالجلسة الموجودة

        \Log::info('Final session referral code in showGame', ['ref' => session('referral_code')]);

        // تحميل فئات اللعبة النشطة فقط
        $categories = $game->activeCategories()->get();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('games.show', compact('game', 'categories', 'generalDiscounts'))->with('currentReferralCode', session('referral_code'));
    }

    /**
     * Display section with all its categories and products
     */
    public function showSection(Section $section, Request $request)
    {
        $categories = $section->categories()->get();
        
        $query = Product::whereIn('category_id', $categories->pluck('id'))->whereNull('parent_id');

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

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('sections.show', compact('section', 'categories', 'products', 'generalDiscounts'));
    }

    /**
     * Display section category with products
     */
    public function showSectionCategory(Section $section, Category $category, Request $request)
    {
        // Verify category belongs to section
        if ($category->section_id !== $section->id) {
            abort(404);
        }

        $query = Product::where('category_id', $category->id)->whereNull('parent_id');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        // Get all categories in this section
        $categories = $section->categories()->get();

        // Get all active general discounts
        $generalDiscounts = Discount::where('type', 'general')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->get();

        return view('sections.category-show', compact('section', 'category', 'categories', 'products', 'generalDiscounts'));
    }
}

