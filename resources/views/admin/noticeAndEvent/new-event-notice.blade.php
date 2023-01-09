@extends('layouts.container')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="step-first">
                    <div class="kt-grid__item">
                    <!--end: Form Wizard Form-->
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        New Event Notice
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <form class="kt-form center-division-form" action="{{ route('admin.save.notice.event') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="kt-portlet__body">
                                        <div class="kt-checkbox-list">
                                            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand" for="is_event">
                                                <input type="checkbox" name="is_event" id="is_event" checked value="1"> Is Event
                                                <span></span>
                                            </label>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6"  id="event_date">
                                                <label for="exampleSelect1">Event Date</label>
                                                <div class="input-group date">
                                                    <input type="text" readonly="readonly" placeholder="Select date"
                                                           id="kt_datepicker_3" name="event_date" value=""
                                                           class="form-control">
                                                    <div class="input-group-append"><span class="input-group-text"><i
                                                                class="la la-calendar-check-o"></i></span></div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="exampleSelect1">Title</label>
                                                <input type="text" name="title" value="" class="form-control" maxlength="100" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleSelect1">Content</label>
                                            <textarea class="form-control" name="content_text" id="exampleTextarea" rows="3" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="targetEmployee">Target Employee</label>
                                            <div class="kt-radio-inline">
                                                <label class="kt-radio">
                                                    <input type="radio" value="1" name="targetEmployee" class="targetEmployee"> All
                                                    <span></span>
                                                </label>
                                                <label class="kt-radio">
                                                    <input type="radio" value="2" checked="checked" name="targetEmployee" class="targetEmployee"> Custom
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>


                                            {{-- start department process and process segment--}}
                                        <div class="target_employee_area">
                                            <div id="kt_repeater_1">
                                                <div class="form-group form-group-last row" id="kt_repeater_1">
                                                    <div data-repeater-list="dps" class="col-lg-12">
                                                        <div data-repeater-item class="form-group row align-items-center">


