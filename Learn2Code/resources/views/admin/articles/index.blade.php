@extends('layouts.backend')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-white mb-1">จัดการบทความ</h2>
        <p class="text-muted mb-0">เพิ่ม แก้ไข และจัดการบทความทั้งหมด</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>เพิ่มบทความใหม่
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4" style="background: #0f1319; border: 1px solid var(--border);">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label text-white">ค้นหา</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ $search }}" placeholder="ค้นหาหัวข้อหรือผู้เขียน...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label text-white">สถานะ</label>
                <select class="form-select" id="status" name="status">
                    <option value="">ทุกสถานะ</option>
                    <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>ร่าง</option>
                    <option value="published" {{ $status === 'published' ? 'selected' : '' }}>เผยแพร่</option>
                    <option value="archived" {{ $status === 'archived' ? 'selected' : '' }}>เก็บถาวร</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label text-white">เรียงลำดับ</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="created_desc" {{ $sort === 'created_desc' ? 'selected' : '' }}>ใหม่ล่าสุด</option>
                    <option value="title_asc" {{ $sort === 'title_asc' ? 'selected' : '' }}>หัวข้อ A-Z</option>
                    <option value="title_desc" {{ $sort === 'title_desc' ? 'selected' : '' }}>หัวข้อ Z-A</option>
                    <option value="published_desc" {{ $sort === 'published_desc' ? 'selected' : '' }}>เผยแพร่ล่าสุด</option>
                    <option value="published_asc" {{ $sort === 'published_asc' ? 'selected' : '' }}>เผยแพร่เก่าสุด</option>
                    <option value="views_desc" {{ $sort === 'views_desc' ? 'selected' : '' }}>ยอดดูมากสุด</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-search me-1"></i>ค้นหา
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Articles Table -->
@if($articles->isNotEmpty())
<div class="table-responsive">
    <table class="table table-darkish table-hover">
        <thead>
            <tr>
                <th style="width: 60px;">#</th>
                <th style="width: 80px;">รูปภาพ</th>
                <th>หัวข้อ</th>
                <th style="width: 120px;">ผู้เขียน</th>
                <th style="width: 100px;">สถานะ</th>
                <th style="width: 80px;">ยอดดู</th>
                <th style="width: 120px;">วันที่เผยแพร่</th>
                <th style="width: 200px;" class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>
                    @if($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}"
                             alt="{{ $article->title }}"
                             class="rounded"
                             style="width: 60px; height: 40px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded"
                             style="width: 60px; height: 40px; background: #1a1d25; border: 1px solid var(--border);">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <div>
                        <strong class="text-white">{{ Str::limit($article->title, 50) }}</strong>
                        @if($article->featured)
                            <span class="badge bg-warning text-dark ms-1">
                                <i class="bi bi-star-fill"></i> แนะนำ
                            </span>
                        @endif
                    </div>
                    @if($article->excerpt)
                        <small class="text-muted d-block">{{ Str::limit($article->excerpt, 80) }}</small>
                    @endif
                    @if($article->tags)
                        <div class="mt-1">
                            @foreach(array_slice($article->tags, 0, 3) as $tag)
                                <span class="badge text-bg-secondary me-1" style="font-size: 0.7rem;">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </td>
                <td>
                    <span class="text-white">{{ $article->author }}</span>
                </td>
                <td>
                    @switch($article->status)
                        @case('published')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle-fill me-1"></i>เผยแพร่
                            </span>
                            @break
                        @case('draft')
                            <span class="badge bg-secondary">
                                <i class="bi bi-pencil-fill me-1"></i>ร่าง
                            </span>
                            @break
                        @case('archived')
                            <span class="badge bg-dark">
                                <i class="bi bi-archive-fill me-1"></i>เก็บถาวร
                            </span>
                            @break
                    @endswitch
                </td>
                <td>
                    <span class="badge text-bg-info">
                        <i class="bi bi-eye-fill me-1"></i>{{ number_format($article->views) }}
                    </span>
                </td>
                <td>
                    @if($article->published_at)
                        <span class="text-white">{{ $article->formatted_published_at }}</span>
                        <small class="text-muted d-block">{{ $article->published_at->format('H:i') }}</small>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="{{ route('blog.show', $article->slug) }}" target="_blank"
                           class="btn btn-sm btn-outline-info" title="ดูบทความ">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.articles.edit', $article->id) }}"
                           class="btn btn-sm btn-outline-warning" title="แก้ไข">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger" title="ลบ"
                                onclick="confirmDelete({{ $article->id }}, '{{ addslashes($article->title) }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        แสดง {{ $articles->firstItem() ?? 0 }}-{{ $articles->lastItem() ?? 0 }}
        จากทั้งหมด {{ $articles->total() }} รายการ
    </div>
    <div>
        {{ $articles->appends(request()->query())->links() }}
    </div>
</div>

@else
<!-- Empty State -->
<div class="text-center py-5">
    <i class="bi bi-file-text display-1 text-muted"></i>
    <h4 class="text-white mt-3">ไม่มีบทความ</h4>
    <p class="text-muted">เริ่มต้นสร้างบทความแรกของคุณได้เลย</p>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>เพิ่มบทความใหม่
    </a>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--panel); border: 1px solid var(--border);">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title text-white">ยืนยันการลบ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-white">คุณต้องการลบบทความ <strong id="articleTitle"></strong> หรือไม่?</p>
                <p class="text-danger"><i class="bi bi-exclamation-triangle me-2"></i>การกระทำนี้ไม่สามารถยกเลิกได้</p>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>ลบ
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_before')
<script>
function confirmDelete(articleId, articleTitle) {
    document.getElementById('articleTitle').textContent = articleTitle;
    document.getElementById('deleteForm').action = `/admin/articles/${articleId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Auto-submit form on sort/status change
document.getElementById('sort').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('status').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endsection