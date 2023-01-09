    <form class="kt-form kt-form--label-right " action="{{ route('admin.employee.interview.answer.store') }}" method="POST">
        @csrf
        <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">

        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Question:</label>e
                    <select class="form-control kt-selectpicker" id="questionList" data-live-search="true" name="question" autocomplete="off">
                        <option value="">Select</option>
                        @foreach($questions as $question)
                            <option value="{{ $question->id }}" mark="{{ $question->marks }}">{{ $loop->iteration }}. {{ $question->name }} ({{ $question->marks }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row" id="labelFieldContainer">
                <div class="appended-field row container">
                    <div class="col-lg-6">
                        <input type="text" name="label[]" class="form-control" id="">
                    </div>

                    <div class="col-lg-4">
                        <input type="text" name="value[]" class="form-control value" id="">
                    </div>
                    <div class="col-lg-2">
                        <br>
                        <a href="#" class="btn-sm btn-outline-danger delete"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-6"><b>Total Mark</b></div>
                <div class="col-lg-4"><b class="totalMark">0</b></div>
                <div class="col-lg-2">
                    <a href="#" class="btn-sm btn-outline-success" id="labelFieldAdd"><i class="fas fa-plus"></i></a>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Type:</label>
                    <select class="form-control" name="fieldType" autocomplete="off">
                        <option value="">Select</option>
                        <option value="input">Input</option>
                        <option value="textarea">Text Area</option>
                        <option value="check">Check</option>
                        <option value="radio">Radio</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
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

