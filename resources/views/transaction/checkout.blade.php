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
        <div class="col-12 mt-5 d-flex justify-content-center pr-5 row">
            <div class="col-6 p-4">
                <div class="card ">
                    <div class="card-header card-pink">
                        <p class="h4">Detail Produk</p>
                    </div>
                    <div class="card-body">
                        <table class="w-100">
                            <?php $n=1;?>
                            @foreach ($cart as $produk)
                                <tr class="w-100">
                                    <td>{{$n}}. </td>
                                    <td class="font-weight-bold">{{$produk->product->nama}}</td>
                                    <td>Rp. {{ number_format($produk->product->harga, 2, ',', '.') }}</td>
                                    <td>x {{$produk->qty}}</td>
                                    <td class="font-weight-bold">Rp. {{ number_format(($produk->product->harga * $produk->qty), 2, ',', '.') }}</td>
                                </tr>
                                <?php $n++;?>
                            @endforeach
                        </table>
                    </div>
                </div>

                <p class="h4 mt-4">Opsi Pengiriman</p>
                <hr>
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading-jne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-jne" aria-expanded="true" aria-controls="collapse-jne">Jalur Nugraha Ekakurir (JNE)</button>
                            </h5>
                        </div>

                        <div id="collapse-jne" class="collapse" aria-labelledby="heading-jne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="form-check">
                                    @foreach ($jne->rajaongkir->results[0]->costs as $cost)
                                        @foreach ($cost->cost as $cos)
                                        <input class="form-check-input" type="radio" name="selectedService" id="<?php echo $cost->service; ?>" value="<?php echo $cost->service;?>-<?php echo $cos->value;?>">
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
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-jnt" aria-expanded="true" aria-controls="collapse-jnt">J & T</button>
                            </h5>
                        </div>

                        <div id="collapse-jnt" class="collapse mt-2" aria-labelledby="heading-jnt" data-parent="#accordion">
                            <div class="card-body">
                                <div class="form-check">
                                    @foreach ($jnt->rajaongkir->results[0]->costs as $cost)
                                        @foreach ($cost->cost as $cos)
                                        <input class="form-check-input" type="radio" name="selectedService" id="<?php echo $cost->service; ?>" value="<?php echo $cost->service;?>-<?php echo $cos->value;?>">
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
                <p class="h4 text-right"><span id="total">Total : Rp. {{ number_format($produk->harga, 2, ',', '.') }}</span></p>
                <form method="post" action="{{route('buat-pesanan')}}" class="d-inline">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{$customer->id}}"/>
                    <input type="hidden" name="service" value=""/>
                    <input type="hidden" name="tipe" value="multiple"/>
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
        $(document).ready(function(){
            var total = parseInt({{$total_harga}});
            $('input[type=radio][name=selectedService]').change(function() {
                var service_mentah = $(this).val();
                var service_parts = service_mentah.split('-');
                var service = service_parts[0];
                var ongkir = service_parts[1];
                var kurir = $(this).parent().parent().parent().parent().parent().find('.card-header').text();
                var total_ongkir = total + parseInt(ongkir);
                $('input[name=service]').val(service);
                $('input[name=ongkir]').val(ongkir);
                $('input[name=kurir]').val(kurir);
                $('input[name=total]').val(total_ongkir);
                $('#total').text('Total : Rp. ' + total_ongkir.toLocaleString('id-ID', {minimumFractionDigits: 2}));
            });
        });
    </script>
@endsection
