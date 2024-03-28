@extends('layouts.app')
 
@section('title', 'VinThri')
 
@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Edit Inventory Stock</h1>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('/inventory') }}"> Back</a>
        </div>
</div>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('inventory.update', $inventory) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $inventory->product->name }}" class="form-control" readonly>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong name="image" >Image:</strong>
                    <td>
                        @php
                        $images = explode(',', $inventory->product->images);
                        @endphp
                        @foreach ($images as $image)
                        <img src="/productImages/{{ $image }}" width="100px" style="margin-right: 10px;">
                        @endforeach
                    </td> 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Stock:</strong>
                    <input type="text" name="stock" value="{{ $inventory->stock }}" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>     
    </form>
</div>
@endsection
