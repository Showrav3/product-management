@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product List</h1>

    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by Product ID or Description" value="{{ request()->get('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('products.index', ['sort' => 'name', 'order' => request()->get('order', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request()->get('search')]) }}" 
           class="btn btn-outline-secondary {{ request()->get('sort') == 'name' ? 'btn-primary' : '' }}">
            Sort by Name 
            @if(request()->get('sort') == 'name')
                {{ request()->get('order') == 'asc' ? '↓' : '↑' }}
            @endif
        </a>

        <a href="{{ route('products.index', ['sort' => 'price', 'order' => request()->get('order', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request()->get('search')]) }}" 
           class="btn btn-outline-secondary {{ request()->get('sort') == 'price' ? 'btn-primary' : '' }}">
            Sort by Price 
            @if(request()->get('sort') == 'price')
                {{ request()->get('order') == 'asc' ? '↓' : '↑' }}
            @endif
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th> <!-- Serial Number Column -->
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Serial Number -->
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 60px; object-fit: cover;">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock ?? 'N/A' }}</td>
                <td>{{ $product->description ?? 'No description' }}</td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination-container mt-3">
        <nav aria-label="Product Pagination">
            <ul class="pagination justify-content-end">
                @if ($products->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">Previous</a>
                    </li>
                @endif

                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Display total products and current products being displayed -->
        <div class="d-flex justify-content-end mt-1">
            <span>Showing {{ $products->count() }} of {{ $products->total() }} products</span>
        </div>
    </div>

</div>
@endsection
