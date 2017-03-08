<?php

namespace App\Http\Controllers;

use App\PayPal;
use App\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartsController extends Controller
{
    public function index()
    {
        $shopping_cart_id = \Session::get('shopping_cart_id');

        $shopping_cart = ShoppingCart::findOrCreateBySessionID($shopping_cart_id);

        $paypal = new PayPal($shopping_cart);

        $payment = $paypal->generate();

        return redirect($payment->getApprovalLink());
    }

    public function show($id)
    {
        $shopping_cart = ShoppingCart::where('customid', $id)->first();
        $order = $shopping_cart->order();
        return view('shopping_carts.completed', ['shopping_cart' => $shopping_cart, 'order' => $order]);
    }
}
