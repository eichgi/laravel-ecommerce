<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'recipient_name',
        'line1',
        'line2',
        'city',
        'email',
        'shopping_cart_id',
        'status',
        'total',
        'guide_number'
    ];

    public function scopeLatest($query)
    {
        return $query->orderID()->monthly();
    }

    public function scopeOrderID($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeMonthly($query)
    {
        return $query->whereMonth('created_at', '=', date('m'));
    }

    public function address()
    {
        return "$this->line1 $this->line2";
    }

    public static function createFromPayPalResponse($response, $shopping_cart)
    {
        $payer = $response->payer;
        $orderData = (array)$payer->payer_info->shipping_address;
        $orderData = $orderData[key($orderData)];
        $orderData['email'] = $payer->payer_info->email;
        $orderData['total'] = $shopping_cart->total();
        $orderData['shopping_cart_id'] = $shopping_cart->id;
        return Order::create($orderData);
    }
}
