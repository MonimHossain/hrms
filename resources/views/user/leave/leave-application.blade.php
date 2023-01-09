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
                                Leave Application
                            </h3>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <div class="container">
                        <div class="row">
                            <div class="offset-sm-1 col-sm-9">
                                @if(!auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [\App\Utils\TeamMemberType::MEMBER])->exists())
                                <div class="alert alert-outline-danger fade show mt-4" role="alert">
                                    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                    <div class="alert-text">You can not apply for leave because you do not belong to any team. Please contact to HR.</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="la la-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                                @endif

                                <form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
                                      action="{{ route('user.leave.apply') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">

                                    <div class="kt-portlet__body">
                                        <div class="form-group form-group-last kt-hide">
                                            <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    Oh snap! Change a few things up and try submitting again.
                                                </div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-12" id="clWarning" style="display:none">
                                            <p>
                                                Note: CL is not allowed for more than 1 consecutive day.
                                            </p>
                                        </div> --}}
                                        <div class="form-group form-group-last" id="clWarning"  style="display:none">
                                            <div class="alert alert-info" role="alert" id="kt_form_1_msg">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    Note: CL is not allowed for more than 1 consecutive day.
                                                </div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-sm-6">
                                                <label>Start Date:</label>
                                                <input type="text" value="{{ old('start_date') }}" name="start_date"
                                                       class="form-control kt_datepicker_3 start-date " readonly
                                                       placeholder="">
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="">End Date:</label>
                                                <input type="text" name="end_date" readonly value="{{ old('end_date') }}"
                                                       class="form-control kt_datepicker_3 end-date" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{-- <div class="col-lg-6">
                                                <label class="">Subject</label>
                                                <input type="text" name="subject" class="form-control"
                                                       id="subject" placeholder="Enter Subject">
                                            </div> --}}
                                            <div class="col-sm-3">
                                                <label>Leave Type</label>
                                                <input type="hidden" id="has_earnLeave" value="{{ $has_earnLeave }}">
                                                <input type="hidden" id="leaveTypes" value="{{ json_encode($leaveTypes) }}">
                                                <select class="form-control" name="leave_type_id" id="leave_type">
                                                    <option value="">Select</option>
                                                    @foreach ($leaveTypes as $leaveType)
                                                        @if($leaveType->leave_type_id ==  \App\Utils\LeaveStatus::EARNED)
                                                            @continue
                                                        @endif
                                                        <option {{ old('leave_type_id') == $leaveType->leave_type_id ? 'selected':'' }} class="leaveType_{{ $leaveType->leave_type_id }}" value="{{ $leaveType->leave_type_id }}">{{ _lang('leave.leaveType',$leaveType->leave_type_id) }}</option>
                                                    @endforeach

                                                    @if($has_earnLeave)
                                                    <option {{ old('leave_type_id') == \App\Utils\LeaveStatus::EARNED ? 'selected':'' }}  class="leaveType_{{ \App\Utils\LeaveStatus::EARNED }}" value="{{ \App\Utils\LeaveStatus::EARNED }}">{{ _lang('leave.leaveType', \App\Utils\LeaveStatus::EARNED) }}</option>
                                                    @endif

                                                    <option {{ old('leave_type_id') == \App\Utils\LeaveStatus::LWP ? 'selected':'' }} class="leaveType_{{ \App\Utils\LeaveStatus::LWP }}" value="{{ \App\Utils\LeaveStatus::LWP }}">{{ _lang('leave.leaveType', \App\Utils\LeaveStatus::LWP) }}</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-3">
                                                <label>If Half Day*</label>
                                                <select class="form-control" name="half_day" id="half_day" disabled>
                                                    <option value="">Select</option>
                                                    <option {{ old('half_day') == \App\Utils\LeaveStatus::FIRST_HALF_DAY ? 'selected':'' }} value="{{ \App\Utils\LeaveStatus::FIRST_HALF_DAY }}">First Half</option>
                                                    <option {{ old('half_day') == \App\Utils\LeaveStatus::SECOND_HALF_DAY ? 'selected':'' }} value="{{ \App\Utils\LeaveStatus::SECOND_HALF_DAY }}">Second Half</option>

                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="">Leave Reason</label>
                                                <select class="form-control" name="leave_reason_id" required>
                                                    <option value="">Select</option>
                                                    @foreach ($leaveReasons as $leaveReason)
                                                        <option {{ old('leave_reason_id') == $leaveReason->id ? 'selected':'' }} value="{{ $leaveReason->id }}">{{ $leaveReason->leave_reason }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label class="">Remarks:</label>
                                                <textarea name="description" id="description" cols="30"
                                                          rows="3" class="form-control" placeholder="Write your leave remarks">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label class="">Address During leave:</label>
                                                <div class="kt-input-icon kt-input-icon--right">
                                                    <textarea name="leave_location" id="address" class="form-control" rows="1"
                                                              placeholder="">{{ old('leave_location') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <label class="">Leave Documents</label>
                                                {{--                                                <div class="kt-dropzone dropzone m-dropzone--success" action="{{ route('user.leave.document.upload') }}" id="dropzone">--}}
                                                {{--                                                    <div class="kt-dropzone__msg dz-message needsclick">--}}
                                                {{--                                                        <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>--}}
                                                {{--                                                        <span class="kt-dropzone__msg-desc">Only image, pdf and psd files are allowed for upload</span>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                <div class="file-upload">
                                                    <div class="file-select">
                                                        <div class="file-select-button" id="fileName">Choose File</div>
                                                        <div class="file-select-name" id="noFile">No file chosen...</div>
                                                        <input type="file" name="file" id="chooseFile">
                                                        <div id="output"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- <div class="col-lg-4">
                                                <label class="">Resume Date:</label>
                                                <div class="kt-input-icon kt-input-icon--right">
                                                    <input name="resume_date" type="text" readonly
                                                           class="form-control kt_datepicker_3" placeholder="">
                                                </div>
                                            </div> --}}
                                        </div>
                                        Note: You can apply for AL after 1 year from your permanent DOJ.
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                Note: CL is not allowed for more than 1 consecutive day. Please apply for AL instead.
                                            </p>
                                        </div>
                                    </div> --}}

                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <button type="submit"
                                                            class="btn btn-primary">Submit
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Form-->

            </div>
            <!--end::Portlet-->
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/dropzone/dist/dropzone.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/pekeupload@2.1.1/js/pekeUpload.min.js') }}" type="text/javascript"></script>
    {{--    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script>--}}

    <script>
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
    </script>

    <script>
        $(document).ready(function () {
            // Display a warning toast, with no title
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": false,
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "fadeOut"
            };

            let leave_type = null, start_date = 0, end_date = 0, diff = 0, isPast = 0;
            let casual_leave = (_ => _)({{ \App\Utils\LeaveStatus::CASUAL }});
            let earned_leave = (_ => _)({{ \App\Utils\LeaveStatus::EARNED }});
            let sick_leave = (_ => _)({{ \App\Utils\LeaveStatus::SICK }});
            let maternity_leave = (_ => _)({{ \App\Utils\LeaveStatus::MATERNITY }});
            let paternity_leave = (_ => _)({{ \App\Utils\LeaveStatus::PATERNITY }});
            let lwp = (_ => _)({{ \App\Utils\LeaveStatus::LWP }});
            let leaveTypes = $('#leaveTypes').val();
            let has_earnLeave = $('#has_earnLeave').val();
            let maternity_leave_quantity = ((_ => _)({{ $maternity_leave }})) ? (_ => _)({{ $maternity_leave }}) / 2 - 1 : null;
            let paternity_leave_quantity = ((_ => _)({{ $paternity_leave }})) ? (_ => _)({{ $paternity_leave }}) / 2 - 1 : null;

            // alert(maternity_leave_quantity);
            $('#leave_type').on('change', function () {
                leave_type = $(this).val(); // get leave type value
                // console.log(leave_type);

                if (start_date != 0 && end_date != 0) {
                    exceptionHandle(leave_type, start_date, end_date)
                }
                if (leave_type && start_date != 0) {
                    dateDiffCheck(leave_type, start_date, end_date);
                    maternityPaternityLeave(leave_type, diff);
                    // paternityLeave(leave_type, diff);
                }
            });

            $('.start-date').datepicker().on('changeDate', function (e) {
                start_date = new Date($(this).val());
                canApply(start_date);
                if (end_date != 0) {
                    exceptionHandle(leave_type, start_date, end_date)
                }
                if (leave_type && start_date != 0) {
                    dateDiffCheck(leave_type, start_date, end_date);
                    maternityPaternityLeave(leave_type, diff);
                    // paternityLeave(leave_type, diff);
                }
            });

            $('.end-date').datepicker().on('changeDate', function (e) {
                end_date = new Date($(this).val());
                if (start_date != 0) {
                    exceptionHandle(leave_type, start_date, end_date);
                    maternityPaternityLeave(leave_type, diff);
                    // paternityLeave(leave_type, diff);
                }
            });

            //handle all exceptions
            function exceptionHandle(leave_type, start_date, end_date) {
                canApply(start_date); // can apply
                dateDiffCheck(leave_type, start_date, end_date);// calculate leave count
                manageLeaveTypes(diff, isPast);
                halfDayEnable(leave_type, diff); // half day validation
                casualLeaveWarning(leave_type, diff); // casual leave warning
                maternityPaternityLeave(leave_type, diff);
            }

            function manageLeaveTypes(diff, isPast){

                let leaveCount = (end_date - start_date) / (1000 * 60 * 60 * 24) + 1;
                let today = new Date();
                let futureDiff = (start_date - today) / (1000 * 60 * 60 * 24) + 1;
                let currentdate = today.getFullYear() + '-' + today.getMonth() +'-'+ today.getDate();
                let selected_start = start_date.getFullYear() + '-' + start_date.getMonth() +'-'+ start_date.getDate();
                // console.log(currentdate, selected_start, leaveCount);


                // if date is today or past and only leave count is 1 then CL available
                // CL disabled for advance leave
                if(currentdate == selected_start || isPast > 1){
                    if (leaveCount > 2) {
                        $('.leaveType_'+casual_leave).prop('disabled', true);
                        // $('#clWarning').show();
                    } else {
                        $('.leaveType_'+casual_leave).prop('disabled', false);
                        // $('#clWarning').hide();
                    }
                } else {
                    // alert('leave count is > 1 and CL');
                    $('.leaveType_'+casual_leave).prop('disabled', true);
                    // $('#clWarning').true();
                }

                // if SL and leaveCount > 1 day then choose file is must
                // if(leaveCount > 2 && $('#leave_type').val() == casual_leave){
                //     toastr.warning("CL is not allowed more than 2 consecutive days. Please apply for AL", "Note!");
                // }

                if(leaveCount > 1 && $('#leave_type').val() == sick_leave){
                    toastr.warning(" Please submit your medical document to avail the SL more than 1 days.", "Note!");
                    $('#chooseFile').prop('required', true);
                } else {
                    $('#chooseFile').prop('required', false);
                }

                // if lwp and leaveCount > 7 day then show alert
                if(leaveCount > 7 && $('#leave_type').val() == lwp){
                    toastr.warning("Please contact your dept. head to avail LWP", "Note!!");
                }
            }

            //casual day warning
            function casualLeaveWarning(leave_type, diff) {
                if (diff > 2 && leave_type == casual_leave) {
                    $("#leave_type").val("").change();
                    toastr.warning("CL is not allowed more than 2 consecutive days. Please apply for AL", "Note!");
                    // toastr.warning("You should not apply casual leave more than two days. It might not be accepted without appropriate/exception reason.", "Hey!!");
                }
            }

            // can apply
            function canApply(start_date) {
                let today = new Date();
                // let diff = new Date(today - start_date);
                let diff = (today - start_date) / (1000 * 60 * 60 * 24) + 1;
                // console.log(Math.round(diff))
                if (Math.round(diff) > 15 ) {
                    toastr.error("You can not apply for past dated leave more than 15 days.", "Opps!!");
                }else{
                    // Remove current toasts using animation
                    toastr.clear()
                }
                isPast = Math.round(diff);
                return isPast;
            }

            // calculate leave count
            function dateDiffCheck(leave_type, start_date, end_date) {
                diff = (end_date - start_date) / (1000 * 60 * 60 * 24) + 1; // calculate leave count
                return diff;
            }

            // half day input field enable/disable
            function halfDayEnable(leave_type, diff) {
                if (diff == 1 && (leave_type == casual_leave || leave_type == sick_leave || leave_type == lwp)) {
                    $('#half_day').prop('disabled', false);
                } else {
                    $('#half_day').prop('disabled', true);
                }
            }



            //maternity leave
            function maternityPaternityLeave(leave_type, diff) {
                if (leave_type == maternity_leave && maternity_leave_quantity > 0) {
                    $('.end-date').prop('readonly', true).datepicker('destroy');
                    var date = new Date(start_date);
                    var newdate = new Date(date);
                    var end_date = newdate.setDate(newdate.getDate() + maternity_leave_quantity);
                    $('.end-date').val(getFormattedDate(end_date));
                } else if (leave_type == paternity_leave && paternity_leave_quantity > 0) {
                    $('.end-date').prop('readonly', true).datepicker('destroy');
                    var date = new Date(start_date);
                    var newdate = new Date(date);
                    var end_date = newdate.setDate(newdate.getDate() + paternity_leave_quantity);
                    $('.end-date').val(getFormattedDate(end_date));
                } else {
                    $('.end-date')
                        .prop('readonly', true)
                        .datepicker({
                            rtl: KTUtil.isRTL(),
                            todayBtn: "linked",
                            clearBtn: true,
                            todayHighlight: true,
                            orientation: "bottom left",
                            templates: arrows,
                            format: 'yyyy-mm-dd',
                        });
                }
            }

            //format date
            function getFormattedDate(date) {
                let newDate = new Date(date);
                let year = newDate.getFullYear();
                let month = (1 + newDate.getMonth()).toString().padStart(2, '0');
                let day = newDate.getDate().toString().padStart(2, '0');
                return year + '-' + month + '-' + day;
            }

            // leave form validation
            $("#leaveApplication").validate({
                // define validation rules
                rules: {
                    leave_type_id: {
                        required: true,
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    subject: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    leave_location: {
                        required: true
                    },
                    resume_date: {
                        required: true
                    },

                },

                // display error alert on form submit
                invalidHandler: function (event, validator) {
                    let alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTop();
                },

                submitHandler: function (form) {
                    form.submit(); // submit the form
                }
            });
        });
    </script>

    <script>
        $('#chooseFile').bind('change', function () {
            var filename = $("#chooseFile").val();
            if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file chosen...");
            } else {
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
            console.log($(this).files);

            // loadMime(fileInput.files[0], function(mime) {
            //     //print the output to the screen
            //     output.innerHTML = mime;
            // });
        });

        function loadMime(file, callback) {

            //List of known mimes
            var mimes = [
                {
                    mime: 'image/jpeg',
                    pattern: [0xFF, 0xD8, 0xFF],
                    mask: [0xFF, 0xFF, 0xFF],
                },
                {
                    mime: 'image/png',
                    pattern: [0x89, 0x50, 0x4E, 0x47],
                    mask: [0xFF, 0xFF, 0xFF, 0xFF],
                }
                // you can expand this list @see https://mimesniff.spec.whatwg.org/#matching-an-image-type-pattern
            ];

            function check(bytes, mime) {
                for (var i = 0, l = mime.mask.length; i < l; ++i) {
                    if ((bytes[i] & mime.mask[i]) - mime.pattern[i] !== 0) {
                        return false;
                    }
                }
                return true;
            }

            var blob = file.slice(0, 4); //read the first 4 bytes of the file

            var reader = new FileReader();
            reader.onloadend = function(e) {
                if (e.target.readyState === FileReader.DONE) {
                    var bytes = new Uint8Array(e.target.result);

                    for (var i=0, l = mimes.length; i<l; ++i) {
                        if (check(bytes, mimes[i])) return callback("Mime: " + mimes[i].mime + " <br> Browser:" + file.type);
                    }

                    return callback("Mime: unknown <br> Browser:" + file.type);
                }
            };
            reader.readAsArrayBuffer(blob);
        }


        //when selecting a file on the input
        fileInput.onchange = function() {
            // loadMime(fileInput.files[0], function(mime) {

            //     //print the output to the screen
            //     output.innerHTML = mime;
            // });
        };
    </script>



@endpush
