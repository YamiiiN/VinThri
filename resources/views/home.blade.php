@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Home
        </h1>
    </div>
</header>
<hr />
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($inventories as $inventory)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mt-4">
                            @php
                            $images = explode(',', $inventory->product->images);
                            @endphp
                            @foreach ($images as $image)
                            <img src="/productImages/{{ $image }}" width="100px" style="margin-right: 10px;">
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Item: {{ $inventory->product->name }}</h2>
                            {{-- <input type="checkbox" name="selected_products[]" value="{{ $inventory->product->id }}" class="ml-2"> --}}
                        </div>
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Price: {{ $inventory->product->unit_price }}</h2>

                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-700">Available Stock: {{ $inventory->stock }}</p>

                        </div>
                       <a href="{{ route('cart.show_add_form', ['productId' => $inventory->product_id]) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Add to Cart</a>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
