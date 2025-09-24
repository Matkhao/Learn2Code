@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    <h3>:: Form Add Course ::</h3>

    <form action="/courses" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Course Title</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="title" required
                       placeholder="Course Title"
                       minlength="3" value="{{ old('title') }}">
                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Category -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Category</label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="category_id" required
                       placeholder="Category ID"
                       value="{{ old('category_id') }}">
                @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Provider -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Provider</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="provider" required
                       placeholder="Course Provider"
                       value="{{ old('provider') }}">
                @error('provider') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Instructor -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Instructor</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="provider_instructor"
                       placeholder="Instructor Name"
                       value="{{ old('provider_instructor') }}">
                @error('provider_instructor') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Level -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Level</label>
            <div class="col-sm-6">
                <select class="form-control" name="level">
                    <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
                @error('level') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Language -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Language</label>
            <div class="col-sm-6">
                <select class="form-control" name="language">
                    <option value="TH" {{ old('language') == 'TH' ? 'selected' : '' }}>Thai</option>
                    <option value="EN" {{ old('language') == 'EN' ? 'selected' : '' }}>English</option>
                </select>
                @error('language') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Price Type -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Price Type</label>
            <div class="col-sm-6">
                <select class="form-control" name="price_type" required>
                    <option value="free" {{ old('price_type') == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="paid" {{ old('price_type') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
                @error('price_type') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Price -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Price</label>
            <div class="col-sm-6">
                <input type="number" step="0.01" class="form-control" name="price"
                       placeholder="Price" value="{{ old('price', 0.00) }}">
                @error('price') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Duration -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Duration</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="duration_text"
                       placeholder="เช่น 10 ชั่วโมง, 6 สัปดาห์"
                       value="{{ old('duration_text') }}">
                @error('duration_text') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Description</label>
            <div class="col-sm-7">
                <textarea name="description" class="form-control" rows="4"
                          placeholder="รายละเอียดคอร์ส">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Cover Image (UPLOAD with name=cover_img) -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Cover Image</label>
            <div class="col-sm-6">
                <input type="file" name="cover_img" accept="image/*" id="cover_img_input" class="form-control">
                @error('cover_img') <div class="text-danger">{{ $message }}</div> @enderror

                <!-- preview -->
                <div class="mt-2">
                    <img id="cover_preview" src="#" alt="" style="display:none;max-width:100%;height:auto;max-height:220px;border:1px solid #eee;border-radius:8px;">
                </div>
            </div>
        </div>

        <!-- Course URL -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Course URL</label>
            <div class="col-sm-7">
                <input type="url" class="form-control" name="course_url"
                       placeholder="ลิงก์ไปหน้าคอร์สจริง"
                       value="{{ old('course_url') }}">
                @error('course_url') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="form-group row mb-3">
            <label class="col-sm-2"></label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary">Insert Course</button>
                <a href="/courses" class="btn btn-danger">Cancel</a>
            </div>
        </div>

    </form>

@endsection

@section('footer')
@endsection

@section('js_before')
<script>
document.getElementById('cover_img_input')?.addEventListener('change', function (e) {
    const [file] = e.target.files || [];
    const img = document.getElementById('cover_preview');
    if (file) {
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    } else {
        img.src = '#';
        img.style.display = 'none';
    }
});
</script>
@endsection

{{-- devbanban.com --}}
