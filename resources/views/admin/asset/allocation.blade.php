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
                                Allocations                                
                            </h3>                            
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">                            
                            <form class="kt-form" action="{{ route('asset.allocaiton')  }}" method="GET">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <a class="btn btn-sm btn-primary" href="{{ route('asset.allocation.add') }}">Add new</a>                            
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <input type="text" name="employee_id" class="form-control" value="{{ Request::get('employee_id') }}" placeholder="Employee ID">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Asset Type</label>
                                            <div class="input-group">
                                                <select name="asset_type" class="form-control" id="">
                                                    <option value="">Select All</option>
                                                    @foreach($asset_types as $asset_type)
                                                        <option {{ (Request::get('asset_type') == $asset_type->id) ? 'selected':'' }} value="{{ $asset_type->id }}">{{ $asset_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Asset ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  placeholder="Asset ID" name="asset_id" value="{{ Request::get('asset_id') }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control month-pick"
                                                       placeholder="Select Date"
                                                       autocomplete="off"
                                                       id="" name="date_from" value="{{ Request::get('date_from') }}"/>
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
                                            <label>Date To</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control month-pick" readonly
                                                       placeholder="Select Date"
                                                       autocomplete="off"
                                                       id="" name="date_to" value="{{ Request::get('date_to') }}"/>
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
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                            <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th>Asset ID</th>
                                    <th>Asset Name</th>
                                    <th>Type</th>
                                    <th>Employee</th>
                                    <th>Allocated</th>
                                    <th>Returned</th>
                                    <th>Damaged</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($history as $row)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{ route('asset.view', ['id'=>$row->asset->id]) }}">
                                                {{ $row->asset->asset_id }}
                                            </a>
                                        </td>
                                        <td>{{ $row->asset->name }}</td>
                                        <td>{{ $row->asset->AssetType->name }}</td>                                        
                                        <td width="20%">
                                            <strong>Name:</strong>
                                            <a target="_blank" href="{{ route('employee.profile', [$row->employee->id]) }}">
                                                {{ $row->employee->fullName }} 
                                            </a>
                                            <br>
                                            <strong>EID:</strong> {{ $row->employee->employer_id }} <br>
                                            <strong>Dept:</strong> 
                                            @foreach($row->employee->departmentProcess->unique('department_id') as $item)
                                                {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach <br>
                                        </td>
                                        <td>
                                            <strong>Allocated at:</strong> {{ $row->allocaiton_date }} <br>
                                            <strong>Allocated by:</strong> 
                                                <a target="_blank" href="{{ route('employee.profile', [$row->allocated_by]) }}">
                                                    {{ $row->allocatedBy->fullName }} <br>
                                                </a>
                                            <strong>Note:</strong> {{ $row->allocation_note }}
                                        </td>
                                        <td>
                                            @if($row->returned_at)
                                                <strong>Returned at:</strong> {{ $row->returned_at }} <br>
                                                <strong>Received by:</strong> {{ $row->received_by }} <br>
                                                <strong>Note:</strong> {{ $row->return_note }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ ($row->is_damaged) ? 'Yes':'No' }}</td>
                                        <td>
                                            <a href="{{ route('asset.allocation.edit', ['id'=>$row->id]) }}"><i class="flaticon-edit"></i></a>
                                            <a href="{{ route('asset.allocation.view', ['id'=>$row->id]) }}"><i class="flaticon-eye"></i></a>
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



@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script>
        function getFilePath() {
            // var input = document.getElementById("customFile");
            // var fReader = new FileReader();
            // fReader.readAsDataURL(input.files[0]);
            // fReader.onloadend = function(event){
            //     $("#customFileLabel").empty();
            //     $("#customFileLabel").append(event.target.result);
            // }
            $("#customFileLabel").empty();
            $("#customFileLabel").append(document.getElementById("customFile").files[0].name);
        }


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

        $(document).on('change', '#reward', function () {
            if($("#reward option:selected" ).val() != '-1'){
                $('#other').hide();
            }else{
                $('#other').show();
            }
        });

    </script>

@endpush






