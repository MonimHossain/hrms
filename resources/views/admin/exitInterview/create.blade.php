    <form class="kt-form kt-form--label-right " action="{{ route('admin.employee.interview.store') }}" method="POST">
        @csrf
        <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">

        <div class="kt-portlet__body">
            <input type="hidden" name="type_id" value="employee">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Name:</label>
                    <input type="text" name="name" class="form-control" id="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Marks:</label>
                    <input type="text" class="form-control" name="marks" value="">
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

