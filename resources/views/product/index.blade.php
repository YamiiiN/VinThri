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
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Details</th>
                <th>Selling Price</th>
                <th>Supplier</th>
                <th>Date Supplied</th>
                <th width="280px">Action</th>
            </tr>

            @foreach ($productSuppliers as $productSupplier)           
            <tr>              
                <td><img src="/productImages/{{ $productSupplier->product->image }}" width="100px"></td>
                <td>{{ $productSupplier->product->name }}</td>
                <td>{{ $productSupplier->product->category->name }}</td>
                <td>{{ $productSupplier->product->description }}</td>
                <td>{{ $productSupplier->product->unit_price }}</td>
                <td>{{ $productSupplier->supplier->first_name}} {{ $productSupplier->supplier->last_name}}</td>
                <td>{{ $productSupplier->date_supplied }}</td>
                <td>{{ $productSupplier->date_supplied }}</td>

            </tr>
            @endforeach
        </table>
    </div>
@endsection