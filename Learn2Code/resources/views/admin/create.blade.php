@extends('layouts.backend')

@section('css_before')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin/admin.create.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
@endsection

@section('content')
    <div class="page-hero">
        <h2><i class="bi bi-person-plus-fill"></i> เพิ่มผู้ดูแลระบบ</h2>
        <p><i class="bi bi-info-circle"></i> กรอกข้อมูลให้ครบถ้วนเพื่อเพื่อผู้ดูแลระบบต้องสมโปรไฟล์เรียบร้อย</p>
    </div>



    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> เกิดข้อผิดพลาด</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin') }}" method="POST" autocomplete="off" novalidate id="adminForm">
        @csrf

        <div class="card-ui">
            <div class="card-head">
                <i class="bi bi-ui-checks-grid"></i>
                <div class="title">ข้อมูลผู้ดูแลระบบ</div>
            </div>

            <div class="card-body">

                <div class="section-header">
                    <i class="bi bi-person-badge"></i> ข้อมูลพื้นฐาน
                </div>

                <div class="mb-3">
                    <div class="label"><i class="bi bi-type"></i> ชื่อคอร์ส <span class="req">*</span></div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-input-cursor-text"></i></span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="เช่น Admin Natthaphong" minlength="3" maxlength="100" value="{{ old('name') }}"
                            required data-counter="name">
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="help">สูงสุด 100 ตัวอักษร</small>
                        <small class="counter" data-for="name">0/100</small>
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-envelope"></i> อีเมล (ใช้เข้าสู่ระบบ) <span
                                class="req">*</span></div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="name@example.com" value="{{ old('email') }}" required>
                        </div>
                        <small class="help">ต้องเป็นอีเมลที่ถูกต้องและไม่ซ้ำ</small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-shield-lock"></i> บทบาทผู้ใช้ <span class="req">*</span>
                        </div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-people"></i></span>
                            <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                <option value="">เลือกบทบาท</option>
                                <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>ผู้ดูแลระบบ
                                    (Administrator)</option>
                                <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>สมาชิก (Member)
                                </option>
                            </select>
                        </div>
                        <small class="help">เลือกสิทธิ์การเข้าถึงระบบ</small>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <div class="section-header">
                    <i class="bi bi-key"></i> ความปลอดภัย
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-lock"></i> รหัสผ่าน <span class="req">*</span></div>
                        <div class="input-icon" style="position: relative;">
                            <span class="icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="อย่างน้อย 8 ตัวอักษร" minlength="8" required>
                            <button type="button" class="pw-toggle" id="togglePw"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="pw-meter">
                            <div class="pw-meter-bar" id="pwBar"></div>
                        </div>
                        <small class="help">ควรมีตัวอักษรผสม ตัวเลข และสัญลักษณ์</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-shield-check"></i> ยืนยันรหัสผ่าน <span
                                class="req">*</span></div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-shield-check-fill"></i></span>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" placeholder="พิมพ์รหัสผ่านอีกครั้ง" minlength="8" required>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <div class="section-header">
                    <i class="bi bi-image"></i> รูปโปรไฟล์
                </div>

                <div class="mb-3">
                    <div class="label"><i class="bi bi-person-circle"></i> URL รูปโปรไฟล์ (ไม่บังคับ)</div>
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <img id="avatarPreview" class="avatar-preview"
                                src="https://via.placeholder.com/64x64?text=Avatar" alt="Avatar Preview">
                        </div>
                        <div class="col">
                            <div class="input-icon">
                                <span class="icon"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" class="form-control @error('avatar_url') is-invalid @enderror"
                                    id="avatar_url" name="avatar_url" placeholder="https://example.com/avatar.png"
                                    value="{{ old('avatar_url') }}">
                            </div>
                            <small class="help">ลิงก์รูปภาพจากแหล่งภายนอก</small>
                        </div>
                    </div>
                    @error('avatar_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="divider"></div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle me-1"></i> บันทึกผู้ดูแลระบบ
                    </button>
                    <a href="{{ url('/admin/users') }}" class="btn btn-danger">
                        <i class="bi bi-arrow-left-short me-1"></i> ยกเลิก
                    </a>
                </div>

            </div>
        </div>

    </form>
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('adminForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                const name = form.querySelector('[name="name"]');
                const email = form.querySelector('[name="email"]');
                const password = form.querySelector('[name="password"]');
                const passwordConfirm = form.querySelector('[name="password_confirmation"]');
                const roleId = form.querySelector('[name="role_id"]');

                if (!name.value || name.value.length < 2) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'กรุณากรอกชื่ออย่างน้อย 2 ตัวอักษร',
                        confirmButtonColor: '#2196f3',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });
                    return false;
                }

                if (!email.value || !email.value.includes('@')) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'กรุณากรอกอีเมลให้ถูกต้อง',
                        confirmButtonColor: '#2196f3',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });
                    return false;
                }

                if (!password.value || password.value.length < 8) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
                        confirmButtonColor: '#2196f3',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });
                    return false;
                }

                if (password.value !== passwordConfirm.value) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'รหัสผ่านไม่ตรงกัน',
                        confirmButtonColor: '#2196f3',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });
                    return false;
                }

                if (!roleId.value) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'กรุณาเลือกบทบาทผู้ใช้',
                        confirmButtonColor: '#2196f3',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });
                    return false;
                }
            });

            function bindCounter(selector, maxDefault) {
                const el = form.querySelector(`[data-counter="${selector}"]`) || form.querySelector(
                    `[name="${selector}"]`);
                const label = form.querySelector(`[data-for="${selector}"]`);
                const max = (el && el.getAttribute('maxlength')) ? +el.getAttribute('maxlength') : maxDefault;
                if (!el || !label) return;
                const render = () => label.textContent = `${(el.value||'').length}/${max}`;
                render();
                ['input', 'keyup'].forEach(evt => el.addEventListener(evt, render));
            }
            bindCounter('name', 100);

            const pw = document.getElementById('password');
            const toggle = document.getElementById('togglePw');
            const bar = document.getElementById('pwBar');
            const avatar = document.getElementById('avatar_url');
            const avatarPreview = document.getElementById('avatarPreview');

            function strength(v) {
                let s = 0;
                if (v.length >= 8) s++;
                if (/[a-z]/.test(v)) s++;
                if (/[A-Z]/.test(v)) s++;
                if (/[0-9]/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                return Math.min(s, 5);
            }

            function render(v) {
                const s = strength(v);
                const pct = [0, 20, 40, 60, 80, 100][s];
                bar.style.width = pct + '%';
                if (s >= 4) {
                    bar.style.background = 'var(--success)';
                } else if (s >= 2) {
                    bar.style.background = 'var(--blue)';
                } else {
                    bar.style.background = 'var(--danger)';
                }
            }

            if (pw) {
                pw.addEventListener('input', e => render(e.target.value));
                render('');
            }

            if (toggle) {
                toggle.addEventListener('click', function() {
                    const show = pw.getAttribute('type') === 'password';
                    pw.setAttribute('type', show ? 'text' : 'password');
                    this.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
                });
            }

            if (avatar && avatarPreview) {
                function updatePreview() {
                    const v = (avatar.value || '').trim();
                    if (v) {
                        avatarPreview.src = v;
                        avatarPreview.onerror = function() {
                            this.src = 'https://via.placeholder.com/64x64?text=Error';
                        };
                    } else {
                        avatarPreview.src = 'https://via.placeholder.com/64x64?text=Avatar';
                    }
                }
                avatar.addEventListener('input', updatePreview);
                avatar.addEventListener('blur', updatePreview);
                updatePreview();
            }
        });
    </script>
@endsection
