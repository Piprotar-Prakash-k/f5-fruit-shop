
<div>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand">🍎 Fruit Shop</a>
            <div>
                @auth
                    <span class="text-white me-3">Welcome {{ auth()->user()->name }}!</span>
                    <a href="/customer/logout" class="btn btn-outline-light">Logout</a>
                @else
                    <a href="/customer/login" class="btn btn-outline-light me-2">Login</a>
                    <a href="/customer/register" class="btn btn-light">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">🛒 Your Cart</h2>

        @if($cartItems->isEmpty())
            <div class="alert alert-warning text-center">
                Your cart is empty! <a href="/">Continue Shopping</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>₹{{ $item->product->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ $item->quantity * $item->product->price }}</td>
                                <td>
                                    <button wire:click="removeItem({{ $item->id }})" class="btn btn-danger btn-sm">
                                        Remove ❌
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold text-success">₹{{ $total }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-end">
                <a href="/" class="btn btn-outline-success me-2">← Continue Shopping</a>
                <a href="/checkout" class="btn btn-success">Proceed to Checkout ✅</a>
            </div>
        @endif
    </div>
</div>