@extends('layouts.app')

@section('content')
<style>
    .select2-container--bootstrap-5 .select2-selection {
        background-color: #f8f9fa !important;
        border: none !important;
        border-radius: 8px !important;
        height: 45px !important;
        display: flex !important;
        align-items: center !important;
    }

    .table > :not(caption) > * > * {
        border-bottom-width: 1px;
        border-color: #f2f2f2;
        padding: 1rem 1rem;
    }

    .card {
        background-color: #00c984;
    }

    .btn-action {
        border-radius: 6px;
        font-size: 0.85rem;
        padding: 0.4rem 1rem;
    }
    .btn-edit:hover { background-color: #00b376; color: white; }

    .btn-create {
        background-color: #00c984 !important;
        color: #fff !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-create:hover {
        background-color: #00b376 !important;
        color: #fff !important;
        transform: translateY(-1px);
    }

    .btn-delete {
        background-color: #ff4d4d !important;
        color: #fff !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #e60000 !important;
        color: #fff !important;
        transform: translateY(-1px);
    }
    .form-control:focus {
        box-shadow: none;
        background-color: #ff4d4d;
        color: white;
</style>

<div class="container-fluid py-4 px-lg-5">
    @if (session('success_password'))
    <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 12px;">
        <i class="bi bi-shield-lock-fill me-3 fs-4"></i>
    .btn-delete-trigger:hover { background-color: #e60000; color: white; }
            <strong class="d-block">Account Created!</strong>
            <span>{{ session('success_password') }}</span>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Operator Accounts</h4>
                    <p class="text-muted small mb-0">Manage your system <span class="badge bg-light text-danger fw-normal">.operator-accounts</span></p>
                    <p class="small mb-0 text-muted">Default password: <span class="text-danger">4 chars of email + nomor</span></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.operator') }}" class="btn btn-create d-flex align-items-center" style="border-radius: 8px;">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Operator
                    </a>
                    <button class="btn btn-create d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addAccountModal" style="border-radius: 8px;">
                        <i class="bi bi-plus-lg me-2"></i> <span class="fw-bold">Add New</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $operator)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $operator->name }}</div>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $operator->email }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-action btn-create text-white" data-bs-toggle="modal" data-bs-target="#editModal{{ $operator->id }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-action btn-delete text-white" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $operator->id }}">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $operator->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <h5 class="fw-bold">Edit Account</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.users.update', $operator->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body px-4">
                                            <div class="mb-3">
                                                <label class="small fw-bold mb-1">Name</label>
                                                <input type="text" name="name" class="form-control bg-light border-0 py-2" value="{{ $operator->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold mb-1">Email</label>
                                                <input type="email" name="email" class="form-control bg-light border-0 py-2" value="{{ $operator->email }}" required>
                                            </div>
                                            <div class="mb-1">
                                                <label class="small fw-bold mb-1 text-primary">New Password (optional)</label>
                                                <input type="password" name="new_password" class="form-control bg-light border-0 py-2" placeholder="Leave blank to keep current">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pb-4 px-4">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-create px-4">Update Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/status-not-found.svg" alt="No data" style="width: 120px;" class="mb-3 opacity-50">
                                <p class="text-muted mb-0">No operator accounts found in our database.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAccountModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark">Add New Operator</h5>
                    <p class="text-muted small mb-0">Ensure all fields are filled correctly.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small mb-1">Full Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small mb-1">Email Address</label>
                        <input type="email" name="email" class="form-control bg-light border-0 py-2" placeholder="operator@wikrama.sch.id" required>
                    </div>
                    <input type="hidden" name="role" value="operator">
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-create px-4 fw-bold">Save Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3.5rem;"></i>
                </div>
                <h5 class="fw-bold">Delete Account?</h5>
                <p class="text-muted small">This action cannot be undone. All data associated with this operator will be removed.</p>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-delete fw-bold py-2">Confirm Delete</button>
                        <button type="button" class="btn btn-light py-2" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            const actionUrl = `/admin/users/${id}`;
            
            $('#deleteForm').attr('action', actionUrl);
            deleteModal.show();
        });
    });
</script>
@endpush
@endsection