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
                            Document History
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.document.history') }}" method="psot">
                        <div class="row">
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
                                                                     name="end_date" value="{{ Request::get('start_date') }}" class="form-control">
                                    <div class="input-group-append"><span class="input-group-text"><i
                                                class="la la-calendar-check-o"></i></span></div>
                                </div>
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
                                <label>Employee ID</label>
                                <select name="employee_id" class="form-control kt-selectpicker" id="employeeList" data-live-search="true">
                                    <option value="">Select Employee</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Ref. Number</label>
                                <select name="ref_id" class="form-control kt-selectpicker" id="ref_number" data-live-search="true">
                                    <option value="">Select Ref. Number</option>
                                    @foreach($documents as $value)
                                        <option value="{{ $value->ref_id }}">{{ $value->ref_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label><br>
                                <input type="submit" id="search-btn" value="Search" class="btn btn-outline-primary">
                            </div>
                        </div>
                    </form>


                    <div class="table-responsive">
                        @if(!empty($docHistory))
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                <th>Ref Id</th>
                                <th>Employee Name</th>
                                <th>Doc Type</th>
                                <th>Created By</th>
                                <th>Created at</th>
                                <th>Doc Status</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($docHistory as $history )
                                    <tr>
                                        <td>
                                            {{ $history->ref_id }}
                                        </td>
                                        <td>
                                            {{ $history->employee->Fullname ?? '' }}
                                        </td>
                                        <td>
                                            {{ $history->document->name }}
                                        </td>
                                        <td>
                                            {{ $history->processedBy->FullName ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $history->created_at }}
                                        </td>
                                        <td>
                                            {{ ($history->status == 1) ?'Active':'Inactive' }}
                                        </td>
                                        <td class="text-bold text-center">
                                            <a onclick="confirmationPdf(event)"  href="{{ route('letter.and.documents.pdf',['id'=>$history->id, '']) }}" type="button" id="saveAndPdf" title="Download PDF" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="fas fa-file-pdf"></i></a>
                                            <a onclick="confirmationMail(event)" href="{{ route('admin.document.email',['id'=>$history->id]) }}" type="button" id="sendEmail" title="Send Email" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="fas fa-envelope-open-text"></i></a>
                                            <button docTemplateId="{{ $history->id }}" type="button" id="saveAndPdf" title="Change Status" class="btn btn-outline-primary active-btn">&nbsp;&nbsp;<i aria-hidden="true" class="fa fa-exclamation-circle"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                            {{ $docHistory->appends(Request::all())->links() }}
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>




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
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script>
        function confirmationPdf(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to Download",
                html:
                    '<div class="form-group"><div class="kt-radio-inline"><label class="kt-radio"><input type="radio" value="no" name="padType" class="padType"> Without pad template'+
                    '<span></span></label> <label class="kt-radio"><input type="radio" value="yes" checked="checked" name="padType" class="padType"> With pad template'+
                    '<span></span></label></div></div>',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Download'
            }).then((result) => {
                if (result.value) {
                    location.href = urlToRedirect+'/'+ $("input[name='padType']:checked").val();
                }
            });
        }


        function confirmationMail(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to Send Mail",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Send Email'
            }).then((result) => {
                if (result.value) {
                    location.href = urlToRedirect;
                }
            });
        }


        $(document).on('click', '.active-btn', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change this status",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    var id = $(this).attr('docTemplateId');
                    $.ajax({
                        url: "{{ route('letter.and.documents.status') }}",
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", "doc_id": id},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                location.reload(true);
                            }
                        }
                    });
                }
            });
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


    <script>
        $(document).on('change', '#employeeList', function()
        {

            var id = $(this).val();
            $.ajax({
                url: "{{ route('load.doc.employee.information') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}","id": id},
                success: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endpush



