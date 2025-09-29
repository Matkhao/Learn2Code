<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="{{ $article->meta_description ?: $article->excerpt_or_content }}" />
    <meta name="author" content="{{ $article->author }}" />
    <meta name="keywords" content="{{ $article->tags ? implode(', ', $article->tags) : '' }}" />
    <title>{{ $article->title }} | Learn2Code Blog</title>

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->excerpt_or_content }}">
    <meta property="og:image" content="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/default-og.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Prism.js for code highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

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
            line-height: 1.6;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        h1, h2, h3, h4, h5, h6, .display-1, .display-2, .navbar-brand {
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
            background: rgba(10, 12, 16, .95);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(10px);
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
        Article Header
        ========================================================= */
        .article-header {
            background: linear-gradient(135deg, #0d1117 0%, #0a0c10 100%);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .article-header::after {
            content: "";
            position: absolute;
            inset: auto -15% -15% auto;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(closest-side, rgba(33, 150, 243, .12), rgba(33, 150, 243, 0));
            filter: blur(25px);
            transform: translate(15%, 15%);
        }

        .article-title {
            font-family: "Bebas Neue", sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: #fff;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            line-height: 1.2;
        }

        .article-excerpt {
            font-size: 1.1rem;
            color: var(--muted);
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--muted-2);
            font-weight: 500;
        }

        .meta-item i {
            color: var(--brand);
        }

        /* =========================================================
        Breadcrumb
        ========================================================= */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 1rem 0;
        }

        .breadcrumb-item a {
            color: var(--brand);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--brand-2);
        }

        .breadcrumb-item.active {
            color: var(--muted);
        }

        /* =========================================================
        Article Content
        ========================================================= */
        .article-content {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 3rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-soft);
        }

        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            color: #fff;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .article-content h1:first-child,
        .article-content h2:first-child,
        .article-content h3:first-child {
            margin-top: 0;
        }

        .article-content p {
            margin-bottom: 1.5rem;
            color: var(--text);
            font-size: 1.05rem;
        }

        .article-content ul,
        .article-content ol {
            margin-bottom: 1.5rem;
            color: var(--text);
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content blockquote {
            background: var(--panel-2);
            border-left: 4px solid var(--brand);
            padding: 1.5rem;
            border-radius: 0 12px 12px 0;
            margin: 2rem 0;
            font-style: italic;
            color: var(--muted);
        }

        .article-content code {
            background: var(--chip);
            color: #ff6b9d;
            padding: 0.2rem 0.4rem;
            border-radius: 6px;
            font-size: 0.9rem;
            border: 1px solid var(--chip-border);
        }

        .article-content pre {
            background: #1e1e1e;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1.5rem;
            overflow-x: auto;
            margin: 2rem 0;
        }

        .article-content pre code {
            background: transparent;
            border: none;
            padding: 0;
            color: inherit;
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

        /* =========================================================
        Featured Image
        ========================================================= */
        .featured-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: var(--radius);
            border: 1px solid var(--line);
            margin: 2rem 0;
            box-shadow: var(--shadow-soft);
        }

        /* =========================================================
        Related Articles
        ========================================================= */
        .related-section {
            background: var(--panel-2);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 2rem;
            margin: 3rem 0;
            box-shadow: var(--shadow-soft);
        }

        .section-title {
            font-family: "Bebas Neue", sans-serif;
            font-size: 1.75rem;
            color: #fff;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .related-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
            transition: .25s ease;
        }

        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-sm);
            border-color: rgba(33, 150, 243, .3);
        }

        .related-title {
            font-family: "Bebas Neue", sans-serif;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .related-title a {
            color: inherit;
            text-decoration: none;
        }

        .related-title a:hover {
            color: var(--brand);
        }

        .related-excerpt {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .related-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--muted-2);
        }

        /* =========================================================
        Share Buttons
        ========================================================= */
        .share-section {
            background: var(--panel-3);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: center;
        }

        .share-title {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .share-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: .2s ease;
        }

        .share-btn:hover {
            transform: translateY(-2px);
        }

        .share-facebook {
            background: #1877f2;
            color: #fff;
        }

        .share-twitter {
            background: #1da1f2;
            color: #fff;
        }

        .share-line {
            background: #00b900;
            color: #fff;
        }

        .share-copy {
            background: var(--chip);
            color: var(--text);
            border: 1px solid var(--chip-border);
        }

        .share-copy:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        /* =========================================================
        Back Button
        ========================================================= */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--panel);
            color: var(--text);
            border: 1px solid var(--line);
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: .2s ease;
        }

        .back-btn:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            transform: translateY(-2px);
        }

        /* =========================================================
        Mobile Responsive
        ========================================================= */
        @media (max-width: 768px) {
            .article-header {
                padding: 1.5rem;
                margin: 1rem 0;
            }

            .article-content {
                padding: 1.5rem;
            }

            .related-section {
                padding: 1.5rem;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .share-buttons {
                flex-direction: column;
                align-items: center;
            }

            .share-btn {
                width: 100%;
                max-width: 200px;
                justify-content: center;
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

    <!-- Breadcrumb -->
    <div class="container-xxl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">บทความ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 50) }}</li>
            </ol>
        </nav>

        <a href="{{ route('blog.index') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            กลับหน้าบทความ
        </a>
    </div>

    <!-- Article Header -->
    <div class="container-xxl">
        <div class="article-header">
            <h1 class="article-title">{{ $article->title }}</h1>

            @if($article->excerpt)
            <p class="article-excerpt">{{ $article->excerpt }}</p>
            @endif

            <div class="article-meta">
                <div class="meta-item">
                    <i class="bi bi-person-fill"></i>
                    <span>{{ $article->author }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-calendar-fill"></i>
                    <span>{{ $article->formatted_published_at }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock-fill"></i>
                    <span>{{ $article->reading_time }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-eye-fill"></i>
                    <span>{{ number_format($article->views) }} ครั้ง</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    @if($article->featured_image)
    <div class="container-xxl">
        <img src="{{ asset('storage/' . $article->featured_image) }}"
             alt="{{ $article->title }}" class="featured-image">
    </div>
    @endif

    <!-- Article Content -->
    <div class="container-xxl">
        <div class="article-content">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>

    <!-- Tags -->
    @if($article->tags)
    <div class="container-xxl">
        <div class="mb-4">
            <h5 class="text-white mb-3">หมวดหมู่</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($article->tags as $tag)
                    <a href="{{ route('blog.index', ['tag' => $tag]) }}" class="tag-chip">
                        <i class="bi bi-tag-fill"></i> {{ $tag }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Share Section -->
    <div class="container-xxl">
        <div class="share-section">
            <h5 class="share-title">แชร์บทความนี้</h5>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                   target="_blank" class="share-btn share-facebook">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                   target="_blank" class="share-btn share-twitter">
                    <i class="bi bi-twitter"></i> Twitter
                </a>
                <a href="https://social-plugins.line.me/lineit/share?url={{ urlencode(url()->current()) }}"
                   target="_blank" class="share-btn share-line">
                    <i class="bi bi-line"></i> LINE
                </a>
                <button class="share-btn share-copy" onclick="copyToClipboard()">
                    <i class="bi bi-clipboard"></i> คัดลอกลิงก์
                </button>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    @if($relatedArticles->isNotEmpty())
    <div class="container-xxl">
        <div class="related-section">
            <h2 class="section-title">
                <i class="bi bi-journals"></i> บทความที่เกี่ยวข้อง
            </h2>
            <div class="row g-4">
                @foreach($relatedArticles as $related)
                <div class="col-md-4">
                    <div class="related-card">
                        <h3 class="related-title">
                            <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                        </h3>
                        <p class="related-excerpt">{{ Str::limit($related->excerpt_or_content, 100) }}</p>
                        <div class="related-meta">
                            <span>{{ $related->author }}</span>
                            <span>{{ $related->formatted_published_at }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

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
    <!-- Prism.js for syntax highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <script>
        // Copy to clipboard function
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                // Show success message
                const button = document.querySelector('.share-copy');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="bi bi-check-circle-fill"></i> คัดลอกแล้ว!';
                button.style.background = 'var(--success)';

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.background = '';
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('ไม่สามารถคัดลอกลิงก์ได้');
            });
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Enhanced code block styling
        document.addEventListener('DOMContentLoaded', function() {
            // Add copy button to code blocks
            document.querySelectorAll('pre').forEach(function(pre) {
                const code = pre.querySelector('code');
                if (code) {
                    const copyButton = document.createElement('button');
                    copyButton.className = 'btn btn-sm btn-outline-light position-absolute';
                    copyButton.style.cssText = 'top: 0.5rem; right: 0.5rem; font-size: 0.8rem;';
                    copyButton.innerHTML = '<i class="bi bi-clipboard"></i>';
                    copyButton.onclick = function() {
                        navigator.clipboard.writeText(code.textContent).then(() => {
                            copyButton.innerHTML = '<i class="bi bi-check"></i>';
                            setTimeout(() => {
                                copyButton.innerHTML = '<i class="bi bi-clipboard"></i>';
                            }, 2000);
                        });
                    };

                    pre.style.position = 'relative';
                    pre.appendChild(copyButton);
                }
            });
        });

        // Reading progress indicator
        window.addEventListener('scroll', function() {
            const article = document.querySelector('.article-content');
            if (article) {
                const articleTop = article.offsetTop;
                const articleHeight = article.offsetHeight;
                const windowHeight = window.innerHeight;
                const scrollTop = window.pageYOffset;

                const progress = Math.min(100, Math.max(0,
                    ((scrollTop + windowHeight - articleTop) / articleHeight) * 100
                ));

                // You can use this progress value to show a reading progress bar if needed
            }
        });
    </script>
</body>

</html>