@extends('layouts.app')

@section('content')
<style>
    .modal { z-index: 1065 !important; }
    .modal-backdrop { z-index: 1060 !important; }

    .table thead th {
        border: none;
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr { border-bottom: 1px solid #f2f2f2; }

    .btn-edit {
        background-color: #00c984;
        color: white;
        border-radius: 10px;
        padding: 8px 30px;
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-edit:hover { background-color: #00b376; color: white; }

    .btn-delete-trigger {
        background-color: #ff4d4d;
        color: white;
        border-radius: 10px;
        padding: 8px 20px;
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-delete-trigger:hover { background-color: #e60000; color: white; }

    .modal.fade .modal-dialog {
        transform: scale(0.9);
        transition: transform 0.2s ease-out;
    }
    .modal.show .modal-dialog { transform: scale(1); }
</style>

<div class="container-fluid py-4 px-lg-5" style="background-color: #f8f9fa; min-height: 100vh;">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 12px; background-color: #d1e7dd;">
            <i class="bi bi-check-circle-fill me-2" style="color: #0f5132;"></i>
            <div style="color: #0f5132;">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4 p-lg-5">

            {{-- Header Tabel nya --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Categories Table</h3>
                </div>

                <button type="button" class="btn d-flex align-items-center px-4 py-2 shadow-sm text-white"
                    data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                    style="background-color: #00c984; border-radius: 10px; border: none;">
                    <div class="bg-white rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 20px; height: 20px;">
                        <i class="bi bi-plus" style="color: #00c984; font-size: 1.2rem; line-height: 0;"></i>
                    </div>
                    <span class="fw-bold">Add</span>
                </button>
            </div>

            {{-- Data Tabel --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="px-4" style="width: 80px;">NO</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Division PJ</th>
                            <th class="text-center">Total Items</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @forelse($categories as $index => $cat)
                        <tr>
                            <td class="px-4 py-4 text-muted">{{ $index + 1 }}</td>
                            <td class="text-center fw-semibold text-dark">{{ $cat->name }}</td>
                            <td class="text-center text-muted">{{ $cat->division_pj }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light text-dark px-3">{{ $cat->items_count }} Items</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $cat->id }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-delete-trigger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $cat->id }}">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- modal edit --}}
                        <div class="modal fade" id="editCategoryModal{{ $cat->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                    <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold text-dark">Edit Category Forms</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold small">Name</label>
                                                <input type="text" class="form-control bg-light border-0 py-2" name="name" value="{{ $cat->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Division PJ</label>
                                                <select class="form-select bg-light border-0 py-2" name="division_pj" required>
                                                    <option value="Sarpras" {{ $cat->division_pj == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                                                    <option value="Tata Usaha" {{ $cat->division_pj == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                                                    <option value="Tefa" {{ $cat->division_pj == 'Tefa' ? 'selected' : '' }}>Tefa</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pb-4 px-4">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-edit px-4" style="border-radius: 8px;">Update Category</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- modal hapus --}}
                        <div class="modal fade" id="deleteCategoryModal{{ $cat->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body p-5 text-center">
                                        <div class="mb-4">
                                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem; opacity: 0.8;"></i>
                                        </div>
                                        <h4 class="fw-bold text-dark mb-2">apakah anda yakin?</h4>
                                        <p class="text-muted mb-4 small">anda akan menghapus <br> <strong>"{{ $cat->name }}"</strong>.ini gabisa di dibatalin.</p>

                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-delete-trigger py-2 fw-bold" style="border-radius: 10px;">hapus</button>
                                                <button type="button" class="btn btn-light py-2 fw-bold text-muted" data-bs-dismiss="modal">gajadi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- modal menambahkan data --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark">Add Category Forms</h5>
                    <p class="text-muted small mb-0">Please <span style="color: #d63384;">.fill-all</span> input form with right value.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-dark">Name</label>
                        <input type="text" class="form-control py-2 bg-light border-0" name="name" placeholder="Contoh: Alat Dapur" style="border-radius: 8px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Division PJ</label>
                        <select class="form-select bg-light border-0 py-2" name="division_pj" required style="border-radius: 8px;">
                            <option selected disabled value="">Select Division PJ</option>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                            <option value="Tefa">Tefa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 gap-2">
                    <button type="button" class="btn btn-light px-4 py-2 text-muted fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-edit px-4 py-2 fw-bold" style="border-radius: 8px;">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection