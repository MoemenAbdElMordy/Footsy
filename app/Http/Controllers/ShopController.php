<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Price filter
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 300);
        $query->whereBetween('price', [$minPrice, $maxPrice]);

        // Brand filter
        if ($request->filled('brands')) {
            $query->whereIn('brand', $request->brands);
        }

        // Color filter
        if ($request->filled('colors')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->colors as $color) {
                    $q->orWhereJsonContains('colors', $color);
                }
            });
        }

        $products = $query->paginate(12);
        $brands = Product::distinct()->pluck('brand')->sort()->values();
        $colors = Product::select('colors')->get()->pluck('colors')->flatten()->unique()->sort()->values();
        $pageTitle = 'All Products';

        return view('pages.shop.index', compact('products', 'brands', 'colors', 'pageTitle'));
    }

    public function category(Request $request, $category)
    {
        $query = Product::where('category', $category);

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Price filter
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 300);
        $query->whereBetween('price', [$minPrice, $maxPrice]);

        // Brand filter
        if ($request->filled('brands')) {
            $query->whereIn('brand', $request->brands);
        }

        // Color filter
        if ($request->filled('colors')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->colors as $color) {
                    $q->orWhereJsonContains('colors', $color);
                }
            });
        }

        $products = $query->paginate(12);
        $brands = Product::distinct()->pluck('brand')->sort()->values();
        $colors = Product::select('colors')->get()->pluck('colors')->flatten()->unique()->sort()->values();
        $pageTitle = ucfirst($category) . "'s Collection";

        return view('pages.shop.index', compact('products', 'brands', 'colors', 'pageTitle', 'category'));
    }
}

