<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class ProductList extends Component
{
    public array $quantities = [];

    public function addToCart($productId)
    {
        if (!Auth::check()) {
            return redirect('/customer/login');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'quantity'   => 1,
            ]);
        }

        $this->quantities[$productId] = $this->getCartQuantity($productId);
        $this->dispatch('notify', message: 'Added to Cart! 🛒');
    }

    public function increment($productId)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        }

        $this->quantities[$productId] = $cart->quantity;
    }

    public function decrement($productId)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            if ($cart->quantity > 1) {
                $cart->quantity -= 1;
                $cart->save();
                $this->quantities[$productId] = $cart->quantity;
            } else {
                $cart->delete();
                $this->quantities[$productId] = 0;
            }
        }
    }

    public function getCartQuantity($productId)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        return $cart ? $cart->quantity : 0;
    }

    public function render()
    {
        $products = Product::all();

        if (Auth::check()) {
            foreach ($products as $product) {
                $this->quantities[$product->id] = $this->getCartQuantity($product->id);
            }
        }

        return view('livewire.product-list', [
            'products' => $products,
        ]);
    }
}