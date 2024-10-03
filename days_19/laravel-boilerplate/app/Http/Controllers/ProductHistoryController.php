<?php

namespace App\Http\Controllers;

use App\Models\ProductHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductHistoryController extends Controller
{
    public function index()
    {
        $productHistories = ProductHistory::all();
        return view('product_histories.index', compact('productHistories'));
    }
}
