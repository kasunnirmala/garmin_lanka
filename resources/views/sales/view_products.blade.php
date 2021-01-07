@extends('layouts.dashboard.dashboard_layout')


@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/admin/admin.css')}}">
@endsection


@section('page-name')
    All Stock
@endsection


@section('body-content')

    <div class="container-fluid">
        <table class="table-sm table-striped" id="allstock" style="font-size: 80%">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Vendor Name</th>
                <th scope="col">Garmin ID</th>
                <th scope="col">product Desc</th>
                <th scope="col">Quantity</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($data as $product)
                <tr>
                    <td>{{$product->vendorName}}</td>
                    <td>{{$product->garminId}}</td>
                    <td>{{$product->productDesc}}</td>
                    <td>{{$product->qty}}</td>

                    <td>
                        <button class="btn btn-sm btn-success action-btn" data-toggle="modal"
                                data-target="#add-product-amount" data-product-id="{{$product->productID}}"
                                data-max="{{$product->qty}}">
                            SALE-OUT
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>


        <div class="modal fade" id="add-product-amount" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="product-id">
                        <div class="form-group">
                            <label for="product-amount">Amount</label>
                            <input type="number" class="form-control" id="product-amount" name="Amount">
                        </div>


                        <button class="btn btn-sm btn-success" id="btn-add-product-amount">OUT</button>

                    </div>

                </div>

            </div>
        </div>


    </div>
@endsection


@section('script-js')
    <script>
        $(document).ready(function () {
            $('#allstock').DataTable();
        });
        $("#add-product-amount").on('show.bs.modal', function (event) {
            let product_id = $(event.relatedTarget).data('product-id');
            let max = $(event.relatedTarget).data('max');
            $(this).find('#product-id').val(product_id);
            $(this).find('#product-amount').attr({"max": max, "min": 1});
        })


        $("#btn-add-product-amount").on('click', function () {
            if($('#product-amount')[0].checkValidity()){
                var id = $("#product-id").val();
                var amount = $("#product-amount").val();
                window.location.href = '/sales/out?id=' + id + '&amount=' + amount;
                // window.location.href = '/garmin/public/sales/out?id=' + id + '&amount=' + amount;
            }else{
                $.notify("Please Enter Valid Amount", "error");
            }



        });

    </script>


@endsection
