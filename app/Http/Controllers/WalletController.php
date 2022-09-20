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
        $orders = auth()->user()->orders()->latest()->paginate(Order::PAGINATE_COUNT);

        return view('wallets.index', compact('orders'));
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
            'user_id' => auth()->id(),
            'transaction_id' => Order::generateTransactionId(),
            'amount' => $request->amount,
            'status' => Order::STATUS_PENDING,
        ]);

        $payment = new PaymentController();
        return $payment->pay($order->amount, $order->transaction_id);
    }
}
