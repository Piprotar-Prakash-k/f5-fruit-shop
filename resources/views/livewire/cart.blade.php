<div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand fw-bold fs-5">🍎 Fruit Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-2 py-lg-0">
                    @auth
                        <span class="text-white">Welcome {{ auth()->user()->name }}!</span>
                        <a href="/customer/logout" class="btn btn-outline-light btn-sm">Logout</a>
                    @else
                        <a href="/customer/login" class="btn btn-outline-light btn-sm">Login</a>
                        <a href="/customer/register" class="btn btn-light btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4 px-3">
        <h2 class="mb-4 fs-4 fw-bold">🛒 Your Cart</h2>

        @if($cartItems->isEmpty())
            <div class="alert alert-warning text-center">
                Your cart is empty! <a href="/">Continue Shopping</a>
            </div>
        @else
            <!-- Mobile Card View -->
            <div class="d-md-none">
                @foreach($cartItems as $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                                <p class="text-muted mb-1" style="font-size: 0.85rem;">Price: ₹{{ $item->product->price }}</p>
                                <p class="text-muted mb-1" style="font-size: 0.85rem;">Qty: {{ $item->quantity }}</p>
                                <p class="text-success fw-bold mb-0">₹{{ $item->quantity * $item->product->price }}</p>
                            </div>
                            <button wire:click="removeItem({{ $item->id }})" class="btn btn-danger btn-sm">❌</button>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="card bg-light mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold text-success fs-5">₹{{ $total }}</span>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="d-none d-md-block">
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
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
                <a href="/" class="btn btn-outline-success">← Continue Shopping</a>
                <a href="/checkout" class="btn btn-success">Proceed to Checkout ✅</a>
            </div>
        @endif
    </div>
</div>