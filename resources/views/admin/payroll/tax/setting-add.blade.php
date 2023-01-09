<form class="kt-form" action="{{ route('payroll.tax.setting.save') }}" method="POST">
    @csrf
    <div class="col-md-12">
        <div class="kt-portlet__body">

            <div class="form-group row">
                <div class="col-sm-4">
                    <label class="col-md-4" style="text-align: left">Tax (%)</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter tax amount"
                               value="">
                </div>
                <div class="col-sm-4">
                    <label class="col-md-4" style="text-align: left">Min</label>
                    <input type="number" class="form-control" name="min" placeholder="Enter min amount"
                           value="">
                </div>
                <div class="col-sm-4">
                    <label class="col-md-4" style="text-align: left">Max</label>
                    <input type="number" class="form-control" name="max" placeholder="Enter max amount"
                           value="">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>

</form>
