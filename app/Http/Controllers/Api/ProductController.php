<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'success' => true,
            'data'    => $products,
        ]);
    }

    // Get one product
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $product,
        ]);
    }

    // Create product (admin)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'price'    => 'required|numeric',
            'quantity' => 'required|integer',
            'quality'  => 'required',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product created!',
            'data'    => $product,
        ]);
    }

    // Update product (admin)
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product updated!',
            'data'    => $product,
        ]);
    }

    // Delete product (admin)
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted!',
        ]);
    }
}