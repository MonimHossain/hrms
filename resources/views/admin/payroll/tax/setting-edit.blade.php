<form class="kt-form" action="{{ route('payroll.tax.setting.update', ['id'=>$id]) }}" method="POST">
    <input name="_method" type="hidden" value="PUT">
    @csrf
    <div class="col-md-12">
        <div class="kt-portlet__body">

            <div class="form-group row">
                <div class="col-sm-4">
                    <label class="col-md-4" style="text-align: left">Tax (%)</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter tax amount"
                               value="{{ $settings->amount }}">
                </div>
                <div class="col-sm-4">
                    <label class="col-md-4" style="text-align: left">Min</label>
                    <input type="number" class="form-control" name="min" placeholder="Enter min amount"
                           value="{{ $settings->min }}">
                </div>
                <div class="col-sm-4">
                    <label class="col-md-4" style="text-align: left">Max</label>
                    <input type="number" class="form-control" name="max" placeholder="Enter max amount"
                           value="{{ $settings->max }}">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>

</form>
