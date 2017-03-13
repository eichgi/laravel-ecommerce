<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * OrdersController constructor.
     */
    public function __construct()
    {
        $this->middleware("auth");
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->get();
        $totalMonth = Order::totalMonth();
        $totalMonthCount = Order::totalMonthCount();
        return view('orders.index', compact(['orders', 'totalMonth', 'totalMonthCount']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $field = $request->name;
        $order->$field = $request->value;
        $order->save();
        return $order->$field;
    }
}
