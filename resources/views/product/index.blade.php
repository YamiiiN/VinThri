<!DOCTYPE html>
<html>
<head>
    <title>Product CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Products CRUD</h2>
                </div>
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
                <td><img src="/productImages/{{ $product->image }}" width="100px"></td>
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
</body>
</html>