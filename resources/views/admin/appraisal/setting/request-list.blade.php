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
                                Employee Closing Request List
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <div class="table-responsive">
                                <label for="" class="text-primary">Team Lead</label>
                                <table class="table table-bordered table-striped custom-table table-nowrap mb-0" id="html_table">
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Department</th>
                                            <th>Applied At</th>
                                            <th>Status</th>
                                            <th>Application</th>
                                            <th>Action</th>
                                        </tr>
                                        @if(isset($closingApplicationForLead))
                                            @foreach($closingApplicationForLead as $close)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $close->employee->employer_id }} : {{ $close->employee->FullName }}
                                                </td>
                                                <td>
                                                    @foreach($close->employee->departmentProcess as $item)
                                                        {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                   {{ \Carbon\Carbon::parse($close->applied_at)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                     {{ _lang('employee-closing.teamLeadSupervisorStatus', $close->status) }}
                                                </td>
                                                <td>
                                                    {!! \Illuminate\Support\Str::limit($close->application, 50, '. . .') !!}
                                                </td>
                                                <td>
                                                    <a href="" style="position: relative; top: 5px" title="Approval Closing" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.closing.approval.lead.or.supervisor', ['id'=> $close->id, 'flag'=>'tl']) }}" class="text-primary custom-btn globalModal">
                                                        <span class="btn btn-outline-primary"><i class="fas fa-check-circle"></i></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                         @endif
                                </table>
                            </div>

                            <br>
                            <br>

                            <div class="table-responsive">
                                <label for="" class="text-primary">Supper Visor</label>
                                <table class="table table-bordered table-striped custom-table table-nowrap mb-0" id="html_table">
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Applied At</th>
                                        <th>Status</th>
                                        <th>Application</th>
                                        <th>Action</th>
                                    </tr>
                                    @if(isset($closingApplicationForSupervisor))
                                        @foreach($closingApplicationForSupervisor as $close)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $close->employee->employer_id }} : {{ $close->employee->FullName }}
                                                </td>
                                                <td>
                                                    @foreach($close->employee->departmentProcess as $item)
                                                        {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($close->applied_at)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                    {{ _lang('employee-closing.teamLeadSupervisorStatus', $close->status) }}
                                                </td>
                                                <td>
                                                    {!! \Illuminate\Support\Str::limit($close->application, 50, '. . .') !!}
                                                </td>
                                                <td>
                                                    <a href="" style="position: relative; top: 5px" title="Approval Closing" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.closing.approval.lead.or.supervisor', ['id'=> $close->id, 'flag'=>'sp']) }}" class="text-primary custom-btn globalModal">
                                                        <span class="btn btn-outline-primary"><i class="fas fa-check-circle"></i></span>
                                                </td>
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
