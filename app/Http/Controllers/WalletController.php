<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('wallets.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $order = Order::create([
            'transaction_id' => Order::generateTransactionId(),
            'amount' => $request->amount,
            'status' => Order::STATUS_PENDING,
        ]);

        $payment = new PaymentController();
        $payment->pay($order->amount, $order->transaction_id);

        return $order;
        return $request->all();
    }
}
