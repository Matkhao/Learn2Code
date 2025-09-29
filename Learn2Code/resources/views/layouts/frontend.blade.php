<!doctype html>
<html lang="th">

<head>
    <!-- =========================================================
       Learn2Code - Frontend Showcase
       ฟิลด์ที่ใช้งาน : title, category_id, provider, provider_instructor, level,
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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">

    @yield('css_before')

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
        html,
        body {
            font-family: "Noto Sans Thai", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            scroll-behavior: smooth;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        h1,
        h2,
        h3,
        h4,
        .display-1,
        .display-2,
        .navbar-brand {
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


        /* =========================================================
       Hero
       ========================================================= */
        .hero {
            background: linear-gradient(135deg, #0d1117 0%, #0a0c10 100%);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: clamp(1.5rem, 3vw, 2.6rem);
            margin-top: 1.25rem;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .hero:after {
            content: "";
            position: absolute;
            inset: auto -10% -10% auto;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(closest-side, rgba(33, 150, 243, .18), rgba(33, 150, 243, 0));
            filter: blur(16px);
            transform: translate(10%, 10%);
        }

        .hero h1 {
            font-weight: 900;
            color: #fff;
            font-size: clamp(1.8rem, 4vw, 3rem);
        }

        .hero h1 .brand {
            color: var(--brand);
        }

        .hero .lead {
            color: var(--muted);
            font-weight: 500;
        }

        /* =========================================================
       Chip Tags
       ========================================================= */
        .chip-wrap {
            gap: .6rem;
            flex-wrap: wrap;
        }

        .chip {
            background: var(--chip);
            color: #e3eaf5;
            border: 1px solid var(--chip-border);
            border-radius: 999px;
            padding: .5rem 1rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: .2s ease;
        }

        .chip:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            transform: translateY(-1px);
        }

        .chip .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--brand);
        }

        /* =========================================================
       Filter / Sort Bar
       ========================================================= */
        .filter-bar {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 16px;
            box-shadow: var(--shadow-soft);
        }

        .filter-title {
            font-weight: 800;
            color: #fff;
        }

        .form-select,
        .form-control {
            background: #0e1218;
            color: #dfe7f3;
            border: 1px solid var(--line-2);
            border-radius: 12px;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(33, 150, 243, .15);
        }

        .btn-filter {
            background: var(--brand);
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: 12px;
            padding: .6rem 1rem;
        }

        .btn-filter:hover {
            background: var(--brand-dark);
        }

        /* =========================================================
       Section Head
       ========================================================= */
        .section-head .section-eyebrow {
            color: #9ecbff;
            font-weight: 800;
            letter-spacing: .03em;
            background: rgba(33, 150, 243, .1);
            border: 1px dashed rgba(33, 150, 243, .35);
            padding: .25rem .6rem;
            border-radius: 999px;
            display: inline-block;
        }

        .section-head .section-title {
            font-family: "Bebas Neue";
            font-size: clamp(1.4rem, 3vw, 2rem);
            color: #fff;
            margin-top: .5rem;
        }

        .section-sub {
            color: var(--muted);
            margin-top: .25rem;
        }

        /* =========================================================
       Course Card
       ========================================================= */
        .course-card {
            background: var(--panel);
            border: 1px solid #1c2029;
            border-radius: 16px;
            padding: 18px;
            height: 100%;
            transition: .25s ease;
            position: relative;
            overflow: hidden;
        }

        .course-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow);
            border-color: rgba(33, 150, 243, .55);
        }

        .course-card .ribbon {
            position: absolute;
            top: 14px;
            right: -40px;
            transform: rotate(35deg);
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            font-weight: 900;
            letter-spacing: .5px;
            font-size: .8rem;
            padding: .3rem 1.6rem;
            box-shadow: 0 8px 18px rgba(33, 150, 243, .35);
        }

        .course-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(145deg, var(--brand), var(--brand-dark));
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 800;
        }

        .track-title {
            font-family: "Bebas Neue";
            color: #fff;
            font-size: 1.3rem;
        }

        .course-desc {
            color: #cfd8e3;
            min-height: 48px;
        }

        .badge-soft {
            display: inline-block;
            padding: .25rem .6rem;
            border: 1px solid var(--line-2);
            border-radius: 999px;
            color: #cfd8e3;
            background: #0e1218;
        }

        .price {
            font-weight: 900;
            color: #fff;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: .25rem;
            color: #ffd166;
            font-weight: 800;
        }

        .rating .star {
            width: 16px;
            height: 16px;
            display: inline-block;
            mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="%23fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z"/></svg>') no-repeat center / contain;
            -webkit-mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="%23fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z"/></svg>') no-repeat center / contain;
            background: #ffd166;
        }

        /* =========================================================
       Image (cover)
       ========================================================= */
        .thumb {
            width: 100%;
            height: 140px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: #0d1117;
            object-fit: cover;
            object-position: center;
            transition: .2s ease;
        }

        .course-card:hover .thumb {
            transform: scale(1.01);
        }

        /* =========================================================
       Skeleton Loader
       ========================================================= */
        .skeleton {
            position: relative;
            overflow: hidden;
            background: #0e1218;
            border-radius: 12px;
            min-height: 140px;
            border: 1px solid var(--line);
        }

        .skeleton:after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, 0) 100%);
            animation: loading 1.2s infinite;
        }

        @keyframes loading {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* =========================================================
       Stats / Testimonial / News
       ========================================================= */
        .stats {
            background: #0d1117;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            margin-top: 2.5rem;
        }

        .stat-box {
            text-align: center;
            padding: 22px 10px;
        }

        .stat-num {
            color: #fff;
            font-weight: 900;
            font-size: 2rem;
        }

        .stat-label {
            color: #9aa5b4;
        }

        .testi-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
        }

        .testi-quote {
            color: #d8e2f0;
        }

        .testi-user {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-top: 12px;
            color: #cfd8e3;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0d1117;
            border: 1px solid var(--line);
        }

        .news-box {
            background: #0d1117;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 22px;
        }

        .btn-news {
            background: var(--brand);
            color: #fff;
            font-weight: 800;
            border-radius: .6rem;
        }

        /* =========================================================
       Footer
       ========================================================= */
        footer {
            color: #7c8495;
            margin-top: 2rem;
        }

        /* =========================================================
       Sidebar (ถ้านำไปใช้)
       ========================================================= */
        .sidebar-link {
            background: transparent;
            color: #e6eefb;
            border: none;
            transition: all .25s ease;
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .55rem .9rem;
            border-radius: 12px;
        }

        .sidebar-link:hover {
            background: var(--brand);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(33, 150, 243, .35);
        }

        .sidebar-link.active {
            background: var(--brand-dark);
            color: #fff;
            font-weight: 800;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .06);
        }

        /* =========================================================
       Utilities
       ========================================================= */
        .text-brand {
            color: var(--brand);
        }

        .btn-outline-light {
            border: 1px solid var(--line);
            color: #dfe7f3;
            background: #0e1218;
        }

        .btn-outline-light:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        .small-muted {
            color: var(--muted);
            font-size: .9rem;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .rounded-12 {
            border-radius: 12px;
        }

        .rounded-16 {
            border-radius: 16px;
        }

        /* =========== YouTube Lite Video (CSS เดิม) =========== */
        .ratio {
            position: relative;
            width: 100%;
        }

        .ratio::before {
            content: "";
            display: block;
            padding-top: 56.25%;
        }

        .ratio>* {
            position: absolute;
            inset: 0;
        }

        .video-light {
            position: relative;
            background: #000 center/cover no-repeat;
            border-radius: 12px;
            overflow: hidden;
        }

        .video-light iframe {
            display: block;
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: inherit;
        }

        .ratio.video-light>.yt-play {
            position: absolute;
            top: 50% !important;
            left: 50% !important;
            right: auto !important;
            bottom: auto !important;
            transform: translate(-50%, -50%) !important;
            width: clamp(56px, 7.5vw, 84px);
            height: clamp(56px, 7.5vw, 84px);
            border-radius: 999px;
            border: 0;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            --b1: #2196f3;
            --b2: #1976d2;
            background: radial-gradient(120% 120% at 30% 30%, #57c0ff 0%, var(--b1) 45%, var(--b2) 100%);
            color: #fff;
            box-shadow: 0 12px 28px rgba(33, 150, 243, .45), inset 0 2px 8px rgba(255, 255, 255, .25);
            transition: transform .22s cubic-bezier(.2, .8, .2, 1), box-shadow .22s ease;
        }

        .video-light .yt-icon {
            width: clamp(22px, 3.2vw, 34px);
            height: auto;
            display: block;
            fill: currentColor;
            pointer-events: none;
            margin-left: 2px;
        }

        .ratio.video-light>.yt-play::after {
            content: "";
            position: absolute;
            inset: -7px;
            border-radius: inherit;
            background: radial-gradient(70% 70% at 50% 50%, rgba(33, 150, 243, .32), transparent);
            filter: blur(8px);
            pointer-events: none;
        }

        .yt-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .75);
            padding: 20px;
            backdrop-filter: blur(2px);
        }

        .yt-dialog {
            width: clamp(320px, 88vw, 960px);
            aspect-ratio: 16/9;
            background: #000;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .5);
            position: relative;
            overflow: hidden;
        }

        .yt-dialog iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: inherit;
        }

        .yt-close {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 999px;
            background: rgba(255, 255, 255, .95);
            color: #111;
            cursor: pointer;
            display: grid;
            place-items: center;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .3);
        }

        .yt-close svg {
            width: 20px;
            height: 20px;
        }

        /* =========================================================
       Liqud Glass Modal (ธีม)
       ========================================================= */
        .lgx-theme {
            --lgx-text: #eaf5ff;
            --lgx-key: #bcd7ff;
            --lgx-muted: #a9c2df;
            --lgx-border: rgba(255, 255, 255, .15);
            --lgx-shadow: 0 14px 36px rgba(0, 0, 0, .55), inset 0 1px 0 rgba(255, 255, 255, .08);
            --lgx-chip-bg: rgba(33, 150, 243, .12);
            --lgx-chip-border: rgba(33, 150, 243, .25);
            --lgx-chip-text: #bfe0ff;
        }

        .lgx-modal-glass .modal-content {
            background: linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .04));
            border: 1px solid var(--lgx-border);
            color: var(--lgx-text);
            border-radius: 18px;
            box-shadow: var(--lgx-shadow);
            backdrop-filter: blur(14px) saturate(140%);
            -webkit-backdrop-filter: blur(14px) saturate(140%);
            overflow: hidden;
        }

        .lgx-modal-glass .modal-header {
            background: linear-gradient(180deg, #0f1b2b, #0b1422);
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }

        .lgx-modal-glass .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, .12);
            background: linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .03));
        }

        .lgx-title {
            font-weight: 900;
            letter-spacing: .3px;
        }

        .lgx-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: .25rem .55rem;
            border-radius: 999px;
            font-size: .8rem;
            line-height: 1;
            background: var(--lgx-chip-bg);
            color: var(--lgx-chip-text);
            border: 1px solid var(--lgx-chip-border);
            white-space: nowrap;
        }

        .lgx-subtle {
            color: var(--lgx-muted);
            font-size: .92rem;
        }

        .lgx-cover {
            width: 100%;
            border-radius: 14px;
            object-fit: cover;
            aspect-ratio: 16/9;
            background: #0d1117;
            border: 1px solid var(--lgx-border);
            box-shadow: 0 8px 22px rgba(0, 0, 0, .35);
        }

        .lgx-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .18), transparent);
            margin: 14px 0;
        }

        .lgx-btn {
            border: 1px solid rgba(255, 255, 255, .18);
            background: linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .04));
            color: var(--lgx-text);
            backdrop-filter: blur(6px) saturate(120%);
            -webkit-backdrop-filter: blur(6px) saturate(120%);
        }

        .lgx-btn:hover {
            background: linear-gradient(180deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .06));
            border-color: rgba(255, 255, 255, .28);
        }

        .lgx-btn-primary {
            border: 1px solid rgba(255, 255, 255, .25);
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            box-shadow: 0 10px 26px rgba(33, 150, 243, .35);
        }

        .lgx-btn-primary:hover {
            filter: brightness(1.05);
        }

        .lgx-modal-glass .btn-close {
            filter: invert(1) grayscale(100%);
            opacity: .9;
        }

        .lgx-modal-glass .btn-close:focus {
            box-shadow: none;
        }

        /* ===== Page Loader ===== */
        #pageLoader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: grid;
            place-items: center;
            background:
                radial-gradient(900px 420px at 110% -10%, rgba(66, 165, 245, .18), transparent 60%),
                radial-gradient(850px 380px at -10% -10%, rgba(126, 87, 194, .16), transparent 60%),
                linear-gradient(180deg, #0a0c10 0%, #0b0f15 100%);
        }

        body.no-scroll {
            overflow: hidden
        }

        .loader-glass {
            position: relative;
            width: min(520px, 92vw);
            padding: 28px 26px 22px;
            border-radius: 20px;
            border: 1px solid #1a2230;
            background: linear-gradient(180deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .05));
            box-shadow: 0 18px 60px rgba(0, 0, 0, .5);
            backdrop-filter: saturate(160%) blur(10px);
            animation: pop .35s cubic-bezier(.2, .9, .2, 1);
        }

        @keyframes pop {
            from {
                transform: translateY(8px) scale(.98);
                opacity: .0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        .loader-brand .logo {
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: .6px;
            font-size: 34px;
            color: #e9f1fa;
        }

        .loader-brand .logo span {
            color: #42a5f5
        }

        .loader-ring {
            width: 88px;
            height: 88px;
            margin: 18px auto;
            position: relative;
            filter: drop-shadow(0 6px 24px rgba(66, 165, 245, .45));
        }

        .loader-ring::before,
        .loader-ring::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, .16);
            border-top-color: #42a5f5;
            animation: spin 1.05s linear infinite;
        }

        .loader-ring::after {
            inset: 10px;
            border-color: rgba(255, 255, 255, .12);
            border-right-color: #2e78d1;
            animation-duration: .85s;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        .loader-progress {
            height: 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            overflow: hidden;
            position: relative;
            margin: 10px 0 6px;
        }

        .loader-progress #plBar {
            position: absolute;
            inset: 0;
            transform: scaleX(0);
            transform-origin: left center;
            background: linear-gradient(90deg, #42a5f5, #2e78d1);
        }

        .loader-hint {
            margin: 6px 0 0;
            color: #9fb0c7;
            text-align: center;
            font-weight: 700
        }

        .blob {
            position: absolute;
            filter: blur(36px);
            opacity: .75;
            border-radius: 50%
        }

        .blob.b1 {
            width: 160px;
            height: 160px;
            left: -30px;
            bottom: -20px;
            background: rgba(66, 165, 245, .35);
            animation: float 7s ease-in-out infinite
        }

        .blob.b2 {
            width: 180px;
            height: 180px;
            right: -40px;
            top: -30px;
            background: rgba(170, 142, 255, .28);
            animation: float 9s ease-in-out infinite reverse
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-12px)
            }
        }

        /* เคารพผู้ใช้ที่ปิด motion */
        @media (prefers-reduced-motion: reduce) {

            .loader-ring::before,
            .loader-ring::after,
            .blob {
                animation: none
            }
        }
    </style>
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

            <!-- ambient blobs -->
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
                <span class="accent">Learn2Code
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="d-flex gap-2 ms-lg-3">
                @php
                    $member = auth('member')->user();
                    $admin = auth('admin')->user();
                    $displayName = $admin->name ?? ($member->name ?? 'บัญชีของฉัน');

                    // เป็นแอดมิน ถ้า: ล็อกอินด้วย guard:admin หรือ member ที่มีสิทธิ์แอดมิน
                    $isAdmin =
                        $admin !== null ||
                        ($member &&
                            (!empty($member->is_admin) ||
                                (int) ($member->role_id ?? 0) === 1 ||
                                (int) ($member->user_id ?? 0) === 1 ||
                                (method_exists($member, 'isAdmin') ? $member->isAdmin() : false)));
                @endphp

                @if ($member || $admin)
                    <div class="dropdown">
                        <button class="btn btn-cta dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ $displayName }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            @if ($member)
                                <li><a class="dropdown-item"
                                        href="{{ route('favorites.index', [], false) }}">รายการโปรด</a></li>
                            @endif

                            @if ($isAdmin)
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.courses.index', [], false) }}">
                                        จัดการข้อมูลหลังบ้าน
                                    </a>
                                </li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <!-- ใช้ member.logout ได้เลย เพราะ controller ของคุณ logout ทั้งสอง guard ให้แล้ว -->
                                <form action="{{ route('member.logout') }}" method="POST" class="px-3 py-1">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-danger">ออกจากระบบ</button>
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
        <div class="hero">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <h1>ก้าวสู่ <span class="brand">อนาคตดิจิทัล</span> ของคุณ</h1>
                    <p class="lead">สร้างสรรค์แอปพลิเคชัน และ ผลงานด้านดิจิทัล ด้วยหลักสูตรที่ลงลึกจัดเต็ม
                        ทั้งศาสตร์ และ ศิลป์จากผู้มีประสบการณ์เชี่ยวชาญด้านเทคโนโลยีตัวจริง</p>

                    <!-- dynamic chips (สรุปจากข้อมูลคอร์สในหน้านี้) -->
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
                    <div class="course-card text-center">
                        <div class="fw-bold text-white mb-1">▶ วิดีโอแนะนำ</div>
                        <div class="text-secondary small">สำหรับผู้เริ่มต้น</div>
                        <div class="ratio ratio-16x9 rounded-12 overflow-hidden mt-3 video-light" data-yt="ImpzH9Ui0pI">
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
                 FILTERS / SORT / SEARCH
                 ========================================================= -->
    <div class="container-xxl mt-4">
        <form method="GET" action="/" class="filter-bar">
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
        <div class="section-head">
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
                    <div class="section-title"><b>หลักสูตรทั้งหมด</b></div>
                    <p class="section-sub">แสดงผล {{ $shown }} / {{ $totalCourses }} คอร์ส ตามเงื่อนไขปัจจุบัน
                    </p>
                </div>
                <div class="text-end small-muted">
                    @if (request()->hasAny(['q', 'level', 'language', 'price_type', 'sort']))
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
                        <div class="course-card h-100">
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
                        <div class="stat-num">
                            {{ number_format(collect($courses)->where('price_type', 'free')->count()) }}</div>
                        <div class="stat-label">คอร์สฟรี (ในหน้านี้)</div>
                    </div>
                </div>
                @php $avgOnPage = round(collect($courses)->avg('avg_rating'),1); @endphp
                <div class="col-6 col-lg-3">
                    <div class="stat-box">
                        <div class="stat-num">{{ number_format($avgOnPage, 1) }}</div>
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
    <footer class="text-center mt-5"><small>by devbanban.com ©2025</small></footer>

    <!-- =========================================================
                 PREVIEW MODAL (เดิม)
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
                 CONFIRM DETAILS MODAL (ใหม่) → ไปหน้า course_details.blade (แท็บเดิม)
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
        (function() {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;

            // แสดงเฉพาะครั้งแรกของ session (ตั้งเป็น false ถ้าอยากแสดงทุกครั้ง)
            const onlyFirstTime = true;
            if (onlyFirstTime && sessionStorage.getItem('l2cHomeLoaded') === '1') {
                loader.remove(); // ข้าม
                return;
            }

            document.body.classList.add('no-scroll');
            const bar = document.getElementById('plBar');

            // นับความคืบหน้าแบบสุ่มๆ ให้ดูมีชีวิต
            let p = 0;
            const tick = () => {
                p = Math.min(p + (Math.random() * 14 + 6), 92);
                bar.style.transform = 'scaleX(' + (p / 100) + ')';
            };
            const interval = setInterval(tick, 180);

            // รอโหลดเสร็จ + บังคับเวลาขั้นต่ำให้ไม่สั้นเกินไป
            const MIN_TIME = 800; // ms
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

            // window load = ทุก asset เสร็จ
            window.addEventListener('load', finish, {
                once: true
            });

            // กันบางกรณีที่ onload ไม่ยิง (เช่น cached fast path)
            setTimeout(() => {
                if (document.readyState === 'complete') finish();
            }, 1200);
        })();
        // ===== ป้องกันเปิดซ้ำเวลากด Spacebar ย้ำๆ =====
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

        (function() {
            // Preview modal
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

            // ===== โมดัลยืนยันไปหน้า course.details (แท็บเดิม) =====
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
                        window.location.href = url; // เปิดทับหน้าเดิม
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

@php use Illuminate\Support\Facades\Auth; @endphp
<pre style="background:#111;color:#9fe;padding:8px;border-radius:8px">
auth()->check(): {{ auth()->check() ? 'YES' : 'NO' }}
guard web:      {{ Auth::guard('web')->check() ? 'YES' : 'NO' }}
guard admin:    {{ Auth::guard('admin')->check() ? 'YES' : 'NO' }}
user id/email:  {{ optional(Auth::user())->id }} / {{ optional(Auth::user())->email }}
</pre>

</html>
