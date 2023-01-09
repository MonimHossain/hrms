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
                                Resource Library
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <div class="table-responsive">
                            <table class="table table-striped custom-table" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th>File name</th>
                                    <th>Author</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($adjustments as $file)
                                <tr>
                                    <td>
                                        {{ $file->name }} <br>
                                        <small>
                                            ({{ $file->file }})
                                        </small>
                                        @if($file->note)
                                            <br>
                                            <small>
                                                <strong>Note: </strong>{{ $file->note }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>Name:</strong>
                                        {{ $file->employee->fullName }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" target="" href="{{ asset('uploads/resources/' . $file->file) }}">
                                            <span class="btn-sm btn-outline-primary"><i class="flaticon-eye"></i></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $adjustments->appends(Request::all())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header no-border">
                <h4 class="modal-title" id="myModalLabel">Move to trash</h4> <br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
                <div class="row">
                    <div class="col-md-12 text-center mt-1">
                        <p>
                            <i class="fa fa-info-circle fa-3x"></i>
                        </p>
                        <p>Are you sure?</p>
                    </div>
                </div>
            <div class="modal-footer no-border">
                <button type="button" class="btn btn-default" id="modal-btn-si">Yes</button>
                <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
            </div>
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

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

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
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });
    </script>
    <script>
        var modalConfirm = function(callback){
        var urlData = '';

        $(".btn-confirm").on("click", function(){
            urlData = $(this).attr('href-data');
            $("#mi-modal").modal('show');
        });

        $("#modal-btn-si").on("click", function(){
            callback(true);
            $("#mi-modal").modal('hide');
            window.location.replace(urlData);
        });

        $("#modal-btn-no").on("click", function(){
            callback(false);
            $("#mi-modal").modal('hide');
        });
        };

        modalConfirm(function(confirm){
        if(confirm){
            //Acciones si el usuario confirma
            $("#result").html("CONFIRMADO");
        }else{
            //Acciones si el usuario no confirma
            $("#result").html("NO CONFIRMADO");
        }
        });
    </script>
@endpush




