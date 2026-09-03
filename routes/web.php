<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home-page')->name('home');
Route::livewire('/categories', 'pages::categories-page')->name('categories');
Route::livewire('/products', 'pages::products-page')->name('products');
Route::livewire('/cart', 'pages::cart-page')->name('cart');
Route::livewire('/products/{slug}', 'pages::product-detail-page')->name('product-detail');


Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::auth.login-page')->name('login');
    Route::livewire('/register', 'pages::auth.register-page')->name('register');
    Route::livewire('/reset/{token}', 'pages::auth.reset-password-page')->name('password.reset');
    Route::livewire('/forgot', 'pages::auth.forgot-page')->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    });
    Route::livewire('/checkout', 'pages::checkout-page')->name('checkout');
    Route::livewire('/my-orders', 'pages::my-orders-page')->name('my-orders');
    Route::livewire('/my-orders/{order}', 'pages::order-detail-page')->name('my-order.show');
    Route::livewire('/success', 'pages::success-page')->name('success');
    Route::livewire('/cancel', 'pages::cancel-page')->name('cancel');
});
