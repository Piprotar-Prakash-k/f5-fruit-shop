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

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        🎉 {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

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
                        <a href="/cart" class="btn btn-warning btn-sm">🛒 Cart</a>
                        <a href="/customer/logout" class="btn btn-outline-light btn-sm">Logout</a>
                    @else
                        <a href="/customer/login" class="btn btn-outline-light btn-sm">Login</a>
                        <a href="/customer/register" class="btn btn-light btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Products -->
    <div class="container mt-4 px-3">
        <h2 class="mb-4 fs-4 fw-bold">🍓 Our Fresh Fruits</h2>

        <div class="row g-3">
            @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                    <img src="{{ $product->image_url }}"
                        class="card-img-top"
                        style="height: 150px; object-fit: cover;">
                    @endif
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fw-bold mb-1" style="font-size: 0.9rem;">{{ $product->name }}</h6>
                        <p class="text-muted mb-1" style="font-size: 0.75rem;">{{ $product->category->name ?? 'No Category' }}</p>
                        <h5 class="text-success fw-bold mb-1" style="font-size: 0.95rem;">₹{{ $product->price }}</h5>
                        <p class="mb-2" style="font-size: 0.75rem;">Stock: {{ $product->quantity }}</p>

                        @if(isset($quantities[$product->id]) && $quantities[$product->id] > 0)
                        <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                            <button wire:click="decrement({{ $product->id }})" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 0.8rem;">−</button>
                            <span class="fw-bold">{{ $quantities[$product->id] }}</span>
                            <button wire:click="increment({{ $product->id }})" class="btn btn-success btn-sm px-2 py-1" style="font-size: 0.8rem;">+</button>
                        </div>
                        @endif

                        <button wire:click="addToCart({{ $product->id }})" class="btn btn-success w-100 btn-sm" style="font-size: 0.8rem;">
                            Add to Cart 🛒
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>