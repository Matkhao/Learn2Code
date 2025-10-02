<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายการโปรด | Learn2Code</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/courses/courses.favorites.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
</head>

<body>

    <!-- =========================================================
     NAVBAR
     ========================================================= -->
    <nav class="navbar navbar-expand-lg sticky-top l2c-navbar">
        <div class="container-xxl">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="accent">Learn2Code</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door d-lg-none me-1"></i> หน้าหลัก
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('favorites') ? 'active' : '' }}"
                            href="{{ url('/favorites') }}">
                            <i class="bi bi-heart-fill d-lg-none me-1"></i> รายการโปรด
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2 ms-lg-3">
                    @auth('member')
                        @php
                            $member = auth('member')->user();
                            $isAdmin =
                                auth('admin')->check() ||
                                ($member &&
                                    ((int) $member->role_id === 1 ||
                                        strtolower(optional($member->role)->code ?? '') === 'admin'));
                            $adminUrl = \Illuminate\Support\Facades\Route::has('admin.dashboard')
                                ? route('admin.dashboard')
                                : url('/admin/dashboard');
                        @endphp

                        <div class="dropdown user-dropdown">
                            <button class="btn btn-cta btn-user dropdown-toggle d-flex align-items-center gap-2 w-100"
                                type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                <span class="avatar-circle">
                                    {{ strtoupper(mb_substr($member->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="d-none d-sm-inline">{{ $member->name ?? 'บัญชีของฉัน' }}</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                                <li class="px-3 py-2 user-card">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="avatar-circle">
                                            {{ strtoupper(mb_substr($member->name ?? 'U', 0, 1)) }}
                                        </span>
                                        <div>
                                            <div class="fw-bold">{{ $member->name }}</div>
                                            @if ($member->email)
                                                <small class="text-secondary">{{ $member->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <hr class="dropdown-divider my-2">
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ url('/favorites') }}">
                                        <i class="bi bi-heart-fill me-2"></i> รายการโปรด
                                    </a>
                                </li>

                                @if ($isAdmin)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard.index', [], false) }}">
                                            <i class="bi bi-speedometer2 me-2"></i> จัดการข้อมูลหลังบ้าน
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider my-2">
                                </li>

                                <li>
                                    <form action="{{ route('member.logout') }}" method="POST" class="px-2 py-1">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> ออกจากระบบ
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('member.login') }}" class="btn btn-outline-light">เข้าสู่ระบบ</a>
                        <a href="{{ route('member.register') }}" class="btn btn-cta">สมัครสมาชิก</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    <div class="container container-nonav">
        <div class="page-head">
            <a href="{{ url('/') }}" class="btn-back d-lg-none">← กลับหน้าหลัก</a>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <h2 class="mb-0"><b>รายการโปรด</b></h2>
                <span class="count-badge">{{ $courses->total() }} รายการ</span>
            </div>
        </div>

        @if ($courses->count() === 0)
            <div class="empty my-4">
                <div class="mb-2" style="font-size:18px;color:#eaf2ff">ยังไม่มีคอร์สที่บันทึกไว้</div>
                <div>กดปุ่มรูปหัวใจที่หน้ารายละเอียดคอร์สเพื่อเพิ่มรายการโปรด</div>
                <div class="mt-3"><a href="{{ url('/') }}" class="btn-glass"
                        style="display:inline-block;min-width:200px;">สำรวจคอร์ส</a></div>
            </div>
        @else
            <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-lg-3">
                @foreach ($courses as $c)
                    @php
                        $cid = $c->id ?? ($c->course_id ?? null);

                        // เวลาเพิ่มรายการโปรด
                        $favAtRaw = $c->favored_at ?? ($c->faved_at ?? null);
                        $favedAt = $favAtRaw
                            ? \Illuminate\Support\Carbon::parse($favAtRaw)
                                    ->timezone('Asia/Bangkok')
                                    ->format('d/m/Y H:i') . ' น.'
                            : '-';

                        // ราคา
                        $isFree = ($c->price_type ?? 'free') === 'free';
                        $priceLabel = $isFree ? 'ฟรี' : (isset($c->price) ? number_format((float) $c->price, 2) : '-');

                        // เรตติ้ง
                        $rating = is_numeric($c->avg_rating ?? null) ? max(0, min((float) $c->avg_rating, 5)) : 0;

                        $coverUrl = $c->cover_url ?? null;
                        $coverImg = $c->cover_img ?? null;
                        $imgSrc = null;

                        if (!empty($coverUrl) && preg_match('/^https?:\\/\\//i', $coverUrl)) {
                            $imgSrc = $coverUrl;
                        } else {
                            $img = $coverImg;
                            if (!empty($img)) {
                                try {
                                    $hasImg = \Illuminate\Support\Facades\Storage::disk('public')->exists($img);
                                } catch (\Throwable $e) {
                                    $hasImg = false;
                                }
                                if ($hasImg) {
                                    $imgSrc = \Illuminate\Support\Facades\Storage::url($img);
                                } else {
                                    $imgSrc = file_exists(public_path($img)) ? asset($img) : null;
                                }
                            }
                            if (empty($imgSrc)) {
                                $imgSrc = file_exists(public_path('images/placeholder.png'))
                                    ? asset('images/placeholder.png')
                                    : 'https://via.placeholder.com/640x360?text=No+Image';
                            }
                        }
                    @endphp

                    <div class="col">
                        <div class="glass-card">
                            <div class="cover">
                                <img src="{{ $imgSrc }}" alt="{{ $c->title }}" loading="lazy"
                                    decoding="async">
                                <span class="chip">{{ $c->provider ?? 'Learn2Code' }}</span>
                                <span class="price-badge">{{ $priceLabel }}</span>
                            </div>
                            <div class="card-body">
                                <div class="title" title="{{ $c->title }}">
                                    {{ \Illuminate\Support\Str::limit($c->title, 70) }}</div>
                                <div class="meta">
                                    ผู้สอน: {{ $c->provider_instructor ?? '-' }} · ระดับ: {{ $c->level ?? '-' }} ·
                                    ภาษา: {{ $c->language ?? '-' }}
                                </div>
                                <div class="rating">
                                    ★ {{ number_format($rating, 1) }}
                                    <span class="text-muted">·</span>
                                    <span>เพิ่มเมื่อ {{ $favedAt }}</span>
                                </div>
                                <div class="desc">{{ \Illuminate\Support\Str::limit($c->description ?? '-', 110) }}
                                </div>
                                <div class="actions">
                                    <a class="btn-glass" href="{{ route('courses.detail', $cid) }}">ดูรายละเอียด</a>

                                    <!-- ปุ่มเปิด Modal ยืนยันการลบ -->
                                    <button type="button" class="btn btn-danger-soft w-100" data-bs-toggle="modal"
                                        data-bs-target="#confirmRemove-{{ $cid }}">
                                        ลบออก
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal ยืนยันการลบ -->
                    <div class="modal fade" id="confirmRemove-{{ $cid }}" tabindex="-1"
                        aria-labelledby="confirmRemoveLabel-{{ $cid }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content"
                                style="background:#0f1219;border:1px solid #1c2230;color:#e9f1fa;border-radius:16px;">
                                <div class="modal-header" style="border-bottom-color:#1c2230;">
                                    <h5 class="modal-title" id="confirmRemoveLabel-{{ $cid }}">
                                        ลบออกจากรายการโปรด</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" style="filter:invert(1);"></button>
                                </div>
                                <div class="modal-body">
                                    ต้องการลบ <strong>{{ $c->title }}</strong> ออกจากรายการโปรดใช่ไหม?
                                </div>
                                <div class="modal-footer" style="border-top-color:#1c2230;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        style="background:rgba(255,255,255,.06);border-color:#1c2230;">ยกเลิก</button>
                                    <form method="POST" action="{{ route('courses.favorite', $cid) }}">
                                        @csrf
                                        <button type="submit" class="btn"
                                            style="background:rgba(229,57,53,.18);border:1px solid rgba(229,57,53,.35);color:#ffd5d4;">ลบออก</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $courses->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
