<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/products', function () {
        return view('products');
    })->name('products');

    Route::get('/product/{productId}', function ($productId) {
        return view('product', compact('productId'));
    })->name('product');

    Route::get('/crud', function () {
        return view('crud');
    })->name('crud');

    Route::get('/audit-trail', function () {
        return view('audittrail');
    })->name('audit-trail');
});
