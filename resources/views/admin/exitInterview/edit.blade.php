    <form class="kt-form kt-form--label-right " action="{{ route('admin.employee.interview.update', ['id'=>$id]) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="type_id" value="employee">
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Name:</label>
                    <input type="text" name="name" class="form-control" id="" value="{{ $row->name }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Marks:</label>
                    <input type="text" class="form-control" name="marks" value="{{ $row->marks }}">
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

