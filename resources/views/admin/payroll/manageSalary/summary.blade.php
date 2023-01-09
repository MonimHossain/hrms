@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row justify-content-md-center">
            <div class="col-sm-6">
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <form action="">
                            <div class="row">
                                <div class="col-md-10">
                                    <input class="form-control" name="month" type="month" value="{{ Request::get('month') ? Request::get('month') : date('Y-m') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" value="Filter" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card dash-widget ctm-border-radius shadow-sm grow">
                        <div class="card-body">
                            <div class="card-icon bg-primary">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                <h4 class="card-title">Employees</h4>
                                <p class="card-text">{{ $employeeCount['total'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card dash-widget ctm-border-radius shadow-sm grow">
                        <div class="card-body">
                            <div class="card-icon bg-success">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="card-right">
                                <h4 class="card-title">Active</h4>
                                <p class="card-text">{{ $employeeCount['active'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card dash-widget ctm-border-radius shadow-sm grow">
                        <div class="card-body">
                            <div class="card-icon bg-danger">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                <h4 class="card-title">Inactive</h4>
                                <p class="card-text">{{ $employeeCount['inactive'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card dash-widget ctm-border-radius shadow-sm grow">
                        <div class="card-body">
                            <div class="card-icon bg-warning">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                <h4 class="card-title">Suspended</h4>
                                <p class="card-text">{{ $employeeCount['suspended'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">New Employees</span>
                                    </div>
                                    <div>
                                        <span class="text-success">+{{ number_format(($employeeCount['newJoin']/$employeeCount['active'])*100, 2) }}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{ $employeeCount['newJoin'] }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($employeeCount['newJoin']/$employeeCount['active'])*100 }}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Overall Active Employees {{ $employeeCount['active'] }}</p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Payroll Generated</span>
                                    </div>
                                    <div>
                                        <span class="text-success"></span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{ $salaryDetails['salary-count'] }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month <span class="text-muted">{{ $salaryDetails['salary-prev-count'] }}</span></p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Payroll Cost</span>
                                    </div>
                                    @if($salaryDetails['previous-month'])
                                    <div>
                                        <span class="text-{{ (($salaryDetails['present-month'] - $salaryDetails['previous-month']) > 0) ? 'success' : 'danger' }}">{{ (($salaryDetails['present-month'] - $salaryDetails['previous-month']) > 0) ? '+' : '-' }}{{ number_format(((($salaryDetails['present-month'] - $salaryDetails['previous-month'])/$salaryDetails['previous-month']) * 100), 2)}}%</span>
                                    </div>
                                    @endif
                                </div>
                                <h3 class="mb-3">{{ number_format($salaryDetails['present-month']) }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($salaryDetails['salary-count'] / $employeeCount['total'])*100 }}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month <span class="text-muted">{{ $salaryDetails['previous-month'] }}</span></p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Hold Salary</span>
                                    </div>
                                    @if($salaryDetails['previous-month-hold'])
                                        <div>
                                            <span class="text-{{ (($salaryDetails['present-month-hold'] - $salaryDetails['previous-month-hold']) < 0) ? 'success' : 'danger' }}">{{ (($salaryDetails['present-month-hold'] - $salaryDetails['previous-month-hold'])/$salaryDetails['previous-month-hold']) * 100}}%</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="mb-3">{{ $salaryDetails['present-month-hold'] }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($salaryDetails['salary-hold-count'] / $employeeCount['total'])*100 }}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month Hold <span class="text-muted">{{ $salaryDetails['previous-month-hold'] }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
{{--                <div class="paper col-sm-3">--}}
{{--                    <div class="card card-stats">--}}
{{--                        <div class="card-body ">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-5 col-md-4">--}}
{{--                                    <div class="icon-big text-center icon-warning"><i--}}
{{--                                            class="fas fa-users-cog text-theme-2"></i></div>--}}
{{--                                </div>--}}
{{--                                <div class="col-7 col-md-8">--}}
{{--                                    <div class="numbers"><p class="card-category">Total Employee</p>--}}
{{--                                        <p class="card-title">{{ array_sum(array_column($dataset,'employee_count')) }}</p>--}}
{{--                                        <p></p></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="paper col-sm-6">--}}
{{--                    <div class="card card-stats">--}}
{{--                        <div class="card-body ">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-5 col-md-4">--}}
{{--                                    <div class="icon-big text-center icon-warning"><i--}}
{{--                                            class="fas fa-users-cog text-theme-2"></i></div>--}}
{{--                                </div>--}}
{{--                                <div class="col-7 col-md-8">--}}
{{--                                    <div class="numbers"><p class="card-category">Payroll Generated</p>--}}
{{--                                        <p class="card-title"><strong>{{ array_sum(array_column($dataset,'employeeCount')) }}</strong></p>--}}
{{--                                        <p></p></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="paper col-sm-6">--}}
{{--                    <div class="card card-stats">--}}
{{--                        <div class="card-body ">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-5 col-md-4">--}}
{{--                                    <div class="icon-big text-center icon-warning"><i--}}
{{--                                            class="fas fa-money-bill text-theme-2"></i></div>--}}
{{--                                </div>--}}
{{--                                <div class="col-7 col-md-8">--}}
{{--                                    <div class="numbers"><p class="card-category">Payroll Cost</p>--}}
{{--                                        <p class="card-title">{{ number_format(array_sum(array_column($dataset,'amount')), 2) }}</p>--}}
{{--                                        <p></p></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="row">
{{--            <div class="col-sm-4">--}}
{{--                <div class="kt-portlet">--}}
{{--                    <div class="kt-portlet__body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <strong>Payroll</strong> <br>--}}
{{--                                <h3>{{ date('F') }}</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-1"></div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <strong>Total employee</strong>--}}
{{--                                <h3>{{ $employees->count() }}</h3>--}}
{{--                                <!-- <small>--}}
{{--                                    180(Per) | 3320(Hou) | 800(Con) | 200(Pro)--}}
{{--                                </small> -->--}}
{{--                            </div>--}}
{{--                            <div class="col-md-2">--}}
{{--                                <strong>Working days</strong>--}}
{{--                                <h3>23</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-2">--}}
{{--                                <strong>Payroll processed</strong>--}}
{{--                                <h3><strong>{{ $salary_history->count() }}</strong>/{{ $employees->count() }}</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-2">--}}
{{--                                <strong>Payroll Cost</strong>--}}
{{--                                <h3>--}}
{{--                                    {{ $total_cost }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4 hidden">--}}
{{--                <div class="kt-portlet">--}}
{{--                    <div class="kt-portlet__body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <strong>{{ date('F') }} Payroll</strong> <br>--}}
{{--                                <small>Salary cycle: (16th to 15th)</small> <br>--}}
{{--                                31 Calendar days--}}
{{--                            </div>--}}
{{--                            <div class="col-md-1"></div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <strong>Total employee</strong>--}}
{{--                                <h3>4500</h3>--}}
{{--                                <!-- <small>--}}
{{--                                    180(Per) | 3320(Hou) | 800(Con) | 200(Pro)--}}
{{--                                </small> -->--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <strong>Working days</strong>--}}
{{--                                <h3>23</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <strong>Payroll processed</strong>--}}
{{--                                <h3><strong>3500</strong>/4500</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!--end::Portlet-->
        </div>

        <div class="row">
{{--            <div class="col-md-4 p-0">                --}}
{{--                <div class="col-sm-12">--}}
{{--                    <div class="kt-portlet">                    --}}
{{--                        <div class="kt-portlet__body">                                --}}
{{--                            @foreach($dependent_modules as $module)--}}
{{--                                <div class="form-group">                                        --}}
{{--                                    <div class="form-check">--}}
{{--                                        @if($module['status'])--}}
{{--                                            <i class="fa fa-check text-success pad-r-15"></i>--}}
{{--                                        @else--}}
{{--                                            <i class="fa fa-times text-danger pad-r-18"></i>--}}
{{--                                        @endif--}}
{{--                                        <label class="form-check-label" for="loanCheck">{{ $module['title'] }} of {{ date('M, Y') }}</label>--}}
{{--                                    </div>--}}
{{--                                </div>                                 --}}
{{--                            @endforeach   --}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>  --}}

            </div>
{{--            <div class="row">--}}
{{--                <div class="col-sm-4 p-0">--}}
{{--                    <div class="kt-portlet">--}}
{{--                        <div class="kt-portlet__body">--}}
{{--                            <div id="piechart" style="width: 100%; height: auto;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-8 p-0">--}}
{{--                    <div class="col-sm-12">--}}
{{--                        <div class="kt-portlet">--}}
{{--                            <div class="kt-portlet__body">--}}
{{--                                <div id="chart_div_dept"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--                <div class="col-sm-12">--}}
{{--                    <div class="kt-portlet">--}}
{{--                        <div class="kt-portlet__body">--}}
{{--                            <div id="chart_div"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!--end::Portlet-->
        </div>
    </div>
@endsection


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawMaterial);
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChartSalary);

        function drawChartSalary() {
            var data = google.visualization.arrayToDataTable([
                ['Department', 'November 2019', 'December 2019', 'January 2020'],
                ['P&C', 7975000, 8175000, 8008000],
                ['Operations', 3292000, 3792000, 3494000],
                ['Business Developemnt', 1326000, 1526000, 1417000],
                ['Admin', 7975000, 8175000, 8008000],
                ['IT', 7975000, 8175000, 8008000],
                ['Management', 3292000, 3792000, 3494000],
                ['Accounts', 7975000, 8175000, 8008000],
                ['Solusions', 3292000, 3792000, 3494000],
                ['MIS', 3292000, 3792000, 3494000],
            ]);

            var options = {
                title: 'Department wise salary',
                vAxis: {title: 'Total Cost'},
                isStacked: true,
                height: '400'
            };

            var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div_dept'));

            chart.draw(data, options);
        }

        function drawMaterial() {
            var data = google.visualization.arrayToDataTable([
                ['Process', 'November 2019', 'December 2019', 'January 2020'],
                ['GP Inbound', 7975000, 8175000, 8008000],
                ['GP Inbound 2', 7975000, 8175000, 8008000],
                ['GP Inbound 3', 7975000, 8175000, 8008000],
                ['GP Inbound 4', 7975000, 8175000, 8008000],
                ['Uber', 3292000, 3792000, 3494000],
                ['Uber 2', 3292000, 3792000, 3494000],
                ['Uber 3', 3292000, 3792000, 3494000],
                ['Uber 4', 3292000, 3792000, 3494000],
                ['Banglalink', 2695000, 2695000, 2896000],
                ['Banglalink 2', 2695000, 2695000, 2896000],
                ['Banglalink 3', 2695000, 2695000, 2896000],
                ['Banglalink 4', 2695000, 2695000, 2896000],
                ['Banglalink', 2695000, 2695000, 2896000],
                ['Foodpanda', 2099000, 1999000, 2053000],
                ['Foodpanda 2', 2099000, 1999000, 2053000],
                ['Foodpanda 3', 2099000, 1999000, 2053000],
                ['Foodpanda 4', 2099000, 1999000, 2053000],
                ['Foodpanda 5', 2099000, 1999000, 2053000],
                ['Foodpanda 6', 2099000, 1999000, 2053000],
                ['333', 1326000, 1526000, 1417000],
                ['333 2', 1326000, 1526000, 1417000],
                ['BAT', 1326000, 1526000, 1417000],
                ['BAT 2', 1326000, 1526000, 1417000]
            ]);

            var materialOptions = {
                chart: {
                    title: 'Process wise salary'
                },
                hAxis: {
                    title: 'Total Population',
                    minValue: 0,
                    Type: 'string',
                    Default: 'in'
                },
                vAxis: {
                    title: 'Process',
                    Type: 'string',
                    Default: 'in'
                },
                bars: 'horizontal',
                height: '700'
            };
            var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
            materialChart.draw(data, materialOptions);
        }
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Type', 'Gross salary'],
                ['Permanent',     8008000],
                ['Contractual',      608000],
                ['Houry', 10008000],
                ['provisional', 458000]
            ]);

            var options = {
            title: 'Employment type wise salary'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

@endpush
