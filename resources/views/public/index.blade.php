@extends('template.index')

@section('content')
    <!-- Your home page content goes here -->
    <div class="col-12" style="background-image: url({{asset('/storage/img/bintang.png')}});background-size: contain;background-repeat: repeat-y;">
        <div class="col-12 mt-5">
            <h1 class="text-center lucida mb-3"> *.~ Welcome to our store ~.*</h1>
            <div class="col-12 row">
                <div class="col-12 row justify-content-center ">
                    <div class="col-6 mt-4 d-flex ">
                        <div class="p-2">
                            <img src="{{ asset('storage/'.$promosi->productImage->first()->path) }}" alt="" style="width: 300px;height:300px;" >
                        </div>
                        <div class="h-100 p-2">
                            <div class="row p-2 h-100">
                                <div class="my-auto">
                                    <h3 class="fw-bold text-left">{{$promosi->nama}}</h3>
                                    <h5 class="fw-bold">Rp. {{ number_format($promosi->harga, 2, ',', '.') }}</h5>
                                    <p>{!!$promosi->deskripsi!!}</p>
                                    <a class="btn btn-pink"  href="{{url('product_detail/'.$promosi->id)}}">Lihat Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-12 row justify-content-center">
                    <div class="mt-5 col-10 ">
                        <div class="col-12 row justify-content-center">
                            <hr>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="mt-3 mb-4 col-8">
                        <div class="col-12 row justify-content-center">
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="col-12 justify-content-center row">
                    <div class="col-10">
                        <h1 class="lucida text-center font-weight-bold">Our New Product !</h1>
                        <div class="col-12 row">
                            @foreach ($baru as $pr)
                            <div class="col-4 p-2 h-100">
                                <div class="card card-pink">
                                    <div class="card-body">
                                        <p  class="text-center"><img src="{{ asset('storage/'.$pr->productImage->first()->path) }}" alt="" style="width: 100%;height:250x;"></p>
                                        <h4 class="text-left">{{$pr->nama}}</h4>
                                        <h5 class="fw-bold">Rp. {{ number_format($pr->harga, 2, ',', '.') }}</h5>
                                        <p>{!!$pr->deskripsi!!}</p>
                                        <a class="btn btn-pink" href="{{url('product_detail/'.$pr->id)}}">Lihat Produk</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
@endsection
