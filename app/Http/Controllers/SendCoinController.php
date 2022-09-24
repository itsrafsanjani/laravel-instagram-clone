<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SendCoinController extends Controller
{
    public function create(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $receiver = User::find($request->receiver);

        return view('send-coins.create', [
            'receiver' => $receiver,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:'.auth()->user()->balance],
            'receiver' => ['required', 'exists:users,id'],
        ]);

        $receiver = User::findOrFail($request->receiver);

        try {
            auth()->user()->transfer($receiver, $request->amount);

            return redirect()->route('users.show', $receiver)
                ->with([
                    'status' => 'success',
                    'message' => 'Transfer successfully completed.'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('users.show', $receiver)
                ->with([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }
}
