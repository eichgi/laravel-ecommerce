@extends('layouts.app')

@section('content')
    <div class="container text-center">
        @include('products.product', compact('product'))
    </div>
@endsection