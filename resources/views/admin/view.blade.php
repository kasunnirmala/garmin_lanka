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
                <th scope="col">product Code</th>
                <th scope="col">product Desc</th>
                <th scope="col">Serial Code</th>
                <th scope="col">Serial Desc</th>
                <th scope="col">Stock Availability</th>
                <th scope="col">Stock-up Date</th>
                <th scope="col">Stock-out Date</th>
                <th scope="col">Customer</th>

            </tr>
            </thead>
            <tbody>
            {{--            @foreach ($data as $vendor)--}}
            {{--                @php--}}
            {{--                    $i = true--}}
            {{--                @endphp--}}
            {{--                @foreach ($vendor['products'] as $items)--}}

            {{--                    @foreach ($items['items'] as $item)--}}
            {{--                        <tr>--}}
            {{--                            @if($i)--}}
            {{--                                <td rowspan="{{$vendor['vendor-count']}}">{{$vendor['vendor']->vendor_name}}</td>--}}
            {{--                                @php--}}
            {{--                                    $i = false--}}
            {{--                                @endphp--}}
            {{--                            @endif--}}
            {{--                            @if($loop->index==0)--}}

            {{--                                <td rowspan="{{count($items['items'])}}">{{$items['product']->productCode}}</td>--}}
            {{--                                <td rowspan="{{count($items['items'])}}">{{$items['product']->productDsc}}</td>--}}
            {{--                            @endif--}}
            {{--                            <td>{{$item->itemCode}}</td>--}}
            {{--                            <td>{{$item->itemDsc}}</td>--}}
            {{--                        </tr>--}}
            {{--                    @endforeach--}}

            {{--                @endforeach--}}
            {{--            @endforeach--}}
            @foreach ($data as $vendor)
                @php
                    $vendorRndR=rand(100,255);
                    $vendorRndG=rand(100,255);
                    $vendorRndB=rand(100,255);
                @endphp
                @foreach ($vendor['products'] as $items)
                    @php
                        $productRndR=rand(100,255);
                        $productRndG=rand(100,255);
                        $productRndB=rand(100,255);
                    @endphp
                    @foreach ($items['items'] as $item)

                        <tr>
                            <td style="background-color: {{sprintf("#%02x%02x%02x", $vendorRndR, $vendorRndG, $vendorRndB)}}; color: black; font-weight: 900">{{$vendor['vendor']->vendor_name}}</td>
                            <td style="background-color: {{sprintf("#%02x%02x%02x", $productRndR, $productRndG, $productRndB)}}; color: black; font-weight: 600">{{$items['product']->productCode}}</td>
                            <td style="background-color: {{sprintf("#%02x%02x%02x", $productRndR, $productRndG, $productRndB)}}; color: black; font-weight: 600">{{$items['product']->productDsc}}</td>
                            <td>{{$item->itemCode}}</td>
                            <td>{{$item->itemDsc}}</td>
                            @if($item->in_stock)
                                <td style="color: black;background-color:#94ff94">Available</td>
                            @else
                                <td style="color: black;background-color:#ff9a9d">N/A</td>
                            @endif
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->stock_out_date}}</td>
                            <td>{{$item->customer_name}}</td>

                        </tr>
                    @endforeach

                @endforeach
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
