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
        <h2 class="mb-4 fs-4 fw-bold">✅ Checkout</h2>

        <div class="row g-4">

            <!-- Order Summary -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white fw-bold">
                        🛒 Order Summary
                    </div>
                    <div class="card-body p-2 p-md-3">
                        <!-- Mobile Card View -->
                        <div class="d-md-none">
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <div>
                                    <p class="mb-0 fw-bold" style="font-size: 0.85rem;">{{ $item->product->name }}</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">Qty: {{ $item->quantity }}</p>
                                </div>
                                <span class="text-success fw-bold" style="font-size: 0.85rem;">₹{{ $item->quantity * $item->product->price }}</span>
                            </div>
                            @endforeach
                            <div class="d-flex justify-content-between pt-2">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold text-success">₹{{ $total }}</span>
                            </div>
                        </div>

                        <!-- Desktop Table View -->
                        <div class="d-none d-md-block">
                            <table class="table table-bordered mb-0">
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
            </div>

            <!-- Customer Details -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white fw-bold">
                        👤 Your Details
                    </div>
                    <div class="card-body p-3">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input
                                type="text"
                                wire:model="customer_name"
                                class="form-control @error('customer_name') is-invalid @enderror"
                                placeholder="Enter your full name">
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input
                                type="text"
                                wire:model="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="Enter 10 digit phone number">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Delivery Address</label>
                            <textarea
                                wire:model="address"
                                class="form-control @error('address') is-invalid @enderror"
                                rows="3"
                                placeholder="Enter your full address"></textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <select
                                wire:model="payment_method"
                                class="form-select @error('payment_method') is-invalid @enderror">
                                <option value="cash_on_delivery">💵 Cash on Delivery</option>
                                <option value="online">💳 Online Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
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