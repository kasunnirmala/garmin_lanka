@extends('layouts.dashboard.dashboard_layout')


@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/admin/admin.css')}}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection


@section('page-name')
    Stock Out Page
@endsection


@section('body-content')
    <div class="container-fluid">
        <form id="add-form">
            <div class="row">
                <div class="col-lg-10 col-md-8 col-sm-12">
                    <select class="selectpicker" data-width="100%"
                            data-live-search="true" title="Select Customer" id="customer" required>
                        @foreach ($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#add-new-customer">
                        <i class="fas fa-plus-circle"></i> ADD NEW
                    </button>
                </div>


            </div>
            <br>

            <div id="item-list"></div>

            <br>
            <div class="row d-flex justify-content-end">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#item-summary">SAVE
                </button>
            </div>
        </form>
    </div>


    <div class="modal fade" id="add-new-customer" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add CUstomer</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="addCustomer" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="customer_name">Customer Name:</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name">
                        </div>
                        <div class="form-group">
                            <label for="customer_contact">customer Contact:</label>
                            <input type="text" class="form-control" id="customer_contact" name="customer_contact">
                        </div>
                        <div class="form-group">
                            <label for="customer_address">customer Address: </label>
                            <textarea type="text" class="form-control" id="customer_address" rows="3"
                                      name="customer_address"></textarea>
                        </div>
                        <button class="btn btn-sm btn-success" type="submit">ADD</button>
                    </form>
                </div>

            </div>

        </div>
    </div>


    <div class="modal fade" id="item-summary" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">


                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" id="confirm-button">CONFIRM</button>
                </div>
            </div>

        </div>
    </div>





@endsection


@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        var productID;
        $(document).ready(function () {
            $.urlParam = function (name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                    .exec(window.location.search);

                return (results !== null) ? results[1] || 0 : false;
            }

            console.log($.urlParam('amount'));
            if ($.urlParam('amount')) {
                var maxFields = $.urlParam('amount');
                for (let i = 0; i < maxFields; i++) {
                    createNewItem();
                }
            }
            productID = $.urlParam('id');
        });

        $("#item-summary").on('show.bs.modal', function (event) {
            $(this).find('.modal-body').empty();
            $(this).find('.modal-body').append("<p>Customer :" + $('#customer').text() + "</p><p><u>Item Serial Codes</u></p>");

            var itemList = [];
            rndList.forEach((rnd) => {
                var serial_code = $(`#serial_code${rnd}`).val();
                var serial_description = $(`#serial_description${rnd}`).val();

                itemList.push({serial_code: serial_code, serial_description: serial_description})

                $(this).find('.modal-body').append("<div>" + serial_code + "</div>");

            })


            var items = {
                customer_id: $('#customer').val(),
                itemList: itemList,
                product_id: productID
            }


        })

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
                // '                    <div class="col-lg-6 col-md-12">\n' +
                // '                        <div class="form-group">\n' +
                // '                            <input type="text" class="form-control serial_desc" id="serial_description' + rnd + '"\n' +
                // '                                   placeholder="Description" disabled>\n' +
                // '                        </div>\n' +
                //
                // '                    </div>\n' +

                '                </div>';
            $('#item-list').append(item);

            {{--// $(`#serial_code${rnd}`).focus();--}}
            {{--$(`#serial_code${rnd}`).on('keyup', function (e) {--}}
            {{--    if (e.keyCode == 13) {--}}
            {{--        e.preventDefault();--}}


            {{--        --}}{{--$.ajax({--}}
            {{--        --}}{{--    url: "getItem",--}}
            {{--        --}}{{--    data: {"_token": "{{ csrf_token() }}", 'code': $(`#serial_code${rnd}`).val()},--}}
            {{--        --}}{{--    method: 'POST',--}}
            {{--        --}}{{--    success: function (data) {--}}
            {{--        --}}{{--        if (data) {--}}
            {{--        --}}{{--            $(`#serial_description${rnd}`).val(data['itemDsc'])--}}
            {{--        --}}{{--            // createNewItem();--}}
            {{--        --}}{{--        }--}}
            {{--        --}}{{--    }--}}
            {{--        --}}{{--});--}}


            {{--    }--}}
            {{--});--}}


            // checkItemsList();
        }


        $('#confirm-button').click(function () {
            var itemList = [];
            rndList.forEach((rnd) => {
                var serial_code = $(`#serial_code${rnd}`).val();
                var serial_description = $(`#serial_description${rnd}`).val();

                itemList.push({serial_code: serial_code, serial_description: serial_description})
            })


            var items = {
                customer_id: $('#customer').val(),
                itemList: itemList,
                product_id: productID
            }
            // console.log(items);
            $.ajax({
                url: "stockOut",
                data: {"_token": "{{ csrf_token() }}", 'data': items},
                method: 'POST',
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (data) {
                    console.log(data)
                    window.location.href = '/sales/view';

                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });

        });

    </script>
@endsection
