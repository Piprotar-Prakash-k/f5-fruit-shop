<?php

use App\Livewire\CustomerLogin;
use App\Livewire\CustomerRegister;
use Illuminate\Support\Facades\Route;
use App\Livewire\ProductList;
use App\Livewire\Cart;
use App\Livewire\Checkout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// TODO: Remove this route once the session/CSRF issue is diagnosed
Route::get('/debug-config', function () {
    $dbStatus = 'unknown';
    try {
        DB::connection()->getPdo();
        $dbStatus = 'connected (driver: ' . DB::connection()->getDriverName() . ')';
    } catch (\Exception $e) {
        $dbStatus = 'error: ' . $e->getMessage();
    }

    $sessionsTableExists = false;
    try {
        $sessionsTableExists = DB::getSchemaBuilder()->hasTable(config('session.table', 'sessions'));
    } catch (\Exception $e) {
        // ignore
    }

    return response()->json([
        'session' => [
            'SESSION_DRIVER_env'    => env('SESSION_DRIVER'),
            'config_driver'         => config('session.driver'),
            'SESSION_LIFETIME_env'  => env('SESSION_LIFETIME'),
            'config_lifetime'       => config('session.lifetime'),
            'SESSION_DOMAIN_env'    => env('SESSION_DOMAIN'),
            'config_domain'         => config('session.domain'),
            'config_secure'         => config('session.secure'),
            'config_same_site'      => config('session.same_site'),
            'sessions_table_exists' => $sessionsTableExists,
        ],
        'cache' => [
            'CACHE_STORE_env'  => env('CACHE_STORE'),
            'config_default'   => config('cache.default'),
        ],
        'database' => [
            'DB_CONNECTION_env' => env('DB_CONNECTION'),
            'config_default'    => config('database.default'),
            'status'            => $dbStatus,
        ],
        'app' => [
            'APP_ENV'   => env('APP_ENV'),
            'APP_DEBUG' => env('APP_DEBUG'),
        ],
    ]);
});

Route::get('/', ProductList::class);
Route::get('/customer/register', CustomerRegister::class);
Route::get('/customer/login', CustomerLogin::class);
Route::get('/customer/logout', function () {
    Auth::logout();
    return redirect('/');
});

// Email verification routes
Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Protected routes - only logged in users
Route::middleware('auth')->group(function () {
    Route::get('/cart', Cart::class);
    Route::get('/checkout', Checkout::class);
});