@extends('home') 

@section('js_before')
@include('sweetalert::alert')
@endsection

@section('content')

<h3>:: Form Update Course ::</h3>

<form action="/courses/{{ $id }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <!-- Title -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Course Title</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="title"
                   required minlength="3"
                   value="{{ $title }}">
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Category -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Category</label>
        <div class="col-sm-4">
            <input type="number" class="form-control" name="category_id" value="{{ $category_id }}">
            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Provider -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Provider</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="provider" value="{{ $provider }}">
            @error('provider') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Instructor -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Instructor</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="provider_instructor" value="{{ $provider_instructor }}">
            @error('provider_instructor') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Level -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Level</label>
        <div class="col-sm-4">
            <select class="form-control" name="level">
                <option value="beginner" {{ $level=='beginner'?'selected':'' }}>Beginner</option>
                <option value="intermediate" {{ $level=='intermediate'?'selected':'' }}>Intermediate</option>
                <option value="advanced" {{ $level=='advanced'?'selected':'' }}>Advanced</option>
            </select>
            @error('level') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Language -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Language</label>
        <div class="col-sm-4">
            <select class="form-control" name="language">
                <option value="TH" {{ $language=='TH'?'selected':'' }}>Thai</option>
                <option value="EN" {{ $language=='EN'?'selected':'' }}>English</option>
            </select>
            @error('language') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Price Type -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Price Type</label>
        <div class="col-sm-4">
            <select class="form-control" name="price_type">
                <option value="free" {{ $price_type=='free'?'selected':'' }}>Free</option>
                <option value="paid" {{ $price_type=='paid'?'selected':'' }}>Paid</option>
            </select>
            @error('price_type') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Price -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Price</label>
        <div class="col-sm-4">
            <input type="number" step="0.01" class="form-control" name="price" value="{{ $price }}">
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Duration -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Duration</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="duration_text" value="{{ $duration_text }}">
            @error('duration_text') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Description -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Description</label>
        <div class="col-sm-7">
            <textarea name="description" class="form-control" rows="6">{{ $description }}</textarea>
            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Cover Image -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Cover Image</label>
        <div class="col-sm-6">
            <p>Current Image:</p>
            @if(!empty($cover_img))
              <img src="{{ asset('storage/'.$cover_img) }}" width="200" class="mb-2 rounded">
            @else
              <span class="text-muted">No image uploaded</span>
            @endif
            <p class="mt-2 mb-1">Choose New Image:</p>
            <input type="file" name="cover_img" accept="image/*" class="form-control">
            @error('cover_img') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Course URL -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Course URL</label>
        <div class="col-sm-7">
            <input type="url" class="form-control" name="course_url" value="{{ $course_url }}">
            @error('course_url') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Avg Rating -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Avg Rating</label>
        <div class="col-sm-4">
            <input type="number" step="0.1" min="0" max="5" class="form-control" name="avg_rating" value="{{ $avg_rating }}">
            @error('avg_rating') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Submit -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"></label>
        <div class="col-sm-5">
            <input type="hidden" name="oldImg" value="{{ $cover_img }}">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/courses" class="btn btn-danger">Cancel</a>
        </div>
    </div>

</form>
@endsection
