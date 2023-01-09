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
                                            Add Process Salary Settings
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 margin-top-15">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    </div>

                    <!--begin::Form-->

                    @if("add" === $flag)
                        <form class="kt-form  center-division-form" action="{{ route('process.payment.setting.create') }}" method="POST">
                    @else
                        <form class="kt-form  center-division-form" action="{{ route('process.payment.setting.update', ['id'=>$id]) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                    @endif
                        @csrf
                        <div class="col-md-12">
                            <div class="kt-portlet__body">

                                @if($rows)
                                <div class="form-group row">
                                    <div class="col-md-6  center-division-item">
                                        <label class="col-md-2" style="text-align: left">Division</label>
                                        <label class="col-md-10">
                                            <select name="division_id" class="form-control division" id="">
                                                <option value="0">Select division</option>
                                                @foreach(\App\Division::all() as $item)
                                                    <option {{ (session()->get('division') == $item->name) ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6  center-division-item">
                                        <label class="col-md-2" style="text-align: left">Center</label>
                                        <label class="col-md-10">
                                            <select name="center_id" class="form-control center" id="">
                                                <option value="">Select center</option>
                                                @foreach($centers as $center)
                                                    <option {{ ($rows->center_id == $center->id)? 'selected="selected"':'' }} value="{{ $center->id }}">{{ $center->center }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="col-md-2" style="text-align: left">Department</label>
                                        <label class="col-md-10">
                                            <select name="department_id" class="form-control department" id="">
                                                <option value="">Select department</option>
                                                @foreach($departments as $department)
                                                    <option {{ ($rows->department_id == $department->id)? 'selected="selected"':'' }} value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="col-md-2" style="text-align: left">Process</label>
                                        <label class="col-md-10">
                                            <select name="process_id" class="form-control process" id="">
                                                <option value="">Select process</option>
                                                @foreach($all_process as $process)
                                                    <option {{ ($rows->process_id == $process->id)? 'selected="selected"':'' }} value="{{ $process->id }}">{{ $process->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-md-4" style="text-align: left">Process segment</label>
                                        <label class="col-md-10">
                                            <select name="process_segment_id" class="form-control process-segment" id="">
                                                <option value="">Select segment</option>
                                                @foreach($all_process_segments as $process_segment)
                                                    <option {{ ($rows->process_segment_id == $process_segment->id)? 'selected="selected"':'' }} value="{{ $process_segment->id }}">{{ $process_segment->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="col-md-7" style="text-align: left">Employment Type</label>
                                        <label class="col-md-10">
                                            <select name="employment_type_id" class="form-control" id="">
                                                <option value="">Select process</option>
                                                @foreach($employment_types as $employment_type)
                                                    <option {{ ($rows->employment_type_id == $employment_type->id)? 'selected="selected"':'' }} value="{{ $employment_type->id }}">{{ $employment_type->type }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-md-4" style="text-align: left">Salary Type</label>
                                        <label class="col-md-10">
                                            <select name="salary_type" class="form-control" id="">
                                                <option value="">Select salary type</option>
                                                @foreach($salary_types as $key => $salary_type)
                                                    <option {{ ($rows->salary_type == $key)? 'selected="selected"':'' }} value="{{ $key }}">{{ $salary_type }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-md-2" style="text-align: left">Amount</label>
                                        <label class="col-md-10">
                                            <input type="text" class="form-control" name="amount" placeholder="Enter Amount"
                                                    value="{{ $rows->amount }}">
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-md-6" style="text-align: left">KPI boundary</label>
                                        <label class="col-md-10">
                                            <input type="text" class="form-control" name="kpi_boundary" placeholder="Enter KPI boundary"
                                                    value="{{ $rows->kpi_boundary }}">
                                        </label>
                                    </div>
                                </div>

                                @else

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="col-md-2" style="text-align: left">Division</label>
                                            <label class="col-md-10">
                                                <select name="division_id" class="form-control division" id="">
                                                    <option value="">Select</option>
                                                    @foreach($division as $item)
                                                        <option {{ (session()->get('division') == $item->name) ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-2" style="text-align: left">Center</label>
                                            <label class="col-md-10">
                                                <select name="center_id" class="form-control center" id="">
                                                    <option value="">Select center</option>
                                                    @foreach($centers as $center)
                                                        <option value="{{ $center->id }}">{{ $center->center }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="col-md-2" style="text-align: left">Department</label>
                                            <label class="col-md-10">
                                                <select name="department_id" class="form-control department" id="" required>
                                                    <option value="">Select department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="col-md-2" style="text-align: left">Process</label>
                                            <label class="col-md-10">
                                                <select name="process_id" class="form-control process" id="" required>
                                                    <option value="">Select process</option>
                                                    @foreach($all_process as $process)
                                                        <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-md-4" style="text-align: left">Process segment</label>
                                            <label class="col-md-10">
                                                <select name="process_segment_id" class="form-control process-segment" id="" required>
                                                    <option value="">Select segment</option>
                                                    @foreach($all_process_segments as $process_segment)
                                                        <option value="{{ $process_segment->id }}">{{ $process_segment->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="col-md-7" style="text-align: left">Employment Type</label>
                                            <label class="col-md-10">
                                                <select name="employment_type_id" class="form-control" id="" required>
                                                    <option value="">Select process</option>
                                                    @foreach($employment_types as $employment_type)
                                                        <option value="{{ $employment_type->id }}">{{ $employment_type->type }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-md-4" style="text-align: left">Salary Type</label>
                                            <label class="col-md-10">
                                                <select name="salary_type" class="form-control" id="" required>
                                                    <option value="">Select salary type</option>
                                                    @foreach($salary_types as $key => $salary_type)
                                                        <option value="{{ $key }}">{{ $salary_type }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="col-md-2" style="text-align: left">Amount</label>
                                            <label class="col-md-10">
                                                <input type="text" class="form-control" name="amount" required placeholder="Enter Amount"
                                                       value="">
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-md-6" style="text-align: left">KPI boundary</label>
                                            <label class="col-md-10">
                                                <input type="text" class="form-control" name="kpi_boundary" required placeholder="Enter KPI boundary"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    @endif



                            </div>
                        </div>


                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <label for="" class="offset-1">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </label>
                            </div>
                        </div>
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
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    @include('layouts.partials.includes.division-center')

    <script>
        /*function getFilePath() {
            $("#customFileLabel").empty();
            $("#customFileLabel").append(document.getElementById("customFile").files[0].name);
        }*/

        /*$(document).ready(function(){
            $("select[name='process_id']").on('change', function(){
                let processID = $(this).val();
                let url = '{{ route("employee.get.processSegment",':processID' ) }}';
                url = url.replace(':processID', processID);
                if(processID){
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data){
                            console.log(data);
                            $('select[name="process_segment_id"]').empty();
                            $.each(data, function(id, value){
                                $('select[name="process_segment_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>')
                            })

                        }
                    })
                }
                else
               {
                  $('select[name="process_segment_id"]').empty();
               }
            });
        })*/
    </script>

@endpush
