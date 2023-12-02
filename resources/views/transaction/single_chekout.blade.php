@extends('template.index')

@section('content')
    <!-- Your home page content goes here -->
    <div class="col-12" style="background-image: url({{asset('/storage/img/bintang.png')}});background-size: contain;background-repeat: repeat-y;">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{session()->get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{session()->get('error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> {{session()->get('warning')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-12 mt-5 d-flex justify-content-center pr-5 row">
            <div class="col-6 p-4">
                <div class="card ">
                    <div class="card-header card-pink">
                        <p class="h4">Detail Produk</p>
                    </div>
                    <div class="card-body">
                        <table class="w-100">
                            <tr class="w-100">
                                <td>1. </td>
                                <td class="font-weight-bold">{{$produk->nama}}</td>
                                <td>Rp. {{ number_format($produk->harga, 2, ',', '.') }}</td>
                                <td>x 1</td>
                                <td class="font-weight-bold">Rp. {{ number_format($produk->harga, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <p class="h4 mt-4">Opsi Pengiriman</p>
                <hr>
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading-jne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-jne" aria-expanded="true" aria-controls="collapse-jne">
                                    Jalur Nugraha Ekakurir (JNE)
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-jne" class="collapse" aria-labelledby="heading-jne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="form-check">
                                    @foreach ($jne->rajaongkir->results[0]->costs as $cost)
                                        @foreach ($cost->cost as $cos)
                                        <input class="form-check-input" type="radio" name="selectedService" id="<?php echo $cost->service; ?>" value="<?php echo $cost->service; ?>">
                                        <label class="form-check-label" for="<?php echo $cost->service; ?>">
                                            <?php echo $cost->service . ' ('.$cos->etd.' Hari) ' . number_format($cos->value, 2, ',', '.')  ?>
                                        </label><br>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="accordion" class="mt-2">
                    <div class="card">
                        <div class="card-header" id="heading-jnt">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-jnt" aria-expanded="true" aria-controls="collapse-jnt">
                                    J & T
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-jnt" class="collapse mt-2" aria-labelledby="heading-jnt" data-parent="#accordion">
                            <div class="card-body">
                                <div class="form-check">
                                    @foreach ($jnt->rajaongkir->results[0]->costs as $cost)
                                        @foreach ($cost->cost as $cos)
                                        <input class="form-check-input" type="radio" name="selectedService" id="<?php echo $cost->service; ?>" value="<?php echo $cost->service; ?>">
                                        <label class="form-check-label" for="<?php echo $cost->service; ?>">
                                            <?php echo $cost->service . ' ('.$cos->etd.' Hari) ' . number_format($cos->value, 2, ',', '.')  ?>
                                        </label><br>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 p-4">
                <p class="h4">Detail Pengiriman</p>
                <hr>
                <p class="m-0 font-weight-bold">{{$customer->nama." - ".$customer->no_telp}}</p>
                <p class="m-0  font-weight-bold">Alamat Pengiriman</p>
                <p class="m-0">{{$customer->alamat}}</p>
                <p class="m-0">Desa / Kelurahan :{{$customer->kelurahan}}</p>
                <p class="m-0">Kecamatan :{{$customer->kecamatan}}</p>
                <p class="m-0">{{$customer->kota_name}},{{$customer->provinsi_name}}</p>
                <p class="m-0">{{$customer->kodepos}}</p>
            </div>
            <div class="col-12 p-4 mb-5">
                <p class="h4 text-right">Total : Rp. {{ number_format($produk->harga, 2, ',', '.') }}</p>
                <form method="post" action="" class="d-inline">
                    <input type="hidden" name="product_id" value="{{$produk->id}}"/>
                    <input type="hidden" name="customer_id" value="{{$customer->id}}"/>
                    <input type="hidden" name="service" value=""/>
                    <input type="hidden" name="ongkir" value=""/>
                    <input type="hidden" name="kurir" value=""/>
                    <input type="hidden" name="total" value="{{$produk->harga}}"/>
                    <button class="btn btn-pink w-100">Pilih Metode Pembayaran</button>
                </form>
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
