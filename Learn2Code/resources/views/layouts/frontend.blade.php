<!doctype html>
<html lang="th">
<head>
  <!-- =========================================================
       Learn2Code - Frontend Showcase
       ใช้ตัวแปรและโครงสร้างจากระบบเดิม: $courses (Paginator ของ CoursesModel)
       ฟิลด์ที่ใช้งาน: title, category_id, provider, provider_instructor, level,
       language, price_type, price, duration_text, description, cover_img, course_url, avg_rating
       Bootstrap 5.3.5 + Blade helpers
       ========================================================= -->

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Learn2Code</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

  @yield('css_before')

  <style>
    /* =========================================================
       Theme Variables
       ========================================================= */
    :root{
      --bg:#0a0c10;
      --panel:#12141a;
      --panel-2:#0e121a;
      --panel-3:#0c1016;
      --line:#1b202b;
      --line-2:#202637;
      --text:#e9f1fa;
      --muted:#98a2b3;
      --muted-2:#9aa5b4;
      --brand:#2196f3;
      --brand-2:#42a5f5;
      --brand-dark:#1976d2;
      --chip:#1a1d25;
      --chip-border:#2a2d38;
      --success:#21c17a;
      --warning:#ffca28;
      --danger:#e53935;
      --pink:#f472b6;
      --orange:#fb923c;
      --purple:#a78bfa;
      --radius:16px;
      --radius-sm:12px;
      --shadow:0 24px 60px rgba(0,0,0,.45);
      --shadow-sm:0 10px 28px rgba(0,0,0,.35);
      --shadow-soft:0 6px 16px rgba(0,0,0,.25);
    }

    /* =========================================================
       Base
       ========================================================= */
    html, body{
      font-family:"Noto Sans Thai",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      background:var(--bg);
      color:var(--text);
      scroll-behavior:smooth;
    }
    img{ max-width:100%; height:auto; }
    h1,h2,h3,h4,.display-1,.display-2,.navbar-brand{
      font-family:"Bebas Neue","Noto Sans Thai",sans-serif; letter-spacing:.5px;
    }
    .container-xxl{ max-width:1280px; }

    /* =========================================================
       Navbar
       ========================================================= */
    .navbar{
      background:rgba(10,12,16,.85);
      border-bottom:1px solid var(--line);
      backdrop-filter: blur(6px);
    }
    .navbar .navbar-brand{ color:#fff; font-weight:800; }
    .navbar .navbar-brand .accent{ color:var(--brand); }
    .navbar .nav-link{ color:#cfd8e3 !important; font-weight:600; }
    .navbar .nav-link:hover{ color:var(--brand) !important; transform:translateY(-1px); }
    .btn-cta{
      background:linear-gradient(135deg,var(--brand), var(--brand-dark));
      color:#fff; font-weight:800; border:none; border-radius:.7rem; padding:.55rem 1rem;
      box-shadow:0 6px 14px rgba(33,150,243,.35);
    }
    .btn-cta:hover{ filter:brightness(1.05); transform:translateY(-1px); }

    /* =========================================================
       Hero
       ========================================================= */
    .hero{
      background:linear-gradient(135deg,#0d1117 0%,#0a0c10 100%);
      border:1px solid var(--line);
      border-radius:20px;
      padding:clamp(1.5rem,3vw,2.6rem);
      margin-top:1.25rem;
      box-shadow:var(--shadow-sm);
      position:relative;
      overflow:hidden;
    }
    .hero:after{
      content:"";
      position:absolute; inset:auto -10% -10% auto;
      width:260px; height:260px; border-radius:50%;
      background:radial-gradient(closest-side, rgba(33,150,243,.18), rgba(33,150,243,0));
      filter: blur(16px);
      transform:translate(10%,10%);
    }
    .hero h1{ font-weight:900; color:#fff; font-size:clamp(1.8rem, 4vw, 3rem); }
    .hero h1 .brand{ color:var(--brand); }
    .hero .lead{ color:var(--muted); font-weight:500; }

    /* =========================================================
       Chip Tags
       ========================================================= */
    .chip-wrap{ gap:.6rem; flex-wrap:wrap; }
    .chip{
      background:var(--chip);
      color:#e3eaf5;
      border:1px solid var(--chip-border);
      border-radius:999px;
      padding:.5rem 1rem;
      font-weight:700;
      text-decoration:none;
      display:inline-flex; align-items:center; gap:.5rem;
      transition:.2s ease;
    }
    .chip:hover{ background:var(--brand); border-color:var(--brand); color:#fff; transform:translateY(-1px); }
    .chip .dot{ width:10px;height:10px;border-radius:50%; background:var(--brand); }

    /* =========================================================
       Filter / Sort Bar
       ========================================================= */
    .filter-bar{
      background:var(--panel);
      border:1px solid var(--line);
      border-radius:var(--radius);
      padding:16px;
      box-shadow:var(--shadow-soft);
    }
    .filter-title{ font-weight:800; color:#fff; }
    .form-select, .form-control{
      background:#0e1218; color:#dfe7f3; border:1px solid var(--line-2);
      border-radius:12px;
    }
    .form-select:focus, .form-control:focus{
      border-color:var(--brand); box-shadow:0 0 0 .2rem rgba(33,150,243,.15);
    }
    .btn-filter{
      background:var(--brand); color:#fff; font-weight:800; border:none; border-radius:12px;
      padding:.6rem 1rem;
    }
    .btn-filter:hover{ background:var(--brand-dark); }

    /* =========================================================
       Section Head
       ========================================================= */
    .section-head .section-eyebrow{
      color:#9ecbff; font-weight:800; letter-spacing:.03em;
      background:rgba(33,150,243,.1); border:1px dashed rgba(33,150,243,.35);
      padding:.25rem .6rem; border-radius:999px; display:inline-block;
    }
    .section-head .section-title{
      font-family:"Bebas Neue"; font-size:clamp(1.4rem, 3vw, 2rem); color:#fff; margin-top:.5rem;
    }
    .section-sub{ color:var(--muted); margin-top:.25rem; }

    /* =========================================================
       Course Card
       ========================================================= */
    .course-card{
      background:var(--panel); border:1px solid #1c2029; border-radius:16px;
      padding:18px; height:100%; transition:.25s ease; position:relative; overflow:hidden;
    }
    .course-card:hover{
      transform:translateY(-6px);
      box-shadow:var(--shadow);
      border-color:rgba(33,150,243,.55);
    }
    .course-card .ribbon{
      position:absolute; top:14px; right:-40px; transform:rotate(35deg);
      background:linear-gradient(135deg,var(--brand),var(--brand-dark));
      color:#fff; font-weight:900; letter-spacing:.5px; font-size:.8rem;
      padding:.3rem 1.6rem; box-shadow:0 8px 18px rgba(33,150,243,.35);
    }
    .course-icon{ width:40px;height:40px;border-radius:10px; background:linear-gradient(145deg,var(--brand), var(--brand-dark)); display:grid;place-items:center;color:#fff;font-weight:800; }
    .track-title{ font-family:"Bebas Neue"; color:#fff; font-size:1.3rem; }
    .course-desc{ color:#cfd8e3; min-height:48px; }
    .badge-soft{
      display:inline-block; padding:.25rem .6rem; border:1px solid var(--line-2);
      border-radius:999px; color:#cfd8e3; background:#0e1218;
    }
    .price{
      font-weight:900;
      color:#fff;
    }
    .rating{
      display:flex; align-items:center; gap:.25rem; color:#ffd166;
      font-weight:800;
    }
    .rating .star{
      width:16px;height:16px; display:inline-block;
      mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="%23fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z"/></svg>') no-repeat center / contain;
      -webkit-mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="%23fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z"/></svg>') no-repeat center / contain;
      background:#ffd166;
    }

    /* =========================================================
       Image (cover)
       ========================================================= */
    .thumb{
      width:100%; height:140px; border-radius:12px; border:1px solid var(--line);
      background:#0d1117; object-fit:cover; object-position:center;
      transition: .2s ease;
    }
    .course-card:hover .thumb{ transform:scale(1.01); }

    /* =========================================================
       Skeleton Loader
       ========================================================= */
    .skeleton{
      position:relative; overflow:hidden; background:#0e1218; border-radius:12px;
      min-height:140px; border:1px solid var(--line);
    }
    .skeleton:after{
      content:"";
      position:absolute; inset:0;
      background:linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.05) 50%, rgba(255,255,255,0) 100%);
      animation:loading 1.2s infinite;
    }
    @keyframes loading { 0%{ transform:translateX(-100%);} 100%{ transform:translateX(100%);} }

    /* =========================================================
       Stats / Testimonial / News
       ========================================================= */
    .stats{ background:#0d1117; border-top:1px solid var(--line); border-bottom:1px solid var(--line); margin-top:2.5rem; }
    .stat-box{ text-align:center; padding:22px 10px; }
    .stat-num{ color:#fff; font-weight:900; font-size:2rem; }
    .stat-label{ color:#9aa5b4; }

    .testi-card{ background:var(--panel); border:1px solid var(--line); border-radius:14px; padding:18px; }
    .testi-quote{ color:#d8e2f0; }
    .testi-user{ display:flex; align-items:center; gap:.75rem; margin-top:12px; color:#cfd8e3; }
    .avatar{ width:36px; height:36px; border-radius:50%; background:#0d1117; border:1px solid var(--line); }

    .news-box{ background:#0d1117; border:1px solid var(--line); border-radius:16px; padding:22px; }
    .btn-news{ background:var(--brand); color:#fff; font-weight:800; border-radius:.6rem; }

    /* =========================================================
       Footer
       ========================================================= */
    footer{ color:#7c8495; margin-top:2rem; }

    /* =========================================================
       Sidebar (ถ้านำไปใช้)
       ========================================================= */
    .sidebar-link{
      background:transparent; color:#e6eefb; border:none; transition: all .25s ease;
      display:flex; align-items:center; gap:.6rem; padding:.55rem .9rem; border-radius:12px;
    }
    .sidebar-link:hover{
      background:var(--brand); color:#fff; transform:translateY(-2px);
      box-shadow:0 6px 14px rgba(33,150,243,.35);
    }
    .sidebar-link.active{
      background:var(--brand-dark); color:#fff; font-weight:800; box-shadow: inset 0 0 0 1px rgba(255,255,255,.06);
    }

    /* =========================================================
       Utilities
       ========================================================= */
    .text-brand{ color:var(--brand); }
    .btn-outline-light{
      border:1px solid var(--line); color:#dfe7f3; background:#0e1218;
    }
    .btn-outline-light:hover{ background:var(--brand); border-color:var(--brand); color:#fff; }
    .small-muted{ color:var(--muted); font-size:.9rem; }
    .cursor-pointer{ cursor:pointer; }
    .rounded-12{ border-radius:12px; }
    .rounded-16{ border-radius:16px; }

  </style>
</head>
<body>

<!-- =========================================================
     NAVBAR
     ========================================================= -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-xxl">
    <a class="navbar-brand" href="/">
      <span class="accent">Learn</span>2Code
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">คอร์สเรียน</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="#">บริการ</a></li>
        <li class="nav-item"><a class="nav-link" href="#">บทความ</a></li>
      </ul>
      <div class="d-flex gap-2 ms-lg-3">
        <a href="/dashboard" class="btn btn-cta">เข้าสู่ระบบ</a>
      </div>
    </div>
  </div>
</nav>

<!-- =========================================================
     HERO
     ========================================================= -->
<div class="container-xxl">
  <div class="hero">
    <div class="row g-4 align-items-center">
      <div class="col-lg-7">
        <h1>ก้าวสู่ <span class="brand">อนาคตดิจิทัล</span> ของคุณ</h1>
        <p class="lead">สร้างสรรค์แอปพลิเคชันและผลงานดิจิทัล ด้วยหลักสูตรจากผู้เชี่ยวชาญจริง</p>

        <!-- dynamic chips (สรุปจากข้อมูลคอร์สในหน้านี้) -->
        <div class="d-flex chip-wrap mt-3">
          @php
            $levels = collect($courses)->pluck('level')->filter()->unique()->values();
            $langs  = collect($courses)->pluck('language')->filter()->unique()->values();
            $providers = collect($courses)->pluck('provider')->filter()->unique()->take(6)->values();
          @endphp
          @foreach($levels as $lv)
            <a class="chip" href="{{ request()->fullUrlWithQuery(['level'=>$lv]) }}">
              <span class="dot"></span> ระดับ: {{ strtoupper($lv) }}
            </a>
          @endforeach
          @foreach($langs as $lg)
            <a class="chip" href="{{ request()->fullUrlWithQuery(['language'=>$lg]) }}">
              <span class="dot" style="background:var(--purple)"></span> ภาษา: {{ strtoupper($lg) }}
            </a>
          @endforeach
          @foreach($providers as $pv)
            <a class="chip" href="{{ request()->fullUrlWithQuery(['provider'=>$pv]) }}">
              <span class="dot" style="background:var(--orange)"></span> {{ $pv }}
            </a>
          @endforeach
        </div>
      </div>
      <div class="col-lg-5">
        <div class="course-card text-center">
          <div class="fw-bold text-white mb-1">▶ วิดีโอแนะนำ</div>
          <div class="text-secondary small">สำหรับผู้เริ่มต้น</div>
          <div class="skeleton rounded-12 mt-3"></div>
          <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="#courses" class="btn btn-outline-light btn-sm rounded-12">ดูคอร์สทั้งหมด</a>
            <a href="/dashboard" class="btn btn-cta btn-sm">เริ่มเรียนเลย</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =========================================================
     FILTERS / SORT / SEARCH
     ========================================================= -->
<div class="container-xxl mt-4">
  <form method="GET" action="/" class="filter-bar">
    <div class="row g-2 align-items-end">
      <!-- ค้นหาชื่อคอร์ส -->
      <div class="col-12 col-md-4">
        <label class="form-label small-muted">ค้นหาคีย์เวิร์ด</label>
        <input type="text" name="q" class="form-control" placeholder="เช่น Laravel, UX, React"
               value="{{ request('q') }}">
      </div>

      <!-- เลือกระดับ -->
      <div class="col-6 col-md-2">
        <label class="form-label small-muted">ระดับ</label>
        <select name="level" class="form-select">
          <option value="">ทั้งหมด</option>
          <option value="beginner" {{ request('level')==='beginner'?'selected':'' }}>Beginner</option>
          <option value="intermediate" {{ request('level')==='intermediate'?'selected':'' }}>Intermediate</option>
          <option value="advanced" {{ request('level')==='advanced'?'selected':'' }}>Advanced</option>
        </select>
      </div>

      <!-- ภาษา -->
      <div class="col-6 col-md-2">
        <label class="form-label small-muted">ภาษา</label>
        <select name="language" class="form-select">
          <option value="">ทั้งหมด</option>
          <option value="TH" {{ request('language')==='TH'?'selected':'' }}>Thai</option>
          <option value="EN" {{ request('language')==='EN'?'selected':'' }}>English</option>
        </select>
      </div>

      <!-- ประเภทราคา -->
      <div class="col-6 col-md-2">
        <label class="form-label small-muted">ประเภท</label>
        <select name="price_type" class="form-select">
          <option value="">ทั้งหมด</option>
          <option value="free" {{ request('price_type')==='free'?'selected':'' }}>Free</option>
          <option value="paid" {{ request('price_type')==='paid'?'selected':'' }}>Paid</option>
        </select>
      </div>

      <!-- จัดเรียง -->
      <div class="col-6 col-md-2">
        @php
          $sort = request('sort','latest');
        @endphp
        <label class="form-label small-muted">จัดเรียง</label>
        <select name="sort" class="form-select">
          <option value="latest" {{ $sort==='latest'?'selected':'' }}>ใหม่ล่าสุด</option>
          <option value="price_asc" {{ $sort==='price_asc'?'selected':'' }}>ราคาต่ำ → สูง</option>
          <option value="price_desc" {{ $sort==='price_desc'?'selected':'' }}>ราคาสูง → ต่ำ</option>
          <option value="rating_desc" {{ $sort==='rating_desc'?'selected':'' }}>เรตติ้งสูงสุด</option>
        </select>
      </div>

      <!-- ปุ่ม -->
      <div class="col-12 col-md-auto">
        <button class="btn btn-filter w-100">
          <i class="bi bi-funnel-fill me-1"></i> ค้นหา/กรอง
        </button>
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
  <div class="section-head">
    @php
      $totalCourses = $courses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $courses->total() : count($courses ?? []);
      $shown = $courses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $courses->count() : count($courses ?? []);
    @endphp
    <div class="section-eyebrow">🚀 หลักสูตรที่แนะนำ</div>
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <div class="section-title">หลักสูตรทั้งหมด</div>
        <p class="section-sub">แสดงผล {{ $shown }} / {{ $totalCourses }} คอร์ส ตามเงื่อนไขปัจจุบัน</p>
      </div>
      <div class="text-end small-muted">
        @if(request()->hasAny(['q','level','language','price_type','sort']))
          <span class="badge text-bg-dark rounded-12 border border-secondary">Filtered</span>
        @else
          <span class="badge text-bg-secondary rounded-12">All</span>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- =========================================================
     COURSE GRID
     ========================================================= -->
<div class="container-xxl">
  <div class="row row-cols-1 row-cols-md-4 g-3">
    @isset($courses)
      @forelse($courses as $course)
        @php
          $img = $course->cover_img;
          $hasImg = !empty($img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img);
          $imgSrc = $hasImg
            ? \Illuminate\Support\Facades\Storage::url($img)
            : ( file_exists(public_path('images/placeholder.png'))
                  ? asset('images/placeholder.png')
                  : 'https://via.placeholder.com/560x315?text=No+Image' );
          $isFree = ($course->price_type ?? 'free') === 'free';
          $priceText = $isFree ? 'FREE' : '฿'.number_format($course->price ?? 0, 2);
          $levelText = strtoupper($course->level ?? 'beginner');
          $langText = strtoupper($course->language ?? 'TH');
          $rating = is_numeric($course->avg_rating ?? null) ? floatval($course->avg_rating) : 0.0;
          $rating = max(0,min($rating,5));
          $fullStars = floor($rating);
          $halfStar  = ($rating - $fullStars) >= 0.5 ? 1 : 0;
          $emptyStars = 5 - $fullStars - $halfStar;
        @endphp

        <div class="col">
          <div class="course-card h-100">
            @if($isFree)
              <div class="ribbon">FREE</div>
            @endif

            <div class="d-flex align-items-center gap-2 mb-3">
              <div class="course-icon">C</div>
              <span class="text-secondary small">ระดับ: {{ $levelText }}</span>
              <span class="text-secondary small">| ภาษา: {{ $langText }}</span>
            </div>

            <img src="{{ $imgSrc }}"
                 alt="{{ $course->title }}"
                 class="thumb"
                 loading="lazy"
                 width="560" height="315">

            <h3 class="track-title mt-3">{{ $course->title }}</h3>

            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="rating" title="เรตติ้ง {{ number_format($rating,1) }}/5">
                @for($i=0;$i<$fullStars;$i++)
                  <span class="star"></span>
                @endfor
                @if($halfStar)
                  <span class="star" style="background:linear-gradient(90deg,#ffd166 50%,rgba(255,255,255,.15) 50%);"></span>
                @endif
                @for($i=0;$i<$emptyStars;$i++)
                  <span class="star" style="background:rgba(255,255,255,.15)"></span>
                @endfor
                <span class="small ms-1">{{ number_format($rating,1) }}</span>
              </div>
              <span class="badge-soft">หมวด 
                : #{{ $course->category_id }}</span>
            </div>

            <p class="course-desc mb-3">
              {{ \Illuminate\Support\Str::limit($course->description, 124, '...') }}
            </p>

            <div class="d-flex justify-content-between align-items-center">
              <span class="badge-soft">
                {{ $isFree ? 'ฟรี' : 'มีค่าใช้จ่าย' }}
              </span>
              <span class="price">{{ $priceText }}</span>
            </div>

            <div class="d-flex gap-2 mt-3">
              @if(!empty($course->course_url))
                <a href="{{ $course->course_url }}" target="_blank" rel="noopener noreferrer"
                   class="btn btn-sm btn-primary flex-fill rounded-12">
                  ดูข้อมูลเพิ่มเติม
                </a>
              @endif
              <button class="btn btn-sm btn-outline-light rounded-12"
                      data-bs-toggle="modal"
                      data-bs-target="#previewModal"
                      data-title="{{ $course->title }}"
                      data-provider="{{ $course->provider }}"
                      data-instructor="{{ $course->provider_instructor }}"
                      data-desc="{{ strip_tags($course->description) }}"
                      data-img="{{ $imgSrc }}"
                      data-level="{{ $levelText }}"
                      data-language="{{ $langText }}"
                      data-price="{{ $priceText }}"
                      data-duration="{{ $course->duration_text }}"
                      data-rating="{{ number_format($rating,1) }}">
                พรีวิว
              </button>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-2 small-muted">
              <span>โดย: {{ $course->provider ?? 'ไม่ระบุ' }}</span>
              <span>ระยะเวลา: {{ $course->duration_text ?? '-' }}</span>
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

  <!-- Pagination -->
  <div class="mt-4 d-flex justify-content-center">
    {{ $courses->withQueryString()->links() }}
  </div>
</div>

<!-- =========================================================
     STATS
     ========================================================= -->
<div class="stats py-3">
  <div class="container-xxl">
    <div class="row g-3">
      <div class="col-6 col-lg-3">
        <div class="stat-box">
          <div class="stat-num">{{ number_format($totalCourses) }}</div>
          <div class="stat-label">คอร์สทั้งหมด</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-box">
          <div class="stat-num">{{ number_format(collect($courses)->where('price_type','free')->count()) }}</div>
          <div class="stat-label">คอร์สฟรี (ในหน้านี้)</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        @php
          $avgOnPage = round(collect($courses)->avg('avg_rating'),1);
        @endphp
        <div class="stat-box">
          <div class="stat-num">{{ number_format($avgOnPage,1) }}</div>
          <div class="stat-label">ค่าเฉลี่ยเรตติ้ง (หน้านี้)</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-box">
          <div class="stat-num">24/7</div>
          <div class="stat-label">Community</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =========================================================
     TESTIMONIALS
     ========================================================= -->
<div class="container-xxl my-4">
  <div class="row g-3">
    <div class="col-lg-6">
      <div class="testi-card">
        <div class="testi-quote">“คอร์สสอนละเอียด เข้าใจง่าย ได้ลงมือทำจริง”</div>
        <div class="testi-user"><span class="avatar"></span> <span>ภาคิน | นักศึกษา</span></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="testi-card">
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
  <div class="news-box">
    <h4 class="mb-2">สมัครรับข่าวสาร</h4>
    <p class="text-secondary">รับอัปเดตบทความ เทคนิค และโปรโมชั่นพิเศษก่อนใคร</p>
    <form action="/subscribe" method="post">
      @csrf
      <div class="row g-2">
        <div class="col-md-8">
          <input type="email" name="email" class="form-control" placeholder="อีเมลของคุณ" required>
        </div>
        <div class="col-md-4 d-grid">
          <button class="btn btn-news">สมัครเลย</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- =========================================================
     FOOTER
     ========================================================= -->
<footer class="text-center mt-5">
  <small>by devbanban.com ©2025</small>
</footer>

<!-- =========================================================
     PREVIEW MODAL
     ========================================================= -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="background:var(--panel); color:var(--text); border:1px solid var(--line); border-radius:16px;">
      <div class="modal-header" style="border-bottom:1px solid var(--line);">
        <h5 class="modal-title fw-bold" id="pvTitle">ตัวอย่างคอร์ส</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <img id="pvImg" src="" alt="" class="w-100 rounded-12" style="height:220px;object-fit:cover;object-position:center;">
          </div>
          <div class="col-md-6">
            <div class="small-muted mb-1">โดย <span id="pvProvider">-</span> | ผู้สอน <span id="pvInstructor">-</span></div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge-soft" id="pvLevel">-</span>
              <span class="badge-soft" id="pvLang">-</span>
              <span class="badge-soft" id="pvPrice">-</span>
              <span class="badge-soft" id="pvDuration">-</span>
            </div>
            <div class="small-muted">เรตติ้ง: <span id="pvRating">-</span> / 5</div>
            <hr class="text-secondary">
            <p id="pvDesc" class="mb-0"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="border-top:1px solid var(--line);">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

@yield('footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<!-- =========================================================
     PAGE SCRIPTS
     ========================================================= -->
<script>
(function(){
  // Preview modal population
  const pv = document.getElementById('previewModal');
  if(pv){
    pv.addEventListener('show.bs.modal', function (event) {
      const btn = event.relatedTarget;
      if(!btn) return;
      const title = btn.getAttribute('data-title') || '-';
      const img   = btn.getAttribute('data-img') || '';
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
      pv.querySelector('#pvLevel').textContent = 'ระดับ: ' + (level || '-');
      pv.querySelector('#pvLang').textContent = 'ภาษา: ' + (language || '-');
      pv.querySelector('#pvPrice').textContent = price || '-';
      pv.querySelector('#pvDuration').textContent = 'เวลา: ' + (duration || '-');
      pv.querySelector('#pvRating').textContent = rating || '-';
    });
  }

  // Lazy loading fallback (ถ้าบราวเซอร์เก่า)
  const lazyImgs = document.querySelectorAll('img[loading="lazy"]');
  if('loading' in HTMLImageElement.prototype === false){
    lazyImgs.forEach(img => {
      const src = img.getAttribute('src');
      if(src) {
        const tmp = new Image();
        tmp.onload = () => { img.src = src; };
        tmp.src = src;
      }
    });
  }
})();
</script>

@yield('js_before')
</body>
</html>
