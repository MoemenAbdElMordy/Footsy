<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('pages.home', compact('featuredProducts'));
    }
}

