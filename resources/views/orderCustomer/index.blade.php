@extends('layouts.user')

@section('title', 'Orders')

@section('contents')
    <div class="container">
        <h4>Orders</h4>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders->isEmpty())
                    <tr>
                        <td colspan="3">No orders found.</td>
                    </tr>
                @else
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-primary" href="">View Items</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>

                                    @if ($order->status === 'delivered')
                                        <a href="" class="btn btn-success">Feedback</a>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
