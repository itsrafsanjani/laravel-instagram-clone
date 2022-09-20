<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public const PAGINATE_COUNT = 20;

    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILED = 2;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'status',
        'data',
    ];

    protected $casts = [
        'data' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get the app name and remove spaces or
     * any special characters then uppercase it
     * @return string
     */
    public static function getOrderTransactionIdPrefix(): string
    {
        return Str::upper(Str::slug(config('app.name', 'LARAGRAM'), ''));
    }

    /**
     * unique order id with prefix and 10 digit random number
     * @return string
     */
    public static function generateTransactionId(): string
    {
        $transactionId = mt_rand(1000000000, 9999999999);
        while (Order::where('transaction_id', $transactionId)->exists()) {
            $transactionId = mt_rand(1000000000, 9999999999);
        }

        return self::getOrderTransactionIdPrefix().'-'.$transactionId;
    }

    public function getStatusType(): string
    {
        $statusBadge = [
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_SUCCESS => 'badge-success',
            self::STATUS_FAILED => 'badge-danger',
        ];

        return $statusBadge[$this->status];
    }

    public function getStatusText(): string
    {
        $statusText = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED => 'Failed',
        ];

        return $statusText[$this->status];
    }
}
