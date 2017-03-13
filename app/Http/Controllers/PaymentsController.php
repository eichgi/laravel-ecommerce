<?php

namespace App\Http\Controllers;

use App\Order;
use App\PayPal;
use App\ShoppingCart;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('shoppingcart');
    }

    public function store(Request $request)
    {
        $shopping_cart = $request->shopping_cart;

        $paypal = new Paypal($shopping_cart);

        $response = $paypal->execute($request->paymentId, $request->PayerID);

        if ($response->state == "approved") {
            \Session::remove('shopping_cart_id');
            $order = Order::createFromPayPalResponse($response, $shopping_cart);
            $shopping_cart->approve();
            //$order->sendMail();
        }

        return view('shopping_carts.completed', ['shopping_cart' => $shopping_cart, 'order' => $order]);
        //dd($order);
    }
}
