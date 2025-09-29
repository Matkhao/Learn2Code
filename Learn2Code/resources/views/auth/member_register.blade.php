<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>สมัครสมาชิก | Learn2Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts / Icons ให้ตรงกับหน้า Login -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg: #0a0c10;
            --bg-2: #0c1118;
            --panel: #0f151e;
            --line: #1a2230;
            --text: #e9f1fa;
            --muted: #9fb0c7;
            --brand: #42a5f5;
            --brand-2: #2e78d1;
            --radius: 18px;
            --shadow: 0 18px 60px rgba(0, 0, 0, .5)
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

        .auth-wrap {
            min-height: 100vh;
            display: grid;
            align-items: center
        }

        /* ===== ฝั่งซ้าย (Brand Pane) ===== */
        .brand-pane {
            background:
                radial-gradient(650px 300px at 30% 20%, rgba(66, 165, 245, .18), transparent 60%),
                radial-gradient(600px 280px at 100% 70%, rgba(255, 255, 255, .06), transparent 60%),
                linear-gradient(180deg, rgba(255, 255, 255, .04), rgba(255, 255, 255, .02));
            border: 1px solid var(--line);
            border-radius: calc(var(--radius) + 6px);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden
        }

        .logo {
            font-family: "Bebas Neue", sans-serif;
            font-size: clamp(28px, 4vw, 42px);
            letter-spacing: .5px;
            line-height: 1
        }

        .tag {
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

        /* ===== การ์ดขวา ===== */
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

        /* ===== ฟอร์ม + ไอคอน ===== */
        .form-control {
            background: #0e131a;
            border: 1px solid #202637;
            color: #e7f0ff;
            border-radius: 12px;
            padding: .9rem 3rem
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

        /* เอาไอคอน invalid/valid ของ Bootstrap ออก กันชนกับปุ่มตา */
        .form-control.is-invalid,
        .form-control.is-valid,
        .was-validated .form-control:invalid,
        .was-validated .form-control:valid {
            background-image: none !important;
            padding-right: 3rem !important
        }

        .with-icon .toggle-pass {
            z-index: 2
        }

        /* ===== ปุ่ม ===== */
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
            box-shadow: 0 22px 64px rgba(66, 165, 245, .40)
        }

        .btn-brand:active {
            transform: translateY(1px)
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .85rem 1.2rem;
            border-radius: 12px;
            font-weight: 800;
            color: var(--text);
            text-decoration: none;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .06)
        }

        /* ===== Equal-height ทั้งสองคอลัมน์ ===== */
        .equal-row {
            align-items: stretch !important;
        }

        .equal-row>[class*="col"] {
            display: flex;
        }

        .equal-row>[class*="col"]>section {
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 991.98px) {
            .equal-row>[class*="col"]>section {
                height: auto;
            }
        }

        @media(min-width:992px) {
            .pane-pad {
                padding: 2.2rem 2.4rem
            }

            .pane-h {
                min-height: 640px
            }
        }

        :root {
            --ph-color: #6b7686;
        }

        .form-control::placeholder {
            color: var(--ph-color);
            opacity: 1;
        }

        .form-control:focus::placeholder {
            opacity: .5;
        }
    </style>
</head>

<body>
    <main class="container auth-wrap">
        <div class="row g-4 g-lg-5 align-items-stretch equal-row">
            <!-- ซ้าย -->
            <div class="col-lg-6 d-none d-lg-flex">
                <section class="brand-pane pane-pad pane-h p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="logo">Learn<span style="color:var(--brand)">2</span>Code</div>
                        <a href="/" class="text-decoration-none text-mutedx fw-bold"><i
                                class="bi bi-arrow-left"></i> กลับหน้าหลัก</a>
                    </div>
                    <div class="mt-5">
                        <h1 class="display-5 fw-bold">
                            สมัครสมาชิกเริ่มเรียนได้ทันที</h1>
                        <p class="lead mt-2 text-mutedx">เข้าถึงบทเรียนคุณภาพสูงทั้งสายโปรแกรมมิ่ง ดาต้า และครีเอทีฟ
                            อัปสกิลได้ทุกอุปกรณ์</p>
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

            <!-- ขวา: ฟอร์มสมัคร -->
            <div class="col-12 col-lg-6">
                <section class="cardx p-4 p-md-5 pane-h">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="logo-mini d-lg-none">Learn<span style="color:var(--brand)">2</span>Code</div>
                        <a href="{{ route('member.login') }}"
                            class="text-decoration-none text-mutedx fw-bold d-lg-none">
                            <i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ
                        </a>
                    </div>

                    <h3 class="fw-bolder mb-2" style="letter-spacing:.2px;">สมัครสมาชิก</h3>
                    <p class="text-mutedx mb-3">สร้างบัญชีใหม่เพื่อเริ่มต้นการเรียนของคุณ</p>

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

                    <form method="POST" action="{{ route('member.register.post') }}" novalidate class="mt-1">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ชื่อที่ต้องการแสดง</label>
                            <div class="with-icon">
                                <span class="input-icon"><i class="bi bi-person"></i></span>
                                <input name="name" type="text" autocomplete="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required placeholder="ชื่อที่ต้องการแสดง">
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">อีเมล</label>
                            <div class="with-icon">
                                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                                <input name="email" type="email" inputmode="email" autocomplete="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required placeholder="example@email.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">รหัสผ่าน</label>
                            <div class="with-icon">
                                <span class="input-icon"><i class="bi bi-shield-lock"></i></span>
                                <input id="password" name="password" type="password" autocomplete="new-password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    placeholder="อย่างน้อย 8 ตัวอักษร">
                                <button type="button" class="toggle-pass" aria-label="สลับการแสดงรหัสผ่าน"
                                    onclick="togglePassword('password','eye1')">
                                    <i id="eye1" class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ยืนยันรหัสผ่าน</label>
                            <div class="with-icon">
                                <span class="input-icon"><i class="bi bi-check2-circle"></i></span>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password" class="form-control" required
                                    placeholder="พิมพ์รหัสผ่านซ้ำอีกครั้ง">
                                <button type="button" class="toggle-pass" aria-label="สลับการแสดงรหัสผ่าน"
                                    onclick="togglePassword('password_confirmation','eye2')">
                                    <i id="eye2" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input id="accept" class="form-check-input" type="checkbox" required>
                            <label class="form-check-label text-mutedx"
                                for="accept">ฉันยอมรับเงื่อนไขการใช้งานและนโยบายความเป็นส่วนตัว</label>
                        </div>

                        <button class="btn-brand" type="submit">
                            <i class="bi bi-person-plus"></i> สมัครสมาชิก
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-mutedx me-2">มีบัญชีอยู่แล้ว?</span>
                        <a class="btn-ghost" href="{{ route('member.login') }}"><i
                                class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ</a>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script>
        function togglePassword(inputId, eyeId) {
            const el = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            if (!el) return;
            if (el.type === 'password') {
                el.type = 'text';
                eye.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                el.type = 'password';
                eye.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
