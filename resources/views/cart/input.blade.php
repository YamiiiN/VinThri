@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Yoga Studio Template">
    <meta name="keywords" content="Yoga, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title> 

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>
<form id="cartForm" action="{{ route('cart.store') }}" method="POST">
    @csrf
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(isset($product))
    <div>
        <label for="name">Name: </label>
        <span id="name">{{ $cart->product->name }}</span>
    </div>
    @endif
    <div>
        <label for="product_id">Product ID:</label>
        <input type="text" id="product_id" name="product_id" value="{{ $productId }}" readonly>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" value="1" readonly> <!-- Automatically set quantity to 1 -->
    </div>
    <div>
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" value="{{ $customerId }}" readonly>
    </div>

    <button type="submit" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Add to Cart</button>
</form>

<script>
    document.getElementById('cartForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Extract the values from the form fields
        var productId = document.getElementById('product_id').value;
        var quantity = document.getElementById('quantity').value;
        var customerId = document.getElementById('customer_id').value;

        // Display the values in an alert
        alert('Product ID: ' + productId + '\nQuantity: ' + quantity + '\nCustomer ID: ' + customerId);

        // Submit the form
        this.submit();
    });
</script>
 <!-- hi -->
 <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/mixitup.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
 @endsection