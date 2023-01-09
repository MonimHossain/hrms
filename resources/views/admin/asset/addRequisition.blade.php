@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            @if("add" === $flag)
                                                New Requisition
                                            @elseif("view" === $flag)
                                                Details                                                
                                            @else
                                                Update Requisition
                                            @endif                                                 
                                        </h3>                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->


                    @if("add" === $flag)
                        <form class="kt-form" action="{{ route('asset.requisition.create') }}" method="POST">
                    @else
                        <form class="kt-form" action="{{ route('asset.requisition.update', ['id'=>$id]) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                    @endif

                        @csrf
                        <div class="col-md-12">
                            <div class="kt-portlet__body">
                                @if($rows)
                                    @if($flag == 'view')
                                        <table class="table">
                                            <tr>
                                                <td width="5%">Asset Type</td>
                                                <td>{{ $rows->AssetType->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Employee Details</td>
                                                <td width="20%">
                                                    <strong>Name:</strong>
                                                    <a target="_blank" href="{{ route('employee.profile', [$rows->employee->id]) }}">
                                                        {{ $rows->employee->fullName }} 
                                                    </a>
                                                    <br>
                                                    <strong>EID:</strong> {{ $rows->employee->employer_id }} <br>
                                                    <strong>Dept:</strong> 
                                                    @foreach($rows->employee->departmentProcess->unique('department_id') as $item)
                                                        {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                    @endforeach <br>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td width="5%">Specificaiton</td>
                                                <td>
                                                    {{ $rows->specification }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Due Date</td>
                                                <td>
                                                    {{ date('Y-m-d', strtotime($rows->due_date)) }} <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Status</td>
                                                <td>{{ ($rows->status) ? $status[$rows->status]:'' }}</td>
                                            </tr>                                            
                                        </table>
                                    @else 
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Asset type</label>
                                                <label>
                                                    <select disabled name="asset_type_id" class="form-control" id="">
                                                        <option value="">Select type</option>
                                                        @foreach($asset_types as $asset_type)
                                                            <option value="{{ $asset_type->id }}" {{ ($asset_type->id == $rows->asset_type_id) ? 'selected':'' }} >{{ $asset_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Due Date</label>
                                                <label>
                                                    <input disabled type="date" class="form-control" required name="due_date" placeholder="Enter Date"
                                                        value="{{ date('Y-m-d', strtotime($rows->due_date)) }}">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Specification</label>
                                                <label>
                                                    <textarea disabled name="specification" class="form-control" id="" cols="30" rows="10">{{ $rows->specification }}</textarea>
                                                </label>
                                            </div>
                                        </div>
                                        @if(auth()->user()->hasAnyRole('Super Admin|Admin') && request()->session()->get('validateRole') == 'Admin')
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label class="col-md-2" style="text-align: right">Status</label>
                                                    <label>
                                                        <select required name="status" class="form-control" id="">                                                    
                                                            <option {{ ($rows->status == 0) ? 'selected':'' }} value="0">New</option>
                                                            <option {{ ($rows->status == 1) ? 'selected':'' }} value="1">Accepted</option>                                                    
                                                            <option {{ ($rows->status == 2) ? 'selected':'' }} value="2">Rejected</option>                                                    
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @else

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Asset type</label>
                                            <label>
                                                <select name="asset_type_id" required class="form-control" id="">
                                                    <option value="">Select type</option>
                                                    @foreach($asset_types as $asset_type)
                                                        <option value="{{ $asset_type->id }}">{{ $asset_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Due Date</label>
                                            <label>
                                                <input type="date" class="form-control" required name="due_date" placeholder="Enter Employee ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" required style="text-align: right">Specification</label>
                                            <label>
                                                <textarea name="specification" class="form-control" id="" cols="30" rows="10"></textarea>
                                            </label>
                                        </div>
                                    </div>                                    
                                @endif
                            </div>
                        </div>

                        @if("view" != $flag)
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <label for="" class="offset-1">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </label>
                            </div>
                        </div>
                        @endif
                    </form>

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
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
        $('#month-pick').datepicker({
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

        $(document).on('change', '#reward', function () {
            if($("#reward option:selected" ).val() != '-1'){
                $('#other').hide();
            }else{
                $('#other').show();
            }
        });

    </script>

@endpush
