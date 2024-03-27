<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.app')

@section('title', 'VinThri')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Products</h1>
</div>
<div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="margin-bottom:10px;">
                <a class="btn btn-success" href="{{ url('/product/create') }}"> Create New Product</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Details</th>
                <th>Price</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>
                    @foreach(explode(',', $product->image) as $image)
                        <img src="{{ asset($image) }}" alt="Product Image" style="max-width: 100px;"><br><br>
                    @endforeach
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->unit_price }}</td>
                <td>

                    <form action="{{ route('product.destroy', $product->product_id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('product.edit', $product->product_id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" >Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        {!! $products->links() !!}
    </div>
@endsection
