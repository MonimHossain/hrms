
                <form class="kt-form" action="{{ route('admin.loan.application.history.update', ['id'=>$id]) }}" method="POST">
                    @csrf

                    <input type="hidden" name="_method" value="PUT">

                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>Ref No</label>
                                <div class="input-group">
                                    <span> <b>{{ $findApplication->reference_id }}</b> </span>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label>Status</label>
                                <select class="form-control kt-selectpicker" data-live-search="true" id="status" name="status" required>
                                    <option value="">Select</option>
                                    @foreach(\App\Utils\Payroll::LOAN['SHOWSTATUS'] as $key=> $value)
                                    <option value="{{ $value }}">{{ trans('payroll.loan.status.'.$value) }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </div>
                            </div>
                        </div>
                </form>
