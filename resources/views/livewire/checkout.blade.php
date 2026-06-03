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
        <h2 class="mb-4">✅ Checkout</h2>

        <div class="row">

            <!-- Left side - Order Summary -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white fw-bold">
                        🛒 Order Summary
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ $item->quantity * $item->product->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold text-success">₹{{ $total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right side - Customer Details -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white fw-bold">
                        👤 Your Details
                    </div>
                    <div class="card-body">

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input
                                type="text"
                                wire:model="customer_name"
                                class="form-control @error('customer_name') is-invalid @enderror"
                                placeholder="Enter your full name"
                            >
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input
                                type="text"
                                wire:model="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="Enter 10 digit phone number"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Delivery Address</label>
                            <textarea
                                wire:model="address"
                                class="form-control @error('address') is-invalid @enderror"
                                rows="3"
                                placeholder="Enter your full address"
                            ></textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <select
                                wire:model="payment_method"
                                class="form-select @error('payment_method') is-invalid @enderror"
                            >
                                <option value="cash_on_delivery">💵 Cash on Delivery</option>
                                <option value="online">💳 Online Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/cart" class="btn btn-outline-success">← Back to Cart</a>
                            <button wire:click="placeOrder" class="btn btn-success">
                                Place Order ✅
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>