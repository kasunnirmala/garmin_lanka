@extends('layouts.dashboard.dashboard_layout')


@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/admin/admin.css')}}">
@endsection


@section('page-name')
    All Stock : <span style="font-weight: 500; color: green; border: 1px rgb(148, 148, 148) solid; border-radius: 3px; padding:0px 8px" id="total-price" >{{$total}}</span>
@endsection



@section('body-content')

    <div class="container-fluid">
        <table class="table-sm table-striped" id="allstock" style="font-size: 80%">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Vendor Name</th>
                <th scope="col">Part Number</th>
                <th scope="col">Product Desc</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Last Updated</th>
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
                    <td>{{$product->unit_price}}</td>
                    <td>{{$product->lastUpdated}}</td>
                    <td>
                        <button class="btn btn-sm btn-success action-btn" data-toggle="modal"
                                data-target="#add-product-amount" data-product-id="{{$product->productID}}">
                            ADD
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

                        <button class="btn btn-sm btn-success" id="btn-add-product-amount">ADD</button>

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
            $('#total-price').html(Number($('#total-price').html()).toLocaleString("en-US",{style:"currency",currency:"USD",minimumFractionDigits:2}).replace("$","").trim())
        });
$("#add-product-amount").on('show.bs.modal',function (event) {
let product_id=$(event.relatedTarget).data('product-id');
$(this).find('#product-id').val(product_id);
})


        $("#btn-add-product-amount").on('click', function () {
            // alert($("#product-id").val());
            var id = $("#product-id").val();
            var amount = $("#product-amount").val();
            $.ajax({
                url: "updateProducts",
                data: {"_token": "{{ csrf_token() }}", 'data': {'product_id':id, 'amount': amount}},
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
