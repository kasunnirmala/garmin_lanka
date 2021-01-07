@extends('layouts.dashboard.dashboard_layout')


@section('styles-css')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection


@section('page-name')
    All Stock
@endsection


@section('body-content')

    <div class="container-fluid">
        <table class="table-sm table-striped" id="allstock" style="font-size: 80%">
            <thead class="thead-dark">
                <tr>

                    <th scope="col">Garmin ID</th>
                    <th scope="col">Item Code</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Stock Out Date</th>
                    <th scope="col">Sales Person</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($data as $item)
                    <tr>
                       
                        <td>{{ $item->garminId }}</td>
                        <td>{{ $item->itemCode }}</td>
                        <td>{{ $item->customerName }}</td>
                        <td>{{ $item->stockOutDate }}</td>
                        <td>{{ $item->salesPerson }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>



    </div>
@endsection


@section('script-js')
    <script>
        $(document).ready(function() {
            $('#allstock').DataTable();
        });

    </script>


@endsection
