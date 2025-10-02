@extends('layouts.backend')

@section('css_before')
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/courses/courses.edit.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
@endsection

@section('content')
    <div class="page-hero">
        <h2><i class="bi bi-pencil-square me-2"></i><b>แก้ไขคอร์ส</b></h2>
        <p><i class="bi bi-info-circle"></i> ปรับข้อมูลให้ตรงปัจจุบัน ชื่อ/ราคา/รูปปก/รายละเอียด</p>
    </div>

    <form action="{{ route('admin.courses.update', $id) }}" method="post" enctype="multipart/form-data" id="editForm"
        novalidate>
        @csrf
        @method('put')

        <div class="card-ui">
            <div class="card-head">
                <i class="bi bi-ui-checks-grid"></i>
                <div class="title">ข้อมูลหลักของคอร์ส</div>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <div class="label"><i class="bi bi-type"></i> ชื่อคอร์ส <span class="req">*</span></div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-input-cursor-text"></i></span>
                        <input type="text" class="form-control" name="title" required minlength="3" maxlength="100"
                            value="{{ old('title', $title) }}" placeholder="เช่น พื้นฐาน Web Development ด้วย Laravel"
                            data-field="title">
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="help">ตั้งชื่อให้ชัดเจน สั้น กระชับ</small>
                        <small class="counter" data-for="title">0/100</small>
                    </div>
                    @error('title')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                @php
                    $catId = old('category_id', $category_id ?? null);
                    $catName = isset($categories)
                        ? optional($categories->firstWhere('id', $catId))->name
                        : $category_name ?? null;
                    $catDisplay = $catId ? ($catName ? "{$catId} - {$catName}" : (string) $catId) : '';
                @endphp

                <div class="mb-3">
                    <div class="label"><i class="bi bi-tags"></i> หมวดหมู่ (Category ID)</div>
                    <div class="input-icon has-suffix">
                        <span class="icon"><i class="bi bi-collection"></i></span>

                        <input type="text" class="form-control" id="category_display" value="{{ $catDisplay }}"
                            placeholder="เช่น 1 - ฐานข้อมูล" readonly>

                        <input type="hidden" name="category_id" id="category_id_input" value="{{ $catId }}">

                        <button class="suffix-btn" type="button" id="btnEditCategory" aria-label="แก้ไขหมวดหมู่">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    @error('category_id')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content"
                            style="background:var(--panel); color:var(--text); border:1px solid var(--border);">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-pencil-square me-1"></i> เปลี่ยนหมวดหมู่</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="label mb-2"><i class="bi bi-collection"></i> เลือกหมวดหมู่</label>
                                <select class="form-select" id="categorySelect">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->category_id }}">{{ $cat->category_id }} -
                                            {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <small class="help d-block mt-2">กด “ตกลง” เพื่อใช้เลขหมวดหมู่ที่เลือก</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="btnApplyCategory">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Provider -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-building"></i> ผู้ให้บริการคอร์ส</div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-bank2"></i></span>
                        <input type="text" class="form-control" name="provider"
                            value="{{ old('provider', $provider) }}" placeholder="เช่น DevSchool, Coursera, Udemy"
                            data-field="provider">
                    </div>
                    @error('provider')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Instructor -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-person-badge"></i> ผู้สอน</div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="text" class="form-control" name="provider_instructor"
                            value="{{ old('provider_instructor', $provider_instructor) }}"
                            placeholder="เช่น อ.สมชาย พัฒนาทักษะ" data-field="provider_instructor">
                    </div>
                    @error('provider_instructor')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <!-- Level -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-graph-up-arrow"></i> ระดับเนื้อหา</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-stars"></i></span>
                            <select class="form-select" name="level" data-field="level">
                                @php $lv = old('level', $level); @endphp
                                <option value="beginner" {{ $lv == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ $lv == 'intermediate' ? 'selected' : '' }}>Intermediate
                                </option>
                                <option value="advanced" {{ $lv == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                        @error('level')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Language -->
                    <div class="col-md-6">
                        <div class="label"><i class="bi bi-translate"></i> ภาษา</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-chat-dots"></i></span>
                            @php $lang = old('language', $language); @endphp
                            <select class="form-select" name="language" data-field="language">
                                <option value="TH" {{ $lang == 'TH' ? 'selected' : '' }}>Thai</option>
                                <option value="EN" {{ $lang == 'EN' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                        @error('language')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Price Type -->
                <div class="mb-2">
                    <div class="label"><i class="bi bi-cash-coin"></i> รูปแบบราคา</div>
                    @php $ptype = old('price_type', $price_type ?? 'free'); @endphp

                    <div class="chipset chipset--fill" id="priceTypeChips" role="radiogroup" aria-label="Price type">
                        <div class="chip" role="radio" tabindex="0"
                            aria-checked="{{ $ptype == 'free' ? 'true' : 'false' }}" data-value="free"
                            data-active="{{ $ptype == 'free' ? 'true' : 'false' }}">
                            <i class="bi bi-gift me-1"></i> Free
                        </div>
                        <div class="chip" role="radio" tabindex="0"
                            aria-checked="{{ $ptype == 'paid' ? 'true' : 'false' }}" data-value="paid"
                            data-active="{{ $ptype == 'paid' ? 'true' : 'false' }}">
                            <i class="bi bi-credit-card me-1"></i> Paid
                        </div>
                    </div>

                    <input type="hidden" name="price_type" id="price_type" value="{{ $ptype }}"
                        data-field="price_type">
                    <small class="help d-block">เลือก “Free” แล้วระบบจะปิดช่องราคาชั่วคราว</small>
                    @error('price_type')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Price -->
                <div class="mb-3" id="priceWrap">
                    <div class="label"><i class="bi bi-currency-exchange"></i> ราคา</div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-currency-baht"></i></span>
                        <input type="number" step="0.01" class="form-control" id="price"
                            {{ ($ptype ?? 'free') == 'paid' ? 'name=price' : '' }} value="{{ old('price', $price) }}"
                            placeholder="เช่น 999.00" data-field="price">
                    </div>
                    <input type="hidden" id="price_hidden" name="price"
                        value="{{ ($ptype ?? 'free') == 'paid' ? old('price', $price) : 0 }}"
                        {{ ($ptype ?? 'free') == 'paid' ? 'disabled' : '' }}>
                    @error('price')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Duration -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-alarm"></i> ระยะเวลาเรียน</div>
                    <div class="input-icon">
                        <span class="icon"><i class="bi bi-clock-history"></i></span>
                        <input type="text" class="form-control" name="duration_text"
                            value="{{ old('duration_text', $duration_text) }}" placeholder="เช่น 10 ชั่วโมง, 6 สัปดาห์"
                            data-field="duration_text">
                    </div>
                    @error('duration_text')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-card-text"></i> รายละเอียดคอร์ส</div>
                    <textarea name="description" class="form-control" rows="5" maxlength="600"
                        placeholder="สรุปสิ่งที่จะได้เรียน หัวข้อหลัก และคุณสมบัติที่ผู้เรียนควรมี" data-field="description">{{ old('description', $description) }}</textarea>
                    <div class="d-flex justify-content-between">
                        <small class="help">เคล็ดลับ : ใช้หัวข้อย่อย • เหมาะสำหรับผู้เริ่มต้น • มีโปรเจกต์จริง</small>
                        <small class="counter" data-for="description">0/600</small>
                    </div>
                    @error('description')
                        <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="divider"></div>

                <!-- Cover Image -->
                <div class="mb-3">
                    <div class="label"><i class="bi bi-image"></i> รูปปกปัจจุบัน</div>
                    <div class="thumb-current mb-2">
                        @if (!empty($cover_img))
                            <img src="{{ asset('storage/' . $cover_img) }}" alt="current cover">
                        @else
                            <img src="https://via.placeholder.com/1280x720?text=No+Image" alt="no cover">
                        @endif
                    </div>

                    <div class="label mt-3"><i class="bi bi-cloud-upload"></i> อัปโหลดรูปใหม่ (ถ้าต้องการเปลี่ยน)</div>
                    <div class="dropzone" id="dropzone">
                        <div>ลากรูปมาวางที่นี่ หรือ <button class="btn btn-outline btn-sm" type="button"
                                id="dzPick"><i class="bi bi-folder2-open"></i> เลือกรูป</button></div>
                        <div class="help mt-1">แนะนำอัตราส่วน 16:9 (เช่น 1280×720px) ไฟล์ .jpg/.png</div>
                        <input type="file" name="cover_img" accept="image/*" id="cover_img_input"
                            class="visually-hidden" data-field="cover_img">
                        <div class="dz-actions">
                            <button type="button" class="btn btn-outline btn-sm" id="dzClear"
                                style="display:none;"><i class="bi bi-x-circle"></i> ลบรูปใหม่</button>
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

                <!-- Course URL + Rating -->
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="label"><i class="bi bi-link-45deg"></i> ลิงก์หน้าคอร์ส</div>
                        <div class="input-icon">
                            <span class="icon"><i class="bi bi-globe2"></i></span>
                            <input type="url" class="form-control" name="course_url"
                                value="{{ old('course_url', $course_url) }}"
                                placeholder="https://example.com/courses/your-course" data-field="course_url">
                        </div>
                        @error('course_url')
                            <div class="text-danger mt-1"><i class="bi bi-exclamation-octagon"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="label"><i class="bi bi-star-half"></i> ให้คะแนน (0–5)</div>
                        <div class="rating-widget" data-rating-widget
                            data-initial="{{ old('avg_rating', $avg_rating ?? 0) }}">
                            <div class="rating-stars" data-stars>
                                <i class="bi fs-5"></i><i class="bi fs-5"></i><i class="bi fs-5"></i><i
                                    class="bi fs-5"></i><i class="bi fs-5"></i>
                                <span class="rating-value ms-2 small text-info" data-value>0.0</span>
                            </div>
                            <input type="range" class="form-range rating-range" data-range min="0"
                                max="5" step="0.5" value="{{ old('avg_rating', $avg_rating ?? 0) }}">
                            <input type="hidden" name="avg_rating" data-hidden
                                value="{{ old('avg_rating', $avg_rating ?? 0) }}">
                            <small class="help d-block mt-1">เลื่อนสไลเดอร์ (ทีละ 0.5)
                                หรือคลิกบริเวณดาวเพื่อเลือกคะแนน</small>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="sticky-summary">
                    <div class="summary-head">
                        <div class="summary-title"><i class="bi bi-clipboard2-check"></i> สรุปสิ่งที่แก้ไข</div>
                        <span id="changeCount" class="badge-count">ยังไม่มีการแก้ไข</span>
                    </div>
                    <div id="changePills" class="change-pills"></div>
                    <div id="changeDetail" class="mt-1"></div>
                </div>

                <!-- Bottom actions -->
                <div class="sticky-actions">
                    <input type="hidden" name="oldImg" value="{{ $cover_img }}">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>
                        บันทึกการเปลี่ยนแปลง</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-danger"><i
                            class="bi bi-arrow-left-short me-1"></i> ยกเลิก</a>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('js_before')
    @include('sweetalert::alert')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('category_id_input');
            const select = document.getElementById('categorySelect');
            const openBtn = document.getElementById('btnEditCategory');
            const applyBtn = document.getElementById('btnApplyCategory');
            const modalEl = document.getElementById('categoryModal');
            const modal = (typeof bootstrap !== 'undefined' && bootstrap.Modal) ?
                new bootstrap.Modal(modalEl) : null;

            openBtn?.addEventListener('click', () => {
                if (input && select) {
                    const cur = (input.value || '').toString();
                    if (cur !== '') select.value = cur;
                }
                modal?.show();
            });

            applyBtn?.addEventListener('click', () => {
                if (input && select) input.value = select.value;
                modal?.hide();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editForm');
            if (!form) return;

            /* ---------- change summary state ---------- */
            const pillsWrap = document.getElementById('changePills');
            const changeCount = document.getElementById('changeCount');
            const changeDetail = document.getElementById('changeDetail');
            const pills = {};
            let dirty = false;

            const labelOf = (key) => ({
                title: 'ชื่อคอร์ส',
                category_id: 'หมวดหมู่',
                provider: 'ผู้ให้บริการ',
                provider_instructor: 'ผู้สอน',
                level: 'ระดับ',
                language: 'ภาษา',
                price_type: 'รูปแบบราคา',
                price: 'ราคา',
                duration_text: 'ระยะเวลา',
                description: 'รายละเอียด',
                cover_img: 'รูปปก',
                course_url: 'ลิงก์',
                avg_rating: 'เรตติ้ง'
            })[key] || key;

            function pill(label) {
                const el = document.createElement('div');
                el.className = 'change-pill';
                el.innerHTML = '<i class="bi bi-dot"></i> ' + label;
                return el;
            }

            const esc = (s) => String(s ?? '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [m]));
            const formatCell = (v) => esc(v);

            function renderChangeSummary() {
                const keys = Object.keys(pills);
                changeCount.textContent = keys.length ? `แก้ไข ${keys.length} รายการ` : 'ยังไม่มีการแก้ไข';
                if (!keys.length) {
                    changeDetail.innerHTML = '';
                    return;
                }

                let rows = '';
                keys.forEach(key => {
                    const el = form.querySelector(`[data-field="${key}"]`);
                    const oldVal = original[key] ?? '';
                    let newVal = '';
                    if (el?.type === 'file') {
                        newVal = (el.files && el.files[0]) ? `ไฟล์ใหม่: ${el.files[0].name}` :
                            'เลือกไฟล์ใหม่';
                    } else {
                        newVal = el?.value ?? '';
                    }
                    rows += `
        <tr>
          <th>${labelOf(key)}</th>
          <td class="text-secondary">${formatCell(oldVal)}</td>
          <td>${formatCell(newVal)}</td>
        </tr>`;
                });

                changeDetail.innerHTML = `
      <div class="table-responsive">
        <table class="change-table">
          <thead><tr><th>ฟิลด์</th><th>เดิม</th><th>ใหม่</th></tr></thead>
          <tbody>${rows}</tbody>
        </table>
      </div>`;
            }

            window.markChanged = function(key) {
                if (pills[key]) {
                    renderChangeSummary();
                    return;
                }
                const el = pill(labelOf(key));
                pills[key] = el;
                pillsWrap.appendChild(el);
                dirty = true;
                renderChangeSummary();
            };
            window.unmarkChanged = function(key) {
                if (!pills[key]) return;
                pillsWrap.removeChild(pills[key]);
                delete pills[key];
                dirty = Object.keys(pills).length > 0;
                renderChangeSummary();
            };

            window.addEventListener('beforeunload', function(e) {
                if (!dirty) return;
                e.preventDefault();
                e.returnValue = '';
            });
            form.addEventListener('submit', () => dirty = false);

            [{
                    input: form.querySelector('[name="title"]'),
                    max: 100,
                    label: form.querySelector('[data-for="title"]')
                },
                {
                    input: form.querySelector('[name="description"]'),
                    max: 600,
                    label: form.querySelector('[data-for="description"]')
                }
            ].forEach(function(o) {
                if (!o.input || !o.label) return;
                const render = () => o.label.textContent = (o.input.value || '').length + '/' + o.max;
                render();
                ['input', 'keyup'].forEach(evt => o.input.addEventListener(evt, render));
            });

            /* ---------- price type ---------- */
            const chipsWrap = form.querySelector('#priceTypeChips');
            const hiddenType = form.querySelector('#price_type');
            const priceInput = form.querySelector('#price');
            const priceWrap = form.querySelector('#priceWrap');
            const hiddenPrice = form.querySelector('#price_hidden');

            function updatePriceState() {
                const paid = (hiddenType.value || 'free') === 'paid';
                priceWrap.classList.toggle('is-disabled', !paid);

                if (paid) {
                    priceInput.disabled = false;
                    priceInput.setAttribute('name', 'price');
                    if (hiddenPrice) hiddenPrice.disabled = true;
                } else {
                    priceInput.value = '';
                    priceInput.removeAttribute('name');
                    priceInput.disabled = true;
                    if (hiddenPrice) {
                        hiddenPrice.disabled = false;
                        hiddenPrice.value = '0';
                    }
                }
            }

            function activateChip(chip) {
                chipsWrap.querySelectorAll('.chip').forEach(c => {
                    c.dataset.active = 'false';
                    c.setAttribute('aria-checked', 'false');
                });
                chip.dataset.active = 'true';
                chip.setAttribute('aria-checked', 'true');
                hiddenType.value = chip.dataset.value;
                updatePriceState();
                markChanged('price_type');
                if (chip.dataset.value === 'free') unmarkChanged('price');
            }

            chipsWrap?.addEventListener('click', (e) => {
                const chip = e.target.closest('.chip');
                if (!chip) return;
                activateChip(chip);
            });
            // keyboard support
            chipsWrap?.addEventListener('keydown', (e) => {
                const focus = document.activeElement.closest('.chip');
                if (!focus) return;
                const chips = [...chipsWrap.querySelectorAll('.chip')];
                const idx = chips.indexOf(focus);
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    (chips[idx + 1] || chips[0]).focus();
                }
                if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    (chips[idx - 1] || chips[chips.length - 1]).focus();
                }
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    activateChip(focus);
                }
            });
            updatePriceState();

            /* ---------- dropzone ---------- */
            const dz = form.querySelector('#dropzone');
            const dzPick = form.querySelector('#dzPick');
            const dzClear = form.querySelector('#dzClear');
            const fileIn = form.querySelector('#cover_img_input');
            const prevWrap = form.querySelector('#cover_preview_wrap');
            const prevImg = form.querySelector('#cover_preview');

            function showPreview(file) {
                if (!file) return;
                const url = URL.createObjectURL(file);
                prevImg.src = url;
                prevWrap.style.display = 'block';
                dzClear.style.display = 'inline-flex';
                markChanged('cover_img');
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
                unmarkChanged('cover_img');
            });

            /* ---------- rating (0–5, step 0.5) ---------- */
            form.querySelectorAll('[data-rating-widget]').forEach(function(widget) {
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

                function setRating(v, opts) {
                    const val = clampHalf(v);
                    if (range) range.value = val;
                    if (hidden) hidden.value = val;
                    renderStars(val);
                    if (!opts || !opts.silent) markChanged('avg_rating');
                }

                const init = widget.getAttribute('data-initial') ?? hidden?.value ?? range?.value ?? 0;
                requestAnimationFrame(() => setRating(init, {
                    silent: true
                }));

                range?.addEventListener('input', e => setRating(e.target.value));
                range?.addEventListener('change', e => setRating(e.target.value));

                const pick = (clientX) => {
                    const rect = starsWrap.getBoundingClientRect();
                    const ratio = Math.min(1, Math.max(0, (clientX - rect.left) / rect.width));
                    setRating(ratio * 5);
                };
                starsWrap?.addEventListener('click', e => pick(e.clientX));
                starsWrap?.addEventListener('pointerdown', e => pick(e.clientX)); // รองรับ touch/pointer
            });

            /* ---------- originals & change tracking ---------- */
            const original = {};
            form.querySelectorAll('[data-field]').forEach(el => {
                const key = el.getAttribute('data-field');
                original[key] = (el.type === 'file') ? '' : (el.value || '');
            });
            form.querySelectorAll('[data-field]').forEach(el => {
                const key = el.getAttribute('data-field');
                const handler = () => {
                    const cur = (el.type === 'file') ? '' : (el.value || '');
                    if (cur != original[key]) markChanged(key);
                    else unmarkChanged(key);
                };
                ['change', 'input'].forEach(evt => el.addEventListener(evt, handler));
            });

        });

        window.setCategory = function(id, name) {
            document.getElementById('category_display').value =
                (name && String(name).trim()) ? `${id} - ${name}` : String(id);
            document.getElementById('category_id_input').value = id;
        };
    </script>
@endsection
