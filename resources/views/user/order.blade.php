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
        <div class="col-12 mt-5 d-flex justify-content-center">
            <div class="col-10">
                @foreach($transaction as $trans)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Transaction #{{ $trans->transaction_code }}</h5>
                            <p class="card-text"><strong>Status:</strong> {{ $trans->status }}<br></p>
                            <table class="w-100">
                            <?php $n=1;?>
                            @foreach ($trans->transactionDetail as $produk)
                                <tr class="w-100">
                                    <td>{{$n}}. </td>
                                    <td class="font-weight-bold">{{$produk->product->nama}}</td>
                                    <td>Rp. {{ number_format($produk->product->harga, 2, ',', '.') }}</td>
                                    <td>x {{$produk->qty}}</td>
                                    <td class="font-weight-bold">Rp. {{ number_format(($produk->product->harga * $produk->qty), 2, ',', '.') }}</td>
                                </tr>
                                <?php $n++;?>
                            @endforeach
                            <tr class="w-100">
                                <td>- </td>
                                <td class="font-weight-bold">{{$trans->service->nama.'-'.$trans->service->servis}}</td>
                                <td>Rp. {{ number_format($trans->service->value, 2, ',', '.') }}</td>
                                <td>x 1</td>
                                <td class="font-weight-bold">Rp. {{ number_format($trans->service->value, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="font-weight-bold">Total</td>
                                <td class="font-weight-bold">Rp. {{ number_format($trans->total, 2, ',', '.') }}</td>
                            </tr>
                            </table>
                            @if($trans->status == 'selesai')
                                <a href="/user/transactions/{{ $trans->id }}/review" class="btn btn-primary">Review</a>
                            @endif
                        </div>
                    </div>
                @endforeach
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
