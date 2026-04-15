@extends('layouts.app1')

@section('content1')
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
    </style>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h4 class="fw-bold text-dark mb-1">Edit Account Forms</h4>
                            <p class="text-muted">
                                Please <span style="color: #e83e8c;">.fill-all</span> input
                                form with right value.
                                </p>
                            </div>

                        {{-- Update Form Action & Method --}}
                        <form action="{{ route('staff.profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            {{-- Alert Success --}}
                            @if (session('success'))
                                <div class="alert alert-success border-0 mb-4">{{ session('success') }}</div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Name</label>
                                <input type="text" name="name"
                                    
                                    class="form-control bg-light border-0 py-3 px-4 @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Email</label>
                                <input type="email" name="email"
                                    
                                    class="form-control bg-light border-0 py-3 px-4 @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-bold text-dark">
                                    New Password <span
                                        class="text-warning small fw-normal">optional</span>
                                    </label>
                                {{-- Ganti name menjadi 'password' agar sesuai dengan controller --}}
                                <input type="password" name="password"
                                    
                                    class="form-control bg-light border-0 py-3 px-4 @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('staff.dashboard') }}"
                                    class="btn btn-secondary px-5 py-2 border-0">Cancel</a>
                                <button type="submit"
                                    class="btn btn-create px-5 py-2 border-0">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
