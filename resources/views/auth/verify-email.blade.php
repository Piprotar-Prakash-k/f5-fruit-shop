<!DOCTYPE html>
<html>
<head>
    <title>Verify Email - Fruit Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-4 text-center">
                        <h3>🍎 Verify Your Email</h3>
                        <p class="text-muted mt-3">
                            Thanks for registering! Please check your email
                            and click the verification link we sent you!
                        </p>

                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form method="POST" action="/email/verification-notification">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mt-3">
                                Resend Verification Email
                            </button>
                        </form>

                        <a href="/customer/logout" class="btn btn-outline-secondary w-100 mt-2">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>