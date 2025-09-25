<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Back Office</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @yield('css_before')

    <style>
        :root {
            --bg: #0a0c10;
            --panel: #12141a;
            --border: #1b1f29;
            --text: #e9f1fa;
            --muted: #9aa5b4;
            --blue: #2196f3;
            --blue-dark: #1976d2;
            --success: #21c17a;
            --radius: 16px;
            --space: clamp(1rem, 3vw, 1.5rem);
        }

        html,
        body {
            background: var(--bg);
            color: var(--text);
        }

        .topbar {
            background: linear-gradient(135deg, #0d1117 0%, #0a0c10 100%);
            border-bottom: 1px solid var(--border);
            padding: .85rem 0;
        }

        .topbar h4 {
            margin: 0;
            font-weight: 800;
        }

        .topbar .badge {
            background: var(--blue);
            font-weight: 700;
        }

        .sidebar {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: .75rem;
            position: sticky;
            top: 1rem;
        }

        .sidebar .title {
            font-weight: 800;
            color: #fff;
            margin: .25rem .5rem .35rem;
            font-size: 1.05rem;
        }

        .list-group-dark .list-group-item {
            background: transparent;
            color: #cfd8e3;
            border: 1px solid var(--border);
        }

        .list-group-dark .list-group-item:hover {
            background: #0f141d;
            color: #fff;
        }

        .list-group-dark .list-group-item.active {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
            font-weight: 700;
        }

        .content-panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: var(--space);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .25);
            min-height: 60vh;
        }

        a,
        .link-primary {
            color: var(--blue);
        }

        a:hover {
            color: var(--blue-dark);
        }

        .btn-primary {
            background: var(--blue);
            border-color: var(--blue);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            border-color: var(--blue-dark);
        }

        .table-darkish {
            --bs-table-bg: #0f1319;
            --bs-table-border-color: var(--border);
            --bs-table-color: #d7e2f2;
        }

        footer {
            color: #8e9ab0;
            border-top: 1px solid var(--border);
            padding: 1rem 0;
            margin-top: 2rem;
        }
    </style>
</head>

<body>

    <!-- Top Header -->
    <div class="topbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Back Office <span class="badge rounded-pill ms-2">Laravel 12</span></h4>
                <div class="small text-secondary">ยินดีต้อนรับคุณ <span class="text-white">Admin</span></div>
            </div>
        </div>
    </div>

    @yield('header')

    <div class="container my-3">
        <div class="row g-3">
            <!-- Sidebar -->
            <div class="col-12 col-md-4 col-lg-3">
                <aside class="sidebar">
                    <div class="title"><i class="bi bi-columns-gap me-1"></i> เมนูจัดการ</div>
                    <div class="list-group list-group-dark">

                        {{-- หน้าแรก --}}
                        <a href="/"
                            class="list-group-item list-group-item-action {{ request()->is('/') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-2"></i> หน้าแรก
                        </a>

                        {{-- คอร์สเรียน --}}
                        <a href="/courses"
                            class="list-group-item list-group-item-action {{ request()->is('courses*') ? 'active' : '' }}">
                            <i class="bi bi-journal-code me-2"></i> คอร์สเรียน
                        </a>

                    </div>
                    @yield('sidebarMenu')
                </aside>
            </div>

            <!-- Content -->
            <div class="col-12 col-md-8 col-lg-9">
                <div class="content-panel">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center small">
            by devbanban.com ©2025 <span class="text-primary"></span>
        </div>
    </footer>

    @yield('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js_before')

    {{-- SweetAlert --}}
    @include('sweetalert::alert')
</body>

</html>
