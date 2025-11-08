<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'customer_email',
        'terms_accepted',
        'invoice_required',
        'invoice_ruc',
        'invoice_business_name',
        'invoice_address',
        'total_amount',
        'status',
        'order_type',
        'invoice_status',
        'payment_status',
        'payment_type',
        'notes'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber()
    {
        $prefix = 'SOS-';
        $date = now()->format('Ymd');

        // Get the last order number with this prefix and date
        $lastOrder = self::where('order_number', 'like', $prefix . $date . '%')
            ->orderByDesc('order_number')
            ->first();

        if ($lastOrder) {
            $lastNumber = substr($lastOrder->order_number, strlen($prefix . $date));
            $newNumber = str_pad(intval($lastNumber) + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }
}
