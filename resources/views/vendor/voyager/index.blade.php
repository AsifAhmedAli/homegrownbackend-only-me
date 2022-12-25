@extends('voyager::master')
@section('css')
    <link href="admin-assets/css/datepicker.css"/>
@stop
@section('content')

    <div class="page-content">
        @include('voyager::alerts')
        @if(in_array(strtolower(auth()->user()->role->name), ['developer', 'admin']))
            @include('voyager::dimmers')
        @else
        @endif
    </div>

    <div class="d-full">
        <div class="new-bg-lyer"></div>

        <div class="nd-innr d-full">
            <div class="d-full-rw d-full">
                <form action="" method="GET">
                <div class="d-frm">
                    <div class="d-frm-inpt" data-toggle="datepicker">
                       <input type="text" placeholder="Start Date" value="{!! request()->get('start_date') !!}" class="form-control datepicker start_date" id="startDate" name="start_date">
                    </div>

                    <div class="d-frm-inpt">
                        <input type="text" placeholder="End Date" value="{!! request()->get('end_date') !!}" class="form-control datepicker end_date" id="endDate" name="end_date">
                    </div>

                    <button class="btn">Submit</button>
                </div>
                </form>
            </div>

            <div class="d-full-rw d-full">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-full grnrl-bxstyl position-relative threbx1">
                            <div class="d-curve">Gross Revenue</div>

                            <div class="bngirr-bx-full">
                                <div class="brngr-exprt">
                                    <div class="brngr-img d-c1">
                                        <img src="/images/brng1.png"/>
                                        @if($kits[0]->total > $kits[1]->total && $kits[0]->total > $kits[2]->total)
                                            <div class="sle-img"></div>
                                        @endif
                                    </div>
                                    <h3>${{ $kits[0]->total }}</h3>
                                    <p>Beginner</p>
                                </div>

                                <div class="brngr-exprt">
                                    <div class="brngr-img d-c2">
                                        <img src="/images/brng2.png"/>
                                        @if($kits[1]->total > $kits[0]->total && $kits[1]->total > $kits[2]->total)
                                            <div class="sle-img"></div>
                                        @endif
                                    </div>
                                    <h3>${{ $kits[1]->total }}</h3>
                                    <p>Medium</p>
                                </div>

                                <div class="brngr-exprt">
                                    <div class="brngr-img d-c3">
                                        <img src="/images/brng3.png"/>
                                        @if($kits[2]->total > $kits[1]->total && $kits[2]->total > $kits[0]->total)
                                            <div class="sle-img"></div>
                                        @endif
                                    </div>
                                    <h3>${{ $kits[2]->total }}</h3>
                                    <p>Expert</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="d-full grnrl-bxstyl position-relative threbx1">
                            <div class="d-curve">SUBSCRIPTIONS</div>
                        <canvas id="myChart"></canvas>


                        </div>
                    </div>
                </div>
            </div>


            <div class="d-full-rw d-full">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-full grnrl-bxstyl position-relative threbx2">


                            <div class="bngirr-bx-full">
                                <div class="brngr-exprt">

                                    <h3>${{ $gross_revenue }}</h3>
                                    <p>Gross Revenue</p>
                                </div>


                                <div class="brngr-exprt2">
                                <a href="#">
                                        <img src="/images/hgp-Logo.png"/>
                                        <!-- <img src="data:image/webp;base64,UklGRkABAABXRUJQVlA4TDQBAAAvMUAEECehoG0bxt2IjD/HQ0NBI6nR8AjBv0ZoCbJtOpP7Sx5B27bpECz80Z3BUwQLZGYAAMCSRy35AE2goGC2f/kHoS9QED4DcagvOBSHFisNPMACgiRJTqNGXiNXCwwn7///yR32NvSCiP5PgLn7VfnU3f2gvHkMHfSDKTz5qE0k3QAPZgDBOjHaTrKO8XZd6UlpO/kHaVJlSd6dhg7ARzp3BzhV6YC0k6QXwCoySW8g1ZgB7BV2wKOkAQhay+/RDfhTvDOzfcmsoPigAXhkCzOzhRSdzO4d4DUcmGcdedtE45saA2AlPP7xUdDv8kd0AS7Z5XTqgFtJ8p0iVz6LDEiNwlPJYzKZKKzQJKBvsn0qMY1X0BugfSwXJ/Kf0JHy39B57Ps72h8T0G9ndepP9hPVBg=="/> -->
                                    </a>
                                    <div class="brngr-img d-c4">
                                        <img src="/images/brng4.png"/>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-full grnrl-bxstyl position-relative threbx2">
                            <div class="bngirr-bx-full">
                                <div class="brngr-exprt3">

                                    <h3>${{ $subscriptions_gross }}</h3>
                                    <p>Gross Revenue (Subscriptions)</p>
                                </div>


                                <div class="brngr-exprt algnfnx-end">

                                    <div class="brngr-img d-c5">
                                        <img src="/images/gx-logo.png"/>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="d-full-rw d-full">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-full grnrl-bxstyl position-relative threbx3">


                            <div class="bngirr-bx-full">
                            <div class="brngr-exprt">

                                <div class="brngr-img d-c6">
                                    <img src="/images/brng6.png"/>
                                </div>

                            </div>
                                <div class="brngr-exprt algnfnx-end">

                                    <h3>{{ $retailers }}</h3>
                                    <p>Total Retailers</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="d-full grnrl-bxstyl position-relative threbx3">


                            <div class="bngirr-bx-full">
                            <div class="brngr-exprt">

                                <div class="brngr-img d-c7">
                                    <img src="/images/brng7.png"/>
                                </div>

                            </div>
                                <div class="brngr-exprt3 algnfnx-end">

                                    <h3>{{ $grow_masters }}</h3>
                                    <p>Total GrowMasters</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                    <div class="d-full grnrl-bxstyl position-relative threbx3">


                            <div class="bngirr-bx-full">
                            <div class="brngr-exprt">

                                <div class="brngr-img d-c8">
                                    <img src="/images/brng8.png"/>
                                </div>

                            </div>
                                <div class="brngr-exprt3 algnfnx-end">

                                    <h3>{{ $harvests }}</h3>
                                    <p>Total Harvested</p>
                                </div>





                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="d-full-rw d-full">
                <div class="row">

                    <div class="col-md-12">
                        <div class="d-full grnrl-bxstyl position-relative custmr-bx">
                            <h2>CUSTOMERS</h2>

                            <div class="custmer-immr">
                                <canvas id="customers"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $chartLabels = $dataSet = $dataSetCustomerHavingOrders = []; @endphp

    @foreach($customers as $key => $value)
        @if(!in_array($key, $chartLabels) && !empty($key))
            @php $chartLabels[] = $key @endphp
            @php $dataSet[] = $value @endphp
        @endif
    @endforeach

    @foreach($customers_having_orders as $key => $value)
        @php $dataSetCustomerHavingOrders[] = $value @endphp
    @endforeach


