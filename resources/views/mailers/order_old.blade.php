<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Hola</h1>
<p>Te enviamos los datos de tu compra</p>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Producto</th>
        <th>Costo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{$product->title}}</td>
            <td>{{$product->pricing}}</td>
        </tr>
    @endforeach
    <tr>
        <td>Total</td>
        <td>{{$order->total}}</td>
    </tr>
    </tbody>
</table>
</body>
</html>