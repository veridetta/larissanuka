@extends('template.index')

@section('content')
    <!-- Your home page content goes here -->
    <div class="col-12" style="background-image: url({{asset('/storage/img/bintang.png')}});background-size: contain;background-repeat: repeat-y;">
        <div class="col-12 mt-5 d-flex justify-content-center">
            <div class="col-6">
                <form class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text h-100" id="basic-addon1"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 row">
            @for ($i=0;$i<8;$i++)
            <div class="col-4 p-5 h-100">
                <div class="card h-100">
                    <div class="card-body p-4 h-100">
                        <p  class="text-center"><img src="{{ asset('storage/img/product/1.png') }}" alt="" style="width: 100%;height:250x;"></p>
                        <h6 class="text-center"><a href="#">Nama Produk</a></h6>
                        <p class="fw-bold">Rp. {{ number_format(200000, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
@endsection
