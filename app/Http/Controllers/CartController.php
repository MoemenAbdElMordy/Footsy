<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $shipping = $subtotal > 50 ? 0 : 5;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return view('pages.cart.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|numeric',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock']);
        }

        $cart = Session::get('cart', []);
        $key = $request->product_id . '-' . $request->size . '-' . $request->color;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $request->product_id,
                'size' => $request->size,
                'color' => $request->color,
                'quantity' => $request->quantity,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function update(Request $request, $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$cartItem])) {
            $product = Product::findOrFail($cart[$cartItem]['product_id']);
            
            if ($product->stock < $request->quantity) {
                return back()->withErrors(['quantity' => 'Insufficient stock']);
            }

            $cart[$cartItem]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function remove($cartItem)
    {
        $cart = Session::get('cart', []);
        unset($cart[$cartItem]);
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart');
    }

    private function getCartItems()
    {
        $cart = Session::get('cart', []);
        $items = collect();

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $items->push((object) [
                    'id' => $key,
                    'product' => $product,
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        return $items;
    }
}

