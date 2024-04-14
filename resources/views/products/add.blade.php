@extends('layouts.app')
@section('content')
<h1>Add Product</h1>
<form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" class="form-control" id="name" required>
    </div>
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" name="image" class="form-control-file" id="image" required>
    </div>
    <div class="form-group">
        <label for="category">Product Category</label>
        <select name="category_id" class="form-control" id="category" required>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection