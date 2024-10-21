<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function processPayment(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order || $order->user_id !== $request->auth->sub) {
            return response()->json(['success' => false, 'msg' => 'Order not found'], 404);
        }

        if ($order->status === 'completed') {
            return response()->json(['success' => false, 'msg' => 'Payment already completed'], 400);
        }

        $totalAmount = $order->quantity * $order->product->price;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'item_details' => [
                [
                    'id' => $order->product_id,
                    'price' => $order->product->price,
                    'quantity' => $order->quantity,
                    'name' => $order->product->name
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json(['success' => true, 'msg' => 'Payment initiated', 'snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Payment failed: ' . $e->getMessage()], 400);
        }
    }

    public function handleMidtransNotification(Request $request)
    {
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'order_id' => 'required|exists:orders,id',
            'transaction_status' => 'required|string',
            'transaction_id' => 'required|string',
            'transaction_type' => 'required|string|in:credit_card,bank_transfer,e-wallet,qris'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'success' => false,
                'msg' => $errors,
            ], 422);
        }

        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $paymentType = $payload['transaction_type'];

        $order = Order::find($orderId);

        if ($transactionStatus === 'completed') {
            $order->update(['status' => 'completed']);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->quantity * $order->product->price,
                'payment_method' => $paymentType,
                'payment_status' => 'completed',
                'transaction_id' => $payload['transaction_id'],
            ]);

            return response()->json(['success' => true, 'msg' => 'Payment successful']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Payment failed or pending'], 400);
        }
    }
}

// class PaymentController extends Controller
// {
//     public function processPayment(Request $request, $orderId)
//     {
//         $order = Order::find($orderId);

//         if (!$order || $order->user_id !== auth()->id()) {
//             return response()->json(['msg' => 'Order not found'], 404);
//         }

//         $paymentResponse = [
//             'status' => 'success',
//             'transaction_id' => '123456789',
//         ];

//         if ($paymentResponse['status'] === 'success') {
//             $payment = Payment::create([
//                 'order_id' => $order->id,
//                 'amount' => $order->quantity * $order->product->price,
//                 'payment_method' => $request->payment_method,
//                 'payment_status' => 'completed',
//                 'transaction_id' => $paymentResponse['transaction_id'],
//             ]);

//             $order->update(['status' => 'completed']);

//             return response()->json(['msg' => 'Payment successful', 'payment' => $payment]);
//         } else {
//             return response()->json(['msg' => 'Payment failed'], 400);
//         }
//     }
// }
