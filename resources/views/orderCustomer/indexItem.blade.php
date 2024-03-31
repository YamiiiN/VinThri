@extends('layouts.user')

@section('title', 'Order Items')

@section('contents')
    <div class="container">
        <h4>Order Items for Order ID: {{ $order_id }}</h4>

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
                                <form action="" method="POST">
                                    <a class="btn btn-primary" href="">Feedback</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