{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-sm-2">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label>Division</label>--}}
{{--                                                                        <div>--}}
{{--                                                                            <select class="form-control kt-select2 division" id="kt_select2_222" name="division">--}}
{{--                                                                                <option value="">Select Option</option>--}}
{{--                                                                                @foreach($divisions as $division)--}}
{{--                                                                                    <option value="{{ $division->id }}" {{ isset($filters['division']) && $filters['division'] == $division->id ? 'selected': '' }}>{{ $division->name }}</option>--}}
{{--                                                                                @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-sm-2">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label>Center</label>--}}
{{--                                                                        <div>--}}
{{--                                                                            <select class="form-control kt-select2 center" id="kt_select2_222" name="center">--}}
{{--                                                                                <option value="">Select Center</option>--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-2">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label>Department</label>--}}
{{--                                                                        <div>--}}
{{--                                                                            <select class="form-control kt-select2 department" id="kt_select2_22" name="department">--}}
{{--                                                                                <option value="">Select Option</option>--}}
{{--                                                                                --}}{{--                                                        @foreach($departments as $department)--}}
{{--                                                                                --}}{{--                                                            <option value="{{ $department->id }}" {{ isset($filters['department']) && $filters['department'] == $department->id ? 'selected': '' }}>{{ $department->name }}</option>--}}
{{--                                                                                --}}{{--                                                        @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-2">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label>Process</label>--}}
{{--                                                                        <div>--}}
{{--                                                                            <select class="form-control kt-select2 process" id="kt_select2_31" name="process">--}}
{{--                                                                                <option value="">Select Option</option>--}}
{{--                                                                                --}}{{--                                                        @foreach($processes as $process)--}}
{{--                                                                                --}}{{--                                                            <option value="{{ $process->id }}" {{ isset($filters['process']) && $filters['process'] == $process->id ? 'selected': '' }}>{{ $process->name }}</option>--}}
{{--                                                                                --}}{{--                                                        @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-2">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label>Process segment</label>--}}
{{--                                                                        <div>--}}
{{--                                                                            <select class="form-control kt-select2 process-segment" id="kt_select2_62" name="process_segment">--}}
{{--                                                                                <option value="">Select Option</option>--}}
{{--                                                                                --}}{{--                                                        @foreach($processSegments as $processSegment)--}}
{{--                                                                                --}}{{--                                                            <option value="{{ $processSegment->id }}" {{ isset($filters['process_segment']) && $filters['process_segment'] == $processSegment->id ? 'selected': '' }}>{{ $processSegment->name }}</option>--}}
{{--                                                                                --}}{{--                                                        @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}

                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    <label for="exampleSelectd">Division </label>
                                                                    <select class="form-control division" id="division" name="division">
                                                                        <option value="">Select</option>
                                                                        @foreach($divisions as $division)
                                                                            <option value="{{ $division->id }}"> {{ $division->name }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    <label for="exampleSelectd">Center </label>
                                                                    <select class="form-control center" id="center" name="center">
                                                                        <option value="">Select</option>
                                                                        {{--@foreach($centers as $center)
                                                                            <option {{ ($center->id === 1)?'selected':'' }} value="{{ $center->id }}"> {{ $center->center }} </option>
                                                                        @endforeach--}}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    <div class="kt-form__label">
                                                                        <label>Department </label>
                                                                    </div>
                                                                    <div class="kt-form__control">
                                                                        <select class="form-control department"
                                                                                name="department" id="department">
                                                                            <option value="">Select</option>
                                                                            {{--@foreach($departments as $department)
                                                                                <option
                                                                                    value="{{ $department->id }}"> {{ $department->name }} </option>
                                                                            @endforeach--}}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>


                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    <div class="kt-form__label">
                                                                        <label>Process </label>
                                                                    </div>
                                                                    <div class="kt-form__control">
                                                                        <select class="form-control process" name="process" id="process">
                                                                            <option value="">Select</option>
                                                                            {{--@foreach($processes as $process)
                                                                                <option
                                                                                    value="{{ $process->id }}"> {{ $process->name }} </option>
                                                                            @endforeach--}}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>


                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    <div class="kt-form__label">
                                                                        <label>Process Segment:</label>
                                                                    </div>
                                                                    <div class="kt-form__control">
                                                                        <select class="form-control processSegment"
                                                                                name="processSegment" id="processSegment">
                                                                            <option value="">Select</option>
                                                                            {{--@foreach($processSegments as $processSegment)
                                                                                <option
                                                                                    value="{{ $processSegment->id }}"> {{ $processSegment->name }} </option>
                                                                            @endforeach--}}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>


                                                            <div class="col-md-2">
                                                                <a href="javascript:;" style="margin-top: 25px;"
                                                                   data-repeater-delete=""
                                                                   class="btn-sm btn btn-label-danger btn-bold">
                                                                    <i class="la la-trash-o"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-last row">
                                                    <div class="col-lg-4">
                                                        <a href="javascript:;" data-repeater-create=""
                                                           class="btn btn-bold btn-sm btn-label-brand">
                                                            <i class="la la-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </div>

                                            {{-- end department process and process segment--}}



                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleSelectd">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="">Select</option>
                                                    <option value="0">Unpublished</option>
                                                    <option value="1">Publish</option>
                                                    <option selected="selected" value="2">Draft</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="exampleSelectd">Banner upload</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" name="banner"
                                                           class="custom-file-input"> <label for="customFile"
                                                                                             id="customFileLabel"
                                                                                             class="custom-file-label selected"
                                                                                             style="text-align: left;"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="kt-checkbox-inline">
                                                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name="is_pinned"> Is Pinned
                                                            <span></span>
                                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name="is_mail"> Send Instant Mail
                                                            <span></span>
                                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name="is_remainder"> Send Remainder
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        </div>

                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                                                <button type="reset" class="btn btn-outline-primary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    <!--end: Form Wizard Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- end:: Content -->
@endsection


@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/dompurify/dist/purify.js') }}" type="text/javascript"></script>

@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>

    <script>
        // is event
        $(function () {
            $("#event_date").show();
            $("#is_event").click(function () {
                $(this).is(":checked")? $("#event_date").show():$("#event_date").hide();
            });

            $(".targetEmployee").click(function () {
                var val = $("input[name=targetEmployee]:checked").val();
                (val === '2') ? $(".target_employee_area").show():$(".target_employee_area").hide();
            });
        });

        // Select
        // multi select
        $('.kt_select2_3').select2({
            placeholder: "Select a value",
        });


        //Load view load by doc type
        {{--$(document).on('change', '.process', function()--}}
        {{--{--}}
        {{--    var id = $(this).val();--}}
        {{--    var name = $(this).attr('name');--}}
        {{--    var num = name.match(/[\d\.]+/g);--}}

        {{--    $.ajax({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        },--}}
        {{--        url: "{{ route('admin.notices.load.process.segment') }}",--}}
        {{--        type: 'POST',--}}
        {{--        data: {"id": id},--}}
        {{--        success: function(data) {--}}
        {{--            $('select[name=\'dps['+num+'][processSegment]\']').html("<option value='0'>Select process Segment</option>");--}}
        {{--            if(data){--}}
        {{--                $.each(data, function( index, value ) {--}}
        {{--                    $('select[name=\'dps['+num+'][processSegment]\']').append("<option value='"+ index +"' >"+ value +"</option>");--}}
        {{--                });--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}




            // load custom divition center

            $(document).on('change',".division", function () {
                let divisionID = $(this).val();
                let divisionName = $(this).attr('name');
                let divisionNum = divisionName.match(/[\d\.]+/g);
                let url = '{{ route("get.center",':divisionID') }}';
                url = url.replace(':divisionID', divisionID);
                axios.get(url)
                    .then(function (response) {
                        $('select[name=\'dps['+divisionNum+'][center]\']').html("<option value='0'>Select center</option>");
                        $.each(response.data, function(id, value){
                            console.log(value.center);
                            $('select[name=\'dps['+divisionNum+'][center]\']').append("<option value='"+ value.id +"' >"+ value.center +"</option>");
                        });

                    })
                    .catch(function (error) {
                        $('select[name=\'dps['+divisionNum+'][center]\']').html("<option value='0'>Select center</option>");
                    })
            });

            $(document).on('change', ".center", function () {
                let centerID = $(this).val();
                let centerName = $(this).attr('name');
                let centerNum = centerName.match(/[\d\.]+/g);
                let url = '{{ route("get.department",':centerID' ) }}';
                url = url.replace(':centerID', centerID);
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        $('select[name=\'dps['+centerNum+'][department]\']').html("<option value='0'>Select department</option>");
                        $.each(response.data, function(id, value){
                            $('select[name=\'dps['+centerNum+'][department]\']').append("<option value='"+ value.id +"' >"+ value.name +"</option>");
                        });
                    })
                    .catch(function (error) {
                        // handle error
                        $('select[name=\'dps['+centerNum+'][department]\']').html("<option value='0'>Select department</option>");
                    })
            });

            $(document).on('change', ".department", function () {
                let departmentID = $(this).val();
                let departmentName = $(this).attr('name');
                let departmentNum = departmentName.match(/[\d\.]+/g);
                let url = '{{ route("get.process",':processID' ) }}';
                url = url.replace(':processID', departmentID);
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        $('select[name=\'dps['+departmentNum+'][process]\']').html("<option value='0'>Select process</option>");
                        $.each(response.data, function(id, value){
                            $('select[name=\'dps['+departmentNum+'][process]\']').append("<option value='"+ value.id +"' >"+ value.name +"</option>");
                        });
                    })
                    .catch(function (error) {
                        // handle error
                        $('select[name=\'dps['+departmentNum+'][process]\']').html("<option value='0'>Select process</option>");
                    })
            });

            $(document).on('change', ".process", function () {
                let processID = $(this).val();
                let processName = $(this).attr('name');
                let processNum = processName.match(/[\d\.]+/g);
                let url = '{{ route("get.processSegment",':processSegmentID' ) }}';
                url = url.replace(':processSegmentID', processID);
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        $('select[name=\'dps['+processNum+'][processSegment]\']').html("<option value='0'>Select process segment</option>");
                        $.each(response.data, function(id, value){
                            $('select[name=\'dps['+processNum+'][processSegment]\']').append("<option value='"+ value.id +"' >"+ value.name +"</option>");
                        });
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        $('select[name=\'dps['+processNum+'][processSegment]\']').html("<option value='0'>Select process segment</option>");
                    })
            });


    </script>
@endpush
