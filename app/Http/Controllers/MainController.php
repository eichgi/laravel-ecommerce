<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;


class MainController extends Controller
{
    public function home()
    {
        $products = Product::simplePaginate(2);

        return view('main.home', compact('products'));
    }
}