@extends('layouts.app')
@section('title', 'Products')

@section('content')
<h1>Product Listing</h1>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
<table id="products-table" class="table">
    <thead>
        <tr>
            <th>Sr No.</th>
            <th>Name</th>
            <th>Image</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $key=>$product)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $product->name }}</td>
            <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="70" height="70"></td>
            <td>{{ $product->category ? $product->category->name : 'No Category' }}</td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#products-table').DataTable();
    });
</script>

@endpush