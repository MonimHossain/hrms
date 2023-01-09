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
                        {{--<a href="#" style="position: absolute; top: 15px; right: 15px;" title="Upload file" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('resource.create') }}" class="card-text custom-btn globalModal pull-right">
                            <span class="btn btn-outline-primary">Add New</span>
                        </a>--}}
                        <a href="{{ route('resource.create') }}" style="position: absolute; top: 15px; right: 15px;" title="Upload file">
                            <span class="btn btn-outline-primary">Add New</span>
                        </a>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('resource.list')  }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input type="text" autocomplete="off" class="form-control month-pick" name="date_from" placeholder="Select Month" value="{{ Request::get('date_from') }}">
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $employee)
                                                        <option {{ (Request::get('employee_id') ==  $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <div class="input-group">
                                                <select name="department" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($departments as $department)
                                                        <option {{ (Request::get('department') ==  $department->id)? 'selected="selected"':'' }} value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Process</label>
                                            <div class="input-group">
                                                <select name="process" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($processes as $process)
                                                        <option {{ (Request::get('process') ==  $process->id)? 'selected="selected"':'' }} value="{{ $process->id }}">{{ $process->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                            @if(!empty($resources))
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

                                    @foreach($resources as $file)
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
                                            <a target="_blank" href="{{ route('employee.profile', [$file->employee->id]) }}">
                                                {{ $file->employee->fullName }}
                                            </a>
                                            <br>
                                            <strong>EID:</strong> {{ $file->employee->employer_id }} <br>
                                            <strong>Dept:</strong>
                                            @foreach($file->employee->departmentProcess->unique('department_id') as $item)
                                                {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach <br>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}</td>
                                        <td>
                                            <a href="#" title="Update File Info" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('resource.edit', [$file->id]) }}" class="card-text custom-btn globalModal btn btn-sm btn-outline-primary">
                                                <span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span>
                                            </a>
                                            <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ asset('storage/uploads/resources/' . $file->file) }}">
                                                <span class="btn-sm btn-outline-primary"><i class="flaticon-download"></i></span>
                                            </a>
                                            <a class="btn btn-sm btn-outline-primary btn-confirm" href-data="{{ route('resource.trash', ['id' => $file->id]) }}">
                                                <span class="btn-sm btn-outline-primary"><i class="flaticon-delete"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $resources->appends(Request::all())->links() }}
                            @endif
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




