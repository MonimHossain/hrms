
<form class="kt-section" action="{{ route('employee.evaluation.name.update', ['id'=>$id]) }}" method="post">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="row">
        <div class="form-group col-xl-4">
            <label>Start Date</label>
            <div class="input-group date"><input type="text" readonly="readonly"
                                                 required="required" placeholder=""
                                                 name="start_date" value="{{ $evaluationNames->start_date }}"
                                                 class="form-control kt_datepicker_3">
                <div class="input-group-append"><span class="input-group-text"><i
                            class="la la-calendar-check-o"></i></span></div>
            </div>
        </div>

        <div class="form-group col-xl-4">
            <label>End Date</label>
            <div class="input-group date"><input type="text" readonly="readonly"
                                                 required="required" placeholder=""
                                                 name="end_date" value="{{ $evaluationNames->end_date }}"
                                                 class="form-control kt_datepicker_3">
                <div class="input-group-append"><span class="input-group-text"><i
                            class="la la-calendar-check-o"></i></span></div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="form-group">
                <label>Title</label>
                <div class="kt-form__actions">
                    <input type="text" name="name" class="form-control" id="" value="{{ $evaluationNames->name }}">
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-12">
        <hr>
        <div class="form-group">
            <label class="">&nbsp;</label>
            <input type="submit" value="Submit" class="form-control btn btn-primary">
        </div>
    </div>
</form>





