@extends('voyager::reports.browse')

@section('filters')
    @include('voyager::reports.filters.from')
    @include('voyager::reports.filters.to')
    @include('voyager::reports.filters.status')

    <div class="form-group">
        <label for="coupon-code">Coupon Code</label>
        <input type="text" name="coupon_code" class="form-control" id="coupon-code" value="{{ request('coupon_code') }}">
    </div>
@endsection

@section('result')
    <table class="table table-responsive">
        <thead>
        <tr>
            <th>Date</th>
            <th>Coupon Code</th>
            <th>Orders</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d M, Y') }}</td>
                <td>{{ $data->code }}</td>
                <td>{{ $data->total_orders }}</td>
                <td>${{ $data->total }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-right">
        {!! $report->links() !!}
    </div>
@endsection
