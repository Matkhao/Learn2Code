@extends('frontend')
@section('css_before')
@section('navbar')
@endsection

@section('showProduct')

    @foreach($products as $data)
  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100 shadow-sm border-0 rounded-4 hover-shadow" style="transition: 0.3s;">
      <a href="/detail/{{ $data->id }}">
        <img src="{{ asset('storage/' . $data->product_img) }}" class="card-img-top rounded-top-4" alt="{{ $data->product_name }}" style="height: 220px; object-fit: cover;">
      </a>
      <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-2 text-truncate">
          <a href="/detail/{{ $data->id }}" class="text-decoration-none text-dark fw-bold">
            {{ $data->product_name }}
          </a>
        </h5>
        <p class="card-text text-success fw-semibold mb-3">฿{{ number_format($data->product_price, 2) }} บาท</p>
        <a href="/detail/{{ $data->id }}" class="btn btn-outline-success mt-auto">รายละเอียดเพิ่มเติม</a>
      </div>
    </div>
  </div>
@endforeach




  <div class="row mt-2 mb-2">
    <!-- Pagination links -->
    <div class="col-sm-5 col-md-5"></div>
    <div class="col-sm-3 col-md-3">
      <center>
        {{ $products->links() }}
      </center>
    </div>
</div>




@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}