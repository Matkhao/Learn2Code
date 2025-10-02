<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title ?? 'Course Details' }} | Learn2Code</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
    @php
        use Illuminate\Support\Facades\Route;
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Facades\DB;

        $imgPath = $course->cover_img ?? '';
        $imageUrl = isset($imageUrl)
            ? $imageUrl
            : ($imgPath && Storage::disk('public')->exists($imgPath)
                ? Storage::url($imgPath)
                : (file_exists(public_path('images/placeholder.png'))
                    ? asset('images/placeholder.png')
                    : 'https://via.placeholder.com/1200x630?text=No+Image'));

        $categoryName = $categoryName ?? 'หมวดหมู่ #' . ($course->category_id ?? '-');
        $rating = round((float) ($course->avg_rating ?? 0), 1);
        $isFree = ($course->price_type ?? 'free') === 'free';

        $authUser = auth('member')->user() ?: auth()->user() ?: auth('admin')->user();
        $AUTH_CHECK = !is_null($authUser);

        // สถานะ favorite
        $isFavorited = isset($isFavorited)
            ? (bool) $isFavorited
            : ($AUTH_CHECK
                ? (method_exists($course, 'isFavoritedBy')
                    ? (bool) $course->isFavoritedBy($authUser)
                    : DB::table('tbl_favorites')
                        ->where([
                            'user_id' => $authUser->user_id ?? $authUser->id,
                            'course_id' => $course->course_id,
                        ])
                        ->exists())
                : false);

        $myRating = (int) old('rating', isset($myReview) ? optional($myReview)->rating ?? 3 : 3);
        $myComment = old('comment', isset($myReview) ? optional($myReview)->comment ?? '' : '');

        $loginUrl = Route::has('member.login')
            ? route('member.login')
            : (Route::has('login')
                ? route('login')
                : url('/login'));
    @endphp

    <style>
        :root {
            --bg: #0a0c10;
            --panel: #11151c;
            --panel-2: #0d1117;
            --line: #1a222f;
            --text: #ebf3ff;
            --muted: #a3b1c5;
            --brand: #2196f3;
            --brand-dark: #1976d2;
            --chip: #141a22;
            --chip-border: #263243;
            --success: #1fce88;
            --shadow: 0 24px 60px rgba(0, 0, 0, .45);
            --shadow-sm: 0 10px 28px rgba(0, 0, 0, .35);
            --gap-1: .5rem;
            --gap-2: .75rem;
            --gap-3: 1rem;
            --gap-4: 1.25rem;
            --gap-5: 1.75rem;
            --gap-6: 2.25rem;
            --radius: 16px;
        }

        html,
        body {
            font-family: "Noto Sans Thai", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text)
        }

        .container-xxl {
            max-width: 1280px;
            padding-inline: clamp(12px, 2vw, 18px)
        }

        .hero {
            position: relative;
            min-height: clamp(200px, 30vh, 340px);
            border-bottom: 1px solid var(--line);
            overflow: hidden;
            margin-bottom: var(--gap-6)
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('{{ $imageUrl }}') center 34%/cover no-repeat;
            filter: brightness(.65) saturate(1.05) blur(6px);
            transform: scale(1.03)
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, .18) 0%, rgba(0, 0, 0, .55) 70%)
        }

        .hero .wrap {
            position: relative;
            z-index: 1;
            padding: clamp(12px, 3vw, 22px) 0
        }

        .crumb {
            color: #c6d6ea
        }

        .title {
            font-family: "Bebas Neue", sans-serif;
            font-size: clamp(28px, 4.6vw, 52px);
            letter-spacing: .6px;
            margin: 6px 0 10px;
            text-shadow: 0 1px 0 rgba(0, 0, 0, .4)
        }

        .chip-wrap {
            gap: var(--gap-2);
            flex-wrap: wrap;
            margin-top: var(--gap-2)
        }

        .chip {
            background: var(--chip);
            border: 1px solid var(--chip-border);
            color: #e9f3ff;
            padding: .45rem .85rem;
            border-radius: 999px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            line-height: 1;
            font-size: .96rem
        }

        .fav-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border: 1px solid var(--chip-border);
            background: #0e141d;
            color: #e6f1ff;
            border-radius: 12px;
            padding: .55rem .9rem;
            font-weight: 800
        }

        .fav-btn .heart {
            width: 18px;
            height: 18px;
            display: inline-block;
            mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 21s-7.14-4.35-9.33-8.24C.71 9.14 2.5 5 6.4 5c1.9 0 3.2 1.01 3.6 2.2C10.4 6.01 11.7 5 13.6 5c3.9 0 5.69 4.14 3.73 7.76C19.14 16.65 12 21 12 21z"/></svg>') no-repeat center/contain;
            background: #9cb9ff
        }

        .fav-btn.active {
            border-color: #ff6b81;
            background: linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .03));
            color: #ffdfe4
        }

        .fav-btn.active .heart {
            background: #ff6b81
        }

        .main {
            margin-top: -10px;
            margin-bottom: var(--gap-6)
        }

        .card-glass {
            background: linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .05));
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm)
        }

        .card-glass+.card-glass {
            margin-top: var(--gap-4)
        }

        .cover {
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-sm);
            max-height: clamp(220px, 40vh, 460px);
            margin-bottom: var(--gap-4)
        }

        .cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 35%
        }

        .section-title {
            font-weight: 800;
            letter-spacing: .3px;
            margin-bottom: var(--gap-2)
        }

        .desc {
            color: #e8f1ff;
            opacity: .96;
            line-height: 1.75
        }

        .badge-soft {
            display: inline-block;
            padding: .28rem .65rem;
            border: 1px solid var(--chip-border);
            border-radius: 999px;
            background: #0f141c;
            color: #dbe8ff
        }

        .stars {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap
        }

        .stars svg {
            width: 22px;
            height: 22px
        }

        .stars .score {
            margin-left: .1rem;
            color: #cfe1ff;
            font-weight: 800
        }

        .rating-input {
            display: inline-flex;
            direction: rtl;
            gap: 4px
        }

        .rating-input input {
            display: none
        }

        .rating-input label {
            width: 28px;
            height: 28px;
            cursor: pointer;
            opacity: .55;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23FFD166" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>') center/contain no-repeat;
            filter: grayscale(1)
        }

        .rating-input input:checked~label,
        .rating-input label:hover,
        .rating-input label:hover~label {
            opacity: 1;
            filter: none
        }

        .btn-glow {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            border: none;
            color: #fff;
            font-weight: 800;
            border-radius: 12px;
            padding: .9rem 1rem;
            box-shadow: 0 10px 26px rgba(33, 150, 243, .35)
        }

        .btn-glow:hover {
            filter: brightness(1.06)
        }

        .btn-ghost {
            background: #0e131b;
            border: 1px solid var(--chip-border);
            color: #e9f3ff;
            font-weight: 700;
            border-radius: 12px
        }

        .btn-ghost:hover {
            background: #16202c
        }

        .sidebar .btn {
            width: 100%
        }

        .sidebar .list-unstyled>li+li {
            border-top: 1px dashed var(--line)
        }

        [data-animate] {
            opacity: 0;
            transform: translateY(12px);
            transition: .45s ease
        }

        [data-animate].in {
            opacity: 1;
            transform: none
        }

        @media (max-width:991.98px) {
            .sticky-lg {
                position: static !important
            }

            .cover {
                max-height: clamp(200px, 36vh, 380px)
            }

            .sidebar {
                margin-top: var(--gap-4)
            }
        }

        @media (max-width:575.98px) {
            .chip {
                font-size: .9rem;
                padding: .38rem .7rem
            }

            .title {
                font-size: clamp(26px, 7vw, 40px)
            }

            .hero {
                margin-bottom: var(--gap-5)
            }
        }
    </style>
