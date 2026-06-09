<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get my cart
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->with('product')
                    ->get();

        return response()->json([
            'success' => true,
            'data'    => $cart,
        ]);
    }

    // Add to cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            $cart = Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Added to cart!',
            'data'    => $cart,
        ]);
    }

    // Remove from cart
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found!',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from cart!',
        ]);
    }
}