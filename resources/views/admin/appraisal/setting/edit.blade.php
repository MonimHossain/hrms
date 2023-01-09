    <form class="kt-form kt-form--label-right " action="{{ route('admin.employee.appraisal.question.setting.update', ['id'=>$id]) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="put">
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Question Name:</label>
                    <input type="text" name="name" class="form-control" id="" value="{{ $row->name }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Mark:</label>
                    <input type="number" name="mark" class="form-control" id="" value="{{ $row->marks }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Type:</label>
                    <select class="form-control" name="type_id" autocomplete="off">
                        <option value="">Select</option>
                        <option {{ ($row->type_id == 'employee') ? 'selected="selected"':'' }} value="employee">Employee</option>
                        <option {{ ($row->type_id == 'lead') ? 'selected="selected"':'' }} value="lead">Lead</option>
                        <option {{ ($row->type_id == 'company') ? 'selected="selected"':'' }} value="company">Company</option>
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

