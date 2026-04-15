@extends('layouts.app')

@section('content')
    <style>
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
    </style>

    <div class="container-fluid py-4 px-lg-5" style="background-color: #f8f9fa; min-height: 100vh;">

        {{-- Alert Success & Password --}}
        @if (session('success_password'))
            <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 12px;">
                <i class="bi bi-shield-lock-fill me-3 fs-4"></i>
                <div>
                    <strong class="d-block">Success!</strong>
                    <span>{{ session('success_password') }}</span> {{-- --}}
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card p-4 border-0 shadow-sm" style="border-radius: 15px;">
            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $title ?? 'Accounts Table' }}</h4> {{-- --}}
                    <p class="text-muted small mb-0">Add, delete, update <span
                            style="color: #d63384; font-weight: 600;">.admin-accounts</span></p>
                    <p class="text-danger small fw-bold mb-0">p.s password: 4 character of email and nomor.</p>
                    {{-- --}}
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.admin') }}" class="btn btn-create px-4 py-2"
                        style="border-radius: 8px; text-decoration: none;">
                        Export Excel
                    </a>
                    <button class="btn btn-create d-flex align-items-center px-4 py-2 shadow-sm"
                        style="border-radius: 8px;"
                        data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <div class="me-2 d-flex align-items-center justify-content-center"
                            style="width: 18px; height: 18px; background: #fff; border-radius: 4px;">
                            <i class="bi bi-plus" style="color: #00c984; font-weight: bold;"></i>
                        </div>
                        <span class="fw-bold">Add</span>
                    </button>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted border-bottom small">
                            <th class="py-3 px-4 fw-normal" style="width: 50px;">#</th>
                            <th class="py-3 fw-normal">Name</th>
                            <th class="py-3 fw-normal">Email</th>
                            <th class="py-3 fw-normal text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @forelse($users as $index => $user)
                            <tr class="border-bottom">
                                <td class="px-4 py-4 text-muted">{{ $index + 1 }}</td>
                                <td class="py-4 fw-normal text-dark">{{ $user->name }}</td>
                                <td class="py-4 text-muted">{{ $user->email }}</td>
                                <td class="py-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Edit Ungu --}}
                                        <button class="btn btn-create px-4 py-2 text-white shadow-sm"
                                            style="border-radius: 6px; font-size: 0.85rem;"
                                            data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                            Edit
                                        </button>
                                        {{-- Tombol Delete Merah --}}
                                        <button class="btn btn-delete px-3 py-2 text-white shadow-sm"
                                            style="border-radius: 6px;" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal{{ $user->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL EDIT --}}
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                data-bs-backdrop="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="fw-bold">Edit Account Forms</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body px-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        style="background-color: #f8f9fa; border: none;"
                                                        value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        style="background-color: #f8f9fa; border: none;"
                                                        value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-primary">New Password
                                                        (optional)
                                                    </label>
                                                    <input type="password" name="new_password" class="form-control"
                                                        style="background-color: #f8f9fa; border: none;"
                                                        placeholder="Leave blank if no change"> {{-- --}}
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pb-4">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-create px-4">Update Account</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- MODAL DELETE --}}
                            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                                data-bs-backdrop="false">
                                <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                    <div class="modal-content border-0 shadow p-4 text-center"
                                        style="border-radius: 15px;">
                                        <i class="bi bi-exclamation-triangle text-danger mb-3"
                                            style="font-size: 3rem;"></i>
                                        <h4 class="fw-bold">Delete Account?</h4>
                                        <p class="text-muted small">Are you sure you want to delete
                                            <strong>{{ $user->name }}</strong>?
                                        </p>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-delete py-2 fw-bold">Yes,
                                                    Delete</button>
                                                <button type="button" class="btn btn-light py-2"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL ADD --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <div>
                        <h5 class="fw-bold mb-0">Add Account Forms</h5>
                        <p class="text-muted small">Please <span style="color: #d63384;">.fill-all</span> input form with
                            right value.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Name</label>
                            <input type="text" name="name" class="form-control py-2"
                                style="background-color: #f8f9fa; border: none;" placeholder="Fema Flamelina Putri"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" name="email" class="form-control py-2"
                                style="background-color: #f8f9fa; border: none;" placeholder="femaflam22@gmail.com"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Role</label>
                            <select name="role" class="form-select py-2"
                                style="background-color: #f8f9fa; border: none;" required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="operator">Operator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-create px-4" style="border-radius: 8px;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection