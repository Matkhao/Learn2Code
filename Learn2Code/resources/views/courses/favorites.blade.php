<!doctype html>
<html lang="th">

<head>
    <!-- =========================================================
       Learn2Code - Favorites Page (WITH Navbar) + Image handling with Storage
       ========================================================= -->
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

    <style>
        :root {
            --bg: #0a0c10;
            --panel: #0f1219;
            --glass: rgba(255, 255, 255, .06);
            --border: #1c2230;
            --text: #e9f1fa;
            --muted: #9aa5b4;
            --blue: #2196f3;
            --blue-dark: #1976d2;
            --danger: #e53935;
            --success: #21c17a;
            --radius: 16px;
        }

        html,
        body {
            height: 100%;
        }

        body {
            background: radial-gradient(1200px 1200px at 20% -10%, rgba(33, 150, 243, .18), transparent 60%),
                radial-gradient(900px 900px at 120% 30%, rgba(97, 218, 251, .10), transparent 60%),
                var(--bg);
            color: var(--text);
            font-family: "Noto Sans Thai", system-ui, -apple-system, Segoe UI, Roboto, Arial, "Helvetica Neue", sans-serif;
        }

        /* ===== NAVBAR (glass + dark) ===== */
        .navbar {
            background: rgba(15, 18, 25, .6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .navbar .navbar-brand {
            font-family: "Bebas Neue";
            letter-spacing: .6px;
            font-size: 26px;
            color: #fff;
        }

        .navbar .navbar-brand .accent {
            color: #7cc5ff;
        }

        .navbar .nav-link {
            color: #cfe2ff;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #fff;
        }

        .btn-cta {
            background: linear-gradient(180deg, #2b89ff, #1b6fe0);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 10px;
            padding: .45rem .9rem;
            font-weight: 600;
        }

        .btn-cta:hover {
            filter: brightness(1.05);
        }

        .dropdown-menu {
            background: #0f1219;
            border: 1px solid #1c2230;
            color: #e9f1fa;
            border-radius: 12px;
        }

        .dropdown-item {
            color: #e9f1fa;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, .06);
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, .35);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='3' stroke-linecap='round' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
        }

        .container-nonav {
            padding-top: 18px;
            padding-bottom: 48px;
        }

        .page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 18px 0;
        }

        .btn-back {
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .04);
            color: var(--text);
            border-radius: 10px;
            padding: 10px 14px;
            text-decoration: none;
            backdrop-filter: blur(8px);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, .08);
        }

        .glass-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, .07), rgba(255, 255, 255, .03));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .45);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, .55);
            border-color: #2a3650;
        }

        .cover {
            position: relative;
            aspect-ratio: 16/9;
            background: #10141d;
            overflow: hidden;
        }

        .cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .chip {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            line-height: 1;
            background: rgba(33, 150, 243, .18);
            color: #bfe1ff;
            border: 1px solid rgba(33, 150, 243, .35);
            backdrop-filter: blur(6px);
        }

        .price-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            line-height: 1;
            background: rgba(255, 255, 255, .08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(6px);
        }

        .card-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .title {
            font-family: "Bebas Neue";
            letter-spacing: .4px;
            font-size: clamp(18px, 2vw, 22px);
            line-height: 1;
            margin: 2px 0 4px 0;
            color: #f3f7ff;
            text-transform: uppercase;
        }

        .meta {
            font-size: 13px;
            color: var(--muted);
        }

        .desc {
            font-size: 14px;
            color: #cbd5e1;
            margin-top: 4px;
            min-height: 44px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #c7d9ff;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-glass {
            flex: 1;
            padding: 10px 12px;
            font-weight: 600;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .04);
            color: #eaf2ff;
            text-decoration: none;
            text-align: center;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, .08);
        }

        .btn-danger-soft {
            flex: 1;
            padding: 10px 12px;
            font-weight: 600;
            border-radius: 10px;
            border: 1px solid rgba(229, 57, 53, .35);
            background: rgba(229, 57, 53, .12);
            color: #ffd5d4;
        }

        .btn-danger-soft:hover {
            background: rgba(229, 57, 53, .18);
        }

        .empty {
            border: 1px dashed #2a3650;
            border-radius: var(--radius);
            padding: 30px;
            text-align: center;
            color: var(--muted);
            background: rgba(255, 255, 255, .02);
        }

        .pagination {
            --bs-pagination-bg: transparent;
        }

        .pagination .page-link {
            background: rgba(255, 255, 255, .04);
            border-color: var(--border);
            color: #d7e6ff;
        }

        .pagination .page-link:hover {
            background: rgba(255, 255, 255, .08);
        }

        .page-title {
            font-family: "Bebas Neue";
            font-size: clamp(26px, 3vw, 32px);
            letter-spacing: .6px;
            margin: 0;
        }

        .count-badge {
            font-size: 12px;
            color: #b0c4ff;
            border: 1px solid rgba(176, 196, 255, .28);
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(176, 196, 255, .08);
        }

        /* Mobile tweaks */
        @media (max-width: 575.98px) {
            .container-nonav {
                padding-left: 10px;
                padding-right: 10px;
            }

            .desc {
                -webkit-line-clamp: 3;
            }

            .cover {
                aspect-ratio: 3/2;
            }

            .btn-back {
                display: inline-block;
            }

            /* เผื่ออยากคงปุ่มกลับบนจอเล็ก */
        }

        /* ===== NAVBAR (L2C) ===== */
        .l2c-navbar {
            background: rgba(14, 18, 27, .65);
            backdrop-filter: blur(12px) saturate(120%);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 8px 28px rgba(0, 0, 0, .28);
            transition: background .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .l2c-navbar .navbar-brand {
            font-family: "Bebas Neue", system-ui;
            letter-spacing: .8px;
            font-size: 28px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .l2c-navbar .navbar-brand .accent {
            background: linear-gradient(90deg, #7cc5ff, #6ef2ff, #8cf8c4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(124, 197, 255, .35);
        }

        /* toggler */
        .l2c-navbar .navbar-toggler {
            border-color: rgba(255, 255, 255, .35);
            padding: .45rem .6rem;
            border-radius: 10px;
        }

        .l2c-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='3' stroke-linecap='round' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
        }

        /* collapse bg on mobile */
        @media (max-width: 991.98px) {
            .l2c-navbar .navbar-collapse {
                background: rgba(14, 18, 27, .75);
                border: 1px solid var(--border);
                border-radius: 14px;
                padding: .6rem;
                margin-top: .5rem;
            }
        }

        /* links */
        .l2c-navbar .nav-link {
            --u: linear-gradient(90deg, #7cc5ff, #6ef2ff, #8cf8c4);
            color: #cfe2ff;
            opacity: .9;
            padding: .5rem .75rem;
            margin: 0 .1rem;
            border-radius: 10px;
            position: relative;
            transition: color .15s ease, background .15s ease;
        }

        .l2c-navbar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .06);
        }

        .l2c-navbar .nav-link::after {
            content: "";
            position: absolute;
            left: 12px;
            right: 12px;
            bottom: 6px;
            height: 2px;
            background: var(--u);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .25s ease;
        }

        .l2c-navbar .nav-link:hover::after,
        .l2c-navbar .nav-link.active::after {
            transform: scaleX(1);
        }

        .l2c-navbar .nav-link.active {
            color: #fff;
        }

        /* CTA + outline */
        .l2c-navbar .btn-cta {
            background: linear-gradient(180deg, #2b89ff, #1b6fe0);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 12px;
            padding: .5rem .95rem;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(43, 137, 255, .25);
        }

        .l2c-navbar .btn-cta:hover {
            filter: brightness(1.07);
        }

        .l2c-navbar .btn-outline-light {
            border-color: rgba(255, 255, 255, .35);
            color: #e9f1fa;
            border-radius: 12px;
            padding: .5rem .95rem;
            font-weight: 600;
            background: rgba(255, 255, 255, .03);
        }

        .l2c-navbar .btn-outline-light:hover {
            background: rgba(255, 255, 255, .07);
            color: #fff;
        }

        /* dropdown dark */
        .l2c-navbar .dropdown-menu {
            background: #0f1219;
            border: 1px solid #1c2230;
            border-radius: 14px;
            padding: .4rem;
            min-width: 220px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
        }

        .l2c-navbar .dropdown-item {
            color: #e9f1fa;
            border-radius: 10px;
        }

        .l2c-navbar .dropdown-item:hover {
            background: rgba(255, 255, 255, .07);
        }

        .l2c-navbar .dropdown-divider {
            border-top-color: #1c2230;
        }
    </style>
</head>

<body>

    <!-- =========================================================
     NAVBAR
     ========================================================= -->
    <nav class="navbar navbar-expand-lg sticky-top l2c-navbar">
        <div class="container-xxl">
            <a class="navbar-brand" href="/">
                <span class="accent">Learn2Code
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">หน้าหลัก</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/blog">บทความ</a></li>
                </ul>

                <div class="d-flex gap-2 ms-lg-3">
                    @auth('member')
                        <div class="dropdown">
                            <button class="btn btn-cta dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ auth('member')->user()->name ?? 'บัญชีของฉัน' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('/favorites') }}">รายการโปรด</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('member.logout') }}" method="POST" class="px-3 py-1">
                                        @csrf
                                        <button class="btn btn-link p-0 text-danger">ออกจากระบบ</button>
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
        <!-- Header (คงปุ่มกลับ ถ้าต้องการซ่อนให้ลบได้) -->
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

                        // เวลาเพิ่มรายการโปรด (รองรับ favored_at / faved_at)
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

                        // ===== รูปปก: cover_url (เต็ม) > storage public (cover_img) > public path > placeholder =====
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
