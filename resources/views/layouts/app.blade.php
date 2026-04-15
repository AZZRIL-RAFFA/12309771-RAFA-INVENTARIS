<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Wikrama</title>

    <link rel="icon" href="{{ asset('images/logo-smkwikrama.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #ffffff;
            --sidebar-hover: #eff6ff;
            --accent-color: #2563eb;
            --text-muted: #64748b;
            --text-main: #0f172a;
            --bg-light: #f8fafc;
            --border-soft: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-soft);
            z-index: 1100;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        body.sidebar-closed .sidebar {
            left: calc(var(--sidebar-width) * -1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            width: 35px;
            height: 35px;
            background: var(--accent-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .brand-name {
            color: var(--text-main);
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
        }

        .menu-label {
            padding: 0 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 1px;
        }

        .sidebar a {
            padding: 0.8rem 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            margin: 2px 12px;
            border-radius: 8px;
        }

        .sidebar a:hover {
            background: var(--sidebar-hover);
            color: var(--accent-color);
        }

        .sidebar a.active {
            background: var(--accent-color);
            color: white !important;
        }

        .submenu-content {
            padding-left: 2.5rem;
            display: none;
        }

        .submenu-content.show {
            display: block;
        }

        .submenu-toggle {
            cursor: pointer;
            padding: 0.8rem 1.5rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 2px 12px;
            border-radius: 8px;
        }

        .header {
            height: 96px;
            margin-left: var(--sidebar-width);
            background: #ffffff;
            border-bottom: 1px solid var(--border-soft);
            transition: all 0.3s ease;
        }

        body.sidebar-closed .header {
            margin-left: 0;
        }

        .header-content {
            padding: 1.25rem 2rem;
            color: var(--text-main);
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .main-container {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem 2rem;
            position: relative;
            z-index: 5;
            transition: all 0.3s ease;
        }

        body.sidebar-closed .main-container {
            margin-left: 0;
        }

        .top-nav-box {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .transition {
            transition: all 0.3s ease;
        }

        .toggle-btn {
            background: #ffffff;
            border: 1px solid var(--border-soft);
            color: var(--text-main);
            padding: 5px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .toggle-btn:hover {
            background: #f1f5f9;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <span class="brand-name">Inventaris</span>
        </div>

        <div class="menu-label">Main Menu</div>
        <a href="/admin/dashboard" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="menu-label">items Data</div>
        <a href="/admin/categories" class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> Categories
        </a>
        <a href="/admin/items" class="{{ Request::is('admin/items*') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Items
        </a>

        <div class="has-submenu">
            <div class="submenu-toggle {{ Request::is('admin/users*', 'admin/operators*') ? 'text-white' : '' }}" onclick="toggleSub(this)">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-people"></i> Accounts
                </div>
                <i class="bi bi-chevron-down small transition"></i>
            </div>
            <div class="submenu-content {{ Request::is('admin/users*', 'admin/operators*') ? 'show' : '' }}">
                <a href="/admin/users" class="{{ Request::is('admin/users*') ? 'active' : '' }}">Admin List</a>
                <a href="/admin/operators" class="{{ Request::is('admin/operators*') ? 'active' : '' }}">Operator List</a>
            </div>
        </div>

        <div class="mt-auto mb-4 px-3">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-link text-danger text-decoration-none small d-flex align-items-center gap-2 p-2">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="header">
        <div class="header-content">
            <div class="d-flex align-items-center gap-3">
                <button class="toggle-btn" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h4 class="fw-bold mb-1">Welcome Back, {{ Auth::user()->name }}</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <div class="fw-semibold">Administrator</div>
                    <div class="small text-muted">Status: Online</div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="top-nav-box">
            <div class="text-muted small">
                <i class="bi bi-house-door"></i> /
                <span class="ms-1 fw-medium text-dark">
                    {{ Request::is('admin/dashboard') ? 'Dashboard' : (Request::is('admin/users*') ? 'Admin Accounts' : (Request::is('admin/operators*') ? 'Operator Accounts' : '')) }}
                </span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="small text-muted me-2">{{ Auth::user()->email }}</span>
            </div>
        </div>

        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-closed');
        }

        function toggleSub(el) {
            const content = el.nextElementSibling;
            content.classList.toggle('show');
            el.querySelector('.bi-chevron-down').classList.toggle('rotate-180');
        }
    </script>
</body>

</html>