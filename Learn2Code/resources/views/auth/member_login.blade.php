<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เข้าสู่ระบบ | Learn2Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/auth/auth.login.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">

</head>

<body>
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <main class="container auth-wrap" style="opacity:0" id="page">
        <div class="row g-4 g-lg-5 align-items-stretch">

            <div class="col-lg-6 d-none d-lg-block fade-up">
                <section class="brand-pane pane-pad pane-h p-4 pane-fill h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="logo">Learn<span style="color:var(--brand)">2</span>Code</div>
                        <a href="/" class="back-link"><i class="bi bi-arrow-left"></i> กลับหน้าหลัก</a>
                    </div>

                    <div class="mt-5">
                        <h1 class="display-5 fw-bold">
                            เริ่มต้นการเรียนที่ยืดหยุ่น และทรงพลัง
                        </h1>
                        <p class="lead mt-2 text-mutedx">
                            คอร์สออนไลน์คุณภาพสูงทั้งสายโปรแกรมมิ่ง ดาต้า และครีเอทีฟ
                            อัปสกิลได้ทุกเวลา รองรับทุกอุปกรณ์
                        </p>
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <span class="tag"><i
                                    class="bi bi-lightning-charge-fill me-1"></i>คอนเทนต์อัปเดตเสมอ</span>
                            <span class="tag"><i class="bi bi-phone me-1"></i>รองรับทุกอุปกรณ์</span>
                            <span class="tag"><i class="bi bi-people-fill me-1"></i>ชุมชนช่วยเหลือ 24/7</span>
                        </div>
                    </div>

                    <div class="orb blue"></div>
                    <div class="orb purple"></div>
                    <div class="orb cyan"></div>
                </section>
            </div>

            <div class="col-12 col-lg-6 fade-up">
                <section class="cardx p-4 p-md-5 pane-h pane-fill h-100 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="logo-mini d-lg-none">Learn<span style="color:var(--brand)">2</span>Code</div>
                        <a href="/" class="back-link d-lg-none"><i class="bi bi-arrow-left"></i> กลับหน้าหลัก</a>
                    </div>

                    <h3 class="fw-bolder mb-2" style="letter-spacing:.2px;">เข้าสู่ระบบ</h3>
                    <p class="text-mutedx mb-3">ยินดีต้อนรับกลับมา ลงชื่อเข้าใช้เพื่อเรียนต่อจากที่ค้างไว้</p>

                    @if (session('status'))
                        <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 px-3">
                            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle me-1"></i> กรุณาตรวจสอบข้อมูล
                            </div>
                            <ul class="m-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('member.login.post') }}" novalidate class="mt-1">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">อีเมล</label>
                            <div class="with-icon">
                                <span class="input-icon">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none"
                                        stroke="#9fb0c7" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="14" rx="3"></rect>
                                        <path d="M3 7l9 6 9-6"></path>
                                    </svg>
                                </span>
                                <input name="email" type="email" inputmode="email" autocomplete="username"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required aria-describedby="emailHelp"
                                    placeholder="ใช้อีเมลที่สมัครสมาชิก">
                            </div>
                            <div id="emailHelp" class="form-text text-mutedx">ใช้อีเมลที่สมัครสมาชิก</div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold">รหัสผ่าน</label>
                            <div class="with-icon">
                                <span class="input-icon">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none"
                                        stroke="#9fb0c7" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 2l7 4v5c0 5-3.5 9-7 11-3.5-2-7-6-7-11V6l7-4z"></path>
                                        <circle cx="12" cy="12" r="2"></circle>
                                    </svg>
                                </span>
                                <input id="password" name="password" type="password"
                                    autocomplete="current-password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    aria-describedby="capsHint" placeholder="รหัสผ่านของคุณ">
                                <button type="button" class="toggle-pass" aria-label="สลับการแสดงรหัสผ่าน"
                                    onclick="togglePassword()">
                                    <svg id="eyeSvg" viewBox="0 0 24 24" width="22" height="22"
                                        fill="none" stroke="#9fb0c7" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="capsHint" class="hint text-warning"><i
                                    class="bi bi-exclamation-circle me-1"></i>
                                เปิด Caps Lock อยู่</div>
                        </div>

                        <button class="btn-brand mt-3" type="submit">
                            <i class="bi bi-box-arrow-in-right"></i>
                            เข้าสู่ระบบ
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-mutedx me-2">ยังไม่มีบัญชี?</span>
                        <a class="btn-ghost" href="{{ route('member.register') }}">
                            <i class="bi bi-person-plus"></i>
                            สมัครสมาชิก
                        </a>
                    </div>
                </section>
            </div>

        </div>
    </main>

    <div id="glassBackdrop" class="glass-backdrop"></div>
    <div id="glassModal" class="glass-modal" role="dialog" aria-modal="true" aria-labelledby="successTitle"
        aria-describedby="successDesc">
        <div class="glass-card">
            <div class="d-flex align-items-start gap-2">
                <div class="count-badge" id="countNum">5</div>
                <div>
                    <h5 id="successTitle">เข้าสู่ระบบสำเร็จ</h5>
                    <p id="successDesc">กำลังพาไปหน้าหลักใน <span id="countText">5</span> วินาที…</p>
                </div>
            </div>
        </div>
    </div>
    <a id="goHomeFab" href="{{ url('/') }}" class="btn-brand go-home-fab" style="display:none">
        <i class="bi bi-house-door"></i> เข้าหน้าหลัก
    </a>

    <div id="loginFlag" data-ok="{{ session('login_success') ? 1 : (request()->query('ok') ? 1 : 0) }}"
        data-home="{{ url('/') }}"></div>

    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('loader');
            const page = document.getElementById('page');
            loader.style.opacity = '0';
            loader.style.transition = 'opacity .35s ease';
            setTimeout(() => loader.style.display = 'none', 400);

            page.style.transition = 'opacity .35s ease';
            page.style.opacity = '1';

            document.querySelectorAll('.fade-up').forEach((el, i) => {
                setTimeout(() => el.classList.add('in'), 120 + i * 120);
            });
        });

        // Password toggle
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeSvg');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.innerHTML =
                    '<path d="M3 3l18 18"></path><path d="M10.58 10.58A3 3 0 0 0 12 15a3 3 0 0 0 2.42-4.42"></path><path d="M9.9 4.24A10.91 10.91 0 0 1 12 4c6.14 0 9.51 5.14 10 7-.23.86-.62 1.67-1.14 2.39"></path><path d="M1 12s3.8-6 11-6a13.2 13.2 0 0 1 4.94.94"></path>';
            } else {
                pwd.type = 'password';
                eye.innerHTML =
                    '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // CapsLock hint
        (function() {
            const pwd = document.getElementById('password');
            const hint = document.getElementById('capsHint');
            if (!pwd) return;
            const listen = e => {
                if (e.getModifierState && e.getModifierState('CapsLock')) hint.classList.add('show');
                else hint.classList.remove('show');
            };
            pwd.addEventListener('keyup', listen);
            pwd.addEventListener('blur', () => hint.classList.remove('show'));
        })();

        // Ripple on buttons
        function addRipple(e) {
            const btn = e.currentTarget;
            const r = document.createElement('span');
            const d = Math.max(btn.clientWidth, btn.clientHeight);
            r.style.width = r.style.height = d + 'px';
            const rect = btn.getBoundingClientRect();
            r.style.left = (e.clientX - rect.left - d / 2) + 'px';
            r.style.top = (e.clientY - rect.top - d / 2) + 'px';
            r.className = 'ripple';
            btn.appendChild(r);
            setTimeout(() => r.remove(), 600);
        }
        document.querySelectorAll('.btn-brand, .btn-ghost').forEach(b => b.addEventListener('click', addRipple));

        // ===== Success Modal Logic =====
        (function() {
            const flagEl = document.getElementById('loginFlag');
            const ok = Number(flagEl?.dataset.ok || 0) === 1;
            if (!ok) return; // ถ้าไม่ได้ล็อกอินสำเร็จ ให้ข้าม

            const home = flagEl.dataset.home || '/';
            const backdrop = document.getElementById('glassBackdrop');
            const modal = document.getElementById('glassModal');
            const countNum = document.getElementById('countNum');
            const countText = document.getElementById('countText');
            const goHomeFab = document.getElementById('goHomeFab');

            let sec = 5;
            const tick = () => {
                sec -= 1;
                countNum.textContent = sec < 0 ? 0 : sec;
                countText.textContent = sec < 0 ? 0 : sec;
                if (sec <= 0) goHome();
            };

            function openModal() {
                backdrop.style.display = 'block';
                modal.style.display = 'grid';
                goHomeFab.style.display = 'inline-flex';
                countNum.textContent = sec;
                countText.textContent = sec;
                window._loginTimer = setInterval(tick, 1000);
            }

            function closeModal() {
                backdrop.style.display = 'none';
                modal.style.display = 'none';
                goHomeFab.style.display = 'none';
                if (window._loginTimer) {
                    clearInterval(window._loginTimer);
                }
            }

            function goHome() {
                closeModal();
                window.location.href = home;
            }

            openModal();
            goHomeFab.addEventListener('click', goHome);
            modal.addEventListener('click', e => {
                if (e.target === modal) goHome();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') goHome();
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
