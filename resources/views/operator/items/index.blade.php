@extends('layouts.app1')

@section('content1')
    <style>
        .table th {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: none;
        }

        .table td {
            padding: 1.2rem 0.75rem;
            color: #2d3436;
        }

        .border-custom {
            border-bottom: 2px solid #a38671;
            display: inline-block;
            min-width: 40px;
            padding-bottom: 2px;
        }
    </style>

    <div class="card p-4 border-0 shadow-sm" style="border-radius: 15px;">
        <div class="mb-4">
            <h4 class="fw-bold mb-0">Items Table</h4>
            <p class="text-muted small">Data <span class="text-danger">.items</span></p>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Available</th>
                        <th class="text-center">Lending Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        @php
                            $rawAvailable = $item->total - ($item->lending + $item->repair);
                            $available = max(0, $rawAvailable);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-center">{{ $item->total }}</td>
                            <td class="text-center">
                                <span class="border-custom">{{ $available }}</span>
                                @if ($rawAvailable < 0)
                                    <div class="small text-danger">stock anomaly</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="border-custom">{{ $item->lending }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
