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
            <div class="col-12 d-flex justify-content-center p-3">
                <div class="col-md-8">
                  <div class="card">
                    <div class="card-title">
                      <h4 class="card-header">Pilih Metode Pembayaran</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md">
                          <div class="form-check custom-option custom-option-basic">
                            <label class="form-check-label custom-option-content" for="customRadioTemp2">
                              <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp2">
                              <span class="custom-option-body">
                                <small>Melalui virtual account.</small>
                              </span>
                            </label>
                          </div>
                        </div>
                        <p>Silahkan tekan tombol berikut untuk melanjutkan pembayaran</p>
                        <button type="button" id="btnBayar" class="btn btn-warning btn-block mt-3">Bayar</button>
                      </div>
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
    <script>
        $('#btnBayar').click(function(){
          var id = '{{$order->id}}';
          var type = '{{$type}}';
          var url = "/post-pembayaran/"+id+"/"+type;
          window.location.href = url;
        })
      </script>
@endsection
