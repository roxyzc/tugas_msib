<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Models\DataMaster\M_product;
use App\Models\DataMaster\M_supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductHistory;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->get();
        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = M_supplier::all();
        $products = M_product::all();
        return view('purchase_orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:m_suppliers,id',
            'order_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:m_products,id',
            'products.*.quantity' => 'required|integer|min:1|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->supplier_id = $request->supplier_id;
        $purchaseOrder->order_date = $request->order_date;
        $purchaseOrder->total_amount = 0;
        $purchaseOrder->save();

        $total = 0;
        foreach ($request->products as $product) {
            $productData = M_product::find($product['product_id']);

            $detail = new PurchaseOrderDetail();
            $detail->purchase_order_id = $purchaseOrder->id;
            $detail->product_id = $product['product_id'];
            $detail->quantity = $product['quantity'];
            $detail->price = $productData->price;
            $detail->save();

            $total += $product['quantity'] * $productData->price;

            $productData->stock += $product['quantity'];
            $productData->save();
        }

        $purchaseOrder->total_amount = $total;
        $purchaseOrder->save();

        return redirect()->route('purchase_orders.index');
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with('details.product')->findOrFail($id);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        foreach ($purchaseOrder->details as $detail) {
            ProductHistory::create([
                'product_id' => $detail->product_id,
                'quantity' => $detail->quantity,
                'action' => 'deleted',
            ]);
        }
        $purchaseOrder->delete();
        return redirect()->route('purchase_orders.index');
    }
}
