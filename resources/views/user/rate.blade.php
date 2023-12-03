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
        <div class="col-12 mt-5 row justify-content-center">
            @foreach ($transaction_detail as $trans)
            @if($trans->product->rating->where('user_id', Auth::user()->id)->first())
                @continue
            @endif
            <div class="col-10 p-4">
                <div class="card">
                    <div class="card-body">
                        <form action="/rate" method="POST">
                            <div class="col-12 justify-content-center text-center">
                                <img src="{{ asset('storage/'.$trans->product->productImage[0]->path) }}" alt="Image {{$trans->product->productImage[0]->id}}" width="80px" height="80px" class=" rounded-circle">
                                <p class="m-0 text-center">{{ $trans->product->nama }}</p>
                                    <p>Rp. {{ number_format($trans->product->harga, 2, ',', '.') }}</p>
                            </div>
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $trans->product->id }}">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select class="form-control" id="rating" name="rating">
                                    <option value="1">1 Bintang</option>
                                    <option value="2">2 Bintang</option>
                                    <option value="3">3 Bintang</option>
                                    <option value="4">4 Bintang</option>
                                    <option value="5">5 Bintang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea class="form-control review" id="review" name="review" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-pink mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
            @endforeach
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
@endsection
