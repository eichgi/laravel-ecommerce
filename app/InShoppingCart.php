<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InShoppingCart extends Model
{
    protected $fillable = ['product_id', 'shopping_cart_id'];

    public static function productsCount($shopping_cart_id)
    {
        return InShoppingCart::where('shopping_cart_id', $shopping_cart_id)->count();
    }
}
