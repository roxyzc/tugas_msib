<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function index()
    {
        $categories = Product::select('category')->distinct()->get();

        return view('reporting.index', ['categories' => $categories]);
    }

    private function getPriceRange($price)
    {
        if ($price < 50000) {
            return 'less_50000';
        } elseif ($price >= 50000 && $price < 99999) {
            return '_50000_99999';
        } elseif ($price >= 100000 && $price < 999999) {
            return '_100000_999999';
        } else {
            return 'more_1000000';
        }
    }

    public function getAllDataProduct(Request $request)
    {
        $dates = $request->input('dates');
        $categories = $request->input('categories');

        if ($dates) {
            $dateRange = explode(' - ', $dates);
            $startDate = $dateRange[0];
            $endDate = date('Y-m-d', strtotime($dateRange[1] . ' +1 day'));
        }

        $query = Product::query();

        if ($dates) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($categories) {
            $query->whereIn('category', $categories);
        }

        $products = $query->get();

        $products = $products->map(function ($product) {
            $product->price_range = $this->getPriceRange($product->price);
            $product->created_range = $product->created_at->format('Y-m-d');
            return $product;
        });

        return response($products);
    }


    public function getChartProduct()
    {
        $products = Product::all();
        $data = [
            'less_50000' => 0,
            '_50000_99999' => 0,
            '_100000_999999' => 0,
            'more_1000000' => 0,
        ];

        foreach ($products as $product) {
            $range = $this->getPriceRange($product->price);
            $data[$range]++;
        }

        return response($data);
    }
}
