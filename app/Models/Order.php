<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const ORDER_TRANSACTION_ID_PREFIX = 'LARAGRAM';

    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILED = 2;

    protected $fillable = [
        'transaction_id',
        'amount',
        'status',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public static function generateTransactionId(): string
    {
        // unique order id with prefix and 10 digit random number
        $transactionId = mt_rand(1000000000, 9999999999);
        while (Order::where('transaction_id', $transactionId)->exists()) {
            $transactionId = mt_rand(1000000000, 9999999999);
        }

        return self::ORDER_TRANSACTION_ID_PREFIX.'-'.$transactionId;
    }
}
