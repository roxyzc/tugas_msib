<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductsController::class, 'index'])->name('products.index');
Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('/create', [ProductsController::class, 'store'])->name('products.store');
Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/edit/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::any('/delete/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

Route::get('/reporting', [ReportingController::class, 'index'])->name('reporting');
Route::get('/reporting/all-data-product', [ReportingController::class, 'getAllDataProduct'])->name('reporting.all.data.product');
Route::get('/reporting/chart-product', [ReportingController::class, 'getChartProduct'])->name('reporting.chart.product');
Route::get('/reporting/search-data-product', [ReportingController::class, 'searchDataProduct']);
