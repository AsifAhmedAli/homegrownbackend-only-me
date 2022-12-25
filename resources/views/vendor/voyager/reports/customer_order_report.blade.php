@extends('voyager::reports.browse')

@section('filters')
    @include('voyager::reports.filters.from')
    @include('voyager::reports.filters.to')
    @include('voyager::reports.filters.status')

    <div class="form-group">
        <label for="customer-name">Customer Name</label>
        <input type="text" name="customer_name" class="form-control" id="customer-name" value="{{ request('customer_name') }}">
    </div>

    <div class="form-group">
        <label for="customer-email">Customer Email</label>
        <input type="text" name="customer_email" class="form-control" id="customer-email" value="{{ request('customer_email') }}">
    </div>
@endsection

@section('result')
    <table class="table table-responsive">
        <thead>
        <tr>
            <th>Date</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Orders</th>
            <th>Products</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d M, Y') }}</td>
                <td>{{ \App\Utils\Helpers\Helper::concatenate('ucwords', $data->customer_first_name, $data->customer_last_name) }}</td>
                <td>{{ $data->customer_email }}</td>
                <td>{{ $data->total_orders }}</td>
                <td>{{ $data->total_products }}</td>
                <td>${{ $data->total }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-right">
        {!! $report->links() !!}
    </div>
@endsection
