<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" enctype="multipart/form-data" class="modal-content" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-id">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="edit-name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="edit-email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Role</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="role-admin" value="admin">
                        <label class="form-check-label" for="role-admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="role-user" value="user">
                        <label class="form-check-label" for="role-user">User</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Photo</label><br>
                    <img id="preview-photo" src="" width="100" class="mb-2" alt="User Photo">
                    <input type="file" name="photo" class="form-control" id="edit-photo">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>
