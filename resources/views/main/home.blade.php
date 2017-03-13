@extends('layouts.app')

@section('title', 'Productos Facilito')

@section('content')
    <div class="container text-center products-container">
        @foreach($products as $product)
            @include('products.product', compact('product'))
        @endforeach
        <div>
            {{$products->links()}}
        </div>
    </div>
@endsection