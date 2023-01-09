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
                                Adjustment Type
                            </h3>
                        </div>
                        <a href="#" style="position: relative; top: 15px" title="Add New Adjustment Type" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.type.create') }}" class="card-text custom-btn globalModal">
                            <span class="btn btn-outline-primary">Add New</span>
                        </a>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">


                            <div class="table-responsive">
                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($adjustments as $adjustment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $adjustment->name }}</td>
                                    <td>
                                        <a href="#" title="Update Adjustment Type" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.type.edit', [$adjustment->id]) }}" class="card-text custom-btn globalModal">
                                            <span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
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
        .inner-table{
            border-collapse: collapse; border-spacing: 0px; text-align:center;
            font-size: 10px;
            font-weight: 500;
            vertical-align: middle;
            border-width:.5px;
            border-style:solid;
        }
        .inner-table th {
            border: 1px solid #0abb87;
        }

        .inner-table td {
            border: 1px solid #0abb87;
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
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>


@endpush




