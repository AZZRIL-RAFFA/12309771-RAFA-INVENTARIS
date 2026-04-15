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

    .btn-returned {
        background-color: #ffc107 !important;
        color: #fff !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-returned:hover {
        background-color: #e0a800 !important;
        color: #fff !important;
        transform: translateY(-1px);
    }
</style>

<div class="container-fluid py-4 px-lg-5" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="card p-4 border-0 shadow-sm card-rounded">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Items Table</h4>
                <p class="text-muted small mb-0">Add, delete, update <span class="text-pink">.items</span></p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" onclick="window.location.href='{{ route('admin.items.export') }}'" class="btn btn-create px-4 py-2 shadow-sm">
                    Export Excel
                </button>

                <button class="btn btn-create d-flex align-items-center px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <div class="icon-plus-wrapper me-2">
                        <i class="bi bi-plus"></i>
                    </div>
                    <span class="fw-bold">Add</span>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle text-center">
                <thead>
                    <tr class="text-muted border-bottom small">
                        <th class="py-3 px-4 fw-normal" style="width: 50px;">#</th>
                        <th class="py-3 fw-normal text-start">Category</th>
                        <th class="py-3 fw-normal text-start">Name</th>
                        <th class="py-3 fw-normal">Total</th>
                        <th class="py-3 fw-normal">Repair</th>
                        <th class="py-3 fw-normal">Lending</th>
                        <th class="py-3 fw-normal">Action</th>
                    </tr>
                </thead>
                <tbody class="border-0">
                    @forelse($items as $index => $item)
                        <tr class="border-bottom">
                            <td class="px-4 py-4 text-muted">{{ $index + 1 }}</td>
                            <td class="py-4 text-muted text-start small">{{ $item->category->name }}</td>
                            <td class="py-4 fw-semibold text-dark text-start">{{ $item->name }}</td>
                            <td class="py-4 text-muted">{{ $item->total }}</td>
                            <td class="py-4 text-muted">{{ $item->repair }}</td>
                            <td class="py-4">
                                @if ($item->lending > 0)
                                    <a href="{{ route('admin.items.detail-lending', ['item_id' => $item->id]) }}" class="text-decoration-underline fw-bold" style="color: #6f42c1;">
                                        {{ $item->lending }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ $item->lending }}</span>
                                @endif
                            </td>
                            <td class="py-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-create px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-delete px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteItemModal{{ $item->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" data-bs-backdrop="false" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg modal-rounded">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold text-dark">Edit Item Forms</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body px-4">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold small">Name</label>
                                                <input type="text" name="name" class="form-control input-light" value="{{ $item->name }}" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-bold small">Category</label>
                                                <select class="form-select select2-init" name="category_id" required>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $cat->id == $item->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-bold small">Total</label>
                                                <div class="input-group">
                                                    <input type="number" name="total" class="form-control input-light" value="{{ $item->total }}" required>
                                                    <span class="input-group-text input-suffix">item</span>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                @php
                                                    $safeCurrentRepair = $item->repair > $item->total ? 0 : $item->repair;
                                                    $maxAdditionalRepair = max(0, $item->total - $safeCurrentRepair);
                                                @endphp
                                                <label class="form-label fw-bold small">
                                                    New Broke item
                                                    <span style="color: #f0ad00; font-weight: 600;">(currently: {{ $safeCurrentRepair }})</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" name="new_broke_item" class="form-control input-light" value="0" min="0" max="{{ $maxAdditionalRepair }}" required data-max="{{ $maxAdditionalRepair }}" data-item-name="{{ $item->name }}">
                                                    <span class="input-group-text input-suffix">item</span>
                                                </div>
                                                <small class="text-muted">
                                                    Max: {{ $maxAdditionalRepair }} item(s). Repair akan ditolak jika hasil akhirnya melebihi total item.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pb-4 px-4">
                                            <button type="button" class="btn btn-secondary px-4 btn-rounded" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-create px-4 btn-rounded">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteItemModal{{ $item->id }}" tabindex="-1" data-bs-backdrop="false" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                <div class="modal-content border-0 shadow-lg modal-rounded p-5 text-center">
                                    <i class="bi bi-exclamation-triangle-fill text-danger mb-4" style="font-size: 3rem; opacity: 0.8;"></i>
                                    <h4 class="fw-bold text-dark mb-2">apakah anda yakin?</h4>
                                    <p class="text-muted small mb-4">hapus <strong>"{{ $item->name }}"</strong>?<br>data yang sudah dihapus gabisa di balikin lagi.</p>
                                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-delete py-2 fw-bold shadow-sm">hapus</button>
                                            <button type="button" class="btn btn-light py-2 fw-bold text-muted shadow-sm" data-bs-dismiss="modal" style="border-radius: 8px;">gajadi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="py-5">
                                <div class="d-flex flex-column align-items-center opacity-25">
                                    <i class="bi bi-box-seam mb-2" style="font-size: 3rem;"></i>
                                    <p class="fw-bold">No items data available.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg modal-rounded">
                <div class="modal-header border-0 pt-4 px-4">
                    <div>
                        <h5 class="modal-title fw-bold text-dark">Add Item Forms</h5>
                        <p class="text-muted small mb-0">Please <span class="text-pink">.fill-all</span> input form with right value.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.items.store') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Name</label>
                            <input type="text" name="name" class="form-control input-light py-2" placeholder="Item name" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Category</label>
                            <select class="form-select select2-init" name="category_id" id="add_category_id" data-placeholder="Select Category" required>
                                <option></option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Total</label>
                            <div class="input-group">
                                <input type="number" name="total" class="form-control input-light py-2" placeholder="0" required>
                                <span class="input-group-text input-suffix">item</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4 gap-2">
                        <button type="button" class="btn btn-secondary px-4 py-2 btn-rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-create px-4 py-2 btn-rounded fw-bold border-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            function initSelect2(element) {
                $(element).find('.select2-init').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $(element),
                    width: '100%',
                    placeholder: $(element).find('.select2-init').data('placeholder')
                });
            }

            $('.modal').on('shown.bs.modal', function() {
                initSelect2(this);
                $(this).find('input[name="name"]').focus();
            });

            // Validasi input New Broke Item
            $(document).on('change input', 'input[name="new_broke_item"]', function() {
                const maxValue = parseInt($(this).data('max'));
                const currentValue = parseInt($(this).val()) || 0;
                const itemName = $(this).data('item-name');

                if (currentValue > maxValue) {
                    alert(`⚠️ Perhatian!\n\nItem "${itemName}":\n- Max broke item yang diizinkan: ${maxValue}\n- Nilai yang anda masukkan: ${currentValue}\n\nsilakan masukkan nilai yang benar!`);
                    $(this).val(maxValue);
                }
            });
        });
    </script>
@endsection