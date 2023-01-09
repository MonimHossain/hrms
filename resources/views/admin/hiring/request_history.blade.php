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
                            Request History
                        </h3>
                    </div>
                    <div class="kt-portlet__head-label">
                        <a href="{{ route('admin.hiring.request.new') }}" class="btn btn-primary">Create New</a>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">

                        {{-- <form action="{{ route('admin.document.request.history') }}" method="GET">
                            <div class="row">
                                @csrf
                                <div class="form-group col-md-2"><label>Start Date</label>
                                    <div class="input-group date"><input type="text" readonly="readonly"
                                                                         placeholder="Select date" id="kt_datepicker_3"
                                                                         name="start_date" value="{{ Request::get('start_date') }}" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text"><i
                                                    class="la la-calendar-check-o"></i></span></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2"><label>End Date</label>
                                    <div class="input-group date"><input type="text" readonly="readonly"
                                                                         placeholder="Select date" id="kt_datepicker_3"
                                                                         name="end_date" value="{{ Request::get('end_date') }}" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text"><i
                                                    class="la la-calendar-check-o"></i></span></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Select Status</label>
                                    <select name="status" class="form-control" id="docType">
                                        <option value="">Select Type</option>
                                        <option {{ ('0' == Request::get('status')) ? 'selected':'' }} value="0">New</option>
                                        <option {{ ('1' == Request::get('status')) ? 'selected':'' }} value="1">Processing</option>
                                        <option {{ ('2' == Request::get('status')) ? 'selected':'' }} value="2">Rejected</option>
                                        <option {{ ('3' == Request::get('status')) ? 'selected':'' }} value="3">Done</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Select Document Type</label>
                                    <select name="doc_type" class="form-control" id="docType">
                                        <option value="">Select Type</option>
                                        @foreach($docTypes as $docType)
                                        <option {{ ($docType->id == Request::get('doc_type')) ? 'selected':'' }} value="{{ $docType->id }}">{{ $docType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Employee</label>
                                    <select name="employee_id" class="form-control kt-selectpicker" id="employeeList" data-live-search="true">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option {{ ($employee->employer_id == Request::get('employee_id')) ? 'selected':'' }} value="{{ $employee->employer_id }}">{{ $employee->employer_id. ' '. $employee->FullName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="submit" id="search-btn" value="Search" class="btn btn-outline-primary">
                                </div>
                            </div>
                        </form> --}}


                    <div class="table-responsive">
                        @if(!empty($requestList) && isset($requestList) && $requestList->count() > 0)
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                            <tr>
                                <th>SL #</th>
                                <th>Job Title</th>
                                <th>Number Of Vacancy</th>
                                <th>Date</th>
                                <th>Approved By</th>
                                <th>Proposed By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($requestList as $history)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                       {{ $history['job_title'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $history['number_of_vacancy'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $history['expected_date'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $history['approved_id'] ?? '' }}-{{ $history['approved_by'] ?? '' }}
                                    </td>
                                    <td>
                                       {{ $history['created_id'] ?? '' }}-{{ $history['created_by'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ _lang('document-and-letter.status', $history['status']) }}
                                    </td>
                                    <td class="text-bold text-center">
                                        <a title="View Details" data-toggle="modal" data-target="#kt_modal" action="{{ route('admin.hiring.request.view',['id'=>$history['id'], '']) }}" class="btn btn-outline-primary card-text custom-btn globalModal">
                                            &nbsp;&nbsp;<i class="fas fa-eye"></i>
                                        </a>
                                        @if($history['approved'])
                                        <a title="Approve Or Reject" data-toggle="modal" form-size="modal-md" data-target="#kt_modal" action="{{ route('admin.hiring.request.edit',['id'=>$history['id'], '']) }}" class="btn btn-outline-primary card-text custom-btn globalModal">
                                            &nbsp;<i class="fas fa-check-circle"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @else
                        <p>No Data Found!</p>
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>


{{--Start Modal here--}}

<div class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Letter and Document View</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table width="760" border="0" align="center" cellpadding="39" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#FFFFFF" style="border:1px solid #d9d9d9">
                            <table width="700" bgcolor="#ffffff" cellspacing="0" border="0" cellpadding="0" style="width:620px;margin:0 auto">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="textContent"></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">&nbsp;</div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Approval Or Reject</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('change.status.document.request.history') }}" method="post">
                    @csrf
                    <input type="hidden" name="doc_id" class="doc_id">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Select Status</label>
                            <select name="status" class="form-control" id="docType">
                                <option value="">Select Status</option>
                                <option value="1">Processing</option>
                                <option value="2">Reject</option>
                                <option value="3">Done</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label><br>
                            <input type="submit" id="search-btn" value="Save" class="btn btn-outline-primary">
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" title="Close" class="btn btn-outline-primary" data-dismiss="modal">&nbsp;&nbsp;<i class="far fa-times-circle"></i></button>


            </div>
        </div>
    </div>
</div>

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
@endpush


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
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script>
        $(document).on('click', '.view-btn', function ()
        {
            var id = $(this).attr('docTemplateId');

            $.ajax({
                url: "{{ route('get.document.request.history.view') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}","doc_id": id},
                success: function(data) {
                    $('.textContent').html(data);
                }
            });
        });


        $(document).on('click', '.change-btn', function ()
        {
            var id = $(this).attr('docTemplateId');
            $('.doc_id').val(id);

        });
    </script>

    <script>

        function addSelect2Ajax($element, $url, $changeCallback, data) {
            var placeHolder = $($element).data('placeholder');

            if (typeof $changeCallback == 'function') {
                $($element).change($changeCallback)
            }

            // $($element).hasClass('select2') && $($element).select2('destroy');

            return $($element).select2({
                allowClear: true,
                width: "resolve",
                ...data,
                placeholder: placeHolder,
                ajax: {
                    url: $url,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        }
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj, index) {
                                return {id: obj.id, text: obj.name};
                            })
                        };
                    }
                }
            });

        }

        addSelect2Ajax('#employeeList', "{{route('employee.all')}}");
    </script>
@endpush



