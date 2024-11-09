@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="border p-2">
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="object-fit: cover; height: 100%; max-height: 300px;">
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">
                        <strong>Product ID:</strong> {{ $product->product_id }}<br>
                        <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>
                        <strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}<br>
                        <strong>Description:</strong> {{ $product->description ?? 'No description available' }}
                    </p>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
