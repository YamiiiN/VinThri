<!DOCTYPE html>
@extends('layouts.app')
 
@section('title', 'VinThri')
 
@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Product</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
                </div>
            </div>
        </div>
        
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
        
        <form action="{{ route('product.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{  $productSupplier->product->name}}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Detail:</strong>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Detail">{{  $productSupplier->product->description}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Price:</strong>
                        <input type="text" name="unit_price" value="{{  $productSupplier->product->unit_price}}" class="form-control" placeholder="Name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <strong>Category:</strong>
                    <select class="form-select" aria-label="Default select example" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}" @if ($category->category_id == $productSupplier->product->category_id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>    
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Images:</strong>
                        @foreach ($images as $image)
                        <div class="mb-2">
                            <img src="/productImages/{{ $image }}" width="100px" class="mr-2">
                        </div>
                        @endforeach
                        <input type="file" name="new_images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <strong>Supplier:</strong>
                    <select class="form-select" aria-label="Default select example" name="category_id">
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $productSupplier->supplier->supplier_id}}" @if ($supplier->supplier_id == $productSupplier->supplier->supplier_id) selected @endif>{{ $supplier->first_name }} {{ $supplier->last_name }}</option>
                        @endforeach
                    </select>
                </div>    
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Supplier Price:</strong>
                        <input type="text" name="price" value="{{ $productSupplier->price}}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Date Supplied:</strong>
                        <input type="date" name="date_supplied" value="{{  $productSupplier->date_supplied}}"  class="form-control">
                    </div>
                </div>  
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>     
        </form>
    </div>
@endsection