<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'Default Website Name') }}</title>
    <link rel="icon" href="{{ asset('storage/img/logo.png') }}" type="image/png">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Splide CSS-->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Inter';
            src: url('{{ asset('/storage/font/inter/Inter-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Lucida';
            src: url('{{ asset('/storage/font/lucida/lucida.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .lucida {
            font-family: 'Lucida', sans-serif;
        }

        body, p, h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif;
        }

        .nav-pink{
            background-color: #FDF0F0 !important;
        }
        .nav-pink .nav-link{
            color: black !important;
            font-weight: 300 !important;
        }
        .nav-pink .nav-link:hover{
            color: #F8B4D0 !important;
        }
        .nav-pink .nav-link:active{
            color: #F8B4D0 !important;
        }
        .nav-pink .nav-link:focus{
            color: #F8B4D0 !important;
        }
        .nav-pink .navbar-brand{
            color: #F8B4D0 !important;
        }
        .nav-pink .navbar-brand:hover{
            color: #F8B4D0 !important;
        }
        .card-pink{
            background-color: #F2BED1 !important;
        }
        .card-pink .card-header{
            background-color: #F8B4D0 !important;
        }
        .card-pink .card-header p{
            color: #FDF0F0 !important;
        }
        .card-pink .card-body{
            background-color: #F2BED1 !important;
        }
        .card-pink .card-body, .card-pink .card-body p, .card-pink .card-body h1, .card-pink .card-body h2, .card-pink .card-body h3, .card-pink .card-body h4, .card-pink .card-body h5, .card-pink .card-body h6 {
            color: white !important;
        }
        .btn-pink {
            background-color: #FDCEDF !important;
            color: #000000 !important;
        }
        .btn-pink:hover {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:active {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:focus {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:disabled {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:active:focus {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:active:hover {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:active:active {
            background-color: #F8B4D0 !important;
        }
        .btn-pink:active:active:focus {
            background-color: #F8B4D0 !important;
        }
        /* WhatsApp floating button styles */
        #whatsapp-chat {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        #whatsapp-chat a {
            display: block;
            width: 100%;
            height: 100%;
            line-height: 60px;
            text-decoration: none;
        }

        .my-float {
            margin-top: 16px;
        }

    </style>

    @yield('user_css')
</head>
<body>
    @include('template/navbar')

    @yield('content')

    @include('template/footer')
    <!-- WhatsApp floating button -->
    <div id="whatsapp-chat" class="float">
        <a href="https://api.whatsapp.com/send?phone=YOUR_PHONE_NUMBER" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <!-- SPLIDE JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    @yield('user_js')
</body>
</html>
