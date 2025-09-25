@extends('home')

@section('css_before')
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg: #0a0c10;
            --panel: #12141a;
            --panel2: #0e1219;
            --border: #1c1f27;
            --text: #e9f1fa;
            --muted: #9aa5b4;
            --blue: #2196f3;
            --blue-dark: #1976d2;
            --danger: #e53935;
            --success: #22c55e;
            --warning: #ffca28;
            --radius: 14px;
            --radius-sm: 10px;
            --shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }

        html,
        body {
            font-family: "Noto Sans Thai", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* Header */
        .page-hero {
            background: radial-gradient(1200px 400px at 10% -20%, rgba(33, 150, 243, .25), transparent),
                radial-gradient(900px 300px at 110% 0%, rgba(25, 118, 210, .23), transparent);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            margin-bottom: 16px;
        }

        .page-hero h1 {
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: .5px;
            font-size: 40px;
            line-height: 1;
            margin: 0;
        }

        .page-hero p {
            color: var(--muted);
            margin: 6px 0 0;
        }

        /* Card */
        .card-ui {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(255, 255, 255, .02), transparent);
        }

        .card-head .title {
            font-weight: 800;
        }

        .card-body {
            padding: 18px;
        }

        /* Label & help */
        .label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .label .req {
            color: var(--warning);
            font-weight: 800;
        }

        .help {
            color: var(--muted);
            font-size: .9rem;
        }

        /* Input with icon */
        .input-icon {
            display: flex;
            align-items: stretch;
        }

        .input-icon .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-right: none;
            background: #10131a;
            color: #9ecbff;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        }

        .input-icon .form-control,
        .input-icon .form-select {
            border: 1px solid var(--border);
            background: #0e1118;
            color: var(--text);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border);
            background: #0e1118;
            color: var(--text);
        }

        .form-control::placeholder {
            color: #6b7686;
        }

        /* Chips (Free / Paid) – เต็มความกว้าง & responsive */
        .chipset--fill {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        @media (max-width:480px) {
            .chipset--fill {
                grid-template-columns: 1fr;
            }
        }

        .chip {
            border: 1px solid var(--border);
            background: #0f1420;
            color: var(--text);
            padding: 12px 16px;
            border-radius: 999px;
            cursor: pointer;
            user-select: none;
            transition: .2s;
            text-align: center;
            width: 100%;
        }

        .chip[data-active="true"] {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }

        .chip:focus {
            outline: 2px solid var(--blue);
            outline-offset: 2px;
            box-shadow: 0 0 0 4px rgba(33, 150, 243, .15);
        }

        /* Disabled price state */
        .is-disabled {
            opacity: .55;
        }

        .is-disabled input {
            pointer-events: none;
        }

        /* Dropzone */
        .dropzone {
            border: 1px dashed #2a3342;
            border-radius: var(--radius);
            background: #0b1018;
            padding: 14px;
            text-align: center;
            transition: .2s;
        }

        .dropzone:hover {
            border-color: #447bd3;
            background: #0d1422;
        }

        .dz-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .preview {
            margin-top: 12px;
            display: none;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: #0b0f16;
        }

        .preview img {
            width: 100%;
            height: auto;
            max-height: 260px;
            object-fit: cover;
            display: block;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 18px 0;
        }

        /* Buttons */
        .btn {
            border-radius: 12px;
            font-weight: 700;
        }

        .btn-primary {
            background: var(--blue);
            border: none;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
        }

        .btn-danger {
            background: var(--danger);
            border: none;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            background: #0f1420;
        }

        /* Counters */
        .counter {
            font-size: .85rem;
            color: var(--muted);
        }

        /* Rating */
        .rating-widget .bi-star-fill,
        .rating-widget .bi-star-half {
            color: #ffd54f;
        }

        .rating-widget .bi-star {
            color: #5f6b7a;
        }

        .rating-widget .rating-stars {
            display: flex;
            align-items: center;
            gap: .25rem;
        }

        .rating-range {
            accent-color: #2196f3;
        }
    </style>
@endsection

@section('content')
    <div class="page-hero">
        <h2><i class="bi bi-journal-plus me-2"></i><b>เพิ่มคอร์สเรียน</b></h2>
        <p><i class="bi bi-info-circle"></i> กรอกข้อมูลให้ครบถ้วนเพื่อช่วยให้ผู้เรียนตัดสินใจได้เร็วขึ้น</p>
    </div>

    <form action="/courses" method="post" enctype="multipart/form-data" id="createForm" novalidate>
        @csrf

        <div class="card-ui">
            <div class="card-head">
                <i class="bi bi-ui-checks-grid"></i>
                <div class="title">ข้อมูลหลักของคอร์ส</div>
            </div>

            <div class="card-body">
                <!-- Title -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-type"></i> ชื่อคอร์ส <span class="req">*</span></div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-input-cursor-text"></i></span>
                        <input type="text" class="form-control" name="title" required minlength="3" maxlength="200"
                            placeholder="เช่น พื้นฐาน Web Development ด้วย Laravel" value="{{ old('title') }}"
                            data-counter="title">
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="help">สูงสุด 200 ตัวอักษร</small>
                        <small class="counter" data-for="title">0/200</small>
                    </div>
                    @error('title')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <!-- Category -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-tags"></i> หมวดหมู่ (Category ID) <span class="req">*</span>
                        </div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-collection"></i></span>
                            <input type="number" class="form-control" name="category_id" required min="0"
                                max="999999" placeholder="เช่น 1 (โปรแกรมมิ่ง), 2 (ออกแบบ) ..."
                                value="{{ old('category_id') }}">
                        </div>
                        @error('category_id')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Language -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-translate"></i> ภาษา</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-chat-dots"></i></span>
                            <select class="form-select" name="language">
                                <option value="TH" {{ old('language') == 'TH' ? 'selected' : '' }}>Thai</option>
                                <option value="EN" {{ old('language') == 'EN' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                        @error('language')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <!-- Provider -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-building"></i> ผู้ให้บริการคอร์ส <span class="req">*</span>
                        </div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-bank2"></i></span>
                            <input type="text" class="form-control" name="provider" required maxlength="120"
                                placeholder="เช่น DevSchool, Coursera, Udemy" value="{{ old('provider') }}">
                        </div>
                        @error('provider')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Instructor (nullable) -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-person-badge"></i> ผู้สอน (ไม่บังคับ)</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-person-lines-fill"></i></span>
                            <input type="text" class="form-control" name="provider_instructor" maxlength="120"
                                placeholder="เช่น อ.สมชาย พัฒนาทักษะ" value="{{ old('provider_instructor') }}">
                        </div>
                        @error('provider_instructor')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <!-- Level -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-graph-up-arrow"></i> ระดับเนื้อหา</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-stars"></i></span>
                            <select class="form-select" name="level">
                                <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner
                                </option>
                                <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>
                                    Intermediate</option>
                                <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced
                                </option>
                            </select>
                        </div>
                        @error('level')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Course URL -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-link-45deg"></i> ลิงก์หน้าคอร์ส</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-globe2"></i></span>
                            <input type="url" class="form-control" name="course_url" maxlength="255"
                                placeholder="https://example.com/courses/your-course" value="{{ old('course_url') }}">
                        </div>
                        @error('course_url')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Price Type -->
                <div class="mb-2">
                    <div class="label"><i class="bi bi-cash-coin"></i> รูปแบบราคา <span class="req">*</span></div>
                    <div class="chipset--fill" id="priceTypeChips">
                        @php $priceTypeOld = old('price_type','free'); @endphp
                        <div class="chip" data-value="free"
                            data-active="{{ $priceTypeOld === 'free' ? 'true' : 'false' }}" tabindex="0"
                            aria-pressed="{{ $priceTypeOld === 'free' ? 'true' : 'false' }}">
                            <i class="bi bi-gift me-1"></i> Free
                        </div>
                        <div class="chip" data-value="paid"
                            data-active="{{ $priceTypeOld === 'paid' ? 'true' : 'false' }}" tabindex="0"
                            aria-pressed="{{ $priceTypeOld === 'paid' ? 'true' : 'false' }}">
                            <i class="bi bi-credit-card me-1"></i> Paid
                        </div>
                    </div>
                    <input type="hidden" name="price_type" id="price_type" value="{{ $priceTypeOld }}">
                    <small class="help">เลือก “Free” ระบบจะปิดช่องราคาชั่วคราว</small>
                    @error('price_type')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Price -->
                <div class="mb-3" id="priceWrap">
                    <div class="label"><i class="bi bi-currency-exchange"></i> ราคา (บาท)</div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-currency-baht"></i></span>
                        <!-- DECIMAL(10,2) => more than 99,999,999.99 จะผิด -->
                        <input type="number" class="form-control" name="price" id="price" min="0"
                            max="99999999.99" step="0.01" placeholder="เช่น 1999.00" value="{{ old('price') }}">
                    </div>
                    <small class="help">สูงสุด 99,999,999.99</small>
                    @error('price')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Duration -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-alarm"></i> ระยะเวลาเรียน</div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-clock-history"></i></span>
                        <input type="text" class="form-control" name="duration_text" maxlength="600"
                            placeholder="เช่น 10 ชั่วโมง, 6 สัปดาห์" value="{{ old('duration_text') }}"
                            data-counter="duration">
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span></span><small class="counter" data-for="duration">0/600</small>
                    </div>
                    @error('duration_text')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-card-text"></i> รายละเอียดคอร์ส</div>
                    <textarea name="description" class="form-control" rows="5" maxlength="2000"
                        placeholder="สรุปสิ่งที่จะได้เรียน หัวข้อหลัก และคุณสมบัติที่ผู้เรียนควรมี" data-counter="desc">{{ old('description') }}</textarea>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="help">ใช้ bullet • เพื่อช่วยให้อ่านง่าย</small>
                        <small class="counter" data-for="desc">0/2000</small>
                    </div>
                    @error('description')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="divider"></div>

                <!-- Cover Image -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-image"></i> หน้าปกคอร์ส</div>
                    <div class="dropzone" id="dropzone">
                        <div>ลากรูปมาวางที่นี่ หรือ
                            <button class="btn btn-outline btn-sm" type="button" id="dzPick"><i
                                    class="bi bi-folder2-open"></i> เลือกรูป</button>
                        </div>
                        <div class="help mt-1">อัตราส่วน 16:9 (เช่น 1280×720px) ไฟล์ .jpg/.png</div>
                        <input type="file" name="cover_img" accept="image/*" id="cover_img_input" class="d-none">
                        <div class="dz-actions">
                            <button type="button" class="btn btn-outline btn-sm" id="dzClear"
                                style="display:none;"><i class="bi bi-x-circle"></i> ลบรูป</button>
                        </div>
                        <div class="preview" id="cover_preview_wrap">
                            <img id="cover_preview" src="#" alt="cover preview">
                        </div>
                    </div>
                    @error('cover_img')
                        <div class="text-danger mt-2"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="divider"></div>

                <!-- Rating -->
                <div class="mb-2">
                    <div class="label"><i class="bi bi-star-half"></i> ให้คะแนนเฉลี่ยเริ่มต้น (0–5)</div>
                    <div class="rating-widget" data-rating-widget data-initial="{{ old('avg_rating', 0) }}">
                        <div class="rating-stars mb-1" data-stars>
                            <i class="bi fs-5"></i>
                            <i class="bi fs-5"></i>
                            <i class="bi fs-5"></i>
                            <i class="bi fs-5"></i>
                            <i class="bi fs-5"></i>
                            <span class="ms-2 small text-info" data-value>0.0</span>
                        </div>
                        <input type="range" class="form-range rating-range" data-range min="0" max="5"
                            step="0.5" value="{{ old('avg_rating', 0) }}">
                        <input type="hidden" name="avg_rating" data-hidden value="{{ old('avg_rating', 0) }}">
                        <small class="help">เลื่อนสไลเดอร์ (ทีละ 0.5) หรือคลิกดาวเพื่อเลือกคะแนน (เก็บเป็น
                            DECIMAL(3,2))</small>
                    </div>
                    @error('avg_rating')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle me-1"></i> บันทึกคอร์ส
                    </button>
                    <a href="/courses" class="btn btn-danger">
                        <i class="bi bi-arrow-left-short me-1"></i> ยกเลิก
                    </a>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('js_before')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createForm');
            if (!form) return;

            /* ---------- counters ---------- */
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
            bindCounter('title', 200);
            bindCounter('duration', 600);
            bindCounter('desc', 2000);

            /* ---------- price type toggle ---------- */
            const chipsWrap = document.getElementById('priceTypeChips');
            const hiddenType = document.getElementById('price_type');
            const priceWrap = document.getElementById('priceWrap');
            const priceInput = document.getElementById('price');

            function setPriceDisabled(disabled) {
                priceWrap.classList.toggle('is-disabled', disabled);
                priceInput.readOnly = disabled;
                if (disabled) {
                    priceInput.value = '';
                }
            }

            function updatePriceState() {
                setPriceDisabled((hiddenType.value || 'free') !== 'paid');
            }
            chipsWrap?.addEventListener('click', e => {
                const chip = e.target.closest('.chip');
                if (!chip) return;
                chipsWrap.querySelectorAll('.chip').forEach(c => c.dataset.active = 'false');
                chip.dataset.active = 'true';
                hiddenType.value = chip.dataset.value;
                updatePriceState();
            });
            updatePriceState();

            /* ---------- clamp/format price to DECIMAL(10,2) ---------- */
            const PRICE_MAX = 99999999.99;

            function clampPrice(v) {
                let n = parseFloat(v);
                if (isNaN(n) || n < 0) n = 0;
                if (n > PRICE_MAX) n = PRICE_MAX;
                return Math.round(n * 100) / 100;
            }
            priceInput?.addEventListener('blur', () => {
                if (priceInput.readOnly) return;
                const v = clampPrice(priceInput.value);
                priceInput.value = v ? v.toFixed(2) : '';
            });

            /* ---------- Dropzone preview ---------- */
            const dz = document.getElementById('dropzone');
            const dzPick = document.getElementById('dzPick');
            const dzClear = document.getElementById('dzClear');
            const fileIn = document.getElementById('cover_img_input');
            const prevWrap = document.getElementById('cover_preview_wrap');
            const prevImg = document.getElementById('cover_preview');

            function showPreview(file) {
                if (!file) return;
                const url = URL.createObjectURL(file);
                prevImg.src = url;
                prevWrap.style.display = 'block';
                dzClear.style.display = 'inline-flex';
            }
            dzPick?.addEventListener('click', () => fileIn?.click());
            dz?.addEventListener('dragover', e => {
                e.preventDefault();
                dz.classList.add('hover');
            });
            dz?.addEventListener('dragleave', () => dz.classList.remove('hover'));
            dz?.addEventListener('drop', e => {
                e.preventDefault();
                dz.classList.remove('hover');
                const file = e.dataTransfer.files?.[0];
                if (file && fileIn) {
                    fileIn.files = e.dataTransfer.files;
                    showPreview(file);
                }
            });
            fileIn?.addEventListener('change', e => showPreview(e.target.files?.[0]));
            dzClear?.addEventListener('click', () => {
                if (fileIn) fileIn.value = '';
                prevImg.src = '#';
                prevWrap.style.display = 'none';
                dzClear.style.display = 'none';
            });

            /* ---------- Rating (0–5, step 0.5, DECIMAL(3,2)) ---------- */
            form.querySelectorAll('[data-rating-widget]').forEach(widget => {
                const starsWrap = widget.querySelector('[data-stars]');
                const range = widget.querySelector('[data-range]');
                const hidden = widget.querySelector('[data-hidden]');
                const valLabel = widget.querySelector('[data-value]');
                const stars = starsWrap ? Array.from(starsWrap.querySelectorAll('i.bi')) : [];

                function renderStars(v) {
                    const val = Number(v) || 0;
                    const full = Math.floor(val);
                    const half = (val - full) >= 0.5 ? 1 : 0;
                    for (let i = 0; i < 5; i++) {
                        const base = 'bi fs-5 ';
                        if (i < full) stars[i].className = base + 'bi-star-fill';
                        else if (i === full && half) stars[i].className = base + 'bi-star-half';
                        else stars[i].className = base + 'bi-star';
                    }
                    if (valLabel) valLabel.textContent = val.toFixed(1);
                }

                function clampHalf(x) {
                    const n = Math.min(5, Math.max(0, Number(x) || 0));
                    return Math.round(n * 2) / 2;
                }

                function setRating(v) {
                    const val = clampHalf(v);
                    range.value = val;
                    hidden.value = val.toFixed(2); // DECIMAL(3,2) เช่น 4.50
                    renderStars(val);
                }

                const init = widget.getAttribute('data-initial') ?? hidden.value ?? range.value ?? 0;
                requestAnimationFrame(() => setRating(init));

                range.addEventListener('input', e => setRating(e.target.value));
                starsWrap?.addEventListener('click', e => {
                    const rect = starsWrap.getBoundingClientRect();
                    const ratio = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
                    setRating(ratio * 5);
                });
            });

            /* ---------- client-side hard guards before submit ---------- */
            form.addEventListener('submit', function(e) {
                // guard price vs price_type
                if ((hiddenType.value || 'free') === 'paid') {
                    const v = clampPrice(priceInput.value);
                    if (!v && v !== 0) {
                        e.preventDefault();
                        alert('กรุณาระบุราคาให้ถูกต้อง');
                        return;
                    }
                    priceInput.value = v.toFixed(2);
                } else {
                    priceInput.value = ''; // free ไม่ส่งราคา
                }
                // clamp category_id
                const cat = form.querySelector('[name="category_id"]');
                if (cat) {
                    let n = parseInt(cat.value || '0', 10);
                    if (isNaN(n) || n < 0) n = 0;
                    if (n > 999999) n = 999999;
                    cat.value = n;
                }
                // trim lengthsให้ไม่เกิน schema
                const t = form.querySelector('[name="title"]');
                if (t && t.value.length > 200) t.value = t.value.slice(0, 200);
                const prov = form.querySelector('[name="provider"]');
                if (prov && prov.value.length > 120) prov.value = prov.value.slice(0, 120);
                const inst = form.querySelector('[name="provider_instructor"]');
                if (inst && inst.value.length > 120) inst.value = inst.value.slice(0, 120);
                const url = form.querySelector('[name="course_url"]');
                if (url && url.value.length > 255) url.value = url.value.slice(0, 255);
                const dur = form.querySelector('[name="duration_text"]');
                if (dur && dur.value.length > 600) dur.value = dur.value.slice(0, 600);
            });

        });
    </script>
@endsection
