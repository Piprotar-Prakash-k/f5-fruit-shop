<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Cart extends Component
{
    public function removeItem($cartId)
    {
        CartModel::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->delete();
    }

    public function render()
    {
        $cartItems = CartModel::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('livewire.cart', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }
}