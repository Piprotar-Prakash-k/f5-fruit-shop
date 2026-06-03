<div>
    <!-- Notification -->
    <div
        x-data="{ show: false, message: '' }"
        x-on:notify.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;"
        class="alert alert-success shadow">
        <span x-text="message"></span>
    </div>
    <!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        🎉 {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand">🍎 Fruit Shop</a>
            <div>
                @auth
                <span class="text-white me-3">Welcome {{ auth()->user()->name }}!</span>
                <a href="/cart" class="btn btn-warning me-2">🛒 Go to Cart</a>
                <a href="/customer/logout" class="btn btn-outline-light">Logout</a>
                @else
                <a href="/customer/login" class="btn btn-outline-light me-2">Login</a>
                <a href="/customer/register" class="btn btn-light">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Products -->
    <div class="container mt-4">
        <h2 class="mb-4">Our Fresh Fruits</h2>

        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                        class="card-img-top"
                        style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-muted">{{ $product->category->name ?? 'No Category' }}</p>
                        <h4 class="text-success">₹{{ $product->price }}</h4>
                        <p>Available: {{ $product->quantity }}</p>

                        <!-- Always show Add to Cart button -->
                        <!-- Row 1: ➖ 1 ➕ -->
                        @if(isset($quantities[$product->id]) && $quantities[$product->id] > 0)
                        <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                            <button wire:click="decrement({{ $product->id }})" class="btn btn-danger btn-sm px-3">−</button>
                            <span class="fw-bold fs-6">{{ $quantities[$product->id] }}</span>
                            <button wire:click="increment({{ $product->id }})" class="btn btn-success btn-sm px-3">+</button>
                        </div>
                        @endif

                        <!-- Row 2: Add to Cart button -->
                        <button wire:click="addToCart({{ $product->id }})" class="btn btn-success w-100 mt-2">
                            Add to Cart 🛒
                        </button>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>