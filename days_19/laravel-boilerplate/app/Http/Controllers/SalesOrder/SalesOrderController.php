<?php

namespace App\Http\Controllers\SalesOrder;

use App\Models\DataMaster\M_product;
use App\Models\DataMaster\M_customer;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SalesOrderController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::with('customer')->get();
        return view('sales_orders.index', compact('salesOrders'));
    }

    public function create()
    {
        $customers = M_customer::all();
        $products = M_product::all();
        return view('sales_orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:m_customers,id',
            'order_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:m_products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach ($request->products as $product) {
            $productData = M_product::find($product['product_id']);
            if ($productData->stock < $product['quantity']) {
                return redirect()->back()->withErrors(['products' => "Stock for product {$productData->name} is insufficient. Available: {$productData->stock}"])->withInput();
            }
        }

        $salesOrder = new SalesOrder();
        $salesOrder->customer_id = $request->customer_id;
        $salesOrder->order_date = $request->order_date;
        $salesOrder->total_amount = 0;
        $salesOrder->save();

        $total = 0;
        foreach ($request->products as $product) {
            $productData = M_product::find($product['product_id']);

            $detail = new SalesOrderDetail();
            $detail->sales_order_id = $salesOrder->id;
            $detail->product_id = $product['product_id'];
            $detail->quantity = $product['quantity'];
            $detail->price = $productData->price;
            $detail->save();

            $total += $product['quantity'] * $productData->price;

            $productData->stock -= $product['quantity'];
            $productData->save();
        }

        $salesOrder->total_amount = $total;
        $salesOrder->save();

        return redirect()->route('sales_orders.index');
    }

    public function show($id)
    {
        $salesOrder = SalesOrder::with('details.product')->findOrFail($id);
        return view('sales_orders.show', compact('salesOrder'));
    }

    public function destroy($id)
    {
        $salesOrder = SalesOrder::findOrFail($id);

        foreach ($salesOrder->details as $detail) {
            $productData = M_product::find($detail->product_id);
            $productData->stock += $detail->quantity;
            $productData->save();
        }

        $salesOrder->delete();
        return redirect()->route('sales_orders.index');
    }
}
