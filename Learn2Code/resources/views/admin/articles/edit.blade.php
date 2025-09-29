@extends('layouts.backend')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-white mb-1">แก้ไขบทความ</h2>
        <p class="text-muted mb-0">แก้ไขข้อมูลบทความ: {{ Str::limit($article->title, 50) }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="btn btn-outline-info">
            <i class="bi bi-eye me-2"></i>ดูบทความ
        </a>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>กลับ
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card" style="background: #0f1319; border: 1px solid var(--border);">
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label text-white fw-bold">
                            หัวข้อบทความ <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $article->title) }}"
                               placeholder="กรอกหัวข้อบทความ..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($article->slug)
                            <div class="form-text text-muted">
                                <i class="bi bi-link-45deg me-1"></i>
                                URL: <code>{{ url('/blog/' . $article->slug) }}</code>
                            </div>
                        @endif
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-4">
                        <label for="excerpt" class="form-label text-white fw-bold">บทนำ</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt" name="excerpt" rows="3"
                                  placeholder="บทนำสั้นๆ เพื่อดึงดูดผู้อ่าน (ไม่เกิน 500 ตัวอักษร)">{{ old('excerpt', $article->excerpt) }}</textarea>
                        <div class="form-text text-muted">หากไม่กรอก ระบบจะใช้เนื้อหาย่อหน้าแรกแทน</div>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label text-white fw-bold">
                            เนื้อหาบทความ <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="15"
                                  placeholder="เขียนเนื้อหาบทความที่นี่..." required>{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-4">
                        <label for="meta_description" class="form-label text-white fw-bold">Meta Description (SEO)</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="2"
                                  placeholder="คำอธิบายสำหรับ Google Search (ไม่เกิน 160 ตัวอักษร)">{{ old('meta_description', $article->meta_description) }}</textarea>
                        <div class="form-text text-muted">แนะนำให้กรอกเพื่อช่วยให้บทความแสดงผลดีใน Google</div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publishing Options -->
            <div class="card mb-4" style="background: #0f1319; border: 1px solid var(--border);">
                <div class="card-header border-bottom border-secondary">
                    <h6 class="text-white mb-0">
                        <i class="bi bi-gear-fill me-2"></i>ตัวเลือกการเผยแพร่
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label text-white fw-bold">
                            สถานะ <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>ร่าง</option>
                            <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>เผยแพร่</option>
                            <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>เก็บถาวร</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Published Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label text-white fw-bold">วันที่เผยแพร่</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at"
                               value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text text-muted">หากไม่กรอก จะใช้วันที่ปัจจุบันเมื่อเผยแพร่</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                   {{ old('featured', $article->featured) ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="featured">
                                <i class="bi bi-star-fill text-warning me-1"></i>บทความแนะนำ
                            </label>
                        </div>
                        <div class="form-text text-muted">บทความแนะนำจะแสดงในหน้าหลักของบล็อก</div>
                    </div>

                    <!-- Article Stats -->
                    <div class="mt-4 pt-3 border-top border-secondary">
                        <h6 class="text-white mb-3">สถิติบทความ</h6>
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="p-2 rounded" style="background: rgba(33, 150, 243, .1);">
                                    <div class="text-primary fw-bold">{{ number_format($article->views) }}</div>
                                    <small class="text-muted">ยอดดู</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 rounded" style="background: rgba(33, 193, 122, .1);">
                                    <div class="text-success fw-bold">{{ $article->reading_time }}</div>
                                    <small class="text-muted">อ่าน</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author & Tags -->
            <div class="card mb-4" style="background: #0f1319; border: 1px solid var(--border);">
                <div class="card-header border-bottom border-secondary">
                    <h6 class="text-white mb-0">
                        <i class="bi bi-person-fill me-2"></i>ข้อมูลผู้เขียน
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Author -->
                    <div class="mb-3">
                        <label for="author" class="form-label text-white fw-bold">
                            ผู้เขียน <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror"
                               id="author" name="author" value="{{ old('author', $article->author) }}"
                               placeholder="ชื่อผู้เขียน" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                        <label for="tags" class="form-label text-white fw-bold">หมวดหมู่ (Tags)</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                               id="tags" name="tags"
                               value="{{ old('tags', $article->tags ? implode(', ', $article->tags) : '') }}"
                               placeholder="เช่น: JavaScript, Laravel, React">
                        <div class="form-text text-muted">คั่นด้วยเครื่องหมายจุลภาค (,)</div>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="card mb-4" style="background: #0f1319; border: 1px solid var(--border);">
                <div class="card-header border-bottom border-secondary">
                    <h6 class="text-white mb-0">
                        <i class="bi bi-image-fill me-2"></i>รูปภาพประกอบ
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Current Image -->
                    @if($article->featured_image)
                    <div class="mb-3">
                        <label class="form-label text-white fw-bold">รูปภาพปัจจุบัน</label>
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                 alt="{{ $article->title }}"
                                 class="img-fluid rounded border d-block"
                                 style="max-height: 200px; border-color: var(--border) !important;">
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="featured_image" class="form-label text-white fw-bold">
                            {{ $article->featured_image ? 'เปลี่ยนรูปภาพ' : 'อัปโหลดรูปภาพ' }}
                        </label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                               id="featured_image" name="featured_image" accept="image/*">
                        <div class="form-text text-muted">
                            รองรับ: JPG, JPEG, PNG, WebP | ขนาดไม่เกิน 5MB
                            @if($article->featured_image)
                                <br>หากไม่เลือกไฟล์ใหม่ จะใช้รูปภาพเดิม
                            @endif
                        </div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Image Preview -->
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <label class="form-label text-white fw-bold">ตัวอย่างรูปภาพใหม่</label>
                        <img id="previewImg" src="" alt="Preview"
                             class="img-fluid rounded border d-block"
                             style="max-height: 200px; border-color: var(--border) !important;">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-2"></i>บันทึกการแก้ไข
                </button>
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-2"></i>ยกเลิก
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-danger w-100"
                                onclick="confirmDelete({{ $article->id }}, '{{ addslashes($article->title) }}')">
                            <i class="bi bi-trash me-2"></i>ลบบทความ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publishing Options -->
            <div class="card mb-4" style="background: #0f1319; border: 1px solid var(--border);">
                <div class="card-header border-bottom border-secondary">
                    <h6 class="text-white mb-0">
                        <i class="bi bi-gear-fill me-2"></i>ตัวเลือกการเผยแพร่
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label text-white fw-bold">
                            สถานะ <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>ร่าง</option>
                            <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>เผยแพร่</option>
                            <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>เก็บถาวร</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Published Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label text-white fw-bold">วันที่เผยแพร่</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at"
                               value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text text-muted">หากไม่กรอก จะใช้วันที่ปัจจุบันเมื่อเผยแพร่</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                   {{ old('featured', $article->featured) ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="featured">
                                <i class="bi bi-star-fill text-warning me-1"></i>บทความแนะนำ
                            </label>
                        </div>
                        <div class="form-text text-muted">บทความแนะนำจะแสดงในหน้าหลักของบล็อก</div>
                    </div>

                    <!-- Article Stats -->
                    <div class="mt-4 pt-3 border-top border-secondary">
                        <h6 class="text-white mb-3">สถิติบทความ</h6>
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="p-2 rounded" style="background: rgba(33, 150, 243, .1);">
                                    <div class="text-primary fw-bold">{{ number_format($article->views) }}</div>
                                    <small class="text-muted">ยอดดู</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 rounded" style="background: rgba(33, 193, 122, .1);">
                                    <div class="text-success fw-bold">{{ $article->reading_time }}</div>
                                    <small class="text-muted">อ่าน</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-muted small">
                            <i class="bi bi-calendar me-1"></i>
                            สร้างเมื่อ: {{ $article->created_at->format('d/m/Y H:i') }}
                            @if($article->updated_at != $article->created_at)
                                <br><i class="bi bi-pencil me-1"></i>
                                แก้ไขล่าสุด: {{ $article->updated_at->format('d/m/Y H:i') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author & Tags -->
            <div class="card mb-4" style="background: #0f1319; border: 1px solid var(--border);">
                <div class="card-header border-bottom border-secondary">
                    <h6 class="text-white mb-0">
                        <i class="bi bi-person-fill me-2"></i>ข้อมูลผู้เขียน
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Author -->
                    <div class="mb-3">
                        <label for="author" class="form-label text-white fw-bold">
                            ผู้เขียน <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror"
                               id="author" name="author" value="{{ old('author', $article->author) }}"
                               placeholder="ชื่อผู้เขียน" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                        <label for="tags" class="form-label text-white fw-bold">หมวดหมู่ (Tags)</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                               id="tags" name="tags"
                               value="{{ old('tags', $article->tags ? implode(', ', $article->tags) : '') }}"
                               placeholder="เช่น: JavaScript, Laravel, React">
                        <div class="form-text text-muted">คั่นด้วยเครื่องหมายจุลภาค (,)</div>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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

@section('css_before')
<style>
/* Form Styling */
.form-control, .form-select {
    background: #0e1218;
    color: #dfe7f3;
    border: 1px solid var(--border);
    border-radius: 8px;
}

.form-control:focus, .form-select:focus {
    background: #0e1218;
    color: #dfe7f3;
    border-color: var(--blue);
    box-shadow: 0 0 0 .2rem rgba(33, 150, 243, .15);
}

.form-check-input:checked {
    background-color: var(--blue);
    border-color: var(--blue);
}

.form-check-input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 .2rem rgba(33, 150, 243, .15);
}

.card {
    box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
}

.card-header {
    background: rgba(255, 255, 255, .02);
}

/* Button Enhancements */
.btn-primary {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    border: none;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(33, 150, 243, .25);
}

.btn-primary:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

.btn-outline-secondary {
    border-color: var(--border);
    color: var(--muted);
}

.btn-outline-secondary:hover {
    background: var(--border);
    color: var(--text);
}

/* Responsive */
@media (max-width: 992px) {
    .col-lg-8, .col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection

@section('js_before')
<script>
function confirmDelete(articleId, articleTitle) {
    document.getElementById('articleTitle').textContent = articleTitle;
    document.getElementById('deleteForm').action = `/admin/articles/${articleId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Image preview functionality
document.getElementById('featured_image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Auto-resize textarea
function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

document.getElementById('content').addEventListener('input', function() {
    autoResize(this);
});

document.getElementById('excerpt').addEventListener('input', function() {
    autoResize(this);
});

// Character count for excerpt and meta description
function updateCharCount(inputId, countId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(countId);

    if (input && counter) {
        input.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/${maxLength}`;
            counter.className = length > maxLength ? 'text-danger' : 'text-muted';
        });
    }
}

// Add character counters
document.addEventListener('DOMContentLoaded', function() {
    // Add character counter for excerpt
    const excerptLabel = document.querySelector('label[for="excerpt"]');
    if (excerptLabel) {
        excerptLabel.innerHTML += ' <small id="excerptCount" class="text-muted">(0/500)</small>';
        updateCharCount('excerpt', 'excerptCount', 500);
        // Update initial count
        const excerpt = document.getElementById('excerpt');
        if (excerpt.value) {
            document.getElementById('excerptCount').textContent = `${excerpt.value.length}/500`;
        }
    }

    // Add character counter for meta description
    const metaLabel = document.querySelector('label[for="meta_description"]');
    if (metaLabel) {
        metaLabel.innerHTML += ' <small id="metaCount" class="text-muted">(0/160)</small>';
        updateCharCount('meta_description', 'metaCount', 160);
        // Update initial count
        const meta = document.getElementById('meta_description');
        if (meta.value) {
            document.getElementById('metaCount').textContent = `${meta.value.length}/160`;
        }
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();

    if (!title || !content) {
        e.preventDefault();
        alert('กรุณากรอกหัวข้อและเนื้อหาบทความ');
        return false;
    }
});
</script>
@endsection