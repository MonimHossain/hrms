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
                            Create Request
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
                <form action="{{ route('admin.hiring.request.store') }}" method="post" id="documentTemplate">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Job Title *</label>
                            <input type="text" name="job_title" class="form-control" id="jobTitle">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Propose to *</label>
                            <select data-live-search="true" name="propose_to" class="form-control kt-selectpicker" id="" data-select2-id="employeeList">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Number of vencency *</label>
                            <input minlength="2" type="number" name="number_of_vacancy" class="form-control" id="numberOfVacency">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Min Salary</label>
                            <input type="number" name="min_salary" class="form-control" id="minSalary">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Max Salary</label>
                            <input type="number" name="max_salary" class="form-control" id="maxSalary">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Expected Date</label>
                                <div class="input-group date"><input type="text" readonly="readonly"
                                                                     placeholder="Select date" id="kt_datepicker_3"
                                                                     name="expected_date" value="" class="form-control">
                                    <div class="input-group-append"><span class="input-group-text"><i
                                                class="la la-calendar-check-o"></i></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <label>Job Requirement*</label>
                            <textarea name="requirement" id="" class="textarea" cols="30" rows="100"></textarea>
                        </div>
                    </div>
                    <!--end::Section-->

                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <label>Job Description</label>
                            <textarea name="description" id="" class="textarea" cols="30" rows="100"></textarea>
                        </div>
                    </div>
                    <!--end::Section-->

                   <div class="form-group">
                       <button type="submit" class="btn btn-outline-primary" id="generate-btn" data-toggle="modal" data-target=".bd-example-modal-lg">Save</button>
                   </div>
                </form>

                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>


{{--Start Modal here--}}


{{--    End modal here--}}


@endsection
@include('layouts.lookup-setup-delete')

@push('css')
    <style>
        div {
            text-align: justify;
            text-justify: inter-word;
        }

        .textarea_hidden {
            visibility: hidden;
            display: none;
        }
        td{
            padding: 5px;
        }
    </style>

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

    <script>

        //Load view load by doc type
        CKEDITOR.replace( 'requirement' );
        CKEDITOR.replace( 'description' );


        // $(document).on('click', '#generate-btn', function (ev)
        // {
        //     ev.preventDefault();
        //     var name = $('#documentName').val();
        //     var documentType = $('#documentType').val();
        //     var content = CKEDITOR.instances.content_text.getData();
        //     if( content === "" || name === "" || documentType === ""){
        //         Swal.fire({
        //             title: 'Fill up all required fields',
        //             type: 'warning',
        //             showConfirmButton: false,
        //             showCancelButton: true,
        //         });
        //     }else{
        //         $('#documentTemplate').submit();
        //     }
        // });


    </script>
@endpush
