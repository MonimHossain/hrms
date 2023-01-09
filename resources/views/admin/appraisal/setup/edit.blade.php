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
                                New Question Set setup
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        <form action="{{ route('appraisal.question.setup.update', ['id' => $id]) }}" method="POST">
                            <input type="hidden" name="_method" value="put">
                            @csrf


                            <div id="kt_repeater_1">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <label for="exampleSelectd">Division</label>
                                                <select class="form-control division" id="division" name="division">
                                                    <option value="">Select</option>
                                                    @foreach($divisions as $division)
                                                        <option {{ ($rows->division_id == $division->id) ? 'selected="selected"' : '' }} value="{{ $division->id }}"> {{ $division->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <label for="exampleSelectd">Center </label>
                                                <select class="form-control center" id="center" name="center">
                                                    <option value="{{ $rows->center_id }}">{{ $rows->center->center ?? '' }}</option>
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
                                                        <option value="{{ $rows->department_id }}">{{ $rows->department->name ?? '' }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Process </label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <select class="form-control process" name="process" id="process">
                                                        <option value="{{ $rows->process_id }}">{{ $rows->process->name ?? '' }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Process Segment:</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <select class="form-control processSegment"
                                                            name="processSegment" id="processSegment">
                                                        <option value="{{ $rows->process_segment_id }}">{{ $rows->processSegment->name ?? '' }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Evaluation :</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <select name="name[]" multiple id="name" class="form-control kt-selectpicker" data-live-search="true">
                                                        <option value="">Select</option>
                                                        @foreach($evaluationNames as $field)
                                                            <option {{ ($field->id == $rows->name) ? 'selected="selected"':'' }} value="{{ $field->id }}">{{ $field->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                            </div>

                            <br>
                            <br>


                            <!--begin::Section-->
                            <div id="ck-editor-content">

                                <div class="kt-section">
                                    <div class="kt-section__content">
                                        <h5>Question List : </h5>

                                        <hr>
                                        <ol>
                                        @foreach($questions as $question)
                                                <li class="mt-list-item">
                                                    <div class="col-md-12">
                                                        <div class="kt-checkbox-inline">
                                                            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                                    <input type="checkbox" {{ in_array($question->id, $checkedQuestionList) ? 'checked' : '' }} name="qst_id[]" value="{{ $question->id }}"> {{ $question->name }}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </li>
                                        @endforeach
                                        </ol>

                                    </div>
                                </div>

                                <!--end::Section-->

                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-primary">Save</button>
                                </div>

                            </div>
                        </form>
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
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

@endpush

@push('js')
    <script>
        $('.textarea').ckeditor();

        $(document).on('change',".division", function () {
            let divisionID = $(this).val();
            let divisionName = $(this).attr('name');
            let divisionNum = divisionName.match(/[\d\.]+/g);
            let url = '{{ route("get.center",':divisionID') }}';
            url = url.replace(':divisionID', divisionID);
            axios.get(url)
                .then(function (response) {
                    $('.center').html("<option value='0'>Select center</option>");
                    $('.department').html("<option value='0'>Select center</option>");
                    $('.process').html("<option value='0'>Select center</option>");
                    $('.processSegment').html("<option value='0'>Select center</option>");

                    $.each(response.data, function(id, value){
                        $('.center').append("<option value='"+ value.id +"' >"+ value.center +"</option>");
                    });

                })
                .catch(function (error) {
                    $('.center').html("<option value='0'>Select center</option>");
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
                    $('.department').html("<option value='0'>Select center</option>");
                    $('.process').html("<option value='0'>Select center</option>");
                    $('.processSegment').html("<option value='0'>Select center</option>");

                    $.each(response.data, function(id, value){
                        $('.department').append("<option value='"+ value.id +"' >"+ value.name +"</option>");
                    });
                })
                .catch(function (error) {
                    // handle error
                    $('.department').html("<option value='0'>Select department</option>");
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
                    $('.process').html("<option value='0'>Select center</option>");
                    $('.processSegment').html("<option value='0'>Select center</option>");

                    $.each(response.data, function(id, value){
                        $('.process').append("<option value='"+ value.id +"' >"+ value.name +"</option>");
                    });
                })
                .catch(function (error) {
                    // handle error
                    $('.process').html("<option value='0'>Select process</option>");
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
                    $('.processSegment').html("<option value='0'>Select process segment</option>");

                    $.each(response.data, function(id, value){
                        $('.processSegment').append("<option value='"+ value.id +"' >"+ value.name +"</option>");
                    });
                })
                .catch(function (error) {
                    // handle error
                    $('.processSegment').html("<option value='0'>Select process segment</option>");
                })
        });

    </script>
@endpush
