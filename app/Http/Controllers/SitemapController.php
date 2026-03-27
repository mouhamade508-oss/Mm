<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $host = config('app.url', url('/'));

        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => url('/products'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => url('/digital-products'), 'priority' => '0.7', 'changefreq' => 'weekly'],
        ];

        $categories = Category::all();
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => url('/products?category=' . $category->id),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }

        $products = Product::whereNull('parent_id')->get();
        foreach ($products as $product) {
            $urls[] = [
                'loc' => route('product.show', $product),
                'priority' => '0.9',
                'changefreq' => 'weekly',
            ];
        }

        $payload = view('sitemap', compact('urls'));

        return response($payload, 200)
            ->header('Content-Type', 'application/xml');
    }
}
