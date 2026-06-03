<?php

use App\Livewire\CustomerLogin;
use App\Livewire\CustomerRegister;
use Illuminate\Support\Facades\Route;
use App\Livewire\ProductList;
use App\Livewire\Cart;
use App\Livewire\Checkout;
use Illuminate\Support\Facades\Auth;

Route::get('/', ProductList::class);
Route::get('/customer/register', CustomerRegister::class);
Route::get('/customer/login', CustomerLogin::class);
Route::get('/customer/logout', function () {
    Auth::logout();
    return redirect('/');
});


// Protected routes - only logged in users
Route::middleware('auth')->group(function () {
    Route::get('/cart', Cart::class);
    Route::get('/checkout', Checkout::class); // ← added route inside protected group

});