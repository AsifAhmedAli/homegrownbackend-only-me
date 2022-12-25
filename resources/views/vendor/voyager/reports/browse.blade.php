@extends('voyager::master')

@section('page_title', \App\Utils\Helpers\Helper::reportType(request('type', 'sales_report')))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bar-chart"></i> {{ \App\Utils\Helpers\Helper::reportType(request('type', 'sales_report')) }}
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @yield('result')
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3 class="tab-content-title">Filters</h3>

                        <form method="GET" action="{{ route('admin.reports') }}">
                            <div class="form-group">
                                <label class="control-label" for="report-type">Report Type</label>

                                <select name="type" class="select2 filter">
                                    @foreach (\App\Utils\Helpers\Helper::reportTypes() as $type => $label)
                                        <option value="{{ $type }}" {{ request('type', 'sales_report') === $type ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @yield('filters')

                            <button type="submit" class="btn btn-default" data-loading>
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('javascript')
    <script>
        {{--$('.filter').on('change', function() {--}}
        {{--    window.location.href = "{{ route('admin.reports') }}?type=" + $(this).val();--}}
        {{--});--}}
    </script>
@stop
