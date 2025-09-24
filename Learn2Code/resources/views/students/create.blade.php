@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')   
@endsection
@section('content')
 


    <h3> :: Form Add student :: </h3>

    <form action="/student/" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group row mb-2">
            <label class="col-sm-2"> รหัสนักศึกษา </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="std_code" required placeholder="รหัสนักศึกษา "
                    minlength="5" value="{{ old('std_code') }}">
                @if(isset($errors))
                @if($errors->has('std_code'))
                <div class="text-danger"> {{ $errors->first('std_code') }}</div>
                @endif
                @endif
            </div>
        </div>


        <div class="form-group row mb-2">
            <label class="col-sm-2"> ชื่อ - สกุล </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="std_name" required placeholder="ชื่อ - สกุล "
                    minlength="5" value="{{ old('std_name') }}">
                @if(isset($errors))
                @if($errors->has('std_name'))
                <div class="text-danger"> {{ $errors->first('std_name') }}</div>
                @endif
                @endif
            </div>
        </div>


        <div class="form-group row mb-2">
            <label class="col-sm-2">เบอร์โทร </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="std_phone" required placeholder="เบอร์โทร"
                    minlength="10" maxlength="10" value="{{ old('std_phone') }}">
                @if(isset($errors))
                @if($errors->has('std_phone'))
                <div class="text-danger"> {{ $errors->first('std_phone') }}</div>
                @endif
                @endif
            </div>
        </div>

       

        <div class="form-group row mb-2">
            <label class="col-sm-2"> Pic </label>
            <div class="col-sm-6">
                <input type="file" name="std_img" required placeholder="student_img" accept="image/*">
                @if(isset($errors))
                @if($errors->has('std_img'))
                <div class="text-danger"> {{ $errors->first('std_img') }}</div>
                @endif
                @endif
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2"> </label>
            <div class="col-sm-5">

                <button type="submit" class="btn btn-primary"> Insert student </button>
                <a href="/student" class="btn btn-danger">cancel</a>
            </div>
        </div>

    </form>

</div>

    
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}