@stop

@section('javascript')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="admin-assets/js/datepicker.js"> </script>
    <script>
        $(document).ready(function() {
            $('body').addClass('new-dashbrd');


        });

        $('[data-toggle="datepicker"]').datepicker({
            opens: 'left'
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: ['MONTHLY', 'YEARLY'],
                datasets: [{
                    label: 'Subscriptions',
                    backgroundColor: [
                        'rgb(85, 178, 170)',
                        'rgb(37, 108, 104)',
                    ],
                    data: [{!! $monthly !!}, {!! $yearly !!}],
                }]
            },

            // Configuration options go here
            options: {
                maintainAspectRatio : true,
                responsive : true,
                cutoutPercentage: 60,
                legend: {
                    position: 'left'
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            console.log('data', data)
                            //get the concerned dataset
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            //calculate the total of this data set
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            //get the current items value
                            var currentValue = dataset.data[tooltipItem.index];
                            //calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
                            var percentage = Math.floor(((currentValue/total) * 100)+0.5);

                            return percentage + "%";
                        }
                    }
                }
            }
        });

        var barChartData = {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Customers Having Orders',
                backgroundColor: 'rgb(37, 108, 104)',
                borderWidth: 1,
                data: {!! json_encode($dataSetCustomerHavingOrders) !!}
            },
                {
                    label: 'Customers having no orders',
                    backgroundColor: 'rgb(85, 178, 170)',
                    borderWidth: 1,
                    data: {!! json_encode($dataSet) !!}
                }]
        };

        window.onload = function() {
            var ctx = document.getElementById('customers').getContext('2d');
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
                        text: 'Customers'
                    }
                }
            });
        };

        $("#startDate").on("dp.change", function (e) {
            $('#endDate').data("DateTimePicker").minDate(e.date);
        });

        @php
            $startMinDate = isset($_GET['start_date']) && !empty($_GET['end_date']) ? $_GET['start_date'] : date('Y-m-d');
            $endMinDate = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
        @endphp

        $('#endDate').datetimepicker(
            {
                'format': "MM/DD/YYYY",
                minDate: {!! $endMinDate !!}
            }
        );

        $('#startDate').datetimepicker(
            {
                'format': "MM/DD/YYYY",
                minDate: {!! $startMinDate !!}
            }
        );
    </script>
@endsection
