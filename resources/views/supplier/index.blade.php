@extends('layouts.app')

@section('title', 'VinThri')

@section('contents')
    <div>
        <h1 class="font-bold text-2xl ml-3">Suppliers</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="margin-bottom:10px;">
                    <a class="btn btn-success" href="{{ url('/supplier/create') }}">Create New Supplier</a>
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
                <th width="280px">Action</th>
            </tr>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->first_name }}</td>
                    <td>{{ $supplier->last_name }}</td>
                    <td><img src="/supplierImages/{{ $supplier->image }}" width="100px"></td>
                    <td>{{ $supplier->address }}</td>
                    <td>
                        <form action="{{ route('supplier.destroy', $supplier->supplier_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a class="btn btn-primary" href="{{ route('supplier.edit', $supplier->supplier_id) }}">Edit</a>

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $suppliers->links() !!}
    </div>
@endsection
