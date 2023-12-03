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
                <p class="text-center"><img src="{{ asset('storage/img/logo.png') }}" alt="" width="200px" height="80px"></p>
                <!-- Registration form -->
                <form action="{{ route('auth.register') }}" method="post" class="form">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                    </div>


                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telp</label>
                        <input type="tel" id="no_telp" name="no_telp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <select id="provinsi" name="provinsi" class="form-select" required>
                            <!-- Options will be populated from the database -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota</label>
                        <select id="kota" name="kota" class="form-select" required>
                            <!-- Options will be populated from the database -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="kelurahan" class="form-label">Kelurahan</label>
                        <input type="text" id="kelurahan" name="kelurahan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="address" name="alamat" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kodepos" class="form-label">Kode POS</label>
                        <input type="text" id="kodepos" name="kodepos" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Daftar" class="btn btn-pink col-12">
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <script>
        $(document).ready(function() {
            function formatProvince(province) {
                if (!province.id) {
                    return province.text;
                }
                var $province = $(
                    '<div class="clearfix">' +
                        '<span class="float-left">' +province.text + '</span>' +
                    '</div>'
                );
                return $province;
            };

            $("#provinsi").select2({
                placeholder: "Memuat data..",
                templateResult: formatProvince,
                templateSelection: formatProvince
            });
            $("#kota").select2({
                placeholder: "Pilih provinsi dahulu",
                templateResult: formatProvince,
                templateSelection: formatProvince
            });

            if ($('#provinsi').val() != '') {
                $.ajax({
                    url: '{{ route('api.provinsi') }}',
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'error') {
                            alert(data.message);
                        } else {
                            // Update the options of the Select2 element with the new data
                            $("#provinsi").empty().select2({
                                data: data.results,
                                placeholder: "Pilih Provinsi",
                                templateResult: formatProvince,
                                templateSelection: formatProvince
                            });
                        }
                    }
                });
            }
            $('select[name="provinsi"]').change(function() {
                var value = $("#provinsi").select2('val');
                var values = value.split('-');
                var id = values[0];
                $.ajax({
                    url: '/api/kota/'+id,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'error') {
                            alert(data.message);
                        } else {
                            // Update the options of the Select2 element with the new data
                            $("#kota").empty().select2({
                                data: data.results,
                                placeholder: "Pilih Kota",
                                templateResult: formatProvince,
                                templateSelection: formatProvince
                            });
                        }
                    }
                });
            })
        });

    </script>
@endsection
