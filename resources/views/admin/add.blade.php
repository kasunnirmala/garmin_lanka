@extends('layouts.dashboard.dashboard_layout')


@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/admin/admin.css')}}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection


@section('page-name')
    Add Stock
@endsection


@section('body-content')
    <div class="container-fluid">
        <form id="add-form">
            <div class="row">
                <div class="col-lg-10 col-md-8 col-sm-12">
                    <select class="selectpicker" data-width="100%"
                            data-live-search="true" title="Select Vendor" id="vendor" required>
                        @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}">{{$vendor->vendor_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-new-vendor">
                        <i class="fas fa-plus-circle"></i> ADD NEW
                    </button>
                </div>


            </div>
            <br>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="product_code">Product Code:</label>
                        <input type="text" class="form-control" id="product_code" required>
                    </div>
                    <div class="form-group">
                        <label for="product_code">Product Description:</label>
                        <input type="text" class="form-control" id="product_desc" required>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card" style="height: 100%">
                        <div class="card-header"> Product Details</div>
                        <div class="card-body" id="product_detail"> No Product Details to show</div>
                    </div>


                </div>

            </div>
            <br>
            <div id="item-list"></div>

            <br>
            <div class="row d-flex justify-content-end">
                <button type="button" class="btn btn-success btn-sm" id="submit-button" disabled>SAVE</button>
            </div>
        </form>
    </div>


    <div class="modal fade" id="add-new-vendor" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    <h4 class="modal-title">Add Vendor</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="addVendor" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="vendor_name">Vendor Name:</label>
                            <input type="text" class="form-control" id="vendor_name" name="vendor_name">
                        </div>
                        <div class="form-group">
                            <label for="vendor_contact">Vendor Contact:</label>
                            <input type="text" class="form-control" id="vendor_contact" name="vendor_contact">
                        </div>
                        <div class="form-group">
                            <label for="vendor_address">Vendor Address: </label>
                            <textarea type="text" class="form-control" id="vendor_address" rows="3"
                                      name="vendor_address"></textarea>
                        </div>
                        <button class="btn btn-sm btn-success" type="submit">ADD</button>
                    </form>
                </div>

            </div>

        </div>
    </div>



@endsection


@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $('#product_code').on('keyup', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#product_desc').focus();
                $.ajax({
                    url: "getProduct",
                    data: {"_token": "{{ csrf_token() }}", 'code': $('#product_code').val()},
                    method: 'POST',
                    success: function (data) {
                        $('#product_detail').empty();
                        if (data) {
                            $('#product_detail').html('<p>' + data['productCode'] + '</p><p>' + data['productDsc'] + '</p>');
                            $('#product_desc').val(data['productDsc']);
                            $('#product_desc').attr("disabled", true);
                            createNewItem();
                        } else {
                            $('#product_detail').html("No Product Details to show");
                        }
                    }
                });
            }
        });

        $('#product_desc').on('keyup', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                createNewItem();
            }
        });


        function checkItemsList() {
            if ($('#item-list .item-set').length > 0) {
                $('#submit-button').attr("disabled", false);
            } else {
                $('#submit-button').attr("disabled", true);
            }

        }

        var rndList = [];

        function createNewItem() {
            var rnd = (parseInt(Math.random() * 1000));
            rndList.push(rnd);
            var item = '<div class="row item-set">\n' +
                '                    <div class="col-lg-6 col-md-12">\n' +
                '                        <div class="form-group">\n' +
                '                            <input type="text" class="form-control serial_code" id="serial_code' + rnd + '"\n' +
                '                                   placeholder="Serial Code" required>\n' +
                '                        </div>\n' +

                '                    </div>\n' +
                '                    <div class="col-lg-6 col-md-12">\n' +
                '                        <div class="form-group">\n' +
                '                            <input type="text" class="form-control serial_desc" id="serial_description' + rnd + '"\n' +
                '                                   placeholder="Description">\n' +
                '                        </div>\n' +

                '                    </div>\n' +

                '                </div>';
            $('#item-list').append(item);

            $(`#serial_code${rnd}`).focus();
            $(`#serial_code${rnd}`).on('keyup', function (e) {
                // alert(e);
                if (e.keyCode == 13) {
                    e.preventDefault();
                    $(`#serial_description${rnd}`).focus();
                }
            });
            $(`#serial_description${rnd}`).on('keyup', function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    createNewItem();
                }
            });

            checkItemsList();
        }


        $('#submit-button').click(function () {
            var itemList = [];
            var product_code = $('#product_code').val();
            rndList.forEach((rnd) => {
                var serial_code = $(`#serial_code${rnd}`).val();
                var serial_description = $(`#serial_description${rnd}`).val();

                itemList.push({serial_code: serial_code, serial_description: serial_description})
            })


            var items = {
                vendor_id: $('#vendor').val(),
                product: {productCode: product_code, productDesc: $('#product_desc').val()},
                itemList: itemList
            }
            console.log(items);
            $.ajax({
                url: "addItems",
                data: {"_token": "{{ csrf_token() }}", 'data': items},
                method: 'POST',
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (data) {
                    console.log(data);
                    if (data['status'] == 200) {
                        $.notify("Stock Saved Successfully", "success");
                        location.reload();
                    } else {
                        $.notify("Error in saving...", "error");
                    }

                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });

        });

    </script>
@endsection
