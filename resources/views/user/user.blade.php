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
                <div class="col-12 row justify-content-center">
                    <div class="col-6 p-4">
                        <div class="row justify-content-center">
                            <p class="text-center"><i class="fa fa-circle-user fa-10x"></i></p>
                            <p class="text-center font-weight-bold">{{Auth::user()->name}}</p>
                            <hr>
                            <a href="{{route('user.profile')}}" class="btn btn-pink">Edit Profile</a>
                        </div>
                    </div>
                    <div class="col-6 p-4">
                        <div class="row d-inline ml-5">
                            <table class="ml-5">
                                <tr>
                                    <td class="icon-cell"><i class="fa fa-bookmark fa-3x"></i></td>
                                    <td><a href="{{route('user.favorit')}}" style="color: black; text-decoration: none;">Favorit</a></td>
                                </tr>
                                <tr>
                                    <td class="icon-cell"><i class="fa fa-shopping-cart fa-3x"></i></td>
                                    <td><a href="{{route('user.cart')}}" style="color: black; text-decoration: none;">Cart</a></td>
                                </tr>
                                <tr>
                                    <td class="icon-cell"><i class="fa fa-truck-fast fa-3x"></i></td>
                                    <td><a href="{{route('user.transaction')}}" style="color: black; text-decoration: none;">Order</a></td>
                                </tr>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
    <style>
        .icon-cell {
            width: 100px;
            text-align: center;
        }
        .user-link {
            color: black;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .user-link i {
            margin-right: 5px;
        }
    </style>
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
@endsection
