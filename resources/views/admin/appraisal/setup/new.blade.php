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
                        <form action="{{ route('appraisal.question.setup.save') }}" method="POST">
                            @csrf


                            <div id="kt_repeater_1">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__control">
                                                    <label for="exampleSelectd">Select Question List</label>
                                                    <select class="form-control" name="type_id" id="qst_type_id" autocomplete="off">
                                                        <option value="">Select</option>
                                                        <option value="employee">Employee</option>
                                                        <option value="lead">Lead</option>
                                                        <option value="company">Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <label for="exampleSelectd">Division</label>
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
                                                        <option value="">Select</option>
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
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Evaluation :</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <select name="name[]" multiple id="" class="form-control kt-selectpicker" data-live-search="true">
                                                        <option value="">Select</option>
                                                        @foreach($evaluationNames as $row)
                                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
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
                                        <h4>Question List</h4>
                                        <hr>
                                        <ol id="qstlist">
                                       {{-- @foreach($questions as $question)
                                            <li class="mt-list-item">
                                                <div class="col-md-12">
                                                    <div class="kt-checkbox-inline">
                                                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                                <input type="checkbox" mark="{{ $question->marks }}" name="qst_id[]" value="{{ $question->id }}"> {{ $question->name }}
                                                            <span></span>
                                                        </label>
                                                        <span class="text-small" style="background: lightblue; height: 60px; width: 60px; padding:3px; border-radius:2px">{{ $question->marks }}</span>
                                                        <a href="#" title="Answer List View" form-size="modal-sm" data-toggle="modal"  data-target="#kt_modal" action="{{ route('appraisal.answer.list.view', ['id'=> $question->id]) }}" class="text-primary custom-btn globalModal"><i class="flaticon2-settings"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach--}}
                                        </ol>
                                        <hr>
                                        <span>Total : <b id="totalMark"></b> Marks</span>
                                        <br>
                                        <br>
                                        <br>
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
        $(document).on('change', 'input:checkbox',function ()
        {
            var total = 0;
            $('input:checkbox:checked').each(function(){ // iterate through each checked element.
                total += isNaN(parseInt($(this).attr('mark'))) ? 0 : parseInt($(this).attr('mark'));
            });
            $("#totalMark").text(total);

        });


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
                    $('.department').html("<option value='0'>Select department</option>");
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
                    $('.process').html("<option value='0'>Select process</option>");
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
                    console.log(error);
                    $('.processSegment').html("<option value='0'>Select process segment</option>");
                })
        });


        $(document).on('change', '#qst_type_id', function () {
            $('#qstlist').html('');
            var id = $(this).val();
            $.ajax({
                url: "{{ route('appraisal.question.filter.list') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}","id": id},
                success: function(data) {
                    $.map(data, function( val, i ) {
                        $('#qstlist').append('<li class="mt-list-item">\n' +
                            '                                                <div class="col-md-12">\n' +
                            '                                                    <div class="kt-checkbox-inline">\n' +
                            '                                                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">\n' +
                            '                                                                <input type="checkbox" mark="'+val.marks+'" name="qst_id[]" value="'+val.id+'"> '+val.name+'\n' +
                            '                                                            <span></span>\n' +
                            '                                                        </label>\n' +
                            '                                                        <span class="text-small" style="background: lightblue; height: 60px; width: 60px; padding:3px; border-radius:2px">'+val.marks+'</span>\n' +
                            '                                                        <a href="#" title="Answer List View" form-size="modal-sm" data-toggle="modal"  data-target="#kt_modal" action="<?php echo route('appraisal.answer.list.view', ['']) ?>/'+val.id+'" class="text-primary custom-btn globalModal"><i class="flaticon2-settings"></i></a>\n' +
                            '                                                    </div>\n' +
                            '                                                </div>\n' +
                            '                                            </li>');
                    });
                }
            });
        });

    </script>
@endpush
