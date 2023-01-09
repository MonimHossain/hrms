    <form class="kt-form kt-form--label-right " action="{{ route('admin.employee.appraisal.question.setting.store') }}" method="POST">
        @csrf
        <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">

        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Question Name:</label>
                    <input type="text" name="name" class="form-control" id="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Mark:</label>
                    <input type="text" name="mark" class="form-control markValue" id="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Type:</label>
                    <select class="form-control" name="type_id" autocomplete="off">
                        <option value="">Select</option>
                        <option value="employee">Employee</option>
                        <option value="lead">Lead</option>
                        <option value="company">Company</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-4">
                        <button type="submit"
                                class="btn btn-primary">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>




