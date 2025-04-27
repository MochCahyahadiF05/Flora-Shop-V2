@extends('layouts.admin')

@section('content')
<div class="col-12">
    <div class="row">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                User Management
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">+ Add User</button>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table" id="usersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/photos/users/' . ($user->photo ?? 'default.jpg')) }}"
                                     width="40" height="40" class="rounded-circle" alt="User Photo"><span style="margin-left: 10px">{{ $user->name }}</span>
                                    </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                <span class="badge rounded-pill bg-primary">{{ ucfirst($user->role) }}</span>
                                @elseif ($user->role == 'user')
                                <span class="badge rounded-pill bg-success">{{ ucfirst($user->role) }}</span>
                                @else
                                <span class="badge rounded-pill bg-warning">Tidak ada role</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item edit-btn"
                                           href="#"
                                           data-id="{{ $user->id }}"
                                           data-name="{{ $user->name }}"
                                           data-email="{{ $user->email }}"
                                           data-role="{{ $user->role }}"
                                           data-photo="{{ $user->photo }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#editModal">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
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

<!-- Modal Create -->
@include('admin.pages.users.create')

<!-- Modal Update -->
@include('admin.pages.users.update')
@endsection

@push('scripts')
<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#usersTable').DataTable();

        $('.edit-btn').on('click', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const role = $(this).data('role');
            const photo = $(this).data('photo');

            $('#editForm').attr('action', '/admin/users/' + id);
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-email').val(email);
            $('#role-admin').prop('checked', role === 'admin');
            $('#role-user').prop('checked', role === 'user');

            const photoUrl = photo ? `/storage/photos/users/${photo}` : `/storage/photos/users/default.jpg`;
            $('#preview-photo').attr('src', photoUrl);
        });
    });
</script>
@endpush
