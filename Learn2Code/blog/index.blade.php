<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>บทความสาระการเขียนโปรแกรม | Learn2Code</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/blog.css') }}" rel="stylesheet" />

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
                <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="servicesDropdown" role="button">บริการ</a>
                <ul class="dropdown-menu" style="background:rgba(10,12,16,.85); backdrop-filter: blur(6px); border-radius: 16px" aria-labelledby="servicesDropdown">
                    <li>
                    <i class="fa fa-file-code-o" aria-hidden="true"></i>
                    <a class="dropdown-item" href="#" style="color: #98a2b3">Web Development
                        <div class="text-start">
                        <span>บริการให้คำปรึกษาพัฒนาเว็บไซต์ครบวงจร</span>
                        </div>
                    </a>
                    </li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </li>
                {{-- <li class="nav-item"><a class="nav-link" href="#">บริการ</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="{{ url('/blog') }}">บทความ</a></li>
            </ul>
            <div class="d-flex gap-2 ms-lg-3">
                <a href="/dashboard" class="btn btn-cta">เข้าสู่ระบบ</a>
            </div>
            </div>
        </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-start text-white">
                    <h1 class="display-4 fw-bolder">Learn2Code Blog</h1>
                    <p class="lead fw-normal text-white-50 mb-0">รวบรวมความรู้สำหรับ</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Fancy Product</h5>
                                    <!-- Product price-->
                                    $40.00 - $80.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Special Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$20.00</span>
                                    $18.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$50.00</span>
                                    $25.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Popular Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    $40.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$50.00</span>
                                    $25.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Fancy Product</h5>
                                    <!-- Product price-->
                                    $120.00 - $280.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Special Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$20.00</span>
                                    $18.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Popular Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    $40.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/blog.js') }}"></script>
    </body>
</html>
