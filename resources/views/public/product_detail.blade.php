@extends('template.index')

@section('content')
    <!-- Your home page content goes here -->
    <div class="col-12" style="background-image: url({{asset('/storage/img/bintang.png')}});background-size: contain;background-repeat: repeat-y;">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{session()->get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{session()->get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> {{session()->get('warning')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="col-12 mt-5 d-flex justify-content-end pr-5">
            <div class="col-6">
                <form class="form-inline my-2 my-lg-0" method="post" action="{{route('public.product')}}">
                    @csrf
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text h-100" id="basic-addon1"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 row justify-content-center">
            <div class="col-9 mt-5 p-4">
                <div class="col-12 row">
                    <div class="p-2 col-4" >
                        <div id="main-slider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @if($produk->productImage)
                                        @foreach ($produk->productImage as $image)
                                            <li class="splide__slide"><img src="{{ asset('storage/'.$image->path) }}" alt="Image {{$image->id}}"></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div id="thumbnail-slider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @if($produk->productImage)
                                        @foreach ($produk->productImage as $image)
                                            <li class="splide__slide"><img src="{{ asset('storage/'.$image->path) }}" alt="Image {{$image->id}}"></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 p-2 col-8">
                        <div class="row p-2 h-100">
                            <div class="my-auto">
                                <h3 class="fw-bold mb-3">{{$produk->nama}}</h3>
                                <h5 class="fw-bold">Rp. {{ number_format($produk->harga, 2, ',', '.') }}</h5>
                                <p class="" style="width: 70%">{!!$produk->deskripsi!!}</p>
                                <form method="post" class="d-inline" action="{{route('public.tambah_keranjang')}}">@csrf<input type="hidden" name="product_id" value="{{$produk->id}}"/><input class="btn btn-pink mt-4" type="submit" id="btn_keranjang" value="Tambah Keranjang"></form>
                                <form method="post" class="d-inline" action="{{route('public.single_checkout')}}">@csrf<input type="hidden" name="product_id" value="{{$produk->id}}"/><button class="btn btn-pink  mt-4">Beli Sekarang</button></form> <div class="clearfix"></div>
                                <form method="post" class="d-inline" action="{{route('public.tambah_favorit')}}">@csrf<input type="hidden" name="product_id" value="{{$produk->id}}"/><button class="btn btn-outline-info  mt-4"><i class="fa fa-bookmark fa-1x"></i> {{ isset($favorit) ? 'Hapus Favorit' : 'Tambah ke Favorit' }}</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-4">
            <div class="col-12 row">
                <div class="col-7 p-3">
                    <p class="lucida h4">Review :</p>
                    <hr>
                    @foreach ($review as $revi)
                    <div class="col-12 row">
                        <div class="col-1">
                            <i class="fa fa-user-circle fa-3x"></i>
                        </div>
                        <div class="col-11">
                            <p class="h6 font-weight-bold">{{$revi->user->name}}</p>
                            @for ($i=0;$i<5;$i++)
                            @if($i<$revi->rating)
                            <i class="fa fa-star text-warning"></i>
                            @else
                            <i class="fa fa-star"></i>
                            @endif
                            @endfor
                            <p>{!! $revi->review!!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-5 p-3">
                    <p class="lucida h4">Produk Terkait :</p>
                    <hr>
                    <div class="row col-12">
                        @foreach ($produk_terkait as $terkait)
                        <div class="col-6 p-2">
                            <div class="card h-100">
                                <div class="card-body p-4 h-100">
                                    <p  class="text-center"><img src="{{ asset('storage/'.$terkait->productImage->first()->path) }}" alt="" style="width: 100%;height:250x;"></p>
                                    <h6 class=""><a href="{{url('product_detail/'.$terkait->id)}}">{{$terkait->nama}}</a></h6>
                                    <p class="fw-bold">Rp. {{ number_format($terkait->harga, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
    <script>
        var main = new Splide( '#main-slider', {
        type       : 'fade',
        loop       : true,
        heightRatio: 1,
        pagination : false,
        arrows     : false,
        cover      : true,
        } );

        var thumbnails = new Splide( '#thumbnail-slider', {
        rewind          : true,
        fixedWidth      : 58,
        fixedHeight     : 58,
        isNavigation    : true,
        gap             : 4,
        focus           : 'center',
        pagination      : false,
        cover           : true,
        dragMinThreshold: {
            mouse: 4,
            touch: 10,
        },
        breakpoints : {
            640: {
            fixedWidth  : 66,
            fixedHeight : 38,
            },
        },
        } );

        main.sync( thumbnails );
        main.mount();
        thumbnails.mount();
    </script>
@endsection
