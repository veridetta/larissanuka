<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top pl-5 pr-5 nav-pink">
    <a class="navbar-brand " href="#"><img src="{{ asset('storage/img/logo.png') }}" alt="Logo" width="100px" height="40px" class=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="{{route('public.index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('public.product')}}">Product</a>
                </li>
                <li class="nav-item pr-2">
                    <a class="nav-link" href="{{route('user.cart')}}">
                        Keranjang
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.favorit')}}">Favorit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.transaction')}}">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.index')}}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('filament.admin.auth.login') }}">Login</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
