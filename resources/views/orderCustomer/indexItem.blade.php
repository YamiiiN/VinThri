@extends('layouts.user')

@section('title', 'Order Items')

@section('contents')
    <div class="container">
        <h4>Order Items for Order ID: {{ $order->order_id }}</h4>

        @if ($items->isEmpty())
            <p>No items found for this order.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->product_id }}</td>
                            <td>{{ $item->product->name }}</td> <!-- Assuming 'product' is the relationship name in OrderItem -->
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
