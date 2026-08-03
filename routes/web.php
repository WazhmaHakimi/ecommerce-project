<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home-page')->name('home');
Route::view('/categories', 'pages.categories-page')->name('categories');
Route::view('/products', 'pages.products-page')->name('products');
Route::view('/cart', 'pages.cart-page')->name('cart');
Route::view('/products/{product}', 'pages.product-detail-page')->name('product-detail');
Route::view('/checkout', 'pages.checkout-page')->name('checkout');
Route::view('/my-orders', 'pages.my-orders-page')->name('my-orders');
Route::view('/my-orders/{order}', 'pages.order-detail-page')->name('my-order-detail');
Route::view('/login', 'pages.auth.login-page')->name('login');
Route::view('/register', 'pages.auth.register-page')->name('register');
Route::view('/reset', 'pages.auth.reset-password-page')->name('reset-password');
Route::view('/forgot', 'pages.auth.forgot-page')->name('forgot-password');
Route::view('/success', 'pages.success-page')->name('success');
Route::view('/cancel', 'pages.cancel-page')->name('cancel');
