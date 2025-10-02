@extends('layouts.backend')

@section('css_before')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+Thai:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin/admin.dashboard.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Assets/Learn2Code_Transparent.png') }}">
@endsection

@section('content')
    @php
        $metrics = $metrics ?? [];
        $m = fn($k, $d = 0) => $metrics[$k] ?? $d;
        $categoryChart = $categoryChart ?? ['labels' => [], 'data' => []];
        $monthChart = $monthChart ?? ['labels' => [], 'data' => []];
        $latestCourses = $latestCourses ?? collect();
    @endphp

    <div class="page-hero">
        <h2><i class="bi bi-speedometer2"></i> แดชบอร์ดภาพรวม</h2>
        <p>สรุปข้อมูลระบบคอร์สเรียนและผู้ใช้งาน</p>
    </div>

    <div class="stat-grid mb-3">
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-person-badge"></i> ผู้ดูแลระบบ</div>
            <div class="stat-value kpi-blue" id="kpi-admins">{{ number_format($m('admins')) }}</div>
            <div class="stat-sub">จำนวนผู้ใช้สิทธิ์ผู้ดูแลระบบทั้งหมด</div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-people"></i> สมาชิกทั้งหมด</div>
            <div class="stat-value kpi-green" id="kpi-members">{{ number_format($m('members')) }}</div>
            <div class="stat-sub">สมาชิกที่ลงทะเบียนในระบบ</div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-journal-code"></i> คอร์สเรียน</div>
            <div class="stat-value" id="kpi-courses">{{ number_format($m('courses_total')) }}</div>
            <div class="stat-sub">ฟรี <span id="kpi-free">{{ number_format($m('free_courses')) }}</span> / เสียค่าใช้จ่าย
                <span id="kpi-paid">{{ number_format($m('paid_courses')) }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-tags"></i> หมวดหมู่</div>
            <div class="stat-value" id="kpi-categories">{{ number_format($m('categories_total')) }}</div>
            <div class="stat-sub">หมวดหมู่คอร์สทั้งหมด</div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-star-half"></i> คะแนนเฉลี่ยคอร์ส</div>
            <div class="stat-value" id="kpi-avg-rating">{{ number_format($m('avg_rating'), 2) }}</div>
            <div class="stat-sub">อ้างอิงจากตารางรีวิว</div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-cash-coin"></i> ราคาเฉลี่ย</div>
            <div class="stat-value kpi-orange" id="kpi-avg-price">{{ number_format($m('avg_price'), 2) }}</div>
            <div class="stat-sub">หน่วยเป็นสกุลเงินที่บันทึกในระบบ</div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-chat-left-text"></i> รีวิวทั้งหมด</div>
            <div class="stat-value" id="kpi-reviews">{{ number_format($m('reviews_total')) }}</div>
            <div class="stat-sub">จำนวนรีวิวจากผู้ใช้</div>
        </div>
        <div class="stat-card">
            <div class="stat-title"><i class="bi bi-heart"></i> การกดถูกใจ</div>
            <div class="stat-value kpi-red" id="kpi-favorites">{{ number_format($m('favorites_total')) }}</div>
            <div class="stat-sub">จำนวนคอร์สที่ถูกบันทึกเป็นรายการโปรด</div>
        </div>
    </div>

    <div class="card-ui mb-3">
        <div class="card-head"><i class="bi bi-graph-up"></i>
            <div class="title">ภาพรวมเชิงสถิติ <small class="text-secondary ms-2" id="dash-updated-at"></small></div>
        </div>
        <div class="card-body">
            <div class="chart-wrap">
                <div class="card-ui">
                    <div class="card-head"><i class="bi bi-bar-chart"></i>
                        <div class="title">จำนวนคอร์สตามหมวดหมู่</div>
                    </div>
                    <div class="card-body"><canvas id="categoryBar" height="140" role="img"
                            aria-label="กราฟแท่งจำนวนคอร์สตามหมวดหมู่"></canvas></div>
                </div>
                <div class="card-ui">
                    <div class="card-head"><i class="bi bi-pie-chart"></i>
                        <div class="title">สัดส่วนคอร์ส ฟรี / มีค่าใช้จ่าย</div>
                    </div>
                    <div class="card-body"><canvas id="pricePie" height="100" role="img"
                            aria-label="กราฟสัดส่วนคอร์สฟรีและเสียค่าใช้จ่าย"></canvas></div>
                </div>
            </div>

            <div class="card-ui mt-3">
                <div class="card-head"><i class="bi bi-activity"></i>
                    <div class="title">จำนวนคอร์สที่เพิ่มใหม่รายเดือน</div>
                </div>
                <div class="card-body"><canvas id="monthLine" height="100" role="img"
                        aria-label="กราฟเส้นจำนวนคอร์สใหม่รายเดือน"></canvas></div>
            </div>
        </div>
    </div>

    <div class="card-ui">
        <div class="card-head"><i class="bi bi-clock-history"></i>
            <div class="title">คอร์สที่เพิ่มล่าสุด</div>
        </div>
        <div class="card-body">
            @if ($latestCourses->count())
                <div class="table-responsive">
                    <table class="table table-darkish align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ชื่อคอร์ส</th>
                                <th class="text-nowrap">ภาษา</th>
                                <th class="text-end">ราคา</th>
                                <th class="text-end">คะแนนเฉลี่ย</th>
                                <th class="text-nowrap">เพิ่มเมื่อ</th>
                                <th class="text-end">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="latest-courses-tbody">
                            @foreach ($latestCourses as $c)
                                @php
                                    $created = \Illuminate\Support\Carbon::parse($c->created_at);
                                @endphp
                                <tr>
                                    <td class="fw-semibold">
                                        <a href="{{ url('/admin/courses/' . $c->course_id . '/edit') }}"
                                            class="text-decoration-none">{{ $c->title }}</a>
                                    </td>
                                    <td class="text-nowrap">{{ strtoupper($c->language ?? 'TH') }}</td>
                                    <td class="text-end">
                                        @if (($c->price ?? 0) <= 0)
                                            <span class="badge text-bg-success">FREE</span>
                                        @else
                                            {{ number_format((float) $c->price, 2) }}
                                        @endif
                                    </td>
                                    <td class="text-end">{{ number_format((float) ($c->avg_rating ?? 0), 2) }}</td>
                                    <td class="text-nowrap">{{ $created->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ url('/admin/courses/' . $c->course_id . '/edit') }}"
                                            class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-secondary">ยังไม่มีข้อมูล</div>
            @endif
        </div>
    </div>
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const colors = {
                text: '#e9f1fa',
                grid: '#1c1f27',
                tick: '#9aa5b4',
                blue: '#2196f3',
                blueA: 'rgba(33,150,243,.28)',
                green: '#22c55e',
                greenA: 'rgba(34,197,94,.28)',
                orange: '#f59e0b',
                orangeA: 'rgba(245,158,11,.28)'
            };
            const noDataPlugin = {
                id: 'noData',
                afterDraw(chart, args, opts) {
                    const has = (chart.data.datasets || []).some(ds => (ds.data || []).map(v => +v || 0).reduce(
                        (a, b) => a + b, 0) > 0);
                    if (has) return;
                    const {
                        ctx,
                        chartArea: {
                            left,
                            right,
                            top,
                            bottom
                        }
                    } = chart;
                    ctx.save();
                    ctx.fillStyle = '#9aa5b4';
                    ctx.textAlign = 'center';
                    ctx.font = '600 14px system-ui';
                    ctx.fillText(opts?.text || 'ไม่มีข้อมูล', (left + right) / 2, (top + bottom) / 2);
                    ctx.restore();
                }
            };
            const axisCommon = () => ({
                grid: {
                    color: colors.grid,
                    borderColor: colors.grid
                },
                ticks: {
                    color: colors.tick,
                    precision: 0
                }
            });

            let catChart = null,
                pieChart = null,
                lineChart = null;

            function makeOrUpdateBar(ctx, labels, data) {
                if (!catChart) {
                    catChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [{
                                label: 'จำนวนคอร์ส',
                                data,
                                backgroundColor: colors.blueA,
                                borderColor: colors.blue,
                                borderWidth: 1.5,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: colors.text
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                },
                                noData: {
                                    text: 'ไม่มีข้อมูลหมวดหมู่'
                                }
                            },
                            scales: {
                                x: axisCommon(),
                                y: {
                                    ...axisCommon(),
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [noDataPlugin]
                    });
                } else {
                    catChart.data.labels = labels;
                    catChart.data.datasets[0].data = data;
                    catChart.update();
                }
            }

            function makeOrUpdatePie(ctx, free, paid) {
                if (!pieChart) {
                    pieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['ฟรี', 'มีค่าใช้จ่าย'],
                            datasets: [{
                                data: [free, paid],
                                backgroundColor: [colors.greenA, colors.orangeA],
                                borderColor: [colors.green, colors.orange],
                                borderWidth: 1.5
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: colors.text
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                },
                                noData: {
                                    text: 'ยังไม่มีคอร์ส'
                                }
                            },
                            cutout: '60%'
                        },
                        plugins: [noDataPlugin]
                    });
                } else {
                    pieChart.data.datasets[0].data = [free, paid];
                    pieChart.update();
                }
            }

            function makeOrUpdateLine(ctx, labels, data) {
                if (!lineChart) {
                    lineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: 'คอร์สใหม่ (รายเดือน)',
                                data,
                                tension: .25,
                                fill: false,
                                borderColor: colors.blue,
                                backgroundColor: colors.blueA,
                                pointRadius: 3,
                                pointHoverRadius: 4,
                                pointBorderColor: colors.blue
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: colors.text
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                },
                                noData: {
                                    text: 'ไม่มีข้อมูลในช่วงเวลา'
                                }
                            },
                            scales: {
                                x: axisCommon(),
                                y: {
                                    ...axisCommon(),
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [noDataPlugin]
                    });
                } else {
                    lineChart.data.labels = labels;
                    lineChart.data.datasets[0].data = data;
                    lineChart.update();
                }
            }

            makeOrUpdateBar(document.getElementById('categoryBar'), @json($categoryChart['labels'] ?? []),
                @json($categoryChart['data'] ?? []));
            makeOrUpdatePie(document.getElementById('pricePie'), Number(@json($m('free_courses'))), Number(
                @json($m('paid_courses'))));
            makeOrUpdateLine(document.getElementById('monthLine'), @json($monthChart['labels'] ?? []),
                @json($monthChart['data'] ?? []));

            const setUpdatedAt = () => {
                const el = document.getElementById('dash-updated-at');
                if (el) {
                    const d = new Date();
                    el.textContent = `(อัปเดตล่าสุด ${d.toLocaleTimeString()})`;
                }
            };
            setUpdatedAt();

            const refreshUrl = "{{ route('admin.dashboard.refresh') }}";
            const nf = new Intl.NumberFormat();
            const setText = (id, val, fixed = null) => {
                const el = document.getElementById(id);
                if (!el) return;
                el.textContent = fixed === null ? nf.format(val || 0) : Number(val || 0).toFixed(fixed);
            };

            async function refreshDashboard() {
                try {
                    const res = await fetch(refreshUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) return;
                    const j = await res.json();
                    const m = j.metrics || {};
                    setText('kpi-admins', m.admins);
                    setText('kpi-members', m.members);
                    setText('kpi-courses', m.courses_total);
                    setText('kpi-categories', m.categories_total);
                    setText('kpi-reviews', m.reviews_total);
                    setText('kpi-favorites', m.favorites_total);
                    setText('kpi-free', m.free_courses);
                    setText('kpi-paid', m.paid_courses);
                    setText('kpi-avg-price', m.avg_price, 2);
                    setText('kpi-avg-rating', m.avg_rating, 2);
                    makeOrUpdateBar(document.getElementById('categoryBar'), j.categoryChart?.labels || [], j
                        .categoryChart?.data || []);
                    makeOrUpdatePie(document.getElementById('pricePie'), Number(m.free_courses || 0), Number(m
                        .paid_courses || 0));
                    makeOrUpdateLine(document.getElementById('monthLine'), j.monthChart?.labels || [], j
                        .monthChart?.data || []);
                    setUpdatedAt();
                } catch (e) {
                    console.warn('dashboard refresh failed', e);
                }
            }
            setInterval(refreshDashboard, 30000);
        });
    </script>
@endsection
