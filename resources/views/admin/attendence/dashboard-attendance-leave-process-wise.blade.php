@extends('layouts.container')


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
                                        Process Wise Attendance & Leave Dashboard
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- // TODO Attendance Dashboard --}}

                {{-- <form class="kt-form  p-5" action="{{ route('attendance.dashboard') }}" method="get">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Month</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly placeholder="Select Month"
                                    id="month-pick" name="month" value="{{ $month }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>year</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly placeholder="Select Year"
                                    id="year-pick" name="year" value="{{ $year }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="form-group">
                            <div class="kt-form__actions" style="margin-top: 26px;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form> --}}

                <!-- card section start -->
                {{-- <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span class="dbox__title">Present</span>
                                        <span class="dbox__count">{{ $presentPercent }}%</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dbox dbox--color-3">
            <div class="dbox__body">
                <span class="dbox__title">Ontime</span>
                <span class="dbox__count">{{ $ontimePercent }}%</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dbox dbox--color-3">
            <div class="dbox__body">
                <span class="dbox__title">Late</span>
                <span class="dbox__count">{{ $latePercent }}%</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dbox dbox--color-3">
            <div class="dbox__body">
                <span class="dbox__title">Absent</span>
                <span class="dbox__count">{{ $absentPercent }}%</span>
            </div>
        </div>
    </div>
</div>
</div> --}}
<!-- card section end -->

<!-- chart panel -->
{{-- <div class="container">
                        <div class="pt-5 row">

                            <div class="col-sm-6">
                                <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                Male vs Female Absent
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget19__wrapper">
                                            <div class="kt-widget19__text">
                                                {!! $genderRatio->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                DHK vs CTG
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget19__wrapper">
                                            <div class="kt-widget19__text">
                                                {!! $dhkVsCtg->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                Dept wise:
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget19__wrapper">
                                            <div class="kt-widget19__text">
                                                {!! $departmentHeadCount->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}


{{-- <div class="kt-portlet__body">
    <!--begin::Section-->
    <div class="kt-section">
        <div class="kt-section__content kt-section__content--solid">
            <div class="kt-divider">
                <span></span>
                <span class="bold">Process Report</span>
                <span></span>
            </div>
        </div>
    </div>
    <!--end::Section-->
</div> --}}

{{-- process report --}}
<div class="kt-portlet__body">
    <div class="kt-portlet__content">
        <div class="kt-portlet">
            {{-- <div class="kt-portlet kt-portlet--height-fluid kt-widget19"> --}}

            <form action="" method="get" class=" center-division-form" style="width: 100%">

                {{-- <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}"> --}}
                <div class="row p-5">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Month</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" required autocomplete="off"
                                    placeholder="Select Month" id="month-pick" name="month" value="{{ $month }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>year</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" required autocomplete="off"
                                    placeholder="Select Year" id="year-pick" name="year" value="{{ $year }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Division</label>
                            <div>
                                <select required class="form-control kt-select2 division" id="kt_select2_222"
                                    name="division">
                                    <option value="">Select Option</option>
                                    @foreach($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        {{ isset($filters['division']) && $filters['division'] == $division->id ? 'selected': '' }}>
                                        {{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Center</label>
                            <div>
                                <select required class="form-control kt-select2 center" id="kt_select2_222"
                                    name="center">
                                    <option value="">Select Center</option>
                                    @if(isset($filters['division']))
                                    @foreach($centers as $center)
                                    <option value="{{ $center->id }}"
                                        {{ isset($filters['center']) && $filters['center'] == $center->id ? 'selected': '' }}>
                                        {{ $center->center }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Department</label>
                            <div>
                                <select required class="form-control kt-select2 department" id="kt_select2_22"
                                    name="department">
                                    <option value="">Select Option</option>
                                    @if(isset($filters['center']))
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ isset($filters['department']) && $filters['department'] == $department->id ? 'selected': '' }}>
                                        {{ $department->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Process</label>
                            <div>
                                <select class="form-control kt-select2 process" id="kt_select2_31" name="process">
                                    <option value="">Select Option</option>
                                    @if(isset($filters['department']))
                                    @foreach($processes as $process)
                                    <option value="{{ $process->id }}"
                                        {{ isset($filters['process']) && $filters['process'] == $process->id ? 'selected': '' }}>
                                        {{ $process->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Process segment</label>
                            <div>
                                <select class="form-control kt-select2 process-segment" id="kt_select2_62"
                                    name="process_segment">
                                    <option value="">Select Option</option>
                                    @if(isset($filters['process']))
                                    @foreach($processSegments as $processSegment)
                                    <option value="{{ $processSegment->id }}"
                                        {{ isset($filters['process_segment']) && $filters['process_segment'] == $processSegment->id ? 'selected': '' }}>
                                        {{ $processSegment->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group " style="margin-top: 25px;">
                            <button type="submit" class="btn btn-primary"><i class="flaticon2-line-chart"></i>
                                Report</button>
                        </div>
                    </div>
                </div>
            </form>

            @if($teamDetailsTable != null)
            {{-- <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-success ml-5" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#kt_tabs_6_1" role="tab">Atteandance Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#kt_tabs_6_2" role="tab">Leave Report</a>
                </li>
            </ul> --}}
            {{-- <div class="tab-content">
                <div class="tab-pane active" id="kt_tabs_6_1" role="tabpanel"> --}}
            <!-- card section start -->
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">Present</span>
                                <span class="dbox__count">{{ $presentPercent }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">Ontime</span>
                                <span class="dbox__count">{{ $ontimePercent }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">Late</span>
                                <span class="dbox__count">{{ $latePercent }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">Absent</span>
                                <span class="dbox__count">{{ $absentPercent }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card section end -->
            <div class="row">

                <div class="col-sm-6">

                    <div class="kt-portlet__body">
                        <div class="kt-widget19__wrapper">
                            <div class="kt-widget19__text">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TL</th>
                                            <th>Member</th>
                                            <th>Absent (count)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teamDetailsTable as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $item['teamLeadName'] }}</td>
                                            <td>{{ $item['member'] }}</td>
                                            <td>{{ $item['Absent'] }}</td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="kt-portlet__body">
                        <div class="kt-widget19__wrapper">
                            <div class="kt-widget19__text">
                                {!! $processWiseHeadCount->container() !!}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Ontime vs Late:
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget19__wrapper">
                                <div class="kt-widget19__text">
                                    {!! $processWiseOntimeLate->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div>
                <div class="tab-pane" id="kt_tabs_6_2" role="tabpanel"> --}}

            <div class="kt-portlet__body">
                <!--begin::Section-->
                <div class="kt-section">
                    <div class="kt-section__content kt-section__content--solid">
                        <div class="kt-divider">
                            <span></span>
                            <span class="bold">Leave Report</span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <!--end::Section-->
            </div>
            <!-- card section start -->
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">SL</span>
                                {{-- <span class="dbox__count">{{ isset($total_office) ? $total_office : 0 }}</span>
                                --}}
                                <span class="dbox__count">{{ $totalSl }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">CL</span>
                                <span class="dbox__count">{{ $totalCl }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">EL</span>
                                <span class="dbox__count">{{ $totalEl }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dbox dbox--color-3">
                            <div class="dbox__body">
                                <span class="dbox__title">Others</span>
                                <span class="dbox__count">{{ $totalOther }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card section end -->
            <div class="row">

                <div class="col-sm-6">

                    <div class="kt-portlet__body">
                        <div class="kt-widget19__wrapper">
                            <div class="kt-widget19__text">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TL</th>
                                            <th>Member</th>
                                            <th>Leave (count)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teamLeaveDetailsTable as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $item['teamLeadName'] }}</td>
                                            <td>{{ $item['member'] }}</td>
                                            <td>{{ $item['leave'] }}</td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="kt-portlet__body">
                        <div class="kt-widget19__wrapper">
                            <div class="kt-widget19__text">
                                {!! $processWiseLeaveCount->container() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Leave Reason Wise Report:
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget19__wrapper">
                                <div class="kt-widget19__text">
                                    {!! $leaveReason->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- </div>
                </div> --}}
            </div>
            @else
            <div class="container">
                <div class="alert alert-warning fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">No Data!</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="la la-close"></i></span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
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
{{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}"
rel="stylesheet" type="text/css"/>--}}
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
    rel="stylesheet" type="text/css" />
@endpush

@push('library-js')
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset="utf-8"></script> --}}

@endpush

@push('js')

@include('layouts.partials.includes.division-center')

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
        format: 'mm',
        viewMode: 'months',
        minViewMode: 'months'
    });

    $('#year-pick').datepicker({
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

</script>
<script>
    Chart.pluginService.register({
        beforeRender: function (chart) {
            if (chart.config.options.showAllTooltips) {
                // create an array of tooltips
                // we can't use the chart tooltip because there is only one tooltip per chart
                chart.pluginTooltips = [];
                chart.config.data.datasets.forEach(function (dataset, i) {
                    chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                        chart.pluginTooltips.push(new Chart.Tooltip({
                            _chart: chart.chart,
                            _chartInstance: chart,
                            _data: chart.data,
                            _options: chart.options.tooltips,
                            _active: [sector]
                        }, chart));
                    });
                });

                // turn off normal tooltips
                chart.options.tooltips.enabled = false;
            }
        },
        afterDraw: function (chart, easing) {
            if (chart.config.options.showAllTooltips) {
                // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
                if (!chart.allTooltipsOnce) {
                    if (easing !== 1)
                        return;
                    chart.allTooltipsOnce = true;
                }

                // turn on tooltips
                chart.options.tooltips.enabled = true;
                Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                    tooltip.initialize();
                    tooltip.update();
                    // we don't actually need this since we are not animating tooltips
                    tooltip.pivot();
                    tooltip.transition(easing).draw();
                });
                chart.options.tooltips.enabled = false;
            }
        }
    });

</script>


{{-- {!! $genderRatio->script() !!}
{!! $dhkVsCtg->script() !!}
{!! $departmentHeadCount->script() !!} --}}
@if($teamDetailsTable != null)
{!! $processWiseHeadCount->script() !!}
{!! $processWiseOntimeLate->script() !!}
{!! $processWiseLeaveCount->script() !!}
{!! $leaveReason->script() !!}
@endif

{{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script>
--}}
<script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
</script>
{{--        <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"
type="text/javascript"></script>--}}

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

    // enable clear button
    $('.kt_datepicker_3').datepicker({
        rtl: KTUtil.isRTL(),
        todayBtn: "linked",
        clearBtn: true,
        showOn: 'none',
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows,
        format: 'yyyy-mm-dd',
    });

</script>
<script>
    function getFilePath() {
        // var input = document.getElementById("customFile");
        // var fReader = new FileReader();
        // fReader.readAsDataURL(input.files[0]);
        // fReader.onloadend = function(event){
        //     $("#customFileLabel").empty();
        //     $("#customFileLabel").append(event.target.result);
        // }
        $("#customFileLabel").empty();
        $("#customFileLabel").append(document.getElementById("customFile").files[0].name);
    }

</script>


@endpush
