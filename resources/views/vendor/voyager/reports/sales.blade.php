@extends('voyager::reports.browse')

@section('filters')
    @include('voyager::reports.filters.from')
    @include('voyager::reports.filters.to')
    @include('voyager::reports.filters.status')
@endsection

@section('result')
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Date</th>
                <th>Orders</th>
                <th>Products</th>
                <th>Sub Total</th>
                <th>Shipping</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d M, Y') }}</td>
                    <td>{{ $data->total_orders }}</td>
                    <td>{{ $data->total_products }}</td>
                    <td>${{ $data->sub_total }}</td>
                    <td>${{ $data->shipping_cost }}</td>
                    <td>${{ $data->discount }}</td>
                    <td>${{ $data->tax }}</td>
                    <td>${{ $data->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-right">
        {!! $report->links() !!}
    </div>
@endsection
