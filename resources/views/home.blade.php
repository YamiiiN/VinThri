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
{{-- <main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg h-96">
                Homepage
            </div>
        </div>
    </div>
</main> --}}


<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                @php
                    $images = explode(',', $product->image);
                @endphp
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach(explode(',', $product->image) as $image)
                    <img src="{{ asset($image) }}" alt="Product Image" style="max-width: 200px;"><br><br>
                @endforeach
                </div>
                <div class="px-4 py-4">
                    <h3 class="text-gray-900 font-semibold text-lg">{{ $product->name }}</h3>
                    <p class="text-gray-500">{{ $product->description }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="font-semibold text-xl text-gray-900">₱{{ $product->unit_price }}</span>
                        <a href="#" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Add to Cart</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
