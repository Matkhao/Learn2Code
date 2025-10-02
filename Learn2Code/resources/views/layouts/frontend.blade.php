<!doctype html>
<html lang="th">
<!-- =========================================================
       Learn2Code - Frontend
       ฟิลด์ที่ใช้งาน : title, category_id, provider, provider_instructor, level,
       language, price_type, price, duration_text, description, cover_img, course_url, avg_rating
       Bootstrap 5.3.5 + Blade helpers
       ========================================================= -->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Learn2Code</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
    rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/layouts/frontend.layouts.css') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">

@yield('css_before')

</head>

<body>

    <!-- =========================================================
     Page Loader
     ========================================================= -->
    <div id="pageLoader" aria-hidden="true">
        <div class="loader-glass">
            <div class="loader-brand">
                <span class="logo">Learn<span>2</span>Code</span>
            </div>
            <div class="loader-ring"></div>
            <div class="loader-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <span id="plBar"></span>
            </div>
            <p class="loader-hint">กำลังเตรียมคอร์สให้คุณ…</p>
            <span class="blob b1"></span>
            <span class="blob b2"></span>
        </div>
    </div>

    <!-- =========================================================
 NAVBAR
========================================================= -->
    <nav class="navbar navbar-expand-lg sticky-top l2c-navbar">
        <div class="container-xxl">
            <a class="navbar-brand" href="/">
                <span class="accent">Learn2Code</span>
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-lg-3 me-auto">
                    <li class="nav-item"><a class="nav-link active text-white" href="#">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="#courses">คอร์สทั้งหมด</a></li>
                    <li class="nav-item"><a class="nav-link" href="#orgs">องค์กร</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bento">แนะนำ/กิจกรรม</a></li>
                </ul>

                <div class="auth-area d-flex gap-2">
                    @php
                        $member = auth('member')->user();
                        $admin = auth('admin')->user();
                        $displayName = $admin->name ?? ($member->name ?? 'บัญชีของฉัน');
                        $isAdmin =
                            $admin !== null ||
                            ($member &&
                                (!empty($member->is_admin) ||
                                    (int) ($member->role_id ?? 0) === 1 ||
                                    (int) ($member->user_id ?? 0) === 1 ||
                                    (method_exists($member, 'isAdmin') ? $member->isAdmin() : false)));
                    @endphp

                    @if ($member || $admin)
                        <div class="dropdown user-dropdown">
                            <button class="btn btn-cta btn-user dropdown-toggle d-flex align-items-center gap-2"
                                type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                <span class="avatar-circle">{{ strtoupper(mb_substr($displayName, 0, 1)) }}</span>
                                <span class="d-none d-sm-inline">{{ $displayName }}</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                                <li class="px-3 py-2 user-card">
                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="avatar-circle">{{ strtoupper(mb_substr($displayName, 0, 1)) }}</span>
                                        <div>
                                            <div class="fw-bold">{{ $displayName }}</div>
                                            @php $email = $admin->email ?? ($member->email ?? null); @endphp
                                            @if ($email)
                                                <small class="text-secondary">{{ $email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <hr class="dropdown-divider my-2">
                                </li>

                                @if ($member)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('favorites.index', [], false) }}">
                                            <i class="bi bi-heart-fill me-2"></i> รายการโปรด
                                        </a>
                                    </li>
                                @endif

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
                    @endif
                </div>
            </div>
        </div>
    </nav>


    <!-- =========================================================
                 HERO
                 ========================================================= -->
    <div class="container-xxl">
        <div class="hero reveal show">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <h1>ก้าวสู่ <span class="brand">อนาคตดิจิทัล</span> ของคุณ</h1>
                    <p class="lead">สร้างสรรค์แอปพลิเคชันและผลงานด้านดิจิทัลด้วยหลักสูตรที่ลงลึกจัดเต็มทั้งศาสตร์
                        และศิลป์จากผู้มีประสบการณ์เชี่ยวชาญด้านเทคโนโลยีตัวจริง</p>

                    <div class="d-flex chip-wrap mt-3">
                        @php
                            $levels = collect($courses)->pluck('level')->filter()->unique()->values();
                            $langs = collect($courses)->pluck('language')->filter()->unique()->values();
                            $providers = collect($courses)->pluck('provider')->filter()->unique()->take(6)->values();
                        @endphp
                        @foreach ($levels as $lv)
                            <a class="chip" href="{{ request()->fullUrlWithQuery(['level' => $lv]) }}">
                                <span class="dot"></span> ระดับ : {{ strtoupper($lv) }}
                            </a>
                        @endforeach
                        @foreach ($langs as $lg)
                            <a class="chip" href="{{ request()->fullUrlWithQuery(['language' => $lg]) }}">
                                <span class="dot" style="background:var(--purple)"></span> ภาษา :
                                {{ strtoupper($lg) }}
                            </a>
                        @endforeach
                        @foreach ($providers as $pv)
                            <a class="chip" href="{{ request()->fullUrlWithQuery(['provider' => $pv]) }}">
                                <span class="dot" style="background:var(--orange)"></span> {{ $pv }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="course-card text-center tilt">
                        <div class="fw-bold text-white mb-1">▶ วิดีโอแนะนำ</div>
                        <div class="text-secondary small">สำหรับผู้เริ่มต้น</div>
                        <div class="ratio ratio-16x9 rounded-12 overflow-hidden mt-3 video-light"
                            data-yt="ImpzH9Ui0pI">
                            <button class="yt-play" type="button" aria-label="Play video">
                                <svg class="yt-icon" width="36" height="36" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path d="M8 5v14l11-7z" fill="currentColor" />
                                </svg>
                            </button>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="#courses" class="btn btn-cta btn-sm">ดูคอร์สทั้งหมด</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================
     ORGANIZATIONS
     ========================================================= -->
    <div class="container-xxl mt-4" id="orgs">
        <div class="orgs reveal">
            <div class="text-center mb-3">
                <h3>ส่วนหนึ่งจาก <span style="color:#2096f3"><b>องค์กร</b></span> ชั้นนำที่ไว้วางใจพวกเรา</h3>
                <p class="small-muted">
                    เราพร้อมให้บริการทั้งบุคคลทั่วไปทีมในองค์กรและลูกค้าในรูปแบบองค์กร
                    เพื่อจุดประกายทุกไอเดียในการพัฒนาเทคโนโลยีทั้งด้านการเรียนรู้และบริการประชาสัมพันธ์
                </p>
            </div>

            <div
                class="row row-cols-2 row-cols-sm-3 row-cols-md-5 row-cols-lg-6 g-3 align-items-center justify-content-center">

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/Line.png') }}" alt="LINE DC"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/Microsoft.png') }}" alt="Microsoft"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo logo--mono" src="{{ asset('images/brand/Sony.png') }}" alt="Sony"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/Intel.png') }}" alt="Intel"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo logo--mono" src="{{ asset('images/brand/Nvidia.png') }}" alt="NVIDIA"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/SCG.png') }}" alt="SCG"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/Toyota.png') }}" alt="Toyota"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/ttb.png') }}" alt="ttb"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/bangchak.png') }}" alt="Bangchak"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/paolo.png') }}" alt="Paolo"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/sc_asset.png') }}" alt="SC ASSET"
                            loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="col">
                    <div class="logo-wrap">
                        <img class="org-logo" src="{{ asset('images/brand/egat.png') }}" alt="EGAT"
                            loading="lazy" decoding="async">
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- =========================================================
                 FILTERS / SORT / SEARCH
                 ========================================================= -->
    <div class="container-xxl mt-4">
        <form method="GET" action="/" class="filter-bar reveal">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label small-muted">ค้นหาคีย์เวิร์ด</label>
                    <input type="text" name="q" class="form-control" placeholder="เช่น Laravel, UX, React"
                        value="{{ request('q') }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small-muted">ระดับ</label>
                    <select name="level" class="form-select">
                        <option value="">ทั้งหมด</option>
                        <option value="beginner" {{ request('level') === 'beginner' ? 'selected' : '' }}>Beginner
                        </option>
                        <option value="intermediate" {{ request('level') === 'intermediate' ? 'selected' : '' }}>
                            Intermediate</option>
                        <option value="advanced" {{ request('level') === 'advanced' ? 'selected' : '' }}>Advanced
                        </option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small-muted">ภาษา</label>
                    <select name="language" class="form-select">
                        <option value="">ทั้งหมด</option>
                        <option value="TH" {{ request('language') === 'TH' ? 'selected' : '' }}>Thai</option>
                        <option value="EN" {{ request('language') === 'EN' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small-muted">ประเภท</label>
                    <select name="price_type" class="form-select">
                        <option value="">ทั้งหมด</option>
                        <option value="free" {{ request('price_type') === 'free' ? 'selected' : '' }}>Free</option>
                        <option value="paid" {{ request('price_type') === 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    @php $sort = request('sort', 'latest'); @endphp
                    <label class="form-label small-muted">จัดเรียง</label>
                    <select name="sort" class="form-select">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>ใหม่ล่าสุด</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>ราคาต่ำ → สูง</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>ราคาสูง → ต่ำ
                        </option>
                        <option value="rating_desc" {{ $sort === 'rating_desc' ? 'selected' : '' }}>เรตติ้งสูงสุด
                        </option>
                    </select>
                </div>
                <div class="col-12 col-md-auto mt-2">
                    <button class="btn btn-filter w-100"><i class="bi bi-funnel-fill me-1"></i> ค้นหา</button>
                </div>
                <div class="col-12 col-md-auto">
                    <a href="{{ url('/') }}" class="btn btn-outline-light w-100">ล้างตัวกรอง</a>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================
                 SECTION HEAD
                 ========================================================= -->
    <div class="container-xxl my-3" id="courses">
        <div class="section-head reveal">
            @php
                $totalCourses =
                    $courses instanceof \Illuminate\Pagination\LengthAwarePaginator
                        ? $courses->total()
                        : count($courses ?? []);
                $shown =
                    $courses instanceof \Illuminate\Pagination\LengthAwarePaginator
                        ? $courses->count()
                        : count($courses ?? []);
            @endphp
            <div class="section-eyebrow mt-1">🚀 หลักสูตรที่แนะนำ</div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="mt-1">
                    <div class="section-title">
                        <h2><b>หลักสูตรทั้งหมด</b></h2>
                    </div>
                    <p class="section-sub">แสดงผล {{ $shown }} / {{ $totalCourses }} คอร์ส ตามเงื่อนไขปัจจุบัน
                    </p>
                </div>
                <div class="text-end small-muted">
                    @if (request()->hasAny(['q', 'level', 'language', 'price_type', 'sort']))
                        <span class="badge badge-xl text-bg-dark">Filtered</span>
                    @else
                        <span class="badge badge-xl text-bg-secondary">All</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================
                 COURSE GRID
                 ========================================================= -->
    <div class="container-xxl">
        <div class="row row-cols-1 row-cols-md-4 g-3 reveal">
            @isset($courses)
                @forelse($courses as $course)
                    @php
                        $img = $course->cover_img;
                        $hasImg = !empty($img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img);
                        $imgSrc = $hasImg
                            ? \Illuminate\Support\Facades\Storage::url($img)
                            : (file_exists(public_path('images/placeholder.png'))
                                ? asset('images/placeholder.png')
                                : 'https://via.placeholder.com/560x315?text=No+Image');
                        $isFree = ($course->price_type ?? 'free') === 'free';
                        $priceText = $isFree ? 'FREE' : '฿' . number_format($course->price ?? 0, 2);
                        $levelText = strtoupper($course->level ?? 'beginner');
                        $langText = strtoupper($course->language ?? 'TH');
                        $rating = max(
                            0,
                            min(is_numeric($course->avg_rating ?? null) ? floatval($course->avg_rating) : 0.0, 5),
                        );
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                    @endphp
                    <div class="col">
                        <div class="course-card h-100 tilt">
                            @if ($isFree)
                                <div class="ribbon">FREE</div>
                            @endif
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="course-icon">C</div>
                                <span class="text-secondary small">ระดับ {{ $levelText }}</span>
                                <span class="text-secondary small">| ภาษา {{ $langText }}</span>
                            </div>

                            <img src="{{ $imgSrc }}" alt="{{ $course->title }}" class="thumb" loading="lazy"
                                width="560" height="315">
                            <h3 class="track-title mt-3">{{ $course->title }}</h3>

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="rating" title="เรตติ้ง {{ number_format($rating, 1) }}/5">
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <span class="star"></span>
                                    @endfor
                                    @if ($halfStar)
                                        <span class="star"
                                            style="background:linear-gradient(90deg,#ffd166 50%,rgba(255,255,255,.15) 50%);"></span>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <span class="star" style="background:rgba(255,255,255,.15)"></span>
                                    @endfor
                                    <span class="small ms-1">{{ number_format($rating, 1) }}</span>
                                </div>
                                <span class="badge-soft">หมวด #{{ $course->category_id }}</span>
                            </div>

                            <p class="course-desc mb-3">
                                {{ \Illuminate\Support\Str::limit($course->description, 124, '...') }}</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge-soft">{{ $isFree ? 'ฟรี' : 'มีค่าใช้จ่าย' }}</span>
                                <span class="price">{{ $priceText }}</span>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-sm btn-primary flex-fill rounded-12" type="button"
                                    data-bs-toggle="modal" data-bs-target="#confirmDetailsModal"
                                    data-id="{{ $course->course_id }}" data-title="{{ $course->title }}">
                                    ดูข้อมูลเพิ่มเติม
                                </button>
                                <button class="btn btn-sm btn-outline-light rounded-12" data-bs-toggle="modal"
                                    data-bs-target="#previewModal" data-title="{{ $course->title }}"
                                    data-provider="{{ $course->provider }}"
                                    data-instructor="{{ $course->provider_instructor }}"
                                    data-desc="{{ strip_tags($course->description) }}" data-img="{{ $imgSrc }}"
                                    data-level="{{ $levelText }}" data-language="{{ $langText }}"
                                    data-price="{{ $priceText }}" data-duration="{{ $course->duration_text }}"
                                    data-rating="{{ number_format($rating, 1) }}">
                                    พรีวิว
                                </button>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-2 small-muted">
                                <span>โดย : {{ $course->provider ?? 'ไม่ระบุ' }}</span>
                                <span>ระยะเวลา : {{ $course->duration_text ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">ยังไม่มีข้อมูลคอร์สตามเงื่อนไขที่เลือก</div>
                    </div>
                @endforelse
            @else
                <div class="col-12">
                    <div class="alert alert-info">ยังไม่มีข้อมูลคอร์ส</div>
                </div>
            @endisset
        </div>

        <div class="mt-4 d-flex justify-content-center reveal">
            {{ $courses->withQueryString()->links() }}
        </div>
    </div>

    <!-- =========================================================
     BENTO SECTION
     ========================================================= -->
    <section class="container-xxl bento" id="bento">
        <div class="section-head reveal">
            <div class="section-eyebrow">✨ กิจกรรมเพื่มเติม</div>
            <div class="section-title"><b>Bento Highlights</b></div>
            <p class="section-sub">
                รวมเนื้อหาน่าเรียนกิจกรรมและคำแนะนำสั้นๆ ที่ช่วยให้คุณเก่งขึ้นวันละนิดอัปเดตทุกสัปดาห์
            </p>
        </div>

        <div class="bento-grid reveal">
            <!-- A -->
            <div class="bento-item bento-a soft-glow">
                <span class="bento-badge">เริ่มต้นสาย Dev</span>
                <h4 class="bento-title mt-2">Roadmap สำหรับผู้เริ่มต้น</h4>
                <p class="bento-sub mb-2">
                    เริ่มจากศูนย์ก็ไปได้ เลือกเส้นทาง <b>Frontend / Backend / Data / Mobile</b>
                    พร้อมลิสต์คอร์สเรียงตามลำดับที่ควรเรียน ช่วยวางแผนได้เป็นขั้นเป็นตอน
                </p>
                <img src="{{ asset('images/Assets/raodmap.jpg') }}" alt="roadmap" loading="lazy" decoding="async"
                    class="img-fluid rounded-4" />
            </div>

            <!-- B -->
            <div class="bento-item bento-b">
                <span class="bento-badge">ฟรี</span>
                <h5 class="bento-title mt-2">Workshop เสาร์นี้</h5>
                <p class="bento-sub mb-0">
                    ทำเว็บ <b>Portfolio</b> ให้ดูโปรภายใน 2 ชั่วโมงแบบออนไลน์เข้าได้ทุกระดับ
                </p>
            </div>

            <!-- C -->
            <div class="bento-item bento-c">
                <span class="bento-badge">แนะนำ</span>
                <h5 class="bento-title mt-2">Git ที่ใช้จริงในงาน</h5>
                <p class="bento-sub mb-0">
                    เข้าใจเวิร์กโฟลว์ทีม Branch strategy, Pull Request และแนวทางเขียน Commit message ที่อ่านง่าย
                </p>
            </div>

            <!-- D -->
            <div class="bento-item bento-d">
                <span class="bento-badge">อัปเดต</span>
                <h5 class="bento-title mt-2">JavaScript 2025</h5>
                <p class="bento-sub mb-0">
                    สรุปฟีเจอร์ใหม่ที่น่าใช้พร้อมตัวอย่างโค้ดสั้นๆ ให้ลองตามได้ทันที
                </p>
            </div>

            <!-- E -->
            <div class="bento-item bento-e">
                <span class="bento-badge">ชุมชน</span>
                <h5 class="bento-title mt-2">เข้ากลุ่ม Discord</h5>
                <p class="bento-sub mb-0">
                    ถาม–ตอบแบบเรียลไทม์แชร์โปรเจกต์และรับโค้ดตัวอย่างจากเพื่อนๆ ในชุมชน
                </p>
            </div>

            <!-- F -->
            <div class="bento-item bento-f soft-glow">
                <span class="bento-badge">แนะนำคอร์ส</span>
                <h4 class="bento-title mt-2">TypeScript สำหรับงานจริง</h4>
                <p class="bento-sub">
                    ปูพื้นให้แน่นแล้วต่อยอดสู่โปรดักชัน
                </p>

                <img class="bento-illus" alt="ตัวอย่างโค้ด TypeScript บนหน้าจอ"
                    src="https://images.unsplash.com/photo-1515879218367-8466d910aaa4?q=80&w=1200&auto=format&fit=crop" />

                <a href="#courses" class="btn btn-outline-light btn-sm cta-bottom-left"
                    aria-label="ดูรายละเอียดคอร์ส TypeScript">
                    ดูรายละเอียด
                </a>
            </div>
        </div>
    </section>


    <!-- =========================================================
                 TESTIMONIALS
                 ========================================================= -->
    <div class="container-xxl my-4">
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="testi-card reveal">
                    <div class="testi-quote">“คอร์สสอนละเอียด เข้าใจง่าย ได้ลงมือทำจริง”</div>
                    <div class="testi-user"><span class="avatar"></span> <span>ภาคิน | นักศึกษา</span></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testi-card reveal">
                    <div class="testi-quote">“คุณภาพคุ้มราคา เอาไปใช้ทำงานจริงได้ทันที”</div>
                    <div class="testi-user"><span class="avatar"></span> <span>มณีรัตน์ | Developer</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================
                 NEWSLETTER
                 ========================================================= -->
    <div class="container-xxl my-4">
        <div class="news-box reveal">
            <h4 class="mb-2">สมัครรับข่าวสาร</h4>
            <p class="text-secondary">รับอัปเดตบทความ เทคนิค และโปรโมชั่นพิเศษก่อนใคร</p>
            <form action="/subscribe" method="post">
                @csrf
                <div class="row g-2">
                    <div class="col-md-8"><input type="email" name="email" class="form-control"
                            placeholder="อีเมลของคุณ" required></div>
                    <div class="col-md-4 d-grid"><button class="btn btn-news">สมัครเลย</button></div>
                </div>
            </form>
        </div>
    </div>

    <!-- =========================================================
                 FOOTER
                 ========================================================= -->
    <div class="container-xxl">
        <div class="footer-top reveal">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <div class="footer-brand">Learn<span>2</span>Code</div>
                    <div class="small text-secondary">เรียนรู้ทักษะดิจิทัลอย่างมั่นใจเราพัฒนาหลักสูตรที่ลงมือทำจริง
                        ให้คุณนำไปใช้ได้ทันที</div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="social">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" aria-label="GitHub"><i class="bi bi-github"></i></a>
                        <a href="#" aria-label="Discord"><i class="bi bi-discord"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2 reveal">
            <div class="col-6 col-md-3">
                <h6 class="text-white">คอร์สยอดนิยม</h6>
                <a class="footer-link" href="#courses">JavaScript</a>
                <a class="footer-link" href="#courses">TypeScript</a>
                <a class="footer-link" href="#courses">Laravel</a>
                <a class="footer-link" href="#courses">SQL</a>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="text-white">หมวดหมู่</h6>
                <a class="footer-link" href="#courses">Frontend</a>
                <a class="footer-link" href="#courses">Backend</a>
                <a class="footer-link" href="#courses">Data</a>
                <a class="footer-link" href="#courses">DevOps</a>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="text-white">ช่วยเหลือ</h6>
                <a class="footer-link" href="#">คำถามที่พบบ่อย</a>
                <a class="footer-link" href="#">วิธีชำระเงิน</a>
                <a class="footer-link" href="#">ติดต่อเรา</a>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="text-white">ติดตามข่าว</h6>
                <div class="d-flex gap-2">
                    <a class="footer-link" href="#orgs"><i class="bi bi-people me-1"></i>องค์กรพาร์ทเนอร์</a>
                </div>
                <div class="mt-2 small">©2025 Learn2Code — All rights reserved.</div>
            </div>
        </div>

    </div>

    <!-- =========================================================
                 PREVIEW MODAL
                 ========================================================= -->
    <div class="modal fade lgx-modal-glass lgx-theme" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title lgx-title" id="pvTitle">ตัวอย่างคอร์ส</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><img id="pvImg" src="" alt="Course cover"
                                class="lgx-cover"></div>
                        <div class="col-md-6">
                            <div class="lgx-subtle mb-1">โดย <span id="pvProvider">-</span> | ผู้สอน <span
                                    id="pvInstructor">-</span></div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <span class="lgx-chip" id="pvLevel">-</span>
                                <span class="lgx-chip" id="pvLang">-</span>
                                <span class="lgx-chip" id="pvPrice">-</span>
                                <span class="lgx-chip" id="pvDuration">-</span>
                            </div>
                            <div class="lgx-subtle">เรตติ้ง : <span id="pvRating">-</span> / 5</div>
                            <div class="lgx-divider"></div>
                            <p id="pvDesc" class="mb-0"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn lgx-btn"
                        data-bs-dismiss="modal">ปิด</button></div>
            </div>
        </div>
    </div>

    <!-- =========================================================
                 CONFIRM DETAILS MODAL
                 ========================================================= -->
    <div class="modal fade lgx-modal-glass lgx-theme" id="confirmDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title lgx-title">ไปหน้ารายละเอียดคอร์ส?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2 lgx-subtle">คุณต้องการเปิดดูรายละเอียดของคอร์สนี้หรือไม่? ระบบจะพาไปยังหน้า
                        <b>รายละเอียดคอร์ส</b> ในแท็บปัจจุบัน
                    </p>
                    <div class="p-2 rounded-12"
                        style="background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.12);">
                        <div class="small text-uppercase" style="letter-spacing:.08em; color:#9fc8ff;">คอร์ส</div>
                        <div class="fw-bold" id="cdCourseTitle">-</div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn lgx-btn" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn lgx-btn-primary" id="cdConfirmBtn">ไปหน้ารายละเอียด</button>
                </div>
            </div>
        </div>
    </div>

    @yield('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <!-- =========================================================
                 PAGE SCRIPTS
                 ========================================================= -->
    <script>
        // ===== Page Loader =====
        (function() {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;
            const onlyFirstTime = true;
            if (onlyFirstTime && sessionStorage.getItem('l2cHomeLoaded') === '1') {
                loader.remove();
                return;
            }
            document.body.classList.add('no-scroll');
            const bar = document.getElementById('plBar');
            let p = 0;
            const tick = () => {
                p = Math.min(p + (Math.random() * 14 + 6), 92);
                bar.style.transform = 'scaleX(' + (p / 100) + ')';
            };
            const interval = setInterval(tick, 180);
            const MIN_TIME = 800;
            const started = Date.now();

            function finish() {
                const remaining = Math.max(0, MIN_TIME - (Date.now() - started));
                setTimeout(() => {
                    clearInterval(interval);
                    p = 100;
                    bar.style.transform = 'scaleX(1)';
                    loader.style.transition = 'opacity .45s ease, visibility .45s ease';
                    loader.style.opacity = '0';
                    loader.style.visibility = 'hidden';
                    setTimeout(() => {
                        loader.remove();
                        document.body.classList.remove('no-scroll');
                        sessionStorage.setItem('l2cHomeLoaded', '1');
                    }, 480);
                }, remaining);
            }
            window.addEventListener('load', finish, {
                once: true
            });
            setTimeout(() => {
                if (document.readyState === 'complete') finish();
            }, 1200);
        })();

        // ===== Reveal on scroll =====
        (function() {
            const els = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window) || els.length === 0) {
                els.forEach(e => e.classList.add('show'));
                return;
            }
            const io = new IntersectionObserver((entries) => entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('show');
                    io.unobserve(e.target);
                }
            }), {
                threshold: .12
            });
            els.forEach(el => io.observe(el));
        })();

        // ===== YouTube light overlay =====
        let ytOverlayOpen = false;
        document.querySelectorAll('.video-light').forEach(box => {
            const id = (box.dataset.yt || '').trim();
            if (!id) return;
            box.style.backgroundImage = `url(https://i.ytimg.com/vi/${id}/hqdefault.jpg)`;
            const playBtn = box.querySelector('.yt-play');
            if (!playBtn) return;
            playBtn.addEventListener('keydown', (e) => {
                if ((e.code === 'Space' || e.key === ' ') && e.repeat) e.preventDefault();
            });
            playBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                openYTOverlay(id);
            });
        });

        function openYTOverlay(id) {
            if (ytOverlayOpen || document.querySelector('.yt-overlay')) return;
            ytOverlayOpen = true;
            const overlay = document.createElement('div');
            overlay.className = 'yt-overlay';
            overlay.innerHTML = `
    <div class="yt-dialog" role="dialog" aria-modal="true" aria-label="Video player">
      <button class="yt-close" aria-label="Close video">
        <svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
      <iframe src="https://www.youtube-nocookie.com/embed/${id}?autoplay=1&rel=0&modestbranding=1"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen loading="lazy"></iframe>
    </div>`;
            document.body.appendChild(overlay);
            const prevOverflow = document.documentElement.style.overflow;
            document.documentElement.style.overflow = 'hidden';
            document.body.classList.add('yt-overlay-open');

            function close() {
                overlay.remove();
                document.documentElement.style.overflow = prevOverflow || '';
                document.body.classList.remove('yt-overlay-open');
                document.removeEventListener('keydown', onEsc, true);
                document.removeEventListener('keydown', swallowSpace, true);
                ytOverlayOpen = false;
            }

            function onEsc(e) {
                if (e.key === 'Escape') close();
            }

            function swallowSpace(e) {
                if ((e.code === 'Space' || e.key === ' ') && ytOverlayOpen) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) close();
            });
            overlay.querySelector('.yt-close').addEventListener('click', close);
            document.addEventListener('keydown', onEsc, true);
            document.addEventListener('keydown', swallowSpace, true);
            overlay.querySelector('.yt-close').focus();
        }

        // ===== Preview modal fill =====
        (function() {
            const pv = document.getElementById('previewModal');
            if (pv) {
                pv.addEventListener('show.bs.modal', function(event) {
                    const btn = event.relatedTarget;
                    if (!btn) return;
                    const title = btn.getAttribute('data-title') || '-';
                    const img = btn.getAttribute('data-img') || '';
                    const provider = btn.getAttribute('data-provider') || '-';
                    const instructor = btn.getAttribute('data-instructor') || '-';
                    const desc = btn.getAttribute('data-desc') || '-';
                    const level = btn.getAttribute('data-level') || '-';
                    const language = btn.getAttribute('data-language') || '-';
                    const price = btn.getAttribute('data-price') || '-';
                    const duration = btn.getAttribute('data-duration') || '-';
                    const rating = btn.getAttribute('data-rating') || '-';
                    pv.querySelector('#pvTitle').textContent = title;
                    pv.querySelector('#pvImg').src = img;
                    pv.querySelector('#pvProvider').textContent = provider || '-';
                    pv.querySelector('#pvInstructor').textContent = instructor || '-';
                    pv.querySelector('#pvDesc').textContent = desc || '-';
                    pv.querySelector('#pvLevel').textContent = 'ระดับ : ' + (level || '-');
                    pv.querySelector('#pvLang').textContent = 'ภาษา : ' + (language || '-');
                    pv.querySelector('#pvPrice').textContent = price || '-';
                    pv.querySelector('#pvDuration').textContent = 'เวลา : ' + (duration || '-');
                    pv.querySelector('#pvRating').textContent = rating || '-';
                });
            }

            // ===== confirm go details =====
            const detModal = document.getElementById('confirmDetailsModal');
            let goId = '';
            if (detModal) {
                detModal.addEventListener('show.bs.modal', function(event) {
                    const btn = event.relatedTarget;
                    goId = btn?.getAttribute('data-id') || '';
                    const title = btn?.getAttribute('data-title') || '-';
                    this.querySelector('#cdCourseTitle').textContent = title;
                });
                detModal.querySelector('#cdConfirmBtn')?.addEventListener('click', function() {
                    if (goId) {
                        const url = "{{ route('courses.detail', ':id') }}".replace(':id', goId);
                        window.location.href = url;
                    }
                    const inst = bootstrap.Modal.getInstance(detModal);
                    inst && inst.hide();
                });
            }

            // Lazy load fallback
            const lazyImgs = document.querySelectorAll('img[loading="lazy"]');
            if ('loading' in HTMLImageElement.prototype === false) {
                lazyImgs.forEach(img => {
                    const src = img.getAttribute('src');
                    if (src) {
                        const t = new Image();
                        t.onload = () => {
                            img.src = src;
                        };
                        t.src = src;
                    }
                });
            }
        })();
    </script>

    @yield('js_before')
</body>

</html>
