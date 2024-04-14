@foreach($categories as $key=>$category)
<tr>
    <td>{{ ++$key }}</td>
    <td>{{ $category->id }}</td>
    <td>{{ $category->name }}</td>
    <td>
        <button class="btn btn-sm btn-primary edit-category" data-category-id="{{ $category->id }}" data-toggle="modal" data-target="#editCategoryModal">Edit</button>
        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
        </form>
    </td>
</tr>
@endforeach