<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
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

        return $sslc->make_payment();
    }

    public function success(Request $request)
    {
        $validate = SSLCommerz::validate_payment($request);

        if (!$validate) {
            return redirect()->route('wallets.index')
                ->with([
                    'status' => 'error',
                    'message' => 'Transaction is Invalid.'
                ]);
        }

        $transactionId = $request->tran_id;
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order) {
            return redirect()->route('wallets.index')
                ->with([
                    'status' => 'error',
                    'message' => 'Order not found.'
                ]);
        }

        //  Do the rest database saving works
        if ($order->status == Order::STATUS_SUCCESS) {
            return redirect()->route('wallets.index')
                ->with([
                    'status' => 'success',
                    'message' => 'Transaction is already successful.'
                ]);
        }

        try {
            if ($order->status == Order::STATUS_PENDING || $order->status == Order::STATUS_FAILED) {
                $order->update([
                    'status' => Order::STATUS_SUCCESS,
                    'data' => $request->all(),
                ]);

                // give the user the coins
                $user = User::find($order->user_id);
                $user?->deposit($order->amount);

                return redirect()->route('wallets.index')
                    ->with([
                        'status' => 'success',
                        'message' => 'Transaction successfully completed.'
                    ]);
            }
        } catch (\Exception $e) {
            return redirect()->route('wallets.index')
                ->with([
                    'status' => 'error',
                    'message' =>  $e->getMessage()
                ]);
        } catch (ExceptionInterface $e) {
            return redirect()->route('wallets.index')
                ->with([
                    'status' => 'error',
                    'message' =>  $e->getMessage()
                ]);
        }

        return redirect()->route('wallets.index')
            ->with([
                'status' => 'error',
                'message' =>  'Something went wrong.'
            ]);
    }

    public function failure(Request $request)
    {
        $transactionId = $request->tran_id;
        $order = Order::where('transaction_id', $transactionId)->first();
        if (!$order) {
            return redirect()->route('wallets.index')
                ->with([
                    'status' => 'error',
                    'message' => 'Order not found.'
                ]);
        }

        if ($order->status == Order::STATUS_PENDING) {
            $order->update([
                'status' => Order::STATUS_FAILED,
                'data' => $request->all(),
            ]);
        }

        return redirect()->route('wallets.index')
            ->with([
                'status' => 'error',
                'message' => 'Payment cancelled.'
            ]);
    }
}
