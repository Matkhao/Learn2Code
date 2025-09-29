<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="รวบรวมความรู้สำหรับนักพัฒนายุคใหม่ไว้ในที่เดียว {{ isset($tag) ? ' - หมวด: ' . $tag : '' }}" />
    <meta name="author" content="Learn2Code Team" />
    <title>{{ isset($search) && $search ? 'ค้นหา: ' . $search . ' | ' : (isset($tag) && $tag ? 'หมวด: ' . $tag . ' | ' : '') }}บทความเขียนโปรแกรม | Learn2Code</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    <style>
        /* =========================================================
            Theme Variables
            ========================================================= */
        :root {
            --bg: #0a0c10;
            --panel: #12141a;
            --panel-2: #0e121a;
            --panel-3: #0c1016;
            --line: #1b202b;
            --line-2: #202637;
            --text: #e9f1fa;
            --muted: #98a2b3;
            --muted-2: #9aa5b4;
            --brand: #2196f3;
            --brand-2: #42a5f5;
            --brand-dark: #1976d2;
            --chip: #1a1d25;
            --chip-border: #2a2d38;
            --success: #21c17a;
            --warning: #ffca28;
            --danger: #e53935;
            --pink: #f472b6;
            --orange: #fb923c;
            --purple: #a78bfa;
            --radius: 16px;
            --radius-sm: 12px;
            --shadow: 0 24px 60px rgba(0, 0, 0, .45);
            --shadow-sm: 0 10px 28px rgba(0, 0, 0, .35);
            --shadow-soft: 0 6px 16px rgba(0, 0, 0, .25);
        }

        /* =========================================================
        Base
        ========================================================= */
        html, body {
            font-family: "Noto Sans Thai", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            scroll-behavior: smooth;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        h1, h2, h3, h4, .display-1, .display-2, .navbar-brand {
            font-family: "Bebas Neue", "Noto Sans Thai", sans-serif;
            letter-spacing: .5px;
        }

        .container-xxl {
            max-width: 1280px;
        }

        /* =========================================================
        Navbar
        ========================================================= */
        .navbar {
            background: rgba(10, 12, 16, .85);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(6px);
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight: 800;
        }

        .navbar .navbar-brand .accent {
            color: var(--brand);
        }

        .navbar .nav-link {
            color: #cfd8e3 !important;
            font-weight: 600;
        }

        .navbar .nav-link:hover {
            color: var(--brand) !important;
            transform: translateY(-1px);
        }

        .btn-cta {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: .7rem;
            padding: .55rem 1rem;
            box-shadow: 0 6px 14px rgba(33, 150, 243, .35);
        }

        .btn-cta:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        /* =========================================================
        Hero
        ========================================================= */
        .hero {
            background: linear-gradient(135deg, #0d1117 0%, #0a0c10 100%);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: clamp(2rem, 4vw, 3rem);
            margin-top: 1.5rem;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .hero:after {
            content: "";
            position: absolute;
            inset: auto -10% -10% auto;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(closest-side, rgba(33, 150, 243, .18), rgba(33, 150, 243, 0));
            filter: blur(20px);
            transform: translate(10%, 10%);
        }

        .hero h1 {
            font-weight: 900;
            color: #fff;
            font-size: clamp(2rem, 5vw, 3.5rem);
            position: relative;
            z-index: 1;
        }

        .hero h1 .brand {
            color: var(--brand);
        }

        .hero .lead {
            color: var(--muted);
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        /* =========================================================
        Search & Filter
        ========================================================= */
        .search-section {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-soft);
        }

        .form-control, .form-select {
            background: #0e1218;
            color: #dfe7f3;
            border: 1px solid var(--line-2);
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(33, 150, 243, .15);
            background: #0e1218;
            color: #dfe7f3;
        }

        .btn-search {
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
        }

        .btn-search:hover {
            background: var(--brand-dark);
            color: #fff;
        }

        /* =========================================================
        Tags
        ========================================================= */
        .tag-chip {
            background: var(--chip);
            color: #e3eaf5;
            border: 1px solid var(--chip-border);
            border-radius: 999px;
            padding: .4rem .8rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: .2s ease;
            font-size: 0.875rem;
        }

        .tag-chip:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            transform: translateY(-1px);
        }

        .tag-chip.active {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        /* =========================================================
        Article Cards
        ========================================================= */
        .article-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 0;
            height: 100%;
            transition: .3s ease;
            position: relative;
            overflow: hidden;
        }

        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow);
            border-color: rgba(33, 150, 243, .4);
        }

        .article-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 18px 18px 0 0;
            background: linear-gradient(135deg, #1a1d25, #0d1117);
        }

        .article-content {
            padding: 1.5rem;
        }

        .article-title {
            font-family: "Bebas Neue", sans-serif;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .article-title a {
            color: inherit;
            text-decoration: none;
        }

        .article-title a:hover {
            color: var(--brand);
        }

        .article-excerpt {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .article-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--muted-2);
        }

        .article-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .article-date {
            color: var(--muted);
        }

        .article-views {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--brand);
        }

        .featured-badge {
            position: absolute;
            top: 12px;
            right: -35px;
            transform: rotate(35deg);
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            font-weight: 800;
            letter-spacing: .5px;
            font-size: .75rem;
            padding: .25rem 1.5rem;
            box-shadow: 0 4px 12px rgba(33, 150, 243, .4);
        }

        /* =========================================================
        Featured Articles
        ========================================================= */
        .featured-section {
            margin: 3rem 0;
        }

        .section-title {
            font-family: "Bebas Neue", sans-serif;
            font-size: 2rem;
            color: #fff;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 32px;
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            border-radius: 2px;
        }

        /* =========================================================
        Pagination
        ========================================================= */
        .pagination {
            gap: 0.5rem;
        }

        .page-link {
            background: var(--panel);
            border: 1px solid var(--line);
            color: var(--text);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 600;
        }

        .page-link:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        .page-item.active .page-link {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        /* =========================================================
        Empty State
        ========================================================= */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--muted-2);
            margin-bottom: 1rem;
        }

        /* =========================================================
        Mobile Responsive
        ========================================================= */
        @media (max-width: 768px) {
            .hero {
                padding: 1.5rem;
                margin-top: 1rem;
            }

            .search-section {
                padding: 1rem;
            }

            .article-image {
                height: 180px;
            }

            .article-content {
                padding: 1rem;
            }

            .article-title {
                font-size: 1.2rem;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
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
                        <a class="nav-link" href="/">คอร์สเรียน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('blog.index') }}">บทความ</a>
                    </li>
                </ul>
                <div class="d-flex gap-2 ms-lg-3">
                    <a href="/courses" class="btn btn-cta">เข้าสู่ระบบ</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-xxl">
        <div class="hero">
            <h1>
                <span class="brand">Learn2Code</span> Blog
            </h1>
            <p class="lead">รวบรวมความรู้สำหรับนักพัฒนายุคใหม่ไว้ในที่เดียว</p>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="container-xxl">
        <div class="search-section">
            <form method="GET" action="{{ route('blog.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label text-white fw-bold">ค้นหาบทความ</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search ?? '' }}" placeholder="ค้นหาหัวข้อ เนื้อหา หรือคำสำคัญ...">
                </div>
                <div class="col-md-3">
                    <label for="tag" class="form-label text-white fw-bold">หมวดหมู่</label>
                    <select class="form-select" id="tag" name="tag">
                        <option value="">ทุกหมวดหมู่</option>
                        @foreach($popularTags as $popularTag)
                            <option value="{{ $popularTag }}" {{ isset($tag) && $tag === $popularTag ? 'selected' : '' }}>
                                {{ $popularTag }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-search w-100">
                        <i class="bi bi-search me-2"></i>ค้นหา
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popular Tags -->
    @if($popularTags->isNotEmpty())
    <div class="container-xxl">
        <div class="mb-4">
            <h5 class="text-white mb-3">หมวดหมู่ยอดนิยม</h5>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('blog.index') }}" class="tag-chip {{ !isset($tag) ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i> ทั้งหมด
                </a>
                @foreach($popularTags as $popularTag)
                    <a href="{{ route('blog.index', ['tag' => $popularTag]) }}"
                       class="tag-chip {{ isset($tag) && $tag === $popularTag ? 'active' : '' }}">
                        <i class="bi bi-tag-fill"></i> {{ $popularTag }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Articles -->
    @if($featuredArticles->isNotEmpty())
    <div class="container-xxl">
        <div class="featured-section">
            <h2 class="section-title">
                <i class="bi bi-star-fill text-warning"></i> บทความแนะนำ
            </h2>
            <div class="row g-4">
                @foreach($featuredArticles as $featured)
                <div class="col-lg-4 col-md-6">
                    <div class="article-card">
                        <div class="featured-badge">แนะนำ</div>
                        @if($featured->featured_image)
                            <img src="{{ asset('storage/' . $featured->featured_image) }}"
                                 alt="{{ $featured->title }}" class="article-image" loading="lazy">
                        @else
                            <div class="article-image d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text-fill" style="font-size: 3rem; color: var(--muted);"></i>
                            </div>
                        @endif
                        <div class="article-content">
                            <h3 class="article-title">
                                <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                            </h3>
                            <p class="article-excerpt">{{ $featured->excerpt_or_content }}</p>
                            <div class="article-meta">
                                <div class="article-author">
                                    <i class="bi bi-person-fill"></i>
                                    <span>{{ $featured->author }}</span>
                                </div>
                                <div class="d-flex gap-3 align-items-center">
                                    <span class="article-date">{{ $featured->formatted_published_at }}</span>
                                    <div class="article-views">
                                        <i class="bi bi-eye-fill"></i>
                                        <span>{{ number_format($featured->views) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Articles -->
    <div class="container-xxl">
        <div class="mb-5">
            <h2 class="section-title">
                <i class="bi bi-journal-text"></i>
                {{ isset($search) && $search ? 'ผลการค้นหา: ' . $search : (isset($tag) && $tag ? 'หมวด: ' . $tag : 'บทความทั้งหมด') }}
                <span class="text-muted fs-6 fw-normal">({{ $articles->total() }} บทความ)</span>
            </h2>

            @if($articles->isNotEmpty())
                <div class="row g-4">
                    @foreach($articles as $article)
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            @if($article->featured)
                                <div class="featured-badge">แนะนำ</div>
                            @endif
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                     alt="{{ $article->title }}" class="article-image" loading="lazy">
                            @else
                                <div class="article-image d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text-fill" style="font-size: 3rem; color: var(--muted);"></i>
                                </div>
                            @endif
                            <div class="article-content">
                                <h3 class="article-title">
                                    <a href="{{ route('blog.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                <p class="article-excerpt">{{ $article->excerpt_or_content }}</p>
                                @if($article->tags)
                                    <div class="mb-3">
                                        @foreach(array_slice($article->tags, 0, 3) as $tagName)
                                            <a href="{{ route('blog.index', ['tag' => $tagName]) }}"
                                               class="tag-chip me-1 mb-1" style="font-size: 0.75rem;">
                                                {{ $tagName }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="article-meta">
                                    <div class="article-author">
                                        <i class="bi bi-person-fill"></i>
                                        <span>{{ $article->author }}</span>
                                    </div>
                                    <div class="d-flex gap-3 align-items-center">
                                        <span class="article-date">{{ $article->formatted_published_at }}</span>
                                        <div class="article-views">
                                            <i class="bi bi-eye-fill"></i>
                                            <span>{{ number_format($article->views) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $articles->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <h4>ไม่พบบทความ</h4>
                    <p>ลองค้นหาด้วยคำสำคัญอื่น หรือเลือกหมวดหมู่ที่ต่างกัน</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>กลับหน้าหลัก
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5" style="background: var(--panel-3); border-top: 1px solid var(--line);">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-white">Learn2Code</h5>
                    <p class="text-muted">ศูนย์รวมความรู้สำหรับนักพัฒนายุคใหม่</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">© {{ date('Y') }} Learn2Code. สงวนลิขสิทธิ์.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Auto-submit search form on tag change
        document.getElementById('tag').addEventListener('change', function() {
            this.form.submit();
        });

        // Lazy loading for images (fallback for older browsers)
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        if ('loading' in HTMLImageElement.prototype === false) {
            lazyImages.forEach(img => {
                const src = img.getAttribute('src');
                if (src) {
                    const tmp = new Image();
                    tmp.onload = () => {
                        img.src = src;
                    };
                    tmp.src = src;
                }
            });
        }
    </script>
</body>

</html>