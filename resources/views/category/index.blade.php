@extends('layouts.app')
 
@section('title', 'VinThri')
 
@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Categories</h1>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="margin-bottom:10px;">
                <a class="btn btn-success" href="{{ url('/category/create') }}"> Create New Category</a>
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
                <th>Name</th>
                <th>Description</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($categories as $category)           
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    
                    <form action="" method="POST">        
                        <a class="btn btn-primary" href="">Edit</a>
        
                        @csrf
                        @method('DELETE')
            
                        <button type="submit" class="btn btn-danger" >Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        
        {!! $categories->links() !!}
    </div>
@endsection
