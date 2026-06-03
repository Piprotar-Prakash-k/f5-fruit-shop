<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">🍎 Create Account</h3>

                    <form wire:submit="register">
                        <div class="mb-3">
                            <label>Name</label>
                            <input wire:model="name" type="text" class="form-control">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input wire:model="email" type="email" class="form-control">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input wire:model="password" type="password" class="form-control">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input wire:model="password_confirmation" type="password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>

                    <p class="text-center mt-3">
                        Already have account? <a href="/customer/login">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>