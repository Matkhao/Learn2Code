@extends('layouts.backend')

@section('css_before')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/admin/admin.list.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
@endsection

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;
        $sort = request()->query('sort', 'id_asc');
        $isId = Str::startsWith($sort, 'id_');
        $isUpdated = Str::startsWith($sort, 'updated_');
        $sortUrl = function ($key) {
            return request()->fullUrlWithQuery(['sort' => $key, 'page' => null]);
        };
        $q = trim((string) request('q'));
    @endphp

    <div class="page-head">
        <h3><i class="bi bi-person-add me-2"></i> จัดการผู้ดูแลระบบ</h3>
        <div class="d-flex align-items-center gap-2">
            <form method="get" action="{{ url()->current() }}">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" value="{{ $q }}" class="search-input"
                        placeholder="ค้นหาชื่อ / อีเมล...">
                </div>
            </form>

            <a href="{{ route('admin.users.create') }}" class="btn btn-cta">
                <i class="bi bi-plus-circle"></i><span>เพิ่มผู้ดูแลระบบ</span>
            </a>
        </div>
    </div>

    <div class="glass-wrap">
        <div class="table-responsive">
            <table class="table table-darkish table-hover align-middle" id="adminTable">
                <thead>
                    <tr>
                        <th class="text-center" width="15%">ลำดับ
                            <a class="{{ $isId ? 'th-sort is-active' : 'th-sort' }}"
                                href="{{ $sort === 'id_desc' ? $sortUrl('id_asc') : $sortUrl('id_desc') }}">
                                <i class="bi {{ $sort === 'id_desc' ? 'bi-sort-down-alt' : 'bi-sort-up-alt' }}"></i>
                            </a>
                        </th>
                        <th width="11%" class="hide-sm">โปรไฟล์</th>
                        <th>ชื่อและรายละเอียดผู้ดูแล</th>
                        <th class="text-center" width="14%">สิทธิ์</th>
                        <th class="text-center hide-sm" width="16%">อัปเดตล่าสุด
                            <a class="{{ $isUpdated ? 'th-sort is-active' : 'th-sort' }}"
                                href="{{ $sort === 'updated_desc' ? $sortUrl('updated_asc') : $sortUrl('updated_desc') }}">
                                <i class="bi {{ $sort === 'updated_desc' ? 'bi-sort-down-alt' : 'bi-sort-up-alt' }}"></i>
                            </a>
                        </th>
                        <th class="text-center col-action">แก้ไข</th>
                        <th class="text-center col-action">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $i => $a)
                        @php
                            $pk = $a->user_id ?? ($a->id ?? $i + 1);
                            $avatar = $a->avatar_url ?? null;
                            $roleName = $a->role_name ?? 'Admin';
                            $updatedAt =
                                $a->updated_at instanceof \Illuminate\Support\Carbon
                                    ? $a->updated_at
                                    : ($a->updated_at
                                        ? Carbon::parse($a->updated_at)
                                        : null);
                            $updatedText = $updatedAt ? $updatedAt->diffForHumans() : '—';
                        @endphp
                        <tr data-id="{{ $pk }}">
                            <td class="text-center fw-bold">{{ $pk }}</td>
                            <td class="hide-sm">
                                @if ($avatar)
                                    <img src="{{ $avatar }}" class="avatar" alt="">
                                @else
                                    <div class="avatar-box"><i class="bi bi-person"></i></div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-truncate" title="{{ $a->name }}">{{ $a->name ?: '—' }}</div>
                                <div class="small text-dim text-truncate" title="{{ $a->email }}">{{ $a->email }}
                                </div>
                                <div class="small text-dim mt-1">ID : {{ $pk }}</div>
                            </td>
                            <td class="text-center"><span class="badge-role">{{ $roleName }}</span></td>
                            <td class="text-center hide-sm text-white">{{ $updatedText }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $pk) }}" class="btn btn-icon action-btn edit"
                                    title="แก้ไข">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-icon action-btn delete js-del"
                                    data-id="{{ $pk }}" data-name="{{ $a->name }}" title="ลบ">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-form-{{ $pk }}"
                                    action="{{ route('admin.users.destroy', $pk) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="py-4 text-center text-dim">ยังไม่มีผู้ดูแลระบบ</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @php
        $current = method_exists($admins, 'currentPage') ? $admins->currentPage() : 1;
        $last = method_exists($admins, 'lastPage') ? max(1, $admins->lastPage()) : 1;
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
        $mkUrl = fn($p) => request()->fullUrlWithQuery(['page' => $p, 'sort' => request('sort'), 'q' => $q]);
        $per = method_exists($admins, 'perPage') ? $admins->perPage() : 10;
        $total = method_exists($admins, 'total') ? $admins->total() : $admins->count() ?? 0;
        $first = method_exists($admins, 'firstItem') ? $admins->firstItem() ?? 0 : 0;
        $lastItem = method_exists($admins, 'lastItem') ? $admins->lastItem() ?? 0 : 0;
    @endphp

    <nav class="mt-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="small text-dim">
            แสดง {{ $first }}–{{ $lastItem }} จาก {{ $total }} รายการ ต่อหน้า {{ $per }}
            รายการ
        </div>
        <ul class="pagination mb-0">
            <li class="page-item {{ $current == 1 ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl(1) }}">&laquo;</a></li>
            <li class="page-item {{ $current == 1 ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl(max(1, $current - 1)) }}">&lsaquo;</a></li>
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $current ? 'active' : '' }}"><a class="page-link"
                        href="{{ $mkUrl($i) }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item {{ $current == $last ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl(min($last, $current + 1)) }}">&rsaquo;</a></li>
            <li class="page-item {{ $current == $last ? 'disabled' : '' }}"><a class="page-link"
                    href="{{ $mkUrl($last) }}">&raquo;</a></li>
        </ul>
    </nav>

    <div id="deleteOverlay" class="modal-overlay" aria-hidden="true">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="delTitle">
            <div class="modal-body-swal">
                <div class="swal-ico">
                    <div class="swal-ico-inner"><i class="bi bi-exclamation-lg"></i></div>
                </div>
                <div class="swal-title" id="delTitle">แน่ใจหรือไม่?</div>
                <div class="swal-text" id="delText">คุณต้องการลบผู้ดูแลระบบนี้จริง ๆ หรือไม่</div>
            </div>
            <div class="modal-actions">
                <button id="delConfirm" class="btn-swal-primary" type="button">ใช่, ลบเลย!</button>
                <button class="btn-swal-danger" type="button" data-close>ยกเลิก</button>
            </div>
        </div>
    </div>
