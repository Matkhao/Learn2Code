@extends('layouts.backend')

@section('css_before')
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/courses/courses.list.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
@endsection

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;

        $sort = request()->query('sort', 'id_asc');
        $isId = Str::startsWith($sort, 'id_');
        $isPrice = Str::startsWith($sort, 'price_');

        function sortUrl($key)
        {
            return request()->fullUrlWithQuery(['sort' => $key, 'page' => null]);
        }
    @endphp

    <div class="page-head">
        <h3><i class="bi bi-journal-code" aria-hidden="true"></i> จัดการคอร์สเรียน</h3>
        <a href="{{ route('admin.courses.adding') }}" class="btn btn-primary btn-sm" aria-label="เพิ่มคอร์สเรียน">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> เพิ่มคอร์สเรียน
        </a>
    </div>

    <div class="glass-wrap">
        <div class="table-responsive">
            <table class="table table-darkish table-hover align-middle" id="courseTable">
                <thead>
                    <tr>
                        <th class="text-center" width="15%">
                            ลำดับ.
                            <a class="th-sort {{ $isId ? 'is-active' : '' }}"
                                href="{{ sortUrl($sort === 'id_desc' ? 'id_asc' : 'id_desc') }}"
                                title="สลับเรียงตามลำดับ (ID)" aria-label="สลับเรียงตามลำดับ (ID)">
                                <i class="bi {{ $sort === 'id_desc' ? 'bi-sort-down-alt' : 'bi-sort-up-alt' }}"
                                    aria-hidden="true"></i>
                            </a>
                        </th>
                        <th width="11%" class="hide-sm">หน้าปก</th>
                        <th>ชื่อและรายละเอียดคอร์สเรียน</th>
                        <th class="text-center" width="16%">
                            ราคา
                            <a class="th-sort {{ $isPrice ? 'is-active' : '' }}"
                                href="{{ sortUrl($sort === 'price_desc' ? 'price_asc' : 'price_desc') }}"
                                title="สลับเรียงตามราคา" aria-label="สลับเรียงตามราคา">
                                <i class="bi {{ $sort === 'price_desc' ? 'bi-sort-down-alt' : 'bi-sort-up-alt' }}"
                                    aria-hidden="true"></i>
                            </a>
                        </th>
                        <th class="text-center" width="8%">แก้ไข</th>
                        <th class="text-center" width="8%">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $row)
                        @php
                            $pk = $row->course_id ?? ($row->id ?? 0);
                            $hasImg =
                                !empty($row->cover_img) &&
                                \Illuminate\Support\Facades\Storage::disk('public')->exists($row->cover_img);
                            $imgSrc = $hasImg
                                ? \Illuminate\Support\Facades\Storage::url($row->cover_img)
                                : (file_exists(public_path('images/placeholder.png'))
                                    ? asset('images/placeholder.png')
                                    : 'https://via.placeholder.com/640x360?text=No+Image');

                            $categoryName = optional($row->category)->name;
                            $level = $row->level ?? null;
                            $duration = $row->duration_text ?? ($row->duration ?? null);
                            $lang = $row->language ?? '-';
                            $priceType = $row->price_type ?? 'free';
                            $priceVal = $row->price ?? 0;
                            $provider = $row->provider ?? '-';
                            $teacher = $row->provider_instructor ?? '-';
                            $url = $row->course_url ?? null;

                            $tz = 'Asia/Bangkok';
                            $useBuddhistYear = true;
                            $fmtTH = function ($dt) use ($tz, $useBuddhistYear) {
                                if (!$dt) {
                                    return null;
                                }
                                $c = Carbon::parse($dt)->timezone($tz);
                                $year = (int) $c->format('Y') + ($useBuddhistYear ? 543 : 0);
                                return $c->format('d/m/') . $year . ' ' . $c->format('H:i') . ' น.';
                            };
                            $created = $fmtTH($row->created_at ?? null);
                            $updated = $fmtTH($row->updated_at ?? null);
                        @endphp

                        <tr tabindex="0" data-id="{{ $pk }}" data-title="{{ $row->title }}"
                            data-description="{{ str_replace(['"', "\n", "\r"], ['\"', '\n', ''], (string) ($row->description ?? '')) }}"
                            data-img="{{ $imgSrc }}" data-category="{{ optional($row->category)->name }}"
                            data-level="{{ $level }}" data-duration="{{ $duration }}"
                            data-language="{{ $lang }}" data-price-type="{{ $priceType }}"
                            data-price="{{ $priceVal }}" data-provider="{{ $provider }}"
                            data-teacher="{{ $teacher }}" data-url="{{ $url }}"
                            data-created="{{ $created }}" data-updated="{{ $updated }}"
                            aria-label="เปิดรายละเอียดคอร์ส {{ $row->title }}">
                            <td class="text-center fw-bold" data-label="ลำดับ.">{{ $pk }}</td>

                            <td class="pic-cell hide-sm" data-label="หน้าปก">
                                <img src="{{ $imgSrc }}" alt="หน้าปกคอร์ส {{ $row->title }}" loading="lazy">
                            </td>

                            <td data-label="ชื่อและรายละเอียด">
                                <div class="fw-bold">{{ $row->title }}</div>
                                <div class="text-dim small">
                                    {{ \Illuminate\Support\Str::limit((string) $row->description, 140, '…') }}
                                </div>
                                <div class="mt-1 small text-dim">
                                    <i class="bi bi-person-badge me-1" aria-hidden="true"></i>{{ $teacher }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-building me-1" aria-hidden="true"></i>{{ $provider }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-translate me-1" aria-hidden="true"></i>{{ $lang }}
                                </div>
                            </td>

                            <td class="text-center tbl-price" data-label="ราคา">
                                @if ($priceType === 'free')
                                    <span class="price-chip">FREE</span>
                                @else
                                    <span class="price-chip">฿{{ number_format($priceVal, 2) }}</span>
                                @endif
                            </td>

                            <td class="text-center actions" data-label="แก้ไข">
                                <a href="{{ route('admin.courses.edit', $pk) }}" class="btn btn-primary btn-icon btn-sm"
                                    data-no-modal="1" title="แก้ไขคอร์ส {{ $row->title }}"
                                    aria-label="แก้ไขคอร์ส {{ $row->title }}">
                                    <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                </a>
                            </td>

                            <td class="text-center actions" data-label="ลบ">
                                <button type="button" class="btn btn-danger btn-icon btn-sm" data-no-modal="1"
                                    title="ลบคอร์ส {{ $row->title }}" aria-label="ลบคอร์ส {{ $row->title }}"
                                    onclick="deleteConfirm({{ $pk }})">
                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                </button>
                                <form id="delete-form-{{ $pk }}"
                                    action="{{ route('admin.courses.destroy', $pk) }}" method="POST"
                                    style="display:none;">
                                    @csrf @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @php
        $current = $courses->currentPage();
        $last = max(1, $courses->lastPage());
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
        $mkUrl = fn($p) => request()->fullUrlWithQuery(['page' => $p, 'sort' => request('sort')]);
    @endphp

    <nav aria-label="Course pagination" class="mt-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="small text-dim">
            แสดง {{ $courses->firstItem() ?? 0 }}–{{ $courses->lastItem() ?? 0 }} จาก {{ $courses->total() }} รายการ
        </div>
        <ul class="pagination mb-0">
            <li class="page-item {{ $current == 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ $mkUrl(1) }}"
                    aria-label="หน้าแรก">&laquo;</a></li>
            <li class="page-item {{ $current == 1 ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl(max(1, $current - 1)) }}" aria-label="ก่อนหน้า">&lsaquo;</a></li>
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $current ? 'active' : '' }}"><a class="page-link"
                        href="{{ $mkUrl($i) }}" aria-label="หน้า {{ $i }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item {{ $current == $last ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl(min($last, $current + 1)) }}" aria-label="ถัดไป">&rsaquo;</a></li>
            <li class="page-item {{ $current == $last ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl($last) }}" aria-label="หน้าสุดท้าย">&raquo;</a></li>
        </ul>
    </nav>

    <!-- ===== Modal Course Detail ===== -->
    <div class="modal fade modal-glass" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge-chip" id="cm-id">#—</span>
                        <h5 class="modal-title" id="courseModalLabel">Course Title</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <img id="cm-img" class="modal-cover" src="" alt="Course cover">
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge-chip" id="cm-price">FREE</span>
                                <span class="badge-chip" id="cm-level" style="display:none"></span>
                                <span class="badge-chip" id="cm-category" style="display:none"></span>
                                <span class="badge-chip" id="cm-duration" style="display:none"></span>
                            </div>
                            <div class="kv">
                                <div class="key">ผู้สอน</div>
                                <div class="val" id="cm-teacher">-</div>
                                <div class="key">ผู้ให้บริการคอร์ส</div>
                                <div class="val" id="cm-provider">-</div>
                                <div class="key">ภาษา</div>
                                <div class="val" id="cm-language">-</div>
                                <div class="key">สร้าง/อัปเดต</div>
                                <div class="val" id="cm-updated">-</div>
                                <div class="key">ลิงก์</div>
                                <div class="val">
                                    <a href="#" id="cm-url" target="_blank" rel="noopener"
                                        class="text-decoration-none" style="display:none">
                                        <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>ไปยังหน้าคอร์ส
                                    </a>
                                    <span id="cm-url-missing" class="text-dim">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div>
                        <h6 class="mb-2" style="color:#bfe0ff;font-weight:800;">คำอธิบาย</h6>
                        <div id="cm-desc" class="text-break" style="white-space:pre-wrap;"></div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between flex-wrap gap-2">
                    <div class="text-dim small" id="cm-footnote"></div>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-primary" id="cm-edit" style="display:none"><i
                                class="bi bi-pencil-square me-1" aria-hidden="true"></i> แก้ไขคอร์สนี้</a>
                        <button type="button" class="btn btn-danger" id="cm-delete"><i class="bi bi-trash me-1"
                                aria-hidden="true"></i> ลบ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Confirm Delete ===== -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>ยืนยันการลบ
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    ต้องการลบคอร์ส <b id="cd-title">-</b> ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้
                </div>
                <div class="modal-footer d-flex gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-danger" id="cd-confirm">ลบเลย</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteConfirm(id) {
            Swal.fire({
                title: 'แน่ใจหรือไม่?',
                text: "คุณต้องการลบคอร์สนี้จริง ๆ หรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2196f3',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((r) => {
                if (r.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        (function() {
            const table = document.getElementById('courseTable');
            if (!table) return;

            function formatPriceTHB(num) {
                try {
                    const n = Number(num || 0);
                    return n.toLocaleString('th-TH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                } catch (e) {
                    return num;
                }
            }

            function showOrHide(el, val) {
                if (!el) return;
                if (val && String(val).trim() !== '') {
                    el.style.display = '';
                    el.textContent = val;
                } else {
                    el.style.display = 'none';
                    el.textContent = '';
                }
            }

            table.addEventListener('click', function(ev) {
                const target = ev.target;
                if (target.closest('[data-no-modal="1"]')) return;
                const tr = target.closest('tr[data-id]');
                if (!tr) return;
                const d = tr.dataset;

                const modalEl = document.getElementById('courseModal');
                const titleEl = document.getElementById('courseModalLabel');
                const idEl = document.getElementById('cm-id');
                const imgEl = document.getElementById('cm-img');
                const descEl = document.getElementById('cm-desc');
                const priceEl = document.getElementById('cm-price');
                const levelEl = document.getElementById('cm-level');
                const catEl = document.getElementById('cm-category');
                const durEl = document.getElementById('cm-duration');
                const teachEl = document.getElementById('cm-teacher');
                const provEl = document.getElementById('cm-provider');
                const langEl = document.getElementById('cm-language');
                const updEl = document.getElementById('cm-updated');
                const urlA = document.getElementById('cm-url');
                const urlMissing = document.getElementById('cm-url-missing');
                const footEl = document.getElementById('cm-footnote');
                const editBtn = document.getElementById('cm-edit');
                const delBtn = document.getElementById('cm-delete');

                titleEl.textContent = d.title || '—';
                idEl.textContent = `#${d.id || '-'}`;
                imgEl.src = d.img || '';
                imgEl.alt = d.title || 'Course cover';
                descEl.textContent = d.description || '-';

                if ((d.priceType || 'free') === 'free') {
                    priceEl.textContent = 'FREE';
                } else {
                    priceEl.textContent = `฿${formatPriceTHB(d.price)}`;
                }

                showOrHide(levelEl, d.level);
                showOrHide(catEl, d.category);
                showOrHide(durEl, d.duration);

                teachEl.textContent = d.teacher || '-';
                provEl.textContent = d.provider || '-';
                langEl.textContent = d.language || '-';
                updEl.textContent = d.created || d.updated || '-';

                if (d.url && d.url !== 'null' && d.url !== '') {
                    urlA.href = d.url;
                    urlA.style.display = '';
                    urlMissing.style.display = 'none';
                } else {
                    urlA.style.display = 'none';
                    urlMissing.style.display = '';
                }

                if (d.id) {
                    editBtn.href = '{{ url('/admin/courses') }}/' + d.id + '/edit';
                    editBtn.style.display = '';
                } else {
                    editBtn.style.display = 'none';
                }

                footEl.textContent = `กำลังดูรายละเอียดคอร์สหมายเลข ${d.id || '-'} • กด ESC เพื่อปิด`;

                delBtn.onclick = function() {
                    const cdEl = document.getElementById('confirmDeleteModal');
                    document.getElementById('cd-title').textContent = d.title || ('#' + d.id);
                    document.getElementById('cd-confirm').onclick = function() {
                        document.getElementById('delete-form-' + d.id).submit();
                    };
                    new bootstrap.Modal(cdEl).show();
                };

                new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    focus: true
                }).show();
            });

            table.addEventListener('keydown', function(ev) {
                const isEnter = ev.key === 'Enter';
                const isSpace = ev.key === ' ';
                if (!isEnter && !isSpace) return;
                const tr = ev.target.closest('tr[data-id]');
                if (!tr) return;
                ev.preventDefault();
                tr.click();
            });
        })();
    </script>
@endsection
