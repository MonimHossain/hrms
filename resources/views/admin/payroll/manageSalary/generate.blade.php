@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-sm-12">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Generate Salary - {{ date('M, Y') }} {{-- TODO generated date month not current --}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table text-center">
                            <tr>
                                <th>
                                    Emp. Type
                                </th>
                                <th>
                                    Total Employees
                                </th>
                                <th>
                                    Salary Generated
                                </th>
                                <th>
                                    Not Generated
                                </th>
                                <th>
                                    Salary Hold
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            @foreach($employmentTypeData as $key=>$empType)
                                @if ($key == \App\EmploymentType::find(Request::get('employment_type_id'))->type)
                                <tr>
                                    <td>
                                        {{ $key }}
                                    </td>
                                    <td>
                                        {{ $empType }}
                                    </td>
                                    <td>
                                        {{ $salary_list[$key] }}
                                    </td>
                                    <td>
                                        {{ $empType - $salary_list[$key] }} <br>
                                        <small><a data-toggle="modal" data-target="#missingSalaryGen" href="#" class="text-sm">(Show missing)</a></small>
                                    </td>
                                    <td>
                                        {{ $hold_list[$key] }}
                                    </td>
                                    <td>
                                        @if($salary_clearance[$key] == false)
                                            @if($salary_list[$key] > 0)
                                                <span class="badge badge-success">Generated</span>
                                            @else
                                                <span class="badge badge-danger">Not generated</span>
                                            @endif
                                        @else
                                            <span class="badge badge-success">Ready for dispatch</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($salary_clearance[$key] == false)
                                            @if($salary_list[$key] > 0)
                                                {{-- <a href="#" class="btn btn-primary btn-sm" id="regenSalary">
                                                    {{ 'Re-generate' }}
                                                </a>
                                                <a href="{{ route('clearance.emp.salary', [$key]) }}" class="btn btn-success btn-sm">
                                                    Clearance
                                                </a> --}}
                                                {{-- <a href="{{ route('export.emp.salary', [$key]).'?'.Request::getQueryString() }}" class="btn btn-primary btn-sm">
                                                    Download
                                                </a> --}}
                                                <a href="{{ route('generate.emp.salary', [$key]).'?'.Request::getQueryString() }}" class="btn btn-primary btn-sm generateSalary">
                                                    {{ 'Re-generate' }}
                                                </a>
                                            @else
                                                <a href="{{ route('generate.emp.salary', [$key]).'?'.Request::getQueryString() }}" class="btn btn-primary btn-sm generateSalary">
                                                    {{ 'Generate' }}
                                                </a>
                                            @endif
                                        @else
                                            <a class="btn btn-primary btn-sm" href="{{ route('export.emp.salary', [$key]).'?'.Request::getQueryString() }}">Download</a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>


                {{-- generated salary data view --}}
                @if ($generated_salary->count())
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Generate Salary Data - {{ date('M, Y') }} {{-- TODO generated date month not current --}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered">
                            <tr>
                                <th>
                                    Employee
                                </th>
                                <th>
                                    Emp. Type
                                </th>
                                <th>
                                    Month
                                </th>
                                <th>
                                    Payment Type
                                </th>
                                <th>
                                    @if (Request::get('employment_type_id') == \App\Utils\EmploymentTypeStatus::HOURLY)
                                        Rate
                                    @else 
                                        Gross
                                    @endif
                                </th>
                                <th>
                                    Payable
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            @foreach($generated_salary as $salary)
                                <?php
                                    if(!$salary->employee){
                                        dd($salary);
                                    }
                                ?>
                                <tr>
                                    <td>
                                        {{ $salary->employee ? $salary->employee->employer_id : '' }} - {{ $salary->employee ? $salary->employee->FullName : '' }}
                                    </td>
                                    <td>
                                        {{ $salary->employee ? $salary->employee->employeeJourney->employmentType->type : ''}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($salary->month)->format('M Y') }}
                                    </td>
                                    <td>
                                        {{ $salary->employee ? $salary->employee->individualSalary->paymentType->type : '' }}
                                    </td>
                                    <td>
                                        {{ $salary->gross_salary }}
                                    </td>
                                    <td>
                                        {{ $salary->payable_amount }}
                                    </td>
                                    <td>
                                        @if($salary->is_hold == 0)
                                        <span class="kt-badge kt-badge--success bold kt-badge--inline kt-badge--pill">Payable</span>
                                        @elseif($salary->is_hold == 1)
                                        <span class="kt-badge kt-badge--warning bold kt-badge--inline kt-badge--pill">Hold</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a title="Pay Slip" data-toggle="modal" data-target="#kt_modal" href="#" action="{{ route('paySlip.emp.view', ['id'=>$salary->id, 'type'=> $salary->employment_type_id]) }}" class="globalModal"><i class="flaticon2-document"  data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="Pay Slip"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $generated_salary->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="salaryReGen">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Regenerate Salary</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('regenerate.salary') }}" method="post">
                    @csrf
                    <label for="">Employee ID</label>
                    <input required type="text" name="employee_id" id="" class="form-control"> <br>
                    <input type="submit" value="Re-generate" class="btn btn-success btn-sm">
                </form>
            </div>

        </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="missingSalaryGen">
        <div class="modal-dialog">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Salary generate faild list</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="exportTable">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Joining Date</th>
                                <th>Last Working Date</th>
                                <th>Employment Type</th>
                                <th>Employee Status</th>
                            </tr>
                        </thead>        
                        <tbody>
                            @foreach($missing_employee_list as $employee)
                                <tr>
                                    <td>{{ $employee->employer_id }}</td>
                                    <td>{{ $employee->FullName }}</td>
                                    <td>{{ $employee->employeeJourney->doj  ?? '' }}</td>
                                    <td>{{ $employee->employeeJourney->lwd  ?? '' }}</td>
                                    <td>{{ $employee->employeeJourney->employmentType->type  ?? '' }}</td>
                                    <td>{{ $employee->employeeJourney->employeeStatus->status  ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>  
                    </table>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
    
        </div>
        </div>
    </div>


    {{-- invoice modal --}}
    <div class="modal fade" id="invoice">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Salary Statement</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="overflow-hidden">
                    <div class=" p-0">
                        <!-- begin: Invoice-->
                        <!-- begin: Invoice header-->
                        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0 invoice-body">
                            <div class="col-md-11">
                                {{-- <img alt="Logo" src="http://localhost:8000/assets/media/company-logos/logo-2.png"> --}}
                                <div class="d-flex justify-content-between pb-20 pb-md-10 flex-column flex-md-row">
                                    <h3 class="display-4 font-weight-boldest mb-10">PAYSLIP</h3>
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <!--begin::Logo-->
                                        <a href="#" class="mb-5">
                                            <img src="{{ asset('/assets/media/company-logos/logo-2.png') }}" alt="">
                                        </a>
                                        <!--end::Logo-->
                                        <span class=" d-flex flex-column align-items-md-end opacity-70">
                                            <span>Nitol Niloy Tower (Level 8), Nikunja C/A, Airport Road</span>
                                            <span>Dhaka-1229</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="border-bottom w-100 mt-5"></div>
                                <div class="d-flex justify-content-between pt-5 pb-5">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">DATE</span>
                                        <span class="opacity-70">{{ now()->toDateString() }}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                                        <span class="opacity-70">GS 000014</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">INVOICE TO.</span>
                                        <span class="opacity-70">Md. Mahmudul Hasan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice header-->

                        <!-- begin: Invoice body-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-11">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                                                <th class="text-right font-weight-bold text-muted text-uppercase">Percent</th>
                                                <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-boldest">
                                                <td class="pl-0 pt-7">Basic Salary</td>
                                                <td class="text-right pt-7">55%</td>
                                                <td class="text-danger pr-0 pt-7 text-right">35,750.00</td>
                                            </tr>
                                            <tr class="font-weight-boldest border-bottom-0">
                                                <td class="border-top-0 pl-0 py-4">Home Allowance</td>
                                                <td class="border-top-0 text-right py-4">27.5%</td>
                                                <td class="text-danger border-top-0 pr-0 py-4 text-right">17,875.00</td>
                                            </tr>
                                            <tr class="font-weight-boldest border-bottom-0">
                                                <td class="border-top-0 pl-0 py-4">Conveyance Allowance</td>
                                                <td class="border-top-0 text-right py-4">9%</td>
                                                <td class="text-danger border-top-0 pr-0 py-4 text-right">5,850‬.00</td>
                                            </tr>
                                            <tr class="font-weight-boldest border-bottom-0">
                                                <td class="border-top-0 pl-0 py-4">Medical Allowance</td>
                                                <td class="border-top-0 text-right py-4">8.5%</td>
                                                <td class="text-danger border-top-0 pr-0 py-4 text-right">5,525.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice body-->

                        <!-- begin: Invoice footer-->
                        <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-11">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold text-muted  text-uppercase">BANK</th>
                                                <th class="font-weight-bold text-muted  text-uppercase">ACC.NO.</th>
                                                <th class="font-weight-bold text-muted  text-uppercase">DUE DATE</th>
                                                <th class="font-weight-bold text-muted  text-uppercase">Gross Salary</th>
                                                <th class="font-weight-bold text-muted  text-uppercase">Payable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-bolder">
                                                <td>Eastern Bank Ltd.</td>
                                                <td>12345678909</td>
                                                <td>May 07, 2020</td>
                                                <td class="text-danger font-size-h3 font-weight-boldest">65000.00</td>
                                                <td class="text-danger font-size-h3 font-weight-boldest">53657.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice footer-->

                        <!-- begin: Invoice action-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-11">
                                <div class="d-flex justify-content-between">
                                    {{-- <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button> --}}
                                    <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice action-->

                        <!-- end: Invoice-->
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>
@endsection


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <style>


        /* @media print
        {
            body * { visibility: hidden; }
            #printcontent * { visibility: visible; }
            #printcontent { position: absolute; top: 40px; left: 30px; }
        } */
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">    
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    {{-- <script>
        function printElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById('invoice-body');

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            window.print();
        }
    </script> --}}

    <script>
        $(document).ready(function(){
            $("#regenSalary").click(function(){
                $("#salaryReGen").modal();
            });
        });
    </script>

    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>


    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>

    <script>

        function addSelect2Ajax($element, $url, $changeCallback, data) {
            var placeHolder = $($element).data('placeholder');

            if (typeof $changeCallback == 'function') {
                $($element).change($changeCallback)
            }

            // $($element).hasClass('select2') && $($element).select2('destroy');

            return $($element).select2({
                allowClear: true,
                width: "resolve",
                ...data,
                placeholder: placeHolder,
                ajax: {
                    url: $url,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        }
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj, index) {
                                return {id: obj.id, text: obj.name};
                            })
                        };
                    }
                }
            });

        }

        addSelect2Ajax('#employee_id', "{{route('employee.all')}}");


        $(document).ready(function(){
            $('.generateSalary').on('click', function(e){
                e.preventDefault();
                let url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to generate salary",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Generate!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = url;
                        // Swal.fire(
                        //     'Generated',
                        //     'Salary generated successfully',
                        //     'success'
                        // )
                    }
                });
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#exportTable').DataTable( {
                dom: 'Bftiprl',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                "searching": true
            } );
        } );
    </script>


@endpush
