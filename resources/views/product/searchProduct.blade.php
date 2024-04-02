@extends('layouts.user')

@section('title', 'Search')

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
<main>
<div class="single-product-item">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="overflow-hidden shadow-sm sm:rounded-lg" width="500px" height="350">
                    <div class="p-6" style="background-color: #FEFAE0;">
                        <div class="mt-2">
                            @php
                            $images = explode(',', $product->images);
                            @endphp
                            @foreach ($images as $image)
                            <img src="/productImages/{{ $image }}"width="200px" style="margin-right: 20px;">
                            @endforeach
                        </div>
                        <div class="flex justify-center items-center">
                            <h6 class="product-text mt-2 font-weight-bold" style="color: #5F6F52; text-align: center;">Item: {{ $product->name }}</h2>
                        </div>
                        <div class="flex justify-center items-center">
                            <p class="product-text" style="color: #B99470; text-align: center;">₱{{ $product->unit_price }}</h2>
                        </div>
                        <div class="mt-2">
                            @foreach($inventories as $inventory)
                                @if($inventory->product_id === $product->product_id)
                                @if($inventory->stock == 0)
                                    <p class="text-danger text-center">Out of Stock</p>
                                    <button class="primary-btn pc-btn add-to-cart-btn text-center" style="background-color: #A9B388;" height="30px" disabled>Add to Cart</button>
                                @else
                                    <p class="text-success text-center">In Stock</p>
                                @endif                               
                                @endif
                            @endforeach
                        </div>
                        <a href="{{ route('cart.show_add_form', ['productId' => $inventory->product_id]) }}" class="primary-btn pc-btn add-to-cart-btn text-center" style="background-color: #A9B388;" height="30px">Add to Cart</a>                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/mixitup.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection
