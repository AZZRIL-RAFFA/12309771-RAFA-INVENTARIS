@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 px-lg-5" style="background-color: #f8f9fa; min-height: 100vh;">

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center"
                style="border-radius: 12px; background-color: #d1e7dd;">
                <i class="bi bi-check-circle-fill me-2" style="color: #0f5132;"></i>
                <div style="color: #0f5132;">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card p-4 border-0 shadow-sm card-rounded">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Lending Table</h4>
                    <p class="text-muted small mb-0">
                        Data of <span class="text-pink">.lendings</span>
                        @if ($selectedItem)
                            <span class="text-dark"> for {{ $selectedItem->name }}</span>
                        @endif
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary d-flex align-items-center px-4 py-2 shadow-sm btn-rounded">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span class="fw-bold">Back</span>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead>
                        <tr class="text-muted border-bottom small">
                            <th class="py-3 px-4 fw-normal" style="width: 50px;">#</th>
                            <th class="py-3 fw-normal text-start">Item</th>
                            <th class="py-3 fw-normal">Total</th>
                            <th class="py-3 fw-normal text-start">Name</th>
                            <th class="py-3 fw-normal text-start">Ket.</th>
                            <th class="py-3 fw-normal">Date</th>
                            <th class="py-3 fw-normal">Returned</th>
                            <th class="py-3 fw-normal text-start">Edited By</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @forelse($lendings as $index => $lending)
                            <tr class="border-bottom">
                                <td class="px-4 py-4 text-muted">{{ $index + 1 }}</td>
                                <td class="py-4 text-start fw-semibold text-dark">{{ $lending->item->name ?? '-' }}</td>
                                <td class="py-4 text-muted">{{ $lending->total }}</td>
                                <td class="py-4 text-start text-muted small">{{ $lending->name }}</td>
                                <td class="py-4 text-start text-muted small">{{ $lending->notes ?? '-' }}</td>
                                <td class="py-4 text-muted small">{{ $lending->date ? $lending->date->format('d F, Y') : '-' }}</td>
                                <td class="py-4">
                                    @if ($lending->is_returned)
                                        <span class="badge bg-light text-success border">returned</span>
                                    @else
                                        <span class="badge bg-light text-warning border">not returned</span>
                                    @endif
                                </td>
                                <td class="py-4 text-start fw-bold text-dark">{{ $lending->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-5">
                                    <div class="d-flex flex-column align-items-center opacity-25">
                                        <i class="bi bi-inbox mb-2" style="font-size: 3rem;"></i>
                                        <p class="fw-bold mb-0">No lending data available.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection