<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Get my orders
    public function index()
    {
        $orders = Order::where('customer_name', Auth::user()->name)
                       ->with('product')
                       ->latest()
                       ->get();

        return response()->json([
            'success' => true,
            'data'    => $orders,
        ]);
    }

    // Place new order
    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'total_price'    => 'required|numeric',
            'phone'          => 'required',
            'address'        => 'required',
            'payment_method' => 'required',
        ]);

        $order = Order::create([
            'customer_name'  => Auth::user()->name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'payment_method' => $request->payment_method,
            'product_id'     => $request->product_id,
            'quantity'       => $request->quantity,
            'total_price'    => $request->total_price,
            'status'         => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'data'    => $order,
        ]);
    }

    // Get one order
    public function show($id)
    {
        $order = Order::where('id', $id)
                      ->where('customer_name', Auth::user()->name)
                      ->with('product')
                      ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $order,
        ]);
    }

    // Update order status
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found!',
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order updated!',
            'data'    => $order,
        ]);
    }
}