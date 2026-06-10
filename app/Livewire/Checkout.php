<?php

namespace App\Livewire;

use App\Mail\OrderConfirmation;
use App\Models\Cart as CartModel;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

#[Layout('components.layouts.app')]
class Checkout extends Component
{
    public $customer_name = '';
    public $phone = '';
    public $address = '';
    public $payment_method = 'cash_on_delivery';

    public function placeOrder()
    {
        $this->validate([
            'customer_name' => 'required|min:3',
            'phone'         => 'required|digits:10',
            'address'       => 'required|min:10',
            'payment_method'=> 'required',
        ]);

        $cartItems = CartModel::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart');
        }

        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);

            if ($product->quantity < $item->quantity) {
                $this->addError('customer_name', "Not enough stock for {$product->name}!");
                return;
            }
        }

        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);

            $order = Order::create([
                'customer_name'  => $this->customer_name,
                'phone'          => $this->phone,
                'address'        => $this->address,
                'payment_method' => $this->payment_method,
                'product_id'     => $item->product_id,
                'quantity'       => $item->quantity,
                'total_price'    => $item->quantity * $product->price,
                'status'         => 'pending',
            ]);

            $product->quantity -= $item->quantity;
            $product->save();

            // Send confirmation email
            Mail::to(Auth::user()->email)
                ->send(new OrderConfirmation($order));
        }

        CartModel::where('user_id', Auth::id())->delete();

        return redirect('/')->with('success', 'Order placed successfully! ✅');
    }

    public function render()
    {
        $cartItems = CartModel::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('livewire.checkout', [
            'cartItems' => $cartItems,
            'total'     => $total,
        ]);
    }
}