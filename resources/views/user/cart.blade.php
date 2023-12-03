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
            <div class="col-12 row">
                @foreach($cart as $item)
                    <div class="col-6 p-4" id="item{{$item->id}}">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="col-12 row">
                                    <div class="col-2 h-100 my-auto">
                                        <img src="{{ asset('storage/'.$item->product->productImage[0]->path) }}" alt="Image {{$item->product->productImage[0]->id}}" width="80px" height="80px" class=" rounded-circle">
                                    </div>
                                    <div class="col-8 h-100">
                                        <p class="m-0">{{ $item->product->nama }}</p>
                                        <p>Rp. {{ number_format($item->product->harga, 2, ',', '.') }}</p>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon1" onclick="decreaseQuantity({{ $item->id }})">-</button>
                                            <input type="text" class="form-control" value="{{ $item->qty }}" id="quantity{{ $item->id }}">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="increaseQuantity({{ $item->id }})">+</button>
                                            <button class="btn btn-outline-danger" type="button" id="button-addon3" onclick="deleteItem({{ $item->id }})">Delete</button>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-check">
                                            <div class="col-12 row justify-content-end">
                                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="cartItem{{ $item->id }}" name="cartItem[]" onchange="updateSelection({{ $item->id }}, this.checked)">
                                                <input type="hidden" id="price{{ $item->id }}" value="{{ $item->product->harga }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 p-4 mb-5">
            <p class="h4 text-right"><span id="total">Total : Pilih produk dahulu</span></p>
            <a class="btn btn-pink w-100" href="{{route('user.checkout')}}" disabled id="btnCheckout">Lanjutkan</a>
        </div>
    </div>
@endsection

@section('user_css')
    <!-- Your home page CSS goes here -->
@endsection

@section('user_js')
    <!-- Your home page JavaScript goes here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function decreaseQuantity(itemId) {
            var input = $("#quantity" + itemId);
            var currentQuantity = parseInt(input.val());
            if (currentQuantity > 1) { // Prevent quantity from going below 1
                input.val(currentQuantity - 1);
            }

            // Update the quantity in the database
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: '/user/cart/' + itemId, // Update with your update URL
                type: 'PUT',
                data: {
                    qty: input.val()
                },
                success: function(result) {
                    // Calculate the total and check if any items are selected
                    var total = 0;
                    var anyItemsSelected = false;
                    $('input[name="cartItem[]"]:checked').each(function() {
                        var itemId = $(this).val();
                        var quantity = $('#quantity' + itemId).val();
                        var price = $('#price' + itemId).val(); // Assuming you have a hidden input with the price
                        total += quantity * price;
                        anyItemsSelected = true;
                    });

                    // Update the #total element
                    $('#total').text('Total : Rp. ' + total.toLocaleString('id-ID', {minimumFractionDigits: 2}));
                    $('#btnCheckout').prop('disabled', !anyItemsSelected);
                }
            });
        }

        function increaseQuantity(itemId) {
            var input = $("#quantity" + itemId);
            var currentQuantity = parseInt(input.val());
            input.val(currentQuantity + 1);

            // Update the quantity in the database
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: '/user/cart/' + itemId, // Update with your update URL
                type: 'PUT',
                data: {
                    qty: input.val()
                },
                success: function(result) {
                    // Calculate the total and check if any items are selected
                    var total = 0;
                    var anyItemsSelected = false;
                    $('input[name="cartItem[]"]:checked').each(function() {
                        var itemId = $(this).val();
                        var quantity = $('#quantity' + itemId).val();
                        var price = $('#price' + itemId).val(); // Assuming you have a hidden input with the price
                        total += quantity * price;
                        anyItemsSelected = true;
                    });

                    // Update the #total element
                    $('#total').text('Total : Rp. ' + total.toLocaleString('id-ID', {minimumFractionDigits: 2}));
                    $('#btnCheckout').prop('disabled', !anyItemsSelected);
                }
            });
        }
    </script>
    <script>
        function deleteItem(itemId) {
            // Confirm before deleting
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    url: '/user/cart/' + itemId, // Update with your delete URL
                    type: 'DELETE',
                    success: function(result) {
                        // Remove item from the DOM
                        $('#item' + itemId).remove();
                        var total = 0;
                        var anyItemsSelected = false;
                        $('input[name="cartItem[]"]:checked').each(function() {
                            var itemId = $(this).val();
                            var quantity = $('#quantity' + itemId).val();
                            var price = $('#price' + itemId).val(); // Assuming you have a hidden input with the price
                            total += quantity * price;
                            anyItemsSelected = true;
                        });

                        // Update the #total element
                        $('#total').text('Total : Rp. ' + total.toLocaleString('id-ID', {minimumFractionDigits: 2}));
                        $('#btnCheckout').prop('disabled', !anyItemsSelected);
                    }
                });
            }
        }
        function updateSelection(itemId, isSelected) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: '/user/cart/' + itemId, // Update with your update URL
                type: 'PUT',
                data: {
                    is_selected: isSelected
                },
                success: function(result) {
                    // Handle success (optional)
                    // Calculate the total
                    var total = 0;
                        var anyItemsSelected = false;
                        $('input[name="cartItem[]"]:checked').each(function() {
                            var itemId = $(this).val();
                            var quantity = $('#quantity' + itemId).val();
                            var price = $('#price' + itemId).val(); // Assuming you have a hidden input with the price
                            total += quantity * price;
                            anyItemsSelected = true;
                        });

                        // Update the #total element
                        $('#total').text('Total : Rp. ' + total.toLocaleString('id-ID', {minimumFractionDigits: 2}));
                        $('#btnCheckout').prop('disabled', !anyItemsSelected);
                    alert('Item updated!');

                }
            });
        }
    </script>
@endsection