@endsection


@section('footer')
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success') || session('ok'))
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') ?? 'บันทึกข้อมูลสำเร็จ' }}',
                confirmButtonColor: '#2196f3',
                confirmButtonText: 'ตกลง',
                background: '#0f1219',
                color: '#e9f1fa'
            });
        @endif

        let pendingDeleteId = null;
        const overlay = document.getElementById('deleteOverlay');
        const delText = document.getElementById('delText');
        const delConfirm = document.getElementById('delConfirm');

        document.querySelectorAll('.js-del').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                pendingDeleteId = btn.dataset.id || null;
                const nm = btn.dataset.name || '';
                delText.textContent = nm ? `คุณต้องการลบผู้ดูแลระบบ ${nm} หรือไม่` :
                    'คุณต้องการลบผู้ดูแลระบบนี้จริง ๆ หรือไม่';
                overlay.classList.add('open');
                delConfirm.focus();
            });
        });

        delConfirm.addEventListener('click', () => {
            if (pendingDeleteId) {
                const f = document.getElementById('delete-form-' + pendingDeleteId);
                if (f) {
                    f.submit();
                }
            }
        });

        overlay.addEventListener('click', e => {
            if (e.target === overlay || e.target.hasAttribute('data-close')) {
                overlay.classList.remove('open');
                pendingDeleteId = null;
            }
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && overlay.classList.contains('open')) {
                overlay.classList.remove('open');
                pendingDeleteId = null;
            }
        });

        (function() {
            const table = document.getElementById('adminTable');
            if (!table) return;
            table.addEventListener('click', (e) => {
                const tr = e.target.closest('tr');
                if (!tr) return;
                const isAction = e.target.closest('.action-btn');
                if (isAction) return;
                const idCell = tr.getAttribute('data-id');
                table.querySelectorAll('tbody tr').forEach(x => x.classList.remove('row-selected'));
                tr.classList.add('row-selected');
                if (idCell) {
                    window.location.href = '{{ url('/admin/users') }}' + '/' + idCell + '/edit';
                }
            });
        })();
    </script>
@endsection
