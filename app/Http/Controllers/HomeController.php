<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::take(6)->get();
        $products = Product::with(['galleries'])->take(8)->latest()->get();

        return view('pages.home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
