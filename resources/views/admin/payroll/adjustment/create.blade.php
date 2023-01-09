 <!--begin::Form-->
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ route('payroll.adjustment.store') }}">
        {{ csrf_field() }}
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="">Employee</label>
                    <div class="custom-file">
                        <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach($emoloyees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">Adjustment Type</label>
                    <div class="custom-file">
                        <select name="adjustment_type" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach($adjustmentType as  $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">Type</label>
                    <div class="custom-file">
                        <select name="type" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach(\App\Utils\Payroll::ADJUSTMENT['type'] as $key=> $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
             </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label class="">Amount</label>
                    <div class="custom-file">
                        <input type="number" name="amount" class="form-control" id="amount" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">Year-Month </label>
                    <div class="custom-file">
                        <input type="text" name="month" class="form-control month-pick" id="month" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">Remarks </label>
                    <div class="custom-file">
                        <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-brand">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script>
        function getFilePath() {
            // var input = document.getElementById("customFile");
            // var fReader = new FileReader();
            // fReader.readAsDataURL(input.files[0]);
            // fReader.onloadend = function(event){
            //     $("#customFileLabel").empty();
            //     $("#customFileLabel").append(event.target.result);
            // }
            $("#customFileLabel").empty();
            $("#customFileLabel").append(document.getElementById("customFile").files[0].name);
        }

        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }
        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });
    </script>

@endpush
