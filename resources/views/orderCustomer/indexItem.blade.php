@extends('layouts.user')

@section('title', 'Order Items')

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
    <div class="container">
    <div class="cart-table">
        <h2 class="text-center mb-5" style="color: #5F6F52;">Order Items for Order ID: {{ $order_id }}</h2>

        @if ($orderItems->isEmpty())
            <p>No items found for this order.</p>
        @else
                <table>
                    <thead>
                        <tr>
                        <th>Item</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $orderItem)
                        <tr>
                            <td>{{ $orderItem->product->name }}</td> 
                            <td>
                                @php
                                $images = explode(',', $orderItem->product->images);
                                @endphp
                                @foreach ($images as $image)
                                <img src="/productImages/{{ $image }}" width="100px" style="margin-right: 10px;">
                                @endforeach
                            </td>  
                            <td>{{ $orderItem->quantity }}</td>
                            <td>{{ $orderItem->product->unit_price }}</td>
                            <td>{{ $orderItem->product->unit_price * $orderItem->quantity }}</td>
                            <td>
                                @if($orderItem->order->status == 'delivered')
                                    <form action="{{ route('feedback.create') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="order_item_id" value="{{ $orderItem->order_item_id }}">
                                        <button type="submit" class="btn btn-primary">Feedback</button>
                                    </form>
                                @endif
                            </td>                  
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
