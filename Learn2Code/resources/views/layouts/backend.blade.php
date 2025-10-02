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

    <link rel="stylesheet" href="{{ asset('css/layouts/backend.layouts.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
</head>

<body>
    <div class="topbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    Back Office <span class="badge rounded-pill ms-2">Laravel 12</span>
                </h4>

                @php
                    $user = auth('admin')->user() ?? auth('member')->user();
                    $displayName = $user?->name ?: $user?->email ?? 'ผู้ดูแลระบบ';
                @endphp

                <div class="small text-secondary">
                    ยินดีต้อนรับคุณ <span class="text-white">{{ $displayName }}</span>
                </div>
            </div>
        </div>
    </div>

    @yield('header')

    <div class="container my-3">
        <div class="row g-3">
            <div class="col-12 col-md-4 col-lg-3">
                <aside class="sidebar">
                    <div class="title"><i class="bi bi-columns-gap me-1"></i> เมนูจัดการ</div>
                    <div class="list-group list-group-dark">

                        <a href="/"
                            class="list-group-item list-group-item-action {{ request()->is('/') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-2"></i> หน้าหลัก
                        </a>

                        <a href="{{ route('admin.dashboard.index') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> แดชบอร์ด
                        </a>


                        <a href="{{ route('admin.users.index') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-person-add me-2"></i> ผู้ดูแลระบบ
                        </a>

                        <a href="{{ route('admin.courses.index') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-code me-2"></i> คอร์สเรียน
                        </a>

                        <button type="button" class="list-group-item list-group-item-action text-danger"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right me-2"></i> ออกจากระบบ
                        </button>

                        <form id="logoutForm" action="{{ route('member.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    @yield('sidebarMenu')
                </aside>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <div class="content-panel">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container text-center small">©2025 Learn2Code — All rights reserved. <span
                class="text-primary"></span></div>
    </footer>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background:#0f1218;border:1px solid #1b1f29;color:#e9f1fa">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="bi bi-box-arrow-right me-2"></i> ออกจากระบบ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="mb-2">คุณต้องการออกจากระบบใช่หรือไม่?</p>
                    <p class="text-secondary small mb-0">เมื่อยืนยันแล้ว ระบบจะพากลับไปยังหน้าหลัก</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button type="button" class="btn btn-primary" id="btnConfirmLogout">
                        ออกจากระบบ
                    </button>
                </div>
            </div>
        </div>
    </div>

    @yield('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btnConfirmLogout');
            const form = document.getElementById('logoutForm');
            if (btn && form) {
                btn.addEventListener('click', function() {
                    window.onbeforeunload = null;
                    form.submit();
                });
            }
        });
    </script>

    @yield('js_before')
    @include('sweetalert::alert')
</body>

</html>
