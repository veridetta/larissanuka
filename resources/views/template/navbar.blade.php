<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top pl-5 pr-5 nav-pink">
    <a class="navbar-brand " href="#"><img src="{{ asset('storage/img/logo.png') }}" alt="Logo" width="100px" height="40px" class=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('filament.admin.auth.login') }}">Login</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
