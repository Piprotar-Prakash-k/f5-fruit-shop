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