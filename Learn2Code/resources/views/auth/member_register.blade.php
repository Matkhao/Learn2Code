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

    <link rel="stylesheet" href="{{ asset('css/auth/auth.register.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
</head>

<body>
    <main class="container auth-wrap">
        <div class="row g-4 g-lg-5 align-items-stretch equal-row">
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
