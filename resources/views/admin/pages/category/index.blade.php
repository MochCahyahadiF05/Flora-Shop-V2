@extends('layouts.admin')

@section('content')
<div class="col-12">
    <div class="row">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Category Table
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">+ Add Category</button>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table" id="categoryTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php use Illuminate\Support\Str; @endphp
                        @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td title="{{ $category->description }}">
                                {{ Str::limit($category->description, 30, '...') }}
                            </td>
                            <td>{{ $category->created_at ? $category->created_at->format('d M Y') : '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item edit-btn"
                                           href="#"
                                           data-id="{{ $category->id }}"
                                           data-name="{{ $category->name }}"
                                           data-description="{{ $category->description }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#editModal">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit"><i class="bx bx-trash me-1"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
@include('admin.pages.category.create')

<!-- Edit Modal -->
@include('admin.pages.category.update')
@endsection

@push('scripts')
<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#categoryTable').DataTable();

        // Isi form edit saat tombol edit ditekan
        $('.edit-btn').on('click', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');

            $('#editForm').attr('action', '/admin/categories/' + id);
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-description').val(description);
        });
    });
</script>
@endpush
