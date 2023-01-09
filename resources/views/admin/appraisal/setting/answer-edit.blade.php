    <form class="kt-form kt-form--label-right " action="{{ route('admin.employee.appraisal.answer.setting.update', ['id'=>$id]) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="put">
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Question:</label>
                    <select class="form-control kt-selectpicker" id="" data-live-search="true" name="question" autocomplete="off">
                        <option value="">Select</option>
                        @foreach($questions as $question)
                            <option {{ ($row->mst_id == $question->id)? 'selected="selected"':'' }} value="{{ $question->id }}">{{ $loop->iteration }}. {{ $question->name }} - ({{ $question->marks }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Label:</label>
                    <input type="text" name="label" class="form-control" id="" value="{{ $row->label }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Value:</label>
                    <input type="number" name="value" class="form-control" id="" value="{{ $row->value }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Type:</label>
                    <select class="form-control" name="fieldType" autocomplete="off">
                        <option value="">Select</option>
                        <option {{ ($row->type == 'input')? 'selected="selected"':'' }} value="input">Input</option>
                        <option {{ ($row->type == 'textarea')? 'selected="selected"':'' }} value="textarea">Text Area</option>
                        <option {{ ($row->type == 'check')? 'selected="selected"':'' }} value="check">Check</option>
                        <option {{ ($row->type == 'radio')? 'selected="selected"':'' }} value="radio">Radio</option>
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

