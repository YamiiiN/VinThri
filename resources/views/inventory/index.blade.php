@extends('layouts.app')
@section('title', 'VinThri')
@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Inventories</h1>
</div>
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th>Stocks</th>
            <th width="280px">Action</th>
        </tr>

        @foreach ($inventories as $inventory)
        <tr>
            <td>{{ $inventory->product->name }}</td>
            <td><img src="/productImages/{{ $inventory->product->image }}" width="100px"></td>
            <td>{{ $inventory->stock }}</td>
            <td>
                <form action="" method="POST">
                    <a class="btn btn-primary" href="{{ route('inventory.edit', $inventory->inventory_id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $inventories->links() !!}
</div>
@endsection

