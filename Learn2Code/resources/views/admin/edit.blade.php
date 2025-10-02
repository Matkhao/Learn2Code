@extends('layouts.backend')

@section('css_before')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/admin/admin.edit.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
@endsection

@section('content')
    <div class="page-wrap">
        <div class="page-hero">
            <h2><i class="bi bi-person-gear"></i> แก้ไขผู้ดูแลระบบ</h2>
            <p><i class="bi bi-info-circle"></i> แก้ไขข้อมูลผู้ดูแลระบบ (เว้นรหัสผ่านว่างหากไม่ต้องการเปลี่ยน)</p>
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

        <form action="{{ url('/admin/' . $row->user_id) }}" method="POST" autocomplete="off" novalidate id="adminForm">
            @csrf
            @method('PUT')

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
                        <div class="label"><i class="bi bi-type"></i> ชื่อแสดงผล <span class="req">*</span></div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-input-cursor-text"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="เช่น Admin Natthaphong" minlength="3" maxlength="100"
                                value="{{ old('name', $row->name) }}" required data-counter="name"
                                aria-describedby="nameHelp">
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small id="nameHelp" class="help">สูงสุด 100 ตัวอักษร</small>
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
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="name@example.com" value="{{ old('email', $row->email) }}"
                                    required>
                            </div>
                            <small class="help">ต้องเป็นอีเมลที่ถูกต้องและไม่ซ้ำกับผู้ใช้เดิม</small>
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
                                    @php
                                        $roleSelected = old('role_id', $row->role_id ?? 1);
                                        $hasRoles = isset($roles) && count($roles);
                                    @endphp
                                    @if ($hasRoles)
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->role_id }}"
                                                {{ (int) $roleSelected === (int) $r->role_id ? 'selected' : '' }}>
                                                {{ $r->role_id == 1 ? 'ผู้ดูแลระบบ (Administrator)' : ($r->role_id == 2 ? 'สมาชิก (Member)' : $r->name) }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="1" {{ (int) $roleSelected === 1 ? 'selected' : '' }}>
                                            ผู้ดูแลระบบ
                                            (Administrator)</option>
                                        <option value="2" {{ (int) $roleSelected === 2 ? 'selected' : '' }}>สมาชิก
                                            (Member)</option>
                                    @endif
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
                        <i class="bi bi-key"></i> ความปลอดภัย (ไม่บังคับ)
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="label"><i class="bi bi-lock"></i> รหัสผ่านใหม่ <span
                                    class="help">(เว้นว่างหากไม่เปลี่ยน)</span></div>
                            <div class="input-icon" style="position: relative;">
                                <span class="icon"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="อย่างน้อย 8 ตัวอักษร" minlength="8"
                                    aria-describedby="pwdHelp">
                                <button type="button" class="pw-toggle" id="togglePw"
                                    aria-label="สลับการแสดงรหัสผ่าน"><i class="bi bi-eye"></i></button>
                            </div>
                            <div class="pw-meter">
                                <div class="pw-meter-bar" id="pwBar"></div>
                            </div>
                            <small id="pwdHelp" class="help">ควรมีตัวอักษรผสม ตัวเลข และสัญลักษณ์</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="label"><i class="bi bi-shield-check"></i> ยืนยันรหัสผ่านใหม่</div>
                            <div class="input-icon">
                                <span class="icon"><i class="bi bi-shield-check-fill"></i></span>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="พิมพ์รหัสผ่านอีกครั้ง" minlength="8">
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

                    <div class="mb-4">
                        <div class="label"><i class="bi bi-person-circle"></i> URL รูปโปรไฟล์ (ไม่บังคับ)</div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <img id="avatarPreview" class="avatar-preview"
                                    src="{{ old('avatar_url', $row->avatar_url) ?: 'https://via.placeholder.com/64x64?text=Avatar' }}"
                                    alt="ตัวอย่างรูปโปรไฟล์">
                            </div>
                            <div class="col">
                                <div class="input-icon">
                                    <span class="icon"><i class="bi bi-link-45deg"></i></span>
                                    <input type="url" class="form-control @error('avatar_url') is-invalid @enderror"
                                        id="avatar_url" name="avatar_url" placeholder="https://example.com/avatar.png"
                                        value="{{ old('avatar_url', $row->avatar_url) }}">
                                </div>
                                <small class="help">ลิงก์รูปภาพจากแหล่งภายนอก</small>
                            </div>
                        </div>
                        @error('avatar_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="divider"></div>

                    <div class="sticky-summary mt-5">
                        <div class="summary-head">
                            <div class="summary-title"><i class="bi bi-clipboard2-check"></i> สรุปสิ่งที่แก้ไข</div>
                            <span id="changeCount" class="badge-count" role="status"
                                aria-live="polite">ยังไม่มีการแก้ไข</span>
                        </div>
                        <div id="changePills" class="change-pills"></div>
                        <div class="summary-headrow">
                            <div>ฟิลด์</div>
                            <div>เดิม</div>
                            <div>ใหม่</div>
                        </div>
                        <div id="summaryContent"></div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>
                                บันทึกการเปลี่ยนแปลง</button>
                            <a href="{{ url('/admin/users') }}" class="btn btn-danger"><i
                                    class="bi bi-x-circle me-1"></i>
                                ยกเลิก</a>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('adminForm');
            if (!form) return;

            const pillsWrap = document.getElementById('changePills');
            const changeCount = document.getElementById('changeCount');
            const summaryContent = document.getElementById('summaryContent');
            const pills = {};
            let dirty = false;
            let isNavigating = false;

            function beforeUnloadHandler(e) {
                if (!dirty || isNavigating) return;
                e.preventDefault();
                e.returnValue = '';
            }
            window.addEventListener('beforeunload', beforeUnloadHandler);

            document.addEventListener('click', function(e) {
                const a = e.target.closest('a[href]');
                if (!a) return;
                const href = a.getAttribute('href');
                if (href && href !== '#') {
                    isNavigating = true;
                    window.removeEventListener('beforeunload', beforeUnloadHandler);
                }
            });

            const originalData = {
                name: @json($row->name),
                email: @json($row->email),
                role_id: @json((string) $row->role_id),
                avatar_url: @json($row->avatar_url)
            };

            const roleNames = {
                1: 'ผู้ดูแลระบบ',
                2: 'สมาชิก'
            };

            const fieldLabels = {
                name: 'ชื่อแสดงผล',
                email: 'อีเมล',
                role_id: 'บทบาท',
                password: 'รหัสผ่าน',
                avatar_url: 'รูปโปรไฟล์'
            };

            function pill(label) {
                const el = document.createElement('div');
                el.className = 'change-pill';
                el.innerHTML = '<i class="bi bi-dot"></i> ' + label;
                return el;
            }

            function markChanged(key) {
                if (pills[key]) return;
                const el = pill(fieldLabels[key] || key);
                pills[key] = el;
                pillsWrap.appendChild(el);
                dirty = true;
                renderSummary();
            }

            function unmarkChanged(key) {
                if (!pills[key]) return;
                pillsWrap.removeChild(pills[key]);
                delete pills[key];
                dirty = Object.keys(pills).length > 0;
                renderSummary();
            }

            function getCurrent() {
                return {
                    name: (form.querySelector('[name="name"]')?.value || ''),
                    email: (form.querySelector('[name="email"]')?.value || ''),
                    role_id: (form.querySelector('[name="role_id"]')?.value || ''),
                    avatar_url: (form.querySelector('[name="avatar_url"]')?.value || ''),
                    password: (form.querySelector('[name="password"]')?.value || '')
                };
            }

            function buildRows() {
                const cur = getCurrent();
                const rows = [];
                if (cur.name !== (originalData.name || '')) {
                    rows.push({
                        k: 'name',
                        label: fieldLabels.name,
                        oldVal: originalData.name || '—',
                        newVal: cur.name || '—'
                    });
                }
                if (cur.email !== (originalData.email || '')) {
                    rows.push({
                        k: 'email',
                        label: fieldLabels.email,
                        oldVal: originalData.email || '—',
                        newVal: cur.email || '—'
                    });
                }
                if (cur.role_id !== (originalData.role_id || '')) {
                    rows.push({
                        k: 'role_id',
                        label: fieldLabels.role_id,
                        oldVal: roleNames[originalData.role_id] || originalData.role_id || '—',
                        newVal: roleNames[cur.role_id] || cur.role_id || '—'
                    });
                }
                if (cur.avatar_url !== (originalData.avatar_url || '')) {
                    rows.push({
                        k: 'avatar_url',
                        label: fieldLabels.avatar_url,
                        oldVal: originalData.avatar_url || '—',
                        newVal: cur.avatar_url || '—'
                    });
                }
                if ((cur.password || '').length > 0) {
                    rows.push({
                        k: 'password',
                        label: fieldLabels.password,
                        oldVal: '—',
                        newVal: '●●●●●●●●'
                    });
                }
                return rows;
            }

            function renderSummary() {
                const rows = buildRows();
                const count = rows.length;
                const labelText = count ? `แก้ไข ${count} รายการ` : 'ยังไม่มีการแก้ไข';
                if (changeCount) changeCount.textContent = labelText;

                const keysNow = new Set(rows.map(r => r.k));
                Object.keys(pills).forEach(k => {
                    if (!keysNow.has(k)) unmarkChanged(k);
                });
                rows.forEach(r => {
                    if (!pills[r.k]) markChanged(r.k);
                });

                if (!summaryContent) return;
                if (!count) {
                    summaryContent.innerHTML =
                        `<div class="alert alert-danger" style="margin:0"><i class="bi bi-info-circle me-1"></i>ยังไม่มีรายการแก้ไข</div>`;
                    return;
                }
                let html = '';
                rows.forEach(r => {
                    html += `
                        <div class="summary-item">
                            <div class="summary-label">${r.label}</div>
                            <div class="summary-value summary-old">${r.oldVal || '—'}</div>
                            <div class="summary-value summary-new">${r.newVal || '—'}</div>
                        </div>
                    `;
                });
                summaryContent.innerHTML = html;
            }

            form.addEventListener('submit', onSubmitWithRedirect);

            ['name', 'email', 'role_id', 'avatar_url', 'password'].forEach(field => {
                const el = form.querySelector(`[name="${field}"]`);
                if (!el) return;
                const handler = () => {
                    const cur = (el.value || '');
                    const orig = (originalData[field] || '');
                    if (field === 'password') cur.length > 0 ? markChanged(field) : unmarkChanged(
                        field);
                    else cur !== orig ? markChanged(field) : unmarkChanged(field);
                    renderSummary();
                };
                ['input', 'change', 'keyup'].forEach(evt => el.addEventListener(evt, handler));
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

            function renderPw(v) {
                const s = strength(v);
                const pct = [0, 20, 40, 60, 80, 100][s];
                bar.style.width = pct + '%';
                if (s >= 4) bar.style.background = 'var(--success)';
                else if (s >= 2) bar.style.background = 'var(--blue)';
                else bar.style.background = 'var(--danger)';
            }
            if (pw) {
                pw.addEventListener('input', e => renderPw(e.target.value));
                renderPw('');
            }
            if (toggle) {
                toggle.addEventListener('click', function() {
                    const show = pw.getAttribute('type') === 'password';
                    pw.setAttribute('type', show ? 'text' : 'password');
                    this.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
                });
            }

            if (avatar && avatarPreview) {
                const defaultAvatar = @json(old('avatar_url', $row->avatar_url) ?: 'https://via.placeholder.com/64x64?text=Avatar');

                function updatePreview() {
                    const v = (avatar.value || '').trim();
                    if (v) {
                        avatarPreview.src = v;
                        avatarPreview.onerror = function() {
                            this.src = 'https://via.placeholder.com/64x64?text=Error';
                        };
                    } else {
                        avatarPreview.src = defaultAvatar;
                    }
                }
                avatar.addEventListener('input', updatePreview);
                avatar.addEventListener('blur', updatePreview);
                updatePreview();
            }

            renderSummary();

            async function onSubmitWithRedirect(e) {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"]');
                const redirectTo = "{{ url('/admin') }}";

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึก...';
                }

                try {
                    const fd = new FormData(form);
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: fd,
                        redirect: 'follow',
                        credentials: 'same-origin'
                    });

                    if (res.status === 422) {
                        const data = await res.json().catch(() => ({}));
                        const messages = data?.errors ? Object.values(data.errors).flat().join('\n') :
                            'ข้อมูลไม่ถูกต้อง';
                        await Swal.fire({
                            icon: 'error',
                            title: 'บันทึกไม่สำเร็จ',
                            text: messages,
                            confirmButtonColor: '#e53935',
                            background: '#0f1219',
                            color: '#e9f1fa'
                        });
                        return;
                    }

                    if (!res.ok && ![200, 204, 302].includes(res.status)) {
                        await Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถบันทึกข้อมูลได้',
                            confirmButtonColor: '#e53935',
                            background: '#0f1219',
                            color: '#e9f1fa'
                        });
                        return;
                    }

                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: 'บันทึกข้อมูลเรียบร้อย',
                        confirmButtonColor: '#2196f3',
                        confirmButtonText: 'ตกลง',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });

                    isNavigating = true;
                    dirty = false;
                    window.removeEventListener('beforeunload', beforeUnloadHandler);
                    window.location.href = redirectTo;
                } catch (err) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'การเชื่อมต่อล้มเหลว',
                        confirmButtonColor: '#e53935',
                        background: '#0f1219',
                        color: '#e9f1fa'
                    });
                } finally {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> บันทึกการเปลี่ยนแปลง';
                    }
                }
            }
        });
    </script>

    @if (session('success') || session('ok'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: '{{ session('success') ?? session('ok') }}',
                confirmButtonColor: '#2196f3',
                confirmButtonText: 'ตกลง',
                background: '#0f1219',
                color: '#e9f1fa'
            });
        </script>
    @endif
@endsection
