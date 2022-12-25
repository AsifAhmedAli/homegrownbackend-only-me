@extends('voyager::reports.browse')

@section('filters')
    @include('voyager::reports.filters.from')
    @include('voyager::reports.filters.to')
@endsection

@section('result')
    <canvas id="returning_customer"></canvas>

    @php
        $firstTime = \App\Repositories\Report\ReturningCustomerReport::getOnceCustomerOrdered();
        $returning_report = \App\Utils\Helpers\Helper::getMonthlyReport($report);
        $firstTime = \App\Utils\Helpers\Helper::getMonthlyReport($firstTime);
    @endphp

    <table class="table table-responsive">
        <thead>
        <tr>
            <th>Summary</th>
            <th>Customer Type</th>
            <th>Customers</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($returning_report as $key => $data)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromDate($data['month'])->format('F Y') }}</td>
                    <td>Returning</td>
                    <td>{{ $data['count'] }}</td>
                </tr>
            @endforeach
            @foreach ($firstTime as $key => $data)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromDate($data['month'])->format('F Y') }}</td>
                    <td>First Time</td>
                    <td>{{ $data['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('javascript')
    <script>
        @php
            $returning = \App\Utils\Helpers\Helper::makeDataSet($returning_report);
            $firstTimeSet = \App\Utils\Helpers\Helper::makeDataSet($firstTime);
        @endphp

        let returning = @json($returning);
        let firstTimeSet = @json($firstTimeSet);

        const chartLabels = [];
        generateLable();

        function generateLable() {
            returning.forEach(i => {
                chartLabels.push(i.x);
            });
            firstTimeSet.forEach(i => {
                if(chartLabels.length) {
                    let isExist = chartLabels.find(x => x === i.x);
                    if(!isExist) {
                        chartLabels.push(i.x);
                    }
                } else {
                    chartLabels.push(i.x);
                }
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script>

        var chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        var color = Chart.helpers.color;
        var barChartData = {
            labels: chartLabels,
            datasets: [{
                label: 'First Time',
                backgroundColor: chartColors.red,
                borderColor: chartColors.red,
                borderWidth: 1,
                data: firstTimeSet
            }, {
                label: 'Returning',
                borderWidth: 1,
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: chartColors.blue,
                data: returning
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById('returning_customer').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Returning Customers'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        };
    </script>
@stop
