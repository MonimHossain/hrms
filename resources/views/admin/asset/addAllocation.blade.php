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
                                                New Allocation
                                            @elseif("view" === $flag)
                                                Details                                                
                                            @else
                                                Update Allocation
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
                        <form class="kt-form" action="{{ route('asset.allocation.create') }}" method="POST">
                    @else
                        <form class="kt-form" action="{{ route('asset.allocation.update', ['id'=>$id]) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                    @endif

                        @csrf
                        <div class="col-md-12">
                            <div class="kt-portlet__body">
                                @if($rows)
                                    @if($flag == 'view')
                                        <table class="table">
                                            <tr>
                                                <td width="5%">Asset ID</td>
                                                <td>{{ $rows->asset->asset_id }}</td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Asset Name</td>
                                                <td>{{ $rows->asset->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Asset Type</td>
                                                <td>{{ $rows->asset->AssetType->name }}</td>
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
                                                <td width="5%">Allocation info</td>
                                                <td>
                                                    <strong>Allocated at:</strong> {{ $rows->allocaiton_date }} <br>
                                                    <strong>Allocated by:</strong> 
                                                        <a target="_blank" href="{{ route('employee.profile', [$rows->allocated_by]) }}">
                                                            {{ $rows->allocatedBy->fullName }} <br>
                                                        </a>
                                                    <strong>Note:</strong> {{ $rows->allocation_note }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Return details</td>
                                                <td>
                                                    @if($rows->returned_at)
                                                        <strong>Returned at:</strong> {{ $rows->returned_at }} <br>
                                                        <strong>Received by:</strong> {{ $rows->received_by }} <br>
                                                        <strong>Note:</strong> {{ $rows->return_note }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="5%">Damaged</td>
                                                <td>{{ ($rows->is_damaged) ? 'Yes':'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="5%"></td>
                                                <td>
                                                    <a href="{{ route('asset.allocation.edit', ['id'=>$rows->id]) }}"><i class="flaticon-edit"></i> Edit</a>
                                                </td>
                                            </tr>
                                        </table>
                                    @else 



                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Asset ID</label>
                                                <label>
                                                    <input type="text" disabled class="form-control" value="{{ $rows->asset->asset_id }}" required name="asset_id" placeholder="Enter Asset ID"
                                                        value="">
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Employee ID</label>
                                                <label>
                                                    <input type="text" disabled class="form-control" value="{{ $rows->employee->employer_id }}" required name="employee_id" placeholder="Enter Employee ID">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Allocaiton Date</label>
                                                <label>
                                                    <input type="date" disabled class="form-control" value="{{ date('Y-m-d', strtotime($rows->allocaiton_date)) }}" required name="allocaiton_date">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Allocation Note</label>
                                                <label>
                                                    <textarea name="allocation_note" class="form-control" id="" cols="30" rows="10">{{ $rows->allocation_note }}</textarea>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Return Date</label>
                                                <label>
                                                    <input type="date" class="form-control" name="return_date" value="{{ ($rows->return_date) ? date('Y-m-d', strtotime($rows->return_date)) : '' }}">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Return Note</label>
                                                <label>
                                                    <textarea name="return_note" class="form-control" id="" cols="30" rows="10">{{ $rows->return_note }}</textarea>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Damaged</label>
                                                <label>
                                                    <select name="is_damaged" class="form-control" id="">                                                    
                                                        <option {{ $rows->is_damages ? 'selected':'' }} value="0">No</option>
                                                        <option {{ $rows->is_damages ? 'selected':'' }} value="1">Yes</option>                                                    
                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Damage Amount</label>
                                                <label>
                                                    <input type="text" class="form-control" required name="damage_amount" placeholder="Damage Amount"
                                                        value="{{ $rows->damage_amount }}">
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @else

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Asset ID</label>
                                            <label>
                                                <input type="text" class="form-control" required name="asset_id" placeholder="Enter Asset ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Employee ID</label>
                                            <label>
                                                <input type="text" class="form-control" required name="employee_id" placeholder="Enter Employee ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Allocaiton Date</label>
                                            <label>
                                                <input type="date" class="form-control" required name="allocaiton_date" placeholder="Enter Employee ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Allocation Note</label>
                                            <label>
                                                <textarea name="allocation_note" class="form-control" id="" cols="30" rows="10"></textarea>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Return Date</label>
                                            <label>
                                                <input type="date" class="form-control" name="return_date" placeholder="Enter Employee ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Return Note</label>
                                            <label>
                                                <textarea name="return_note" class="form-control" id="" cols="30" rows="10"></textarea>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Damaged</label>
                                            <label>
                                                <select name="is_damaged" class="form-control" id="">                                                    
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>                                                    
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Damage Amount</label>
                                            <label>
                                                <input type="text" class="form-control" required name="damage_amount" placeholder="Damage Amount"
                                                       value="0">
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
