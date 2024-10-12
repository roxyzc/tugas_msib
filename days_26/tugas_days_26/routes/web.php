<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductsController::class, 'index'])->name('products.index');
Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('/create', [ProductsController::class, 'store'])->name('products.store');
Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/edit/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::any('/delete/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
