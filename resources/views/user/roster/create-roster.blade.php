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
                    Create Roster
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form class="kt-form" action="{{ route('user.roster.create.submit') }}" method="POST">
                @csrf
                <div class="kt-portlet__body">
                    <div class="form-group form-group-last">
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                            <div class="alert-text">
                                Create your roster.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="start_date"/>
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
                                <label>End Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="end_date"/>
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
                                <label>Roster</label>
                                <select name="roster_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($rosters as $item)
                                    <option value="{{ $item->id }}">{{ $item->roster_start }} - {{ $item->roster_end }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Off Days</label>
                                <div class="kt-checkbox-inline">
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="0"> SUNDAY
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="1"> MONDAY
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="2"> TUESDAY
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="3"> WEDNESDAY
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="4"> THURSDAY
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="5"> FRIDAY
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="checkbox" name="off_days[]" value="6"> SATURDAY
                                        <span></span>
                                    </label>
                                </div>
                                <span class="form-text text-muted">Please checked your weekend day(s)</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
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
@endpush
