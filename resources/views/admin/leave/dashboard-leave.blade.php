@extends('layouts.container')


@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Leave Dashboard
                        </h3>
                    </div>
                    <span class="pull-right">
                        <a href="{{ route('process.attendance.leave.dashboard') }}" class="btn btn-outline-success"
                            style="position: relative; top: 12px;">Process Report</a>
                    </span>
                </div>

                {{-- // TODO Leave Dashboard --}}

                <form class="kt-form  p-5" action="" method="get">
                    {{-- @csrf --}}
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
                </form>

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

                <!-- chart panel -->
                <div class="container">
                    <div class="pt-5 row">

                        <div class="col-sm-6">
                            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Male vs Female Leave
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
                                            DHK vs CTG (Leave)
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
                                            Dept Wise Leave:
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

                        <div class="col-sm-12">
                            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Leave Reason:
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
@endpush

@push('library-js')
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset="utf-8"></script> --}}

@endpush

@push('js')

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

{{-- laravel charts scripts --}}
{!! $genderRatio->script() !!}
{!! $dhkVsCtg->script() !!}
{!! $departmentHeadCount->script() !!}
{!! $leaveReason->script() !!}


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





@endpush
