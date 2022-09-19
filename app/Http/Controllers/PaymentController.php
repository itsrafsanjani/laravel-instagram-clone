<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DGvai\SSLCommerz\SSLCommerz;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay($amount, $transactionId)
    {
        $customerName = auth()->user()->name;
        $customerEmail = auth()->user()->email;

        $sslc = new SSLCommerz();
        $sslc->amount($amount)
            ->trxid($transactionId)
            ->product(config('app.name').' - '.$amount.' Coin Purchase')
            ->customer($customerName, $customerEmail);

        $payment = json_decode($sslc->make_payment(true));

        return response()->json([
            'data' => [
                'gateway_page_url' => $payment->data,
            ]
        ]);
    }

    public function success(Request $request)
    {
        $validate = SSLCommerz::validate_payment($request);

        if (!$validate) {
            return response()->json([
                'message' => 'Transaction is Invalid.'
            ], 400);
        }

        $transactionId = $request->tran_id;
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 400);
        }

        //  Do the rest database saving works
        if ($order->status == 'Processing' || $order->status == 'Complete') {
            return response()->json([
                'message' => 'Transaction is already successful.'
            ], 400);
        }

        try {
            if ($order->status == Order::STATUS_PENDING) {
                $order->update([
                    'status' => Order::STATUS_SUCCESS,
                    'data' => $request->all(),
                ]);

                return response()->json([
                    'message' => 'Transaction successfully completed.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'Something went wrong.'
        ], 500);
    }

    public function failure(Request $request)
    {
        $transactionId = $request->tran_id;
        $order = Order::where('transaction_id', $transactionId)->first();
        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 400);
        }

        if ($order->status == Order::STATUS_PENDING) {
            $order->update([
                'status' => Order::STATUS_FAILED,
                'data' => $request->all(),
            ]);
        }

        return response()->json([
            'message' => 'Payment cancelled.'
        ], 400);
    }
}
