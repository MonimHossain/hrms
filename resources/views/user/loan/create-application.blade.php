@extends('layouts.container')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                    <h3 class="kt-portlet__head-title">
                        Loan Application
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin::Form-->
                <form class="kt-form" action="{{ route('loam.application.store') }}" method="POST">
                    @csrf

                    <div class="kt-portlet__body">

                        <div class="form-group row">

                            <div class="col-sm-4">
                                <label>Select Loan Type</label>
                                <select class="form-control kt-selectpicker" data-live-search="true" id="loan_type" name="loan_type" required>
                                    <option value="">Select</option>
                                    @foreach($loanTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->loan_type }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-4">
                                <label for="team_lead_id">Set Interval (in month)</label>
                                <select class="form-control" id="interval"
                                        name="interval" required>
                                </select>
                            </div>


                        </div>


                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>Amount</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" autocomplete="off" required placeholder="Enter Amount" id="amount" name="amount"
                                           value=""/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label>Remarks</label>
                                <div class="input-group">
                                    <textarea name="remarks" required class="form-control" id="" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="kt-radio-inline">
                                    <label id="kt-checkbox" class="kt-checkbox">
                                        <input type="checkbox" name="terms" value="" required> I have read loan's terms and condition
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                               <span id="termAndCondition" style="color:#2dbdb6"></span>
                            </div>
                        </div>


                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                    </div>
                </form>



            </div>
        </div>

    </div>

    <!-- end:: Content -->
@endsection


@push('js')

    <script !src="">

        $(document).on('change', '#loan_type', function()
        {
            var id = $(this).val();
            $('#termAndCondition').html('');
            $("#interval").html("");
            $.ajax({
                url: "{{ route('loan.term.condition') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}","id": id},
                success: function(data) {
                    var result = JSON.parse(data);
                    $('#termAndCondition').html(result.content);
                    $('#amount').attr('max', result.max_amount);

                    for(var i=1; i <(result.interval+1); i++)
                    {
                        $("#interval").append(new Option(i, i));
                    }

                }
            });
        });

    </script>

@endpush



