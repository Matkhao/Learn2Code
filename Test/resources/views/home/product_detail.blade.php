@extends('frontend')
@section('css_before')
@section('navbar')
@endsection
@section('showProduct')

<div class="col-12 col-sm-3 col-md-3 mb-2">
    <div class="card" style="width: 100%;">
        <img src="{{ asset('storage/' . $product_img) }}" class="card-img-top" alt="devbanban.com">
    </div>
</div>
<div class="col-12 col-sm-8 col-md-8 mb-2">
    <h5 class="card-title">{{ $product_name }}, Price {{ number_format($product_price) }} THB. </h5>
    <p>
        <b>รายละเอียดสินค้า</b>
        <br>
        {{ $product_detail }}
        <a href="/" class="btn btn-outline-success mt-3">กลับหน้าหลัก</a>
    </p>
</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}