@extends('home')

@section('css_before')
<style>
  :root{
    --bg:#0a0c10; --panel:#12141a; --border:#1c1f27;
    --text:#e9f1fa; --muted:#9aa5b4;
    --blue:#2196f3; --blue-dark:#1976d2;
    --danger:#e53935; --success:#21c17a;
    --radius:14px;
  }

  body{ background:var(--bg); color:var(--text); }

  /* ส่วนหัว */
  .page-head{
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:1.2rem;
  }
  .page-head h3{ font-weight:800; color:#fff; }

  .btn-primary{
    background:var(--blue); border:none; border-radius:var(--radius);
    font-weight:700; padding:.45rem .9rem;
  }
  .btn-primary:hover{ background:var(--blue-dark); }

  /* ตาราง */
  .table-darkish{
    --bs-table-bg:var(--panel);
    --bs-table-color:var(--text);
    --bs-table-border-color:var(--border);
    border-radius:var(--radius);
    overflow:hidden;
  }
  thead th{
    background:#132033; color:#cfe7ff;
    border-bottom:2px solid var(--border);
  }

  /* hover แถว */
  tbody tr{ transition:.25s; }
  tbody tr:hover{ background:#182131; }
  tbody tr:hover td{ color:var(--blue); }
  tbody tr:hover .fw-bold,
  tbody tr:hover .text-secondary{ color:var(--blue) !important; }

  /* ราคา */
  .tbl-price{ color:var(--success); font-weight:700; }

  /* รูปสินค้า */
  .pic-cell img{
    width:80px; height:80px; object-fit:contain;
    border-radius:10px; background:#0d1117; border:1px solid var(--border);
  }

  /* ปุ่ม */
  .btn-icon{
    border-radius:var(--radius); font-weight:700; padding:.35rem .7rem;
  }
  .btn-warning{ color:#111; background:#ffca28; border:none; }
  .btn-warning:hover{ background:#ffb300; }
  .btn-danger{ background:var(--danger); border:none; }
  .btn-danger:hover{ background:#c62828; }

  /* Pagination */
  .pagination .page-link{
    background:var(--panel); color:var(--text); border:1px solid var(--border);
  }
  .pagination .page-link:hover{ background:var(--blue); color:#fff; }
  .pagination .active>.page-link{ background:var(--blue); border-color:var(--blue); }
</style>
@endsection

@section('content')
  <div class="page-head">
    <h3>:: Product Managements ::</h3>
    <a href="/product/adding" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-circle me-1"></i> Add Product
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-darkish table-hover align-middle">
      <thead>
        <tr>
          <th class="text-center" width="6%">No.</th>
          <th width="10%">Pic</th>
          <th>Product Name & Detail</th>
          <th class="text-center" width="14%">Price</th>
          <th class="text-center" width="7%">Edit</th>
          <th class="text-center" width="7%">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $row)
          <tr>
            <td class="text-center">{{ $row->id }}</td>
            <td class="pic-cell">
              <img src="{{ asset('storage/' . $row->product_img) }}"
                   alt="{{ $row->product_name }}"
                   onerror="this.src='{{ asset('images/placeholder.png') }}'">
            </td>
            <td>
              <div class="fw-bold">{{ $row->product_name }}</div>
              <div class="text-secondary small">
                {{ Str::limit($row->product_detail, 120, '...') }}
              </div>
            </td>
            <td class="text-center tbl-price">
              ฿{{ number_format($row->product_price, 2) }}
            </td>
            <td class="text-center">
              <a href="/product/{{ $row->id }}" class="btn btn-warning btn-icon btn-sm">
                <i class="bi bi-pencil-square"></i>
              </a>
            </td>
            <td class="text-center">
              <button type="button" class="btn btn-danger btn-icon btn-sm"
                      onclick="deleteConfirm({{ $row->id }})">
                <i class="bi bi-trash"></i>
              </button>
              <form id="delete-form-{{ $row->id }}" 
                    action="/product/remove/{{ $row->id }}" 
                    method="POST" style="display:none;">
                @csrf
                @method('delete')
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $products->links() }}
  </div>
@endsection

@section('js_before')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteConfirm(id){
  Swal.fire({
    title: 'แน่ใจหรือไม่?',
    text: "คุณต้องการลบข้อมูลนี้จริง ๆ หรือไม่",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#2196f3',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเลย!',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if(result.isConfirmed){
      document.getElementById('delete-form-'+id).submit();
    }
  })
}
</script>
@endsection
