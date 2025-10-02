<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'เกิดข้อผิดพลาด') | Learn2Code</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
    <style>
        :root {
            --bg: #0a0c10;
            --panel: #0f1219;
            --glass: rgba(255, 255, 255, .06);
            --border: #1c2230;
            --text: #e9f1fa;
            --muted: #9aa5b4;
            --blue: #2196f3;
            --radius: 16px;
        }

        html,
        body {
            height: 100%
        }

        body {
            background: radial-gradient(1200px 800px at 20% 10%, rgba(33, 150, 243, .20), transparent 60%),
                radial-gradient(1000px 700px at 80% 90%, rgba(33, 150, 243, .12), transparent 60%),
                var(--bg);
            color: var(--text);
            font-family: "Noto Sans Thai", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
        }

        .logo {
            font-family: "Bebas Neue", system-ui;
            letter-spacing: .5px
        }

        .glass {
            background: linear-gradient(180deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .04));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, .35);
        }

        .code-badge {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            border: 1px dashed rgba(255, 255, 255, .15);
            border-radius: 12px;
            padding: .35rem .65rem;
            background: rgba(255, 255, 255, .06);
            color: #c6e2ff;
        }

        .btn-glass {
            border: 1px solid var(--border);
            background: var(--glass);
            color: var(--text);
            border-radius: 12px;
            backdrop-filter: blur(6px);
        }

        .btn-glass:hover {
            border-color: #2a3346;
            transform: translateY(-1px)
        }

        .btn-primary {
            background: var(--blue);
            border: 0;
            border-radius: 12px
        }

        .btn-primary:hover {
            filter: brightness(1.05)
        }

        .fade-in {
            animation: fade .5s ease-out both
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(6px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .hero-emoji {
            font-size: 68px;
            line-height: 1
        }

        pre.err {
            background: #0b0f16;
            color: #cde1ff;
            border: 1px solid #152030;
            border-radius: 12px;
            padding: 1rem;
            font-size: .9rem;
            white-space: pre-wrap;
            word-break: break-word;
        }
    </style>
</head>

<body>
    @php
        $status =
            (int) ($code ??
                (isset($exception) && method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500));
        $rawMsg = trim((string) ($message ?? (isset($exception) ? $exception->getMessage() : '')));

        $map = [
            401 => ['ต้องล็อกอินก่อน', 'กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ'],
            403 => ['คุณไม่มีสิทธิเข้าหน้านี้', 'บัญชีของคุณไม่มีสิทธิ์เข้าถึงทรัพยากรนี้'],
            404 => ['ไม่พบหน้า (Page Not Found)', 'ลิงก์อาจหมดอายุ ถูกลบ หรือถูกย้าย'],
            419 => ['หน้าเดิมหมดอายุ', 'โปรดรีเฟรชหน้าและลองใหม่'],
            429 => ['ส่งคำขอมากเกินไป', 'พักสักครู่แล้วลองใหม่'],
            500 => ['มีบางอย่างผิดพลาด', 'เราได้รับแจ้งเหตุขัดข้องและกำลังตรวจสอบ'],
            503 => ['ระบบกำลังปิดปรับปรุง', 'กรุณาลองใหม่ภายหลัง'],
        ];
        $title = $map[$status][0] ?? 'เกิดข้อผิดพลาด';
        $desc = $rawMsg !== '' ? $rawMsg : $map[$status][1] ?? 'โปรดลองใหม่ภายหลัง';

        // แนะนำปุ่มลัดตามสถานะ
        $actions = match ($status) {
            401 => [
                ['route' => 'login', 'label' => 'เข้าสู่ระบบ'],
                ['url' => url()->previous(), 'label' => 'ย้อนกลับ'],
            ],
            403 => [
                ['route' => 'home', 'label' => 'กลับหน้าหลัก'],
                ['route' => 'courses.index', 'label' => 'ดูคอร์สทั้งหมด'],
            ],
            404 => [
                ['route' => 'courses.index', 'label' => 'ดูคอร์สทั้งหมด'],
                ['url' => url()->previous(), 'label' => 'ย้อนกลับ'],
            ],
            default => [
                ['route' => 'home', 'label' => 'กลับหน้าหลัก'],
                ['url' => url()->previous(), 'label' => 'ย้อนกลับ'],
            ],
        };

        $now = now()->format('Y-m-d H:i:s');
        $path = request()->fullUrl();
        $refer = url()->previous();
        $debug = (bool) config('app.debug');
    @endphp

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <div class="logo h2 m-0">Learn2Code</div>
            <div class="code-badge">HTTP {{ $status }}</div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass p-4 p-md-5 fade-in">
                    <div class="d-flex align-items-start gap-3">
                        <div class="hero-emoji">🔎</div>
                        <div>
                            <h1 class="h3 mb-2">@yield('title', $title)</h1>
                            <p class="text-white-50 mb-3">{{ $desc }}</p>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @foreach ($actions as $a)
                                    @if (isset($a['route']) && Route::has($a['route']))
                                        <a href="{{ route($a['route']) }}"
                                            class="btn btn-primary">{{ $a['label'] }}</a>
                                    @elseif(isset($a['url']))
                                        <a href="{{ $a['url'] }}" class="btn btn-glass">{{ $a['label'] }}</a>
                                    @endif
                                @endforeach
                                <button id="btnCopy" class="btn btn-glass"
                                    type="button">คัดลอกรายละเอียดข้อผิดพลาด</button>
                            </div>

                            <div class="small text-white-50">
                                เวลา : {{ $now }} เส้นทาง : {{ $path }}
                            </div>

                            <div id="errBox" class="mt-3"
                                @if (!$debug) style="display:none" @endif>
                                <pre class="err" id="errText">{{ $title }} [{{ $status }}]
                                    Path: {{ $path }}
                                    Referer: {{ $refer }}
                                    @if ($rawMsg !== '')
Message: {{ $rawMsg }}
@endif
                                    @if (isset($exception) && method_exists($exception, 'getFile'))
File: {{ $exception->getFile() }}:{{ $exception->getLine() }}
@endif
                                </pre>
                                @if (!$debug)
                                    <div class="text-white-50 small">* เปิดรายละเอียดอัตโนมัติเมื่อ APP_DEBUG=true</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center opacity-50 mt-4 small">© {{ date('Y') }} Learn2Code</div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const btn = document.getElementById('btnCopy');
            const txt = document.getElementById('errText');
            if (btn && txt) {
                btn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(txt.innerText);
                        btn.innerText = 'คัดลอกแล้ว!';
                        setTimeout(() => btn.innerText = 'คัดลอกรายละเอียดข้อผิดพลาด', 1500);
                    } catch (e) {
                        alert('ไม่สามารถคัดลอกได้');
                    }
                });
            }
        })();
    </script>
</body>

</html>
