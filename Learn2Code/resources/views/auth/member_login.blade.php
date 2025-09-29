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

    <style>
        :root {
            --bg: #0a0c10;
            --bg-2: #0c1118;
            --panel: #0f151e;
            --line: #1a2230;
            --glass: rgba(255, 255, 255, .06);
            --text: #e9f1fa;
            --muted: #9fb0c7;
            --brand: #42a5f5;
            --brand-2: #2e78d1;
            --danger: #ef476f;
            --success: #22c55e;
            --radius: 18px;
            --radius-sm: 12px;
            --shadow: 0 18px 60px rgba(0, 0, 0, .5);
            --shadow-sm: 0 10px 30px rgba(0, 0, 0, .35)
        }

        html,
        body {
            background:
                radial-gradient(900px 420px at 110% -10%, rgba(66, 165, 245, .18), transparent 60%),
                radial-gradient(850px 380px at -10% -10%, rgba(126, 87, 194, .16), transparent 60%),
                linear-gradient(180deg, var(--bg) 0%, #0b0f15 100%);
            color: var(--text);
            font-family: "Noto Sans Thai", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif
        }

        /* -------- Loader -------- */
        #loader {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            background: #06080d;
            z-index: 9999
        }

        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, .15);
            border-top-color: var(--brand);
            animation: spin 1s linear infinite
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        /* -------- Entrance animation helpers -------- */
        .fade-up {
            opacity: 0;
            transform: translateY(14px)
        }

        .fade-up.in {
            opacity: 1;
            transform: none;
            transition: .55s cubic-bezier(.22, .8, .25, 1)
        }

        .auth-wrap {
            min-height: 100vh;
            display: grid;
            align-items: center
        }

        /* LEFT brand pane */
        .brand-pane {
            background:
                radial-gradient(650px 300px at 30% 20%, rgba(66, 165, 245, .18), transparent 60%),
                radial-gradient(600px 280px at 100% 70%, rgba(255, 255, 255, .06), transparent 60%),
                linear-gradient(180deg, rgba(255, 255, 255, .04), rgba(255, 255, 255, .02));
            border: 1px solid var(--line);
            border-radius: calc(var(--radius) + 6px);
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative
        }

        .brand-pane .logo {
            font-family: "Bebas Neue", sans-serif;
            font-size: clamp(28px, 4vw, 42px);
            letter-spacing: .5px;
            line-height: 1
        }

        .brand-pane .tag {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .45rem .8rem;
            border-radius: 999px;
            border: 1px solid #263044;
            background: rgba(255, 255, 255, .07);
            font-weight: 800
        }

        .orb {
            position: absolute;
            filter: blur(42px);
            opacity: .75;
            border-radius: 50%;
            pointer-events: none
        }

        .orb.blue {
            background: rgba(66, 165, 245, .45);
            width: 180px;
            height: 180px;
            top: 10%;
            left: 6%;
            animation: float 7s ease-in-out infinite
        }

        .orb.purple {
            background: rgba(170, 142, 255, .34);
            width: 220px;
            height: 220px;
            right: -60px;
            top: 30%;
            animation: float 9s ease-in-out infinite reverse
        }

        .orb.cyan {
            background: rgba(0, 255, 214, .20);
            width: 160px;
            height: 160px;
            bottom: -40px;
            left: 22%;
            animation: float 8s ease-in-out infinite
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-14px)
            }
        }

        /* RIGHT card */
        .cardx {
            background: linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .04));
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            backdrop-filter: saturate(150%) blur(8px)
        }

        .logo-mini {
            font-family: "Bebas Neue", sans-serif;
            font-size: 28px;
            letter-spacing: .5px
        }

        .text-mutedx {
            color: var(--muted) !important
        }

        /* Inputs + Icons (centered perfectly) */
        .form-control {
            background: #0e131a;
            border: 1px solid #202637;
            color: #e7f0ff;
            border-radius: 12px;
            padding: .9rem 3rem .9rem 3rem
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(66, 165, 245, .2);
            background: #0e131a;
            color: #fff
        }

        .with-icon {
            position: relative
        }

        .input-icon,
        .toggle-pass {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center
        }

        .input-icon {
            left: 8px;
            color: #7f8aa3;
            font-size: 18px
        }

        .toggle-pass {
            right: 6px;
            border: 0;
            background: transparent;
            color: #9fb0c7;
            border-radius: 10px
        }

        .toggle-pass:hover {
            background: rgba(255, 255, 255, .06)
        }

        .toggle-pass:active {
            transform: translateY(-50%) scale(.98)
        }

        /* Buttons with micro-interactions */
        .btn-brand {
            --g1: var(--brand);
            --g2: var(--brand-2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            width: 100%;
            padding: .95rem 1rem;
            border: 0;
            border-radius: 12px;
            color: #fff !important;
            font-weight: 900;
            letter-spacing: .1px;
            background: linear-gradient(135deg, var(--g1), var(--g2));
            transition: transform .08s ease, filter .25s ease, box-shadow .25s ease;
            position: relative;
            overflow: hidden;
            isolation: isolate;
            box-shadow: 0 16px 48px rgba(66, 165, 245, .30)
        }

        .btn-brand:hover {
            filter: brightness(1.06);
            box-shadow: 0 22px 64px rgba(66, 165, 245, .40);
            color: #fff !important
        }

        .btn-brand:active {
            transform: translateY(1px)
        }

        .btn-ghost {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .85rem 1.2rem;
            border-radius: 12px;
            font-weight: 800;
            color: var(--text);
            text-decoration: none;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .06);
            overflow: hidden;
            transition: color .25s ease, box-shadow .25s ease
        }

        .btn-ghost:hover {
            box-shadow: 0 8px 26px rgba(66, 165, 245, .25)
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(255, 255, 255, .35);
            animation: ripple .6s ease-out forwards;
            pointer-events: none
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0
            }
        }

        .hint {
            display: none;
            font-size: .9rem;
            margin-top: .25rem
        }

        .hint.show {
            display: block
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--muted);
            text-decoration: none;
            font-weight: 800
        }

        .back-link:hover {
            color: #cfe2ff
        }

        @media (max-width:375.98px) {
            .p-xs-2 {
                padding: .5rem !important
            }
        }

        @media (min-width:992px) {
            .pane-pad {
                padding: 2.2rem 2.4rem
            }

            .pane-h {
                min-height: 640px
            }
        }

        /* ===== Equal-height fix for both panes ===== */
        .pane-fill {
            height: 100%
        }

        .row.align-items-stretch>[class*="col"]>section {
            height: 100%
        }

        .btn-brand i {
            color: #fff !important
        }

        /* ===== Liquid Glass Success Modal ===== */
        .glass-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(6, 8, 13, .55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1050;
            display: none
        }

        .glass-modal {
            position: fixed;
            inset: 0;
            display: none;
            place-items: center;
            z-index: 1060;
        }

        .glass-card {
            width: min(520px, 92vw);
            background: linear-gradient(180deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .05));
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 22px 22px 18px
        }

        .glass-card h5 {
            margin: 0 0 6px 0;
            font-weight: 900
        }

        .glass-card p {
            margin: 0;
            color: var(--muted)
        }

        .count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(66, 165, 245, .16);
            border: 1px solid #264a7a;
            font-weight: 900;
            font-size: 20px;
            color: #eaf2ff;
            margin-right: 10px
        }

        .go-home-fab {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 1070;
            width: auto;
            padding: .85rem 1.1rem;
            border-radius: 14px
        }

        /* ปิดไอคอน invalid/valid ของ Bootstrap เพื่อไม่ให้ชนกับปุ่มตา */
        .form-control.is-invalid,
        .form-control.is-valid,
        .was-validated .form-control:invalid,
        .was-validated .form-control:valid {
            background-image: none !important;
            /* เอาไอคอนเตือนของ Bootstrap ออก */
            padding-right: 3rem !important;
            /* คงช่องว่างให้ปุ่มตาเดิม */
        }

        /* กันการเลื่อนตำแหน่งของปุ่มตาเวลา invalid */
        .with-icon .toggle-pass {
            z-index: 2;
        }

        :root {
            --ph-color: #6b7686;
        }

        .form-control::placeholder {
            color: var(--ph-color);
            opacity: 1;
            /* กันจางเกินไป */
        }

        /* (เลือกได้) ตอนโฟกัสให้จางลงนิดนึง */
        .form-control:focus::placeholder {
            opacity: .5;
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <main class="container auth-wrap" style="opacity:0" id="page">
        <div class="row g-4 g-lg-5 align-items-stretch">

            <!-- LEFT: Brand pane (hidden on < LG) -->
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

            <!-- RIGHT: Login card -->
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

    <!-- ===== Success Modal Markup (hidden by default) ===== -->
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

    <!-- Flag สำหรับเปิด modal: ใช้ session หรือพารามิเตอร์ ?ok=1 ก็ได้ -->
    <div id="loginFlag" data-ok="{{ session('login_success') ? 1 : (request()->query('ok') ? 1 : 0) }}"
        data-home="{{ url('/') }}"></div>

    <script>
        // Hide loader, reveal page + entrance animations
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
                // เริ่มนับถอยหลัง
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