</head>

<body>

    {{-- HERO --}}
    <header class="hero">
        <div class="container-xxl wrap">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <div class="crumb small">คอร์สเรียน • <span class="text-info">{{ $categoryName }}</span></div>
                    <h1 class="title m-0">{{ strtoupper($course->title) }}</h1>
                </div>

                {{-- Favorite (toggle) --}}
                <form id="favForm" class="m-0" method="POST"
                    action="{{ route('courses.favorite', $course->course_id) }}">
                    @csrf
                    <button type="submit" class="fav-btn {{ !empty($isFavorited) ? 'active' : '' }}" id="favBtn">
                        <span class="heart"></span>
                        <span
                            class="txt">{{ !empty($isFavorited) ? 'อยู่ในรายการโปรด' : 'เพิ่มลงรายการโปรด' }}</span>
                    </button>
                </form>
            </div>

            <div class="d-flex chip-wrap mt-3">
                <span class="chip">ผู้ให้บริการ: <strong>{{ $course->provider }}</strong></span>
                <span class="chip">ผู้สอน: <strong>{{ $course->provider_instructor ?: 'ไม่ระบุ' }}</strong></span>
                <span class="chip">ระดับ: <strong class="text-uppercase">{{ $course->level }}</strong></span>
                <span class="chip">ภาษา: <strong class="text-uppercase">{{ $course->language }}</strong></span>
                <span class="chip">ประเภท: <strong>{{ $isFree ? 'ฟรี' : 'จ่ายเงิน' }}</strong></span>
                @if (!$isFree)
                    <span class="chip">ราคา: <strong>฿{{ number_format($course->price ?? 0, 2) }}</strong></span>
                @endif
                @if (!empty($course->duration_text))
                    <span class="chip">ระยะเวลา: <strong>{{ $course->duration_text }}</strong></span>
                @endif
            </div>
        </div>
    </header>

    {{-- MAIN --}}
    <main class="main">
        <div class="container-xxl">
            <div class="row g-4 g-xl-5">
                {{-- LEFT --}}
                <div class="col-lg-8 order-1 order-lg-0" data-animate>
                    <div class="cover"><img src="{{ $imageUrl }}" alt="หน้าปกคอร์ส {{ $course->title }}"></div>

                    {{-- คะแนนรวม --}}
                    <section class="card-glass p-3 p-md-4">
                        <h5 class="section-title">คะแนนรีวิว</h5>
                        @php
                            $display = round($rating, 1);
                            $full = (int) floor($display);
                            $half = $display - $full >= 0.25 && $display - $full < 0.75 ? 1 : 0;
                            if ($display - $full >= 0.75) {
                                $full++;
                                $half = 0;
                            }
                            $empty = max(0, 5 - $full - $half);
                        @endphp
                        <div class="stars" aria-label="คะแนน {{ $display }} จาก 5">
                            @for ($i = 0; $i < $full; $i++)
                                <svg viewBox="0 0 24 24">
                                    <path fill="#FFD166"
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endfor
                            @if ($half)
                                <svg viewBox="0 0 24 24">
                                    <defs>
                                        <linearGradient id="half">
                                            <stop offset="50%" stop-color="#FFD166" />
                                            <stop offset="50%" stop-color="#2a2e39" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half)"
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endif
                            @for ($i = 0; $i < $empty; $i++)
                                <svg viewBox="0 0 24 24">
                                    <path fill="#2a2e39"
                                        d="M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24z" />
                                </svg>
                            @endfor
                            <span class="score">{{ number_format($display, 1) }}/5</span>
                        </div>
                    </section>

                    {{-- รายละเอียดคอร์ส --}}
                    <section class="card-glass p-3 p-md-4" data-animate>
                        <h5 class="section-title">รายละเอียดคอร์ส</h5>
                        <div class="desc">{!! nl2br(e($course->description ?? 'ไม่มีรายละเอียด')) !!}</div>
                    </section>

                    {{-- เขียนรีวิว / รายการรีวิว --}}
                    <section class="card-glass p-3 p-md-4" data-animate>
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                            <h5 class="section-title mb-0">รีวิวจากผู้เรียน</h5>
                            <span class="badge-soft">ทั้งหมด {{ $reviews->total() }} รายการ</span>
                        </div>

                        {{-- ฟอร์มรีวิว --}}
                        @if ($AUTH_CHECK)
                            <form class="mb-3" method="POST"
                                action="{{ route('courses.reviews.store', $course->course_id) }}">
                                @csrf
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-sm-auto">
                                        <div class="small text-secondary">ให้คะแนน:</div>
                                        <div class="rating-input" aria-label="ให้คะแนน 1-5 ดาว">
                                            <input type="radio" id="r5" name="rating" value="5"
                                                @checked($myRating === 5)><label for="r5"
                                                title="5 ดาว"></label>
                                            <input type="radio" id="r4" name="rating" value="4"
                                                @checked($myRating === 4)><label for="r4"
                                                title="4 ดาว"></label>
                                            <input type="radio" id="r3" name="rating" value="3"
                                                @checked($myRating === 3)><label for="r3"
                                                title="3 ดาว"></label>
                                            <input type="radio" id="r2" name="rating" value="2"
                                                @checked($myRating === 2)><label for="r2"
                                                title="2 ดาว"></label>
                                            <input type="radio" id="r1" name="rating" value="1"
                                                @checked($myRating === 1)><label for="r1"
                                                title="1 ดาว"></label>
                                        </div>
                                        @error('rating')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-sm">
                                        <textarea class="form-control" name="comment" rows="2" placeholder="แชร์ความเห็นของคุณ..."
                                            style="background:#0e131b;color:#e9f3ff;border:1px solid var(--chip-border);border-radius:12px">{{ $myComment }}</textarea>
                                        @error('comment')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-sm-auto d-grid">
                                        <button class="btn btn-glow">ส่งรีวิว</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-dark border-0" role="alert"
                                style="background:#0f141c;color:#cfe2ff">
                                โปรดเข้าสู่ระบบเพื่อเขียนรีวิว และเพิ่มรายการโปรด
                            </div>
                        @endif

                        {{-- แสดงรายการรีวิว --}}
                        @forelse($reviews as $rv)
                            <div class="p-3 rounded-3 mb-2" style="background:#0f141c;border:1px solid var(--line)">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge-soft">ผู้ใช้ #{{ $rv->user_id }}</span>
                                        <div class="stars">
                                            @php $r = (int)($rv->rating ?? 0); @endphp
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg viewBox="0 0 24 24">
                                                    <path fill="{{ $i < $r ? '#FFD166' : '#2a2e39' }}"
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="small text-secondary">
                                        {{ \Carbon\Carbon::parse($rv->created_at)->format('d/m/Y H:i') }}</div>
                                </div>
                                @if (!empty($rv->comment))
                                    <div class="mt-2 text-light">{{ $rv->comment }}</div>
                                @endif
                            </div>
                        @empty
                            <div class="text-secondary">ยังไม่มีรีวิวสำหรับคอร์สนี้</div>
                        @endforelse

                        <div class="mt-3">{{ $reviews->links() }}</div>
                    </section>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4 order-0 order-lg-1">
                    <aside class="card-glass p-3 p-md-4 sidebar sticky-lg" data-animate>
                        <h5 class="section-title mb-3">เริ่มเรียนได้ทันที</h5>
                        <div class="d-grid gap-2 mb-3">
                            <a class="btn btn-glow btn-lg" href="{{ $course->course_url }}" target="_blank"
                                rel="noopener">ไปยังคอร์สจริง</a>
                            <a class="btn btn-ghost" href="{{ url('/') }}">← กลับหน้าหลัก</a>
                            <a class="btn btn-ghost" href="{{ url('/#courses') }}">ดูคอร์สทั้งหมด</a>
                        </div>
                        <ul class="list-unstyled m-0">
                            <li class="d-flex align-items-start gap-3 py-3"><span
                                    class="badge-soft">ผู้ให้บริการ</span>
                                <div class="fw-bold">{{ $course->provider }}</div>
                            </li>
                            <li class="d-flex align-items-start gap-3 py-3"><span class="badge-soft">ผู้สอน</span>
                                <div class="fw-bold">{{ $course->provider_instructor ?: 'ไม่ระบุ' }}</div>
                            </li>
                            <li class="d-flex align-items-start gap-3 py-3"><span class="badge-soft">ระดับ</span>
                                <div class="fw-bold text-uppercase">{{ $course->level }}</div>
                            </li>
                            <li class="d-flex align-items-start gap-3 py-3"><span class="badge-soft">ภาษา</span>
                                <div class="fw-bold text-uppercase">{{ $course->language }}</div>
                            </li>
                            <li class="d-flex align-items-start gap-3 py-3"><span class="badge-soft">ประเภท</span>
                                <div class="fw-bold">{{ $isFree ? 'ฟรี' : 'จ่ายเงิน' }}</div>
                            </li>
                            <li class="d-flex align-items-start gap-3 py-3"><span class="badge-soft">ราคา</span>
                                <div class="fw-bold">
                                    @if ($isFree)
                                        ฟรี
                                    @else
                                        ฿{{ number_format($course->price ?? 0, 2) }}
                                    @endif
                                </div>
                            </li>
                            @if (!empty($course->duration_text))
                                <li class="d-flex align-items-start gap-3 py-3"><span
                                        class="badge-soft">ระยะเวลา</span>
                                    <div class="fw-bold">{{ $course->duration_text }}</div>
                                </li>
                            @endif
                            @if (!empty($course->created_at))
                                <li class="d-flex align-items-start gap-3 py-3"><span
                                        class="badge-soft">เพิ่มเมื่อ</span>
                                    <div class="fw-bold">
                                        {{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y H:i') }}</div>
                                </li>
                            @endif
                        </ul>
                        <hr class="my-4" style="border-color:var(--line)">
                        <div class="small text-secondary">หมายเหตุ: ปุ่ม “ไปยังคอร์สจริง”
                            จะพาไปที่เว็บไซต์ผู้ให้บริการภายนอก</div>
                    </aside>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center my-4"><small class="text-secondary">by devbanban.com ©2025</small></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // fade-in
        const els = document.querySelectorAll('[data-animate]');
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('in');
                    io.unobserve(e.target);
                }
            })
        }, {
            threshold: .15
        });
        els.forEach(el => io.observe(el));

        // Toggle favorite
        const favForm = document.getElementById('favForm');
        const favBtn = document.getElementById('favBtn');
        const IS_AUTH = {{ $AUTH_CHECK ? 'true' : 'false' }};
        const LOGIN_URL = @json($loginUrl);

        if (favForm && window.fetch) {
            favForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                try {
                    if (!IS_AUTH) {
                        window.location = LOGIN_URL;
                        return;
                    }
                    const res = await fetch(favForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    if (res.ok) {
                        favBtn.classList.toggle('active');
                        favBtn.querySelector('.txt').textContent =
                            favBtn.classList.contains('active') ? 'อยู่ในรายการโปรด' : 'เพิ่มลงรายการโปรด';
                    } else {
                        favForm.submit();
                    }
                } catch (_) {
                    favForm.submit();
                }
            });
        }
    </script>
</body>

</html>
