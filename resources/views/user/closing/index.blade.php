@extends('layouts.container')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Closing Application Status
                            </h3>
                        </div>

                        <a href="" style="position: relative; top: 5px" title="Closing Application Form" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.closing.create') }}" class="text-primary custom-btn globalModal">
                            <span class="btn btn-outline-primary">Apply</span>
                        </a>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <div class="table-responsive"><table class="table table-bordered table-striped custom-table table-nowrap mb-0">
                                        <tr>
                                            <th>#</th>
                                            <th>Applied At</th>
                                            <th>Last working day</th>
                                            <th>Clearance Status</th>
                                            <th>Final Close</th>
                                            <th>Evaluation</th>
                                        </tr>
                                        @if(isset($closingApplication))
                                            @foreach($closingApplication as $close)
                                            <?php
                                            /*Status*/
                                            $hr_status = $close->closingClearanceStatus->hr_status ?? 0;
                                            $it_status = $close->closingClearanceStatus->it_status ?? 0;
                                            $admin_status = $close->closingClearanceStatus->admin_status ?? 0;
                                            $accounts_status = $close->closingClearanceStatus->accounts_status ?? 0;
                                            $own_dept_status = $close->closingClearanceStatus->own_dept_status ?? 0;

                                            /*Remarks*/
                                            /*$hr_clearance = $close->closingClearanceStatus->hr_clearance ?? '';
                                            $it_clearance = $close->closingClearanceStatus->it_clearance ?? '';
                                            $admin_clearance = $close->closingClearanceStatus->admin_clearance ?? '';
                                            $accounts_clearance = $close->closingClearanceStatus->accounts_clearance ?? '';
                                            $own_dept_clearance = $close->closingClearanceStatus->own_dept_clearance ?? '';*/

                                            /*$checkPending = '<i class="text-warning fa fa-spinner fa-pulse" aria-hidden="true"></i>';*/
                                            $checkPending = '<i class="text-warning">Pending</i>';
                                            $checkYes = '<i class="text-primary fa fa-check"></i>';
                                            $checkNo = '<i class="text-danger fa fa-times"></i>';
                                            $selectStatusArray = [$checkPending, $checkYes, $checkNo];
                                            ?>
                                            <tr>
                                                <td rowspan="5">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td rowspan="5">
                                                    {{ \Carbon\Carbon::parse($close->lwd)->format('d M, Y') }}
                                                </td>
                                                <td rowspan="5">
                                                   {{ \Carbon\Carbon::parse($close->applied_at)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                    <p>Hr : <?php echo $selectStatusArray[$hr_status] ?></p>
                                                </td>
                                                {{--<td>
                                                    {!! \Illuminate\Support\Str::limit($hr_clearance, 50, '. . .') !!}
                                                </td>--}}
                                                <td rowspan="5">
                                                    {{ ($close->final_closing) ? 'Yes' : 'No' }}
                                                </td>
                                                <td rowspan="5">
                                                    @if(empty($close->exitInterviewEvaluation->application_id))
                                                   <a class="btn btn-outline-primary" href="{{ route('employee.exit.interview.create', ['id'=>$close->id]) }}">Give Exit Interview</a>
                                                    @else
                                                        <span>Done</span>
                                                    @endif
                                                </td>
                                            </tr>
                                                <tr>
                                                    <td>
                                                        <p>IT : <?php echo $selectStatusArray[$it_status] ?></p>
                                                    </td>
                                                    {{--<td>
                                                        {!! \Illuminate\Support\Str::limit($it_clearance, 100, '. . .') !!}
                                                    </td>--}}
                                                </tr>
                                                <tr>

                                                    <td>
                                                        <p>Admin : <?php echo $selectStatusArray[$admin_status] ?></p>
                                                    </td>
                                                    {{--<td>
                                                        {!! \Illuminate\Support\Str::limit($admin_clearance, 50, '. . .') !!}
                                                    </td>--}}
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Accounts : <?php echo $selectStatusArray[$accounts_status] ?></p>
                                                    </td>
                                                    {{--<td>
                                                        {!! \Illuminate\Support\Str::limit($accounts_clearance, 50, '. . .') !!}
                                                    </td>--}}
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Own Department : <?php echo $selectStatusArray[$own_dept_status] ?></p>
                                                    </td>
                                                    {{--<td>
                                                        {!! \Illuminate\Support\Str::limit($own_dept_clearance, 50, '. . .') !!}
                                                    </td>--}}
                                                </tr>
                                            @endforeach
                                         @endif
                                </table>

                            </div>
                        </div>
                    </div>
                    <!--end::Form-->


                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

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
       $('.kt-form').on('click', '.reset-button', function (e) {
           $('#team_lead_id').prop("selected", false);
           $('#employee_id').prop("selected", false);
           $('.date_from').val('');
           $('.date_to').val('');
       });


       $(document).on('change', '#team_lead_id', function()
       {
           var id = $(this).val();
           $.ajax({
               url: "{{ route('leave.employee.list') }}",
               type: 'POST',
               data: {"_token": "{{ csrf_token() }}","id": id},
               success: function(data) {
                    var result = JSON.parse(data);
                   $.each(result, function (i, value) {

                       var div_data = "<option value=" + value.id + ">" + value.first_name + "</option>";

                       $('#employee_id').hrml(div_data);

                   });
               }
           });
       });
    </script>
@endpush
