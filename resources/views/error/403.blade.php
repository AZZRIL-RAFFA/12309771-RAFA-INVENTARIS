<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        .error-card {
            max-width: 520px;
            width: 100%;
            padding: 32px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.06);
            text-align: center;
        }
        .error-code {
            font-size: 96px;
            font-weight: 800;
            margin-bottom: 16px;
            color: red;
        }
        .error-title {
            font-size: 28px;
            margin-bottom: 12px;
        }
        .error-text {
            color: #6c757d;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">403</div>
        <div class="error-title">Akses Ditolak</div>
        <div class="error-text">Anda tidak memiliki izin untuk melihat halaman ini.</div>
        @php
            $backUrl = url()->previous();
            if (auth()->check()) {
                $role = auth()->user()->role;
                if ($role === 'admin') {
                    $backUrl = route('admin.dashboard');
                } elseif ($role === 'operator') {
                    $backUrl = route('staff.dashboard');
                }
            }
        @endphp
        <a href="{{ $backUrl }}" class="btn btn-primary">Back</a>
    </div>
</body>
</html>