<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="{{ route('admin.employee.termination.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">

    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-3">
                <label class="">Select Employee :</label>
                <select required class="form-control kt-selectpicker" data-live-search="true" required name="employee_id">
                    <option value="">Select</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label class="">Select Reason :</label>
                <select required class="form-control kt-selectpicker" data-live-search="true" required name="separation_type">
                    <option value="">Select</option>
                    @foreach(\App\Utils\EmployeeClosing::SeparationReason as $key=>$value)
                        <option value="{{ $value }}">{{ ucfirst(_lang('employee-closing.separationReason.'.$value)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3">
                <div class="form-group"><label>Last Working Day</label>
                    <div class="input-group date"><input required type="text" readonly="readonly" required placeholder="Select date" id=""
                                                         name="lwd" value="" class="form-control kt_datepicker_3"
                                                         aria-invalid="false">
                        <div class="input-group-append"><span class="input-group-text"><i
                                    class="la la-calendar-check-o"></i></span></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <label class="">Select Clearance Mode :</label>
                <select required class="form-control kt-selectpicker" data-live-search="true" required name="clearance_mode">
{{--                    <option value="">Select</option>--}}
                    @foreach(\App\Utils\EmployeeClosing::ClearanceMode as $key=>$value)
                        {{-- @if($key == 1) --}}
                        <option value="{{ $key }}">{{ ucfirst($value) }}</option>
                        {{-- @endif --}}
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label class="">Please fill up :</label>
                <textarea aria-required="true" name="remarks" required id="textarea" cols="30"
                          rows="3" class="form-control textarea" placeholder="" required>
                </textarea>
            </div>
        </div>
    </div>

    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-4">
                    <button type="submit"
                            class="btn btn-primary">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


