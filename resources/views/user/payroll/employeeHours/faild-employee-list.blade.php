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
                               Faild Employee Hours History
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                        <div class="row">
                            <div class="col-xs-6 col-md-3">
                                <a href="#" class="info-tile tile-success">
                                    <div class="tile-heading">
                                        <div class="pull-left">Total Uploaded</div>
                                    </div>
                                    <div class="tile-body">
                                        <div class="pull-left"><i class="fas fa-user-check"></i></div>
                                        <div class="pull-right">
                                        {{ $successEmp }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <a href="#" class="info-tile tile-danger">
                                    <div class="tile-heading">
                                        <div class="pull-left">Total Faild</div>
                                    </div>
                                    <div class="tile-body">
                                        <div class="pull-left"><i class="fas fa-user-times"></i></div>
                                        <div class="pull-right">
                                        {{ $faildEmp }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            </div>


                            <div class="table-responsive">
                            <!-- <br><br>
                            <input type="button" id="csvDownload" value="Export data into Excel" class="btn btn-primary">
                            <br> -->
                            <table class="table table-striped table-bordered" id="exportTable">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                    <tr>   
                                </thead>    
                                    @foreach($faildData as $key=>$value)
                                            <tr><td>{{ $value }}</td></tr>
                                    @endforeach
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



@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script !src="">
        var arrows;
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
        $('.month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm-dd',
            viewMode: 'days',
            minViewMode: 'days'
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#exportTable').DataTable( {
                "pageLength": 10,
                dom: 'Bftiprl',
                buttons: [
                    'csvHtml5'
                ],
                "columnDefs": [
                    {"className": "dt-left", "targets": "_all"}
                ],
                "searching": false
            } );

        } );



    </script>
@endpush





