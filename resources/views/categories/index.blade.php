@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <h2>Categories</h2>
    </div>
    <div class="col-sm-6 text-right">
        <button class="btn btn-primary newcat" data-toggle="modal" data-target="#addCategoryModal">Add New Category</button>
    </div>
</div>
<table id="categoryTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sr No.</th>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitCategory">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="form-group">
                        <label for="editCategoryName">Category Name:</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitEditCategory">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    });
</script>

<script>
    $(document).ready(function() {

        $('#submitCategory').click(function() {
            var categoryName = $('#categoryName').val();
            $.ajax({
                url: '{{ route("categories.store") }}',
                method: 'POST',
                data: {
                    name: categoryName,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#addCategoryModal').modal('hide');
                    reloadCategoryList();
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value[0]);
                        });
                    }
                    console.clear();
                }
            });
        });

        $(document).on('click', '.edit-category', function() {
            var categoryId = $(this).data('category-id');
            $.get('/categories/' + categoryId, function(category) {
                $('#editCategoryId').val(category.id);
                $('#editCategoryName').val(category.name);
            });
        });

        $('#submitEditCategory').click(function() {
            var categoryId = $('#editCategoryId').val();
            var categoryName = $('#editCategoryName').val();
            $.ajax({
                url: '/categories/' + categoryId,
                method: 'PUT',
                data: {
                    name: categoryName,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    reloadCategoryList();
                    $('#editCategoryModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value[0]);
                        });
                    }
                    console.clear();
                }
            });
        });


        function reloadCategoryList() {
            $.get('{{ route("category.list") }}', function(data) {
                $('#categoryTable tbody').html(data);
                
        $('#categoryTable').DataTable();
            });
        }
        reloadCategoryList();
    });
</script>
@endpush