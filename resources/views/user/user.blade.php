@extends('template.index')

@section('content')
    <!-- Your home page content goes here -->
    <div class="col-12" style="background-image: url({{asset('/storage/img/bintang.png')}});background-size: contain;background-repeat: repeat-y;">
        //session flash message
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-12 mt-5 d-flex justify-content-center">
            <div class="col-10">
                <img src="{{ asset('storage/img/logo.png') }}" alt="" style="width: 100%;">
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
