@extends('layouts.app')

@section('title', 'VinThri')

@section('contents')
    <div>
        <h1 class="font-bold text-2xl ml-3">Admins Information</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="margin-bottom:10px;">
                    <a class="btn btn-success" href="">Create Admin</a>
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
                <th>First Name</th>
                <th>Last Name</th>
                <th>Image</th>
                <th>Address</th>
                <th>Email</th>
                <th>Password</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($admins as $admin)           
            <tr>
                <td>{{ $admin->first_name }}</td>
                <td>{{ $admin->last_name }}</td>
                <td><img src="/adminImages/{{ $admin->image }}" width="100px"></td>
                <td>{{ $admin->address }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->password }}</td>
                
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

    </div>
@endsection