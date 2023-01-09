@extends('layouts.container')

@push('css')
    <!--start:: google chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')



    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Account Completion Statistics
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <div class="kt-section__content">
                                <div class="col-md-12 white-pannel">
                                    <div id="curve_chart" style="width: 100%; height: 300px"></div>
                                </div> 
                                <div class="kt-section__content">                                    
                                    <table class="table">                                                                     
                                        @foreach ($employeeData as $data)
                                            <tr>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar " role="progressbar" aria-valuenow="{{ $data->profile_completion }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $data->profile_completion }}%">{{ $data->profile_completion }}%</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $data->completed }}
                                                </td>
                                                <th>
                                                    <a href="{{ route('Admin.Report.account-completion-details', [$data->profile_completion]) }}" title="{{ $data->profile_completion }}% Completed" class="card-text custom-btn">
                                                        <span class="btn btn-outline-primary">View</span>
                                                    </a>
                                                </th>
                                            </tr>        
                                        @endforeach
                                    </table>
                                </div>

                            </div>                           
                        </div>
                    </div>

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script>
        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }

        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm-dd',
            // viewMode: 'months',
            // minViewMode: 'months'
        });

        $('.year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: "years",
            minViewMode: "years"
        });
        $("#kt_select2_3, #kt_select2_3_validate").select2({placeholder:"Select fields"})
        
    </script>
    <script type="text/javascript">
        // google.charts.load('current', {'packages': ['corechart']});
        // google.charts.setOnLoadCallback(drawChart);
    
        // function drawChart() {

            // var chartData = {!! json_encode($employeeDataChart) !!}
        //     // console.log(chartData);
        //     var data = google.visualization.arrayToDataTable(chartData);
    
        //     var options = {
        //         title: '',
        //         curveType: 'function',
        //         legend: {position: 'none'},
        //         isStacked: true
        //     };
    
        //     var chart = new google.visualization.BarChart(document.getElementById('curve_chart'));
    
        //     chart.draw(data, options);
        // }
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var chartData = {!! json_encode($employeeDataChart) !!}
            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
            chart: {
                // title: 'Account completion',
                // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
            },
            bars: 'vartical' // Required for Material Bar Charts.
            };

            var chart = new google.charts.Bar(document.getElementById('curve_chart'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

    @endpush
