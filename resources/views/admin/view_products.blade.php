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
                <th scope="col">Unit Price</th>
                <th scope="col">Last Updated</th>
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
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection


@section('script-js')
    <script>
        $(document).ready(function () {
            $('#allstock').DataTable();
        });
    </script>
@endsection
