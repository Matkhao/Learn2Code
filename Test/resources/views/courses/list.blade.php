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
  .page-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem; }
  .page-head h3{ font-weight:800; color:#fff; }
  .btn-primary{ background:var(--blue); border:none; border-radius:var(--radius); font-weight:700; padding:.45rem .9rem; }
  .btn-primary:hover{ background:var(--blue-dark); }
  .table-darkish{ --bs-table-bg:var(--panel); --bs-table-color:var(--text); --bs-table-border-color:var(--border); border-radius:var(--radius); overflow:hidden; }
  thead th{ background:#132033; color:#cfe7ff; border-bottom:2px solid var(--border); }

  /* hover แถว */
  tbody tr{ transition:.25s; }
  tbody tr:hover{ background:var(--blue); color:#fff; }
  tbody tr:hover td{ color:#fff !important; }
  tbody tr:hover .fw-bold,
  tbody tr:hover .text-secondary{ color:#fff !important; }

  .tbl-price{ color:var(--success); font-weight:700; }
  .pic-cell img{ width:80px; height:80px; object-fit:cover; border-radius:10px; background:#0d1117; border:1px solid var(--border); }
  .btn-icon{ border-radius:var(--radius); font-weight:700; padding:.35rem .7rem; }
  .btn-warning{ color:#111; background:#ffca28; border:none; } .btn-warning:hover{ background:#ffb300; }
  .btn-danger{ background:var(--danger); border:none; } .btn-danger:hover{ background:#c62828; }
  .pagination .page-link{ background:var(--panel); color:var(--text); border:1px solid var(--border); }
  .pagination .page-link:hover{ background:var(--blue); color:#fff; }
  .pagination .active>.page-link{ background:var(--blue); border-color:var(--blue); }
</style>
@endsection

@section('content')
  <div class="page-head">
    <h3>:: Courses Management ::</h3>
    <a href="/courses/adding" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-circle me-1"></i> Add Course
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-darkish table-hover align-middle">
      <thead>
        <tr>
          <th class="text-center" width="6%">No.</th>
          <th width="10%">Cover</th>
          <th>Course Title & Description</th>
          <th class="text-center" width="14%">Price</th>
          <th class="text-center" width="7%">Edit</th>
          <th class="text-center" width="7%">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach($courses as $row)
          @php
            $pk = $row->getKey();

            $hasImg = !empty($row->cover_img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($row->cover_img);
            $imgSrc = $hasImg
              ? \Illuminate\Support\Facades\Storage::url($row->cover_img)
              : ( file_exists(public_path('images/placeholder.png'))
                    ? asset('images/placeholder.png')
                    : 'https://via.placeholder.com/160x160?text=No+Image' );
          @endphp
          <tr>
            <td class="text-center">{{ $pk }}</td>
            <td class="pic-cell">
              <img src="{{ $imgSrc }}" alt="{{ $row->title }}">
            </td>
            <td>
              <div class="fw-bold">{{ $row->title }}</div>
              <div class="text-secondary small">
                {{ \Illuminate\Support\Str::limit($row->description, 120, '...') }}
              </div>
            </td>
            <td class="text-center tbl-price">
              @if(($row->price_type ?? 'free') === 'free')
                FREE
              @else
                ฿{{ number_format($row->price ?? 0, 2) }}
              @endif
            </td>
            <td class="text-center">
              <a href="/courses/{{ $pk }}/edit" class="btn btn-warning btn-icon btn-sm">
                <i class="bi bi-pencil-square"></i>
              </a>
            </td>
            <td class="text-center">
              <button type="button" class="btn btn-danger btn-icon btn-sm"
                      onclick="deleteConfirm({{ $pk }})">
                <i class="bi bi-trash"></i>
              </button>
              <form id="delete-form-{{ $pk }}" action="/courses/{{ $pk }}" method="POST" style="display:none;">
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
    {{ $courses->links() }}
  </div>
@endsection

@section('js_before')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteConfirm(id){
  Swal.fire({
    title: 'แน่ใจหรือไม่?',
    text: "คุณต้องการลบคอร์สนี้จริง ๆ หรือไม่",
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
