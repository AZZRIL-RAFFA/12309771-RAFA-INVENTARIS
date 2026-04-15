<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris | SMK Wikrama Bogor</title>

    <link rel="icon" href="{{ asset('images/logo-smkwikrama.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --wikrama-blue: #1e3a8a;
            --wikrama-accent: #2563eb;
            --bg-soft: #f8fafc;
            --text-main: #0f172a;
            --text-soft: #475569;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(180deg, #ffffff 0%, var(--bg-soft) 100%);
            color: var(--text-main);
            overflow-x: hidden;
            min-height: 100vh;
        }

        .bg-glow {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background:
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.08) 0%, transparent 35%),
                radial-gradient(circle at 85% 10%, rgba(30, 58, 138, 0.06) 0%, transparent 30%);
            z-index: -1;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.88);
            border-bottom: 1px solid #e2e8f0;
            padding: 0.8rem 2rem;
        }

        .navbar-brand img {
            height: 45px;
            width: auto;
        }

        .navbar-brand-text {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--wikrama-blue);
            letter-spacing: 0.3px;
        }

        .hero-section {
            padding: 120px 0;
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.2;
            color: var(--text-main);
        }

        .text-accent {
            color: var(--wikrama-accent);
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-soft);
            max-width: 700px;
            margin: 1.5rem auto 3rem;
            line-height: 1.75;
        }

        .hero-info-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--wikrama-blue);
            margin-bottom: 0.4rem;
        }

        .btn-wikrama {
            background-color: var(--wikrama-accent);
            color: white;
            padding: 14px 35px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }

        .btn-wikrama:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .btn-outline-wikrama {
            border: 1px solid #cbd5e1;
            color: var(--text-main);
            padding: 14px 35px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-outline-wikrama:hover {
            background: #eff6ff;
            color: var(--wikrama-blue);
        }

        .modal-content {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
        }

        .form-control {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            color: var(--text-main);
            padding: 12px;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--wikrama-accent);
            color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-group .btn {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #64748b;
        }

        .input-group .btn:hover {
            color: var(--wikrama-accent) !important;
            background: rgba(79, 70, 229, 0.1) !important;
        }

        .modal-header, .modal-footer { border: none; padding: 2rem 2.5rem; }

        .school-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 100px;
            color: var(--wikrama-blue);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<nav class="navbar navbar-expand-lg fixed-top">
    <div style="padding: 0.8rem 2rem; width: 100%; display: flex; justify-content: space-between; align-items: center;">
        <a class="navbar-brand d-flex align-items-center gap-3 mb-0" href="#">
            <img src="{{ asset('images/logo-smkwikrama.png') }}" alt="Logo Wikrama">
            <span class="navbar-brand-text">SMK WIKRAMA</span>
        </a>
        <button class="btn btn-wikrama btn-sm px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
            Login
        </button>
    </div>
</nav>

<section class="hero-section d-flex align-items-center min-vh-100">
    <div class="container text-center">
        <h1 class="hero-title">
            INVENTARIS SEKOLAH <br>
            <span class="text-accent">SMK WIKRAMA BOGOR</span>
        </h1>
        <p class="hero-info-title">Keterangan Sistem</p>
        <p class="hero-subtitle">
            Sistem ini digunakan untuk mengelola data sarana dan prasarana sekolah dalam satu tempat.
            Mulai dari pencatatan barang, peminjaman, kondisi aset, hingga ketersediaan fasilitas dapat dipantau
            secara cepat, rapi, dan akurat.
        </p>

    </div>
</section>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="modal-header d-block text-center pb-0">
                    <h4 class="fw-bold mb-0">login</h4>
                    <p class="text-muted small">pake akun resmi sekolah </p>
                </div>

                <div class="modal-body px-5">
                    @if ($errors->has('loginError'))
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger small py-2">
                            {{ $errors->first('loginError') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small text-secondary fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="nama@smkwikrama.sch.id" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small text-secondary fw-semibold">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="••••••••" required
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <button class="btn" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pt-0">
                    <button class="btn btn-wikrama w-100 py-3 fw-bold">
                        Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>

@if ($errors->any())
<script>
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
</script>
@endif

</body>
</html>