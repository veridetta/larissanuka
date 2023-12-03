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
            <div class="col-md-8">
                  <div class="card">
                    <div class="card-title">
                      <h4 class="card-header">Virtual Account</h4>
                    </div>
                    <div class="card-body p-3 d-flex justify-content-center">
                    <button id="pay-button"></button>
                    <pre><div id="result-json">Menghubungkan dengan server...<br></div></pre>
              </div>
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{$clientKey}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
     //trigger pay-button
     $('#pay-button').trigger('click');
    });
       document.getElementById('pay-button').onclick = function(){
           // SnapToken acquired from previous step
           snap.pay('<?php echo $snap_token?>', {
               // Optional
               onSuccess: function(result){
                   /* You may add your own js here, this is just example */
                   //document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    var id = '{{$order->id}}';
                    var url = "/update/"+id+"/success";
                    window.location.href = url;
               },
               // Optional
               onPending: function(result){
                   /* You may add your own js here, this is just example */
                   //document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    var id = '{{$order->id}}';
                    var url = "/update/"+id+"/pending";
                    window.location.href = url;
               },
               // Optional
               onError: function(result){
                   /* You may add your own js here, this is just example */
                   //document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    var id = '{{$order->id}}';
                    var url = "/update/"+id+"/error";
                    window.location.href = url;
               }
           });
       };
   </script>
@endsection
