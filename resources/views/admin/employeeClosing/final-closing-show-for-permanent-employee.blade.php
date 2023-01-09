<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="{{ route('user.request.clearance.hr.final.approval.change.status', ['id'=>$id]) }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-lg-12">
                <h5>Employee Information :</h5>
                <div class="card-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Name:</label></div>
                                <div class="col-7">{{ $closingApplication->employee->FullName }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Login ID:</label></div>
                                <div class="col-7">{{ $closingApplication->employee->employer_id }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Email:</label></div>
                                <div class="col-7">{{ $closingApplication->employee->email }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Gender:</label></div>
                                <div class="col-7">{{ $closingApplication->employee->gender }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Date of Birth:</label></div>
                                <div class="col-7">{{ $closingApplication->employee->date_of_birth  }}</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Location:</label></div>
                                <div class="col-7">{{ $closingApplication->employee->present_address  }}</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5>FNF :</h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">PF Balance</label></div>
                                <div class="col-7">{{ $providentFund ?? '' }} </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Total PF Balance</label></div>
                                <div class="col-7">
                                    <div class="row">
                                        <input type="text" name="pf" value="{{ $totalProvidentFund ?? '' }}" class="form-control col-4">
                                        <span class="text-danger col-8">({{ $providentFund }}*2)</span></div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Gratuity Amount:</label></div>
                                <div class="col-7">
                                    <input type="text" name="gratuity" value="{{ $gratuity ?? '' }}" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">&nbsp;</div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Total Leaves:</label></div>
                                <div class="col-7">
                                    <input type="text" name="leave" value="{{ $leaves ?? '' }}" id="" class="form-control border-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Leave Encashment</label></div>
                                <div class="col-7">
                                    <input type="text" name="encashment" value="{{ $leaveEncashment ?? '' }}" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <h5>HR Input :</h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="content">
                                <div class="form-group">
                                    <label>Year</label>
                                    <div class="input-group date">
                                        <input type="text" readonly="readonly"
                                                                         required="required" placeholder="" name="payment_date"
                                                                         value="" class="form-control kt_datepicker_3">
                                        <div class="input-group-append"><span class="input-group-text"><i
                                                    class="la la-calendar-check-o"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="content">
                                <div class="form-group">
                                    <label>Year</label>
                                    <div class="input-group">
                                        <select name="payment_status" id="" class="form-control">
                                            <option value="">Select</option>
                                            @foreach(\App\Utils\EmployeeClosing::Payment as $key => $value)
                                                <option value="{{ $value }}">{{ ucfirst($key) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>


            </div>
        </div>

        <div class="form-group row">
            <div class="form-group">
                <label class="kt-checkbox kt-checkbox--tick kt-radio--success"><input
                        type="checkbox" checked="checked" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['final']['true'] }}" name="approval_status" class="is_fixed_officetime">
                    Are You Sure ?
                    <span></span>
                </label>
            </div>
        </div>
    </div>

    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-4">
                    <button type="submit"
                            class="btn btn-primary">Save And Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>



