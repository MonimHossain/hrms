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
                            List of Document History
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
                    <div class="row hidden">
                        <div class="form-group col-md-2"><label>Start Date</label>
                            <div class="input-group date"><input type="text" readonly="readonly"
                                                                 placeholder="Select date" id="kt_datepicker_3"
                                                                 name="date_of_birth" value="" class="form-control">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="la la-calendar-check-o"></i></span></div>
                            </div>
                        </div>
                        <div class="form-group col-md-2"><label>End Date</label>
                            <div class="input-group date"><input type="text" readonly="readonly"
                                                                 placeholder="Select date" id="kt_datepicker_3"
                                                                 name="date_of_birth" value="" class="form-control">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="la la-calendar-check-o"></i></span></div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Select Document Type</label>
                            <select name="leaveType" class="form-control" id="docType">
                                <option value="">Select Type</option>
                                @foreach($docTypes as $docType)
                                <option value="{{ $docType->url }}">{{ $docType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>&nbsp;</label><br>
                            <input type="button" id="search-btn" value="Search" class="btn btn-outline-primary">
                        </div>
                    </div>


                    <div class="table-responsive">
                        @if(!empty($docHistory))
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                            <tr>
                                <th>Ref Id</th>
                                <th>Doc Type</th>
                                <th>Processed By</th>
                                <th>Created at</th>
                                <th>Doc Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($docHistory as $history)
                                <tr>
                                    <td>
                                        {{ $history->ref_id }}
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
                                    <td>
                                        <a type="submit" href="{{ route('employee.letter.and.documents.pdf', ['id'=> $history->id]) }}" id="saveAndPdf" title="Save and pdf Download" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="fas fa-file-pdf"></i></a>
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
@endpush



