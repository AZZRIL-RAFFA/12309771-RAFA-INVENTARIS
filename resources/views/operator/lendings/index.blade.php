@extends('layouts.app1')

@section('content1')
<style>
    body {
        background-color: #f8f9fa;
    }

    .table thead th {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-top: none;
        border-bottom: 2px solid #f0f0f0;
    }

    .table tbody td {
        font-size: 0.9rem;
        color: #495057;
        padding: 1rem 0.75rem;
    }

    .badge-returned {
        background-color: #fff9e6;
        color: #d39e00;
        border: 1px solid #ffeeba;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
    }

    .btn-returned {
        background-color: #ffc107;
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 15px;
        transition: all 0.3s ease;
    }

    .btn-returned:hover {
        background-color: #e0a800;
        color: white;
        transform: translateY(-1px);
    }

    .btn-delete {
        background-color: #ff4d4d;
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 15px;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #e60000;
        color: white;
        transform: translateY(-1px);
    }

    .btn-create {
        background-color: #00c984 !important;
        color: #fff !important;
        border: none !important;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-create:hover {
        background-color: #00b376 !important;
        color: #fff !important;
        transform: translateY(-1px);
    }

    .add-more-link {
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: 0.2s;
    }

    .add-more-link:hover {
        color: #fff;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .card {
        border-radius: 15px;
        border: none;
    }
</style>

<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Lending Table</h4>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('lending.export') }}" class="btn btn-create text-white px-4 py-2"
                    style="text-decoration: none;">
                    Export Excel
                </a>
                <button class="btn btn-create d-flex align-items-center px-4 py-2" data-bs-toggle="modal"
                    data-bs-target="#lendingModal">
                    <i class="bi bi-plus-lg me-2"></i> Add
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center"
                style="background-color: #d1e7dd; color: #0f5132; border-radius: 10px;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center"
                style="background-color: #f8d7da; color: #842029; border-radius: 10px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center"
                style="background-color: #f8d7da; color: #842029; border-radius: 10px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Name</th>
                        <th>Ket.</th>
                        <th>Date</th>
                        <th>Returned</th>
                        <th>Edited By</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lendings as $index => $ld)
                        <tr>
                            <td class="text-muted">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $ld->item->name ?? '-' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $ld->total }}</span></td>
                            <td class="small">{{ $ld->name }}</td>
                            <td class="text-muted small">
                                <div class="text-truncate" style="max-width: 150px;">{{ $ld->notes ?? '-' }}</div>
                            </td>
                            <td class="text-muted small">{{ $ld->date->format('d M Y') }}</td>
                            <td>
                                @if ($ld->is_returned)
                                    <span class="badge bg-light text-success border w-100" style="padding: 6px;">returned</span>
                                @else
                                    <span class="badge-returned d-block text-center">not returned</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-secondary" style="font-size: 0.8rem;">{{ $ld->user->name ?? 'system' }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    @if (!$ld->is_returned)
                                        <button class="btn btn-sm btn-returned" data-bs-toggle="modal"
                                            data-bs-target="#returnModal{{ $ld->id }}">Returned</button>
                                    @endif
                                    <button class="btn btn-sm btn-delete" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $ld->id }}">Delete</button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteModal{{ $ld->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                    <div class="modal-body p-4 text-center">
                                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                                        <h5 class="fw-bold mt-3">apakah anda yakin?</h5>
                                        <p class="text-muted small">Data <b>{{ $ld->item->name ?? 'item' }}</b> atas nama 
                                            <b>{{ $ld->name }}</b> akan dihapus permanen.</p>
                                        <form action="{{ route('lending.destroy', $ld->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-delete py-2 fw-bold"
                                                    style="border-radius: 10px;">hapus</button>
                                                <button type="button" class="btn btn-create py-2 fw-bold"
                                                    data-bs-dismiss="modal" style="border-radius: 10px;">gajadi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="returnModal{{ $ld->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                                        <h5 class="fw-bold text-dark">Return Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    
                                    <form action="{{ route('lending.return', $ld->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body px-4">
                                            <div class="p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                                                <div class="small text-muted mb-1">Peminjam Asli:</div>
                                                <div class="fw-bold text-dark">{{ $ld->name }}</div>
                                                <div class="small text-muted mt-2">Barang: {{ $ld->item->name ?? '-' }} ({{ $ld->total }} pcs)</div>
                                            </div>
                                            
                                            <label class="form-label fw-bold small text-muted">DITERIMA OLEH:</label>
                                            <input type="text" name="returned_to" class="form-control bg-light border-0 py-2" 
                                                value="{{ Auth::user()->name }}" required>
                                            <div class="form-text small" style="font-size: 0.75rem;">
                                                Nama anda otomatis terisi. Ubah jika staf lain yang menerima.
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer border-0 pb-4 px-4">
                                            <button type="button" class="btn btn-create px-4 py-2 fw-bold" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                                            <button type="submit" class="btn btn-create px-4 py-2 fw-bold" style="border-radius: 10px;">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No lending data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="lendingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark">Lending Form</h5>
                    <p class="text-muted small mb-0">Please <span style="color: #d63384; font-family: monospace;">.fill-all</span> input form
                        with valid data.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('lending.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">BORROWER NAME</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2"
                            placeholder="Enter borrower name" required>
                    </div>

                    <div id="items-container">
                        <div class="row g-3 mb-3 item-row">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-muted">ITEMS</label>
                                <select name="items[]" class="form-select border-0 bg-light py-2" required>
                                    <option value="" selected disabled>Select Item</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">TOTAL</label>
                                <input type="number" name="totals[]" class="form-control bg-light border-0 py-2"
                                    placeholder="Qty" required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="button" class="btn btn-create add-more-link px-3 py-2 d-inline-flex align-items-center" id="add-more-item">
                            <i class="bi bi-plus-circle me-2"></i> Add More Item
                        </button>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-muted">NOTES (KETERANGAN)</label>
                        <textarea name="notes" class="form-control bg-light border-0" rows="3"
                            placeholder="Purpose of lending..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 px-4 justify-content-end gap-2">
                    <button type="button" class="btn btn-create px-4 py-2 fw-bold" data-bs-dismiss="modal"
                        style="border-radius: 10px;">Cancel</button>
                    <button type="submit" class="btn btn-create text-white px-5 py-2 fw-bold"
                        style="border-radius: 10px;">Submit Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const newItemTemplate = `
            <div class="row g-3 mb-3 item-row">
                <div class="col-md-7">
                    <select name="items[]" class="form-select border-0 bg-light py-2" required>
                        <option value="" selected disabled>Select Item</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="totals[]" class="form-control bg-light border-0 py-2" placeholder="Qty" required min="1">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-delete border-0 remove-item">
                        <i class="bi bi-trash fs-5"></i>
                    </button>
                </div>
            </div>`;

        $('#add-more-item').on('click', function() {
            $('#items-container').append(newItemTemplate);
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('.item-row').remove();
        });
    });
</script>
@endsection