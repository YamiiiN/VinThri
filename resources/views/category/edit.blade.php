@extends('layouts.app')
 
@section('title', 'VinThri')
 
@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Edit Category</h1>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('/category') }}"> Back</a>
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
        
        <form action="{{ route('category.update', $category->category_id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description:</strong>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Detail">{{ $product->description }}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>     
        </form>
    </div>
@endsection