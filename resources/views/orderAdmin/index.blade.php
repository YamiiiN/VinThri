@extends('layouts.app')

@section('title', 'Orders')

@section('contents')

<h1>All Orders</h1>
    @if(count($orders) > 0)
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                        <td>{{ $order->date }}</td>
                        <td>
                        <form action="{{ route('admin.updateOrderStatus', ['orderId' => $order->order_id]) }}" method="POST">
    @csrf
    @method('PUT')
    <select name="status">
        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
    </select>
    <button type="submit">Update Status</button>
</form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No orders found.</p>
    @endif
@endsection
