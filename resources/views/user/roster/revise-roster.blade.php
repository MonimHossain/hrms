@extends('layouts.container')

@section('content')

<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Revise Roster
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="kt-section__content">
                    <form class="kt-form" action="{{ route('user.roster.revise.view') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>Month</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly placeholder="Select Month" id="month-pick" name="month" value="{{ $month }}"/>
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
                                        <input type="text" class="form-control" readonly placeholder="Select Year" id="year-pick" name="year" value="{{ $year }}"/>
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
                                    <div class="kt-form__actions" style="margin-top: 26px;">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    @if ($rosterRequests->count())
{{--                    <form action="{{ route('user.roster.revise.submit') }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">--}}
{{--                        <button class="btn btn-success pull-right mb-4" type="submit" >Submit for approval</button>--}}
{{--                    </form>--}}

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Roster</th>
                                <th>Off Days</th>
{{--                                @if (isset($rosterRequests->first()->is_revised) && $rosterRequests->first()->is_revised == 0)--}}
{{--                                <th>Actions</th>--}}
{{--                                @endif--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rosterRequests as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \Carbon\Carbon::create($item->date)->toFormattedDateString() }}</td>
                                <td>{{ $item->DayOfTheWeek }}</td>
{{--                                <td class="text-center">{{ ($item->roster_id) ? $item->roster->RosterTime : "-"}}</td>--}}
                                <td class="text-center">{{ ($item->roster_start) ? date('H:i:s', strtotime($item->roster_start)).' - '.date('H:i:s', strtotime($item->roster_end)) : "-"}}</td>
{{--                                <td class="{{ ($item->is_offday) ? "text-danger" : "text-success" }}">{{ ($item->is_offday) ? "Off Day" : "Weekday" }}</td>--}}
                                <td class="{{ ($item->status == \App\Utils\AttendanceStatus::DAYOFF) ? "text-danger" : "text-success" }}">{{ ($item->status == \App\Utils\AttendanceStatus::DAYOFF) ? "Off Day" : "Weekday" }}</td>
{{--                                @if ($item->is_revised == 0)--}}
{{--                                <td class="text-center"><a target="_blank" href="" class="editor_edit text-center" data-id="{{ $item->id }}" data-toggle="modal" data-target="#kt_modal_4"><i class="flaticon-edit text-center"></i></a></td>--}}
{{--                                @endif--}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    No Roster Available.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif

                    <!--begin::Modal-->
                    <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="role-name">Change Roster Time</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form action="{{ route('user.roster.revise.change') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="table-id" name="id" >
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Roster</label>
                                                    <select name="roster_id" class="form-control" id="roster-id">
                                                        <option value="">Select</option>
                                                        @foreach ($rosters as $item)
                                                        <option value="{{ $item->id }}">{{ $item->roster_start }} - {{ $item->roster_end }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">

                                                    <div class="kt-checkbox-inline" style="margin-top: 35px">
                                                        <label class="kt-checkbox kt-checkbox--info">
                                                            <input type="checkbox" name="is_offday" id="off-day" > Off Day
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Change</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                </div>
            </div>
        </div>
    </div>

</div>

<!-- end:: Content -->
@endsection

@push('css')
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush


@push('library-js')
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

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

    $('.editor_edit').on('click', function(){
        let id = $(this).data('id');
        $('#table-id').val(id);


    });

    $('#off-day').on('click', function(){
        if ($('#off-day').is(":checked")){
            $('#roster-id').prop('selectedIndex',0);
            $('#roster-id').prop('disabled', 'disabled');
        }else{
            $('#roster-id').prop('disabled', false);
        }
    });
</script>
@endpush
