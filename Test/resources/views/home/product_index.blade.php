@extends('frontend')

{{-- ===== CSS เพิ่มเติมสำหรับธีมดำ-ฟ้า + การ์ดสินค้า ===== --}}
@section('css_before')
<style>
  /* สีหลัก */
  :root{
    --bg:#0a0c10;           /* พื้นหลังดำ */
    --panel:#12141a;        /* ดำเข้มสำหรับการ์ด */
    --text:#e9f1fa;         /* ข้อความหลัก */
    --muted:#9aa5b4;        /* ข้อความรอง */
    --blue:#2196f3;         /* ฟ้า */
    --blue-dark:#1976d2;    /* ฟ้าเข้ม */
    --green:#21c17a;        /* ราคา/สถานะ */
    --border:#1c2029;       /* เส้นขอบการ์ด */
  }

  /* การ์ดสินค้า */
  .product-card{
    background: var(--panel);
    border: 1px solid var(--border) !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 24px rgba(0,0,0,.25);
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    overflow: hidden;
  }
  .product-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 22px 48px rgba(0,0,0,.45);
    border-color: #253045 !important;
  }

  /* โซนรูป */
  .product-thumb{
    height: 220px;
    width: 100%;
    object-fit: cover;
    background:#0d1117;
    transition: transform .35s ease;
  }
  .product-card:hover .product-thumb{
    transform: scale(1.05);
  }

  /* ป้ายมุม (เช่น ใหม่/ขายดี) */
  .ribbon{
    position:absolute; top:10px; left:10px;
    background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
    color:#fff; font-weight:800; font-size:.75rem;
    padding:.35rem .6rem; border-radius:999px; letter-spacing:.2px;
    box-shadow:0 8px 24px rgba(33,150,243,.35);
  }

  /* เนื้อหาในการ์ด */
  .product-body{
    background: var(--panel);
    color: var(--text);
    padding: 14px 16px;
    display:flex; flex-direction:column; height:100%;
  }
  .product-title{
    font-weight:800; margin:0 0 6px;
    color:#ffffff;
    text-decoration:none;
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
  }
  .product-meta{ color:var(--muted); }
  .product-price{
    color: var(--green);
    font-weight:900;
    font-size:1.05rem;
  }

  /* ปุ่ม */
  .btn-outline-blue{
    border:1px solid var(--blue);
    color: var(--blue);
    border-radius: 999px;
    font-weight:800;
    transition: .2s ease;
  }
  .btn-outline-blue:hover{
    background: var(--blue);
    color:#fff;
  }

  /* ลิงก์ชื่อสินค้า */
  .link-plain{ color:#e9f1fa; text-decoration:none; }
  .link-plain:hover{ color:#ffffff; }

  /* pagination ให้เข้าธีมมืด */
  .pagination .page-link{
    background:#0f1319; border:1px solid #2a2d38; color:#d0daea;
  }
  .pagination .page-link:hover{
    background:#101725; color:#fff;
  }
  .pagination .active .page-link{
    background: var(--blue); border-color: var(--blue); color:#fff;
  }
</style>
@endsection

@section('navbar')
@endsection

{{-- ===== GRID แสดงสินค้า ===== --}}
@section('showProduct')

  @foreach($products as $data)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
      <div class="card product-card position-relative h-100 border-0">

        {{-- รูปสินค้า --}}
        <a href="/detail/{{ $data->id }}" class="d-block">
          <img
            src="{{ asset('storage/' . $data->product_img) }}"
            alt="{{ $data->product_name }}"
            class="product-thumb"
          >
        </a>

        {{-- ป้ายสถานะ ตัวอย่าง: แสดงถ้ามีฟิลด์ is_new หรือยอดขายดี --}}
        @if(!empty($data->is_new))
          <span class="ribbon">ใหม่</span>
        @endif

        {{-- เนื้อหา --}}
        <div class="product-body">
          <h5 class="mb-1">
            <a href="/detail/{{ $data->id }}" class="product-title link-plain">
              {{ $data->product_name }}
            </a>
          </h5>

          <div class="product-meta mb-2">
            {{-- ใส่หมวดหมู่/สั้น ๆ ได้ถ้ามี --}}
            @if(!empty($data->category_name))
              <small class="me-1">หมวด:</small>
              <small class="text-secondary">{{ $data->category_name }}</small>
            @endif
          </div>

          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="product-price">฿{{ number_format($data->product_price, 2) }}</span>
            @if(!empty($data->stock))
              <small class="text-secondary">{{ $data->stock }}</small>
            @endif
          </div>

          <a href="/detail/{{ $data->id }}" class="btn btn-sm btn-outline-blue mt-auto">
            รายละเอียดเพิ่มเติม
          </a>
        </div>

      </div>
    </div>
  @endforeach

  {{-- Pagination --}}
  <div class="row mt-3">
    <div class="col-12 d-flex justify-content-center">
      {{ $products->links() }}
    </div>
  </div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}
