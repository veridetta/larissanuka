@extends('template.index')

@section('content')
    <!-- Your home page content goes here -->
    <div class="col-12" style="background-image: url({{asset('/storage/img/bintang.png')}});background-size: contain;background-repeat: repeat-y;">
        <div class="col-12 mt-5 d-flex justify-content-end pr-5">
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
        <div class="col-12 row justify-content-center">
            <div class="col-9 mt-5 p-4">
                <div class="col-12 row">
                    <div class="p-2 col-4" >
                        <div id="main-slider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @for ($i=0;$i<8;$i++)
                                    <li class="splide__slide"><img src="{{ asset('storage/img/product/1.png') }}" alt="Image {{$i}}"></li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                        <div id="thumbnail-slider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @for ($i=0;$i<8;$i++)
                                    <li class="splide__slide"><img src="{{ asset('storage/img/product/1.png') }}" alt="Thumbnail {{$i}}"></li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 p-2 col-8">
                        <div class="row p-2 h-100">
                            <div class="my-auto">
                                <h3 class="fw-bold mb-3">Baju</h3>
                                <p class="" style="width: 70%">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis porro dolorum corporis in praesentium maxime harum sint iusto voluptates exercitationem, ex, optio, laboriosam officia velit expedita. Rerum aliquam numquam dolorum?</p>
                                <button class="btn btn-pink mt-4">Tambah Keranjang</button> <button class="btn btn-pink ml-4 mt-4">Beli Sekarang</button> <div class="clearfix"></div><button class="btn btn-outline-info  mt-4"><i class="fa fa-bookmark fa-1x"></i> {{ isset($favorit) ? 'Hapus Favorit' : 'Tambah ke Favorit' }}</button>
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
                    @for ($t=0;$t<5;$t++)
                    <div class="col-12 row">
                        <div class="col-1">
                            <i class="fa fa-user-circle fa-3x"></i>
                        </div>
                        <div class="col-11">
                            <p class="h6 font-weight-bold">Nama User</p>
                            <?php $review = 4;?>
                            @for ($i=0;$i<5;$i++)
                            @if($i<$review)
                            <i class="fa fa-star text-warning"></i>
                            @else
                            <i class="fa fa-star"></i>
                            @endif
                            @endfor
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur hic excepturi modi velit illum adipisci commodi molestiae suscipit maxime corrupti ullam minima dolorum molestias sed sapiente ab, quibusdam quas ut!</p>
                        </div>
                    </div>
                    @endfor
                </div>
                <div class="col-5 p-3">
                    <p class="lucida h4">Produk Terkait :</p>
                    <hr>
                    <div class="row col-12">
                        @for ($i=0;$i<4;$i++)
                        <div class="col-6 p-2">
                            <div class="card h-100">
                                <div class="card-body p-4 h-100">
                                    <p  class="text-center"><img src="{{ asset('storage/img/product/1.png') }}" alt="" style="width: 100%;height:250x;"></p>
                                    <h6 class="text-center"><a href="#">Nama Produk</a></h6>
                                </div>
                            </div>
                        </div>
                    @endfor
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
