<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();
        // $cart = Cart::with(['user'])->where('users_id', Auth::user()->id)->firstOrFail();

        return view('pages.cart', [
            'carts' => $carts
        ]);
    }

    public function delete($id) {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function success() {
        return view('pages.success');
    }
}
