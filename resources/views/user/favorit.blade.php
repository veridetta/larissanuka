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
        <div class="col-12 pt-3 pl-4 pr-4">
            <p class="h4 text-center">Favorit</p>
        </div>
        <div class="col-12 mt-5 d-flex justify-content-center">
            <div class="col-6">
                <form class="form-inline my-2 my-lg-0" method="post" action="{{route('user.favorit')}}">
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
        <div class="col-12 row">
            @foreach ($produk as $pr)
            <div class="col-4 p-5 h-100">
                <div class="card card-pink h-100">
                    <div class="card-body">
                        <p  class="text-center"><img src="{{ asset('storage/'.$pr->product->productImage->first()->path) }}" alt="" style="width: 100%;height:250x;"></p>
                        <h4 class="text-left">{{$pr->product->nama}}</h4>
                        <h5 class="fw-bold">Rp. {{ number_format($pr->product->harga, 2, ',', '.') }}</h5>
                        <p>{!!$pr->product->deskripsi!!}</p>
                        <a class="btn btn-pink" href="{{url('product_detail/'.$pr->product->id)}}">Lihat Produk</a>
                    </div>
                </div>
            </div>
            @endforeach
            {{ $produk->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
@endsection
