@extends('layouts.backend')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-white mb-1">เพิ่มบทความใหม่</h2>
        <p class="text-muted mb-0">สร้างบทความใหม่สำหรับเว็บไซต์</p>
    </div>
    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>กลับ
    </a>
</div>

<form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf

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
                               id="title" name="title" value="{{ old('title') }}"
                               placeholder="กรอกหัวข้อบทความ..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-4">
                        <label for="excerpt" class="form-label text-white fw-bold">บทนำ</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt" name="excerpt" rows="3"
                                  placeholder="บทนำสั้นๆ เพื่อดึงดูดผู้อ่าน (ไม่เกิน 500 ตัวอักษร)">{{ old('excerpt') }}</textarea>
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
                                  placeholder="เขียนเนื้อหาบทความที่นี่..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-4">
                        <label for="meta_description" class="form-label text-white fw-bold">Meta Description (SEO)</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="2"
                                  placeholder="คำอธิบายสำหรับ Google Search (ไม่เกิน 160 ตัวอักษร)">{{ old('meta_description') }}</textarea>
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
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>ร่าง</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>เผยแพร่</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>เก็บถาวร</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Published Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label text-white fw-bold">วันที่เผยแพร่</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at" value="{{ old('published_at') }}">
                        <div class="form-text text-muted">หากไม่กรอก จะใช้วันที่ปัจจุบันเมื่อเผยแพร่</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="featured">
                                <i class="bi bi-star-fill text-warning me-1"></i>บทความแนะนำ
                            </label>
                        </div>
                        <div class="form-text text-muted">บทความแนะนำจะแสดงในหน้าหลักของบล็อก</div>
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
                               id="author" name="author" value="{{ old('author', 'Learn2Code Team') }}"
                               placeholder="ชื่อผู้เขียน" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                        <label for="tags" class="form-label text-white fw-bold">หมวดหมู่ (Tags)</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                               id="tags" name="tags" value="{{ old('tags') }}"
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
                    <div class="mb-3">
                        <label for="featured_image" class="form-label text-white fw-bold">อัปโหลดรูปภาพ</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                               id="featured_image" name="featured_image" accept="image/*">
                        <div class="form-text text-muted">
                            รองรับ: JPG, JPEG, PNG, WebP | ขนาดไม่เกิน 5MB
                        </div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <img id="previewImg" src="" alt="Preview"
                             class="img-fluid rounded border"
                             style="max-height: 200px; border-color: var(--border) !important;">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-2"></i>บันทึกบทความ
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>ยกเลิก
                </a>
            </div>
        </div>
    </div>
</form>

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
    }

    // Add character counter for meta description
    const metaLabel = document.querySelector('label[for="meta_description"]');
    if (metaLabel) {
        metaLabel.innerHTML += ' <small id="metaCount" class="text-muted">(0/160)</small>';
        updateCharCount('meta_description', 'metaCount', 160);
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

// Tag suggestions (simple implementation)
document.getElementById('tags').addEventListener('input', function() {
    // You can enhance this with AJAX to fetch existing tags from the database
    // For now, we'll keep it simple
});
</script>
@endsection