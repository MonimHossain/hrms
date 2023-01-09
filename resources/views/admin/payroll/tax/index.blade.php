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
                                Tax History
                            </h3>
                        </div>
                        <div class="row">
                            <a href="{{ asset('hrmsDocs/csv/tax.csv') }}" style="position: relative; top: 33px; right: 10px">Download File Format  |</a>
                            <a href="#" class="pull-right globalModal" style="vertical-align: middle; height: 38px; position: relative; top: 33px" title="Tax Upload" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.tax.upload') }}">Previous Tax Upload</a>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <div class="row">
                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-users-cog text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Tax Enable Employee</p>
                                                        <p class="card-title">{{ $totalEmployeePfActive->groupBy('employee_id')->count() }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-money-bill text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Tax Enable Amount</p>
                                                        <p class="card-title">{{ $totalEmployeePfActive->sum('amount') }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-users-cog text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Tax Disable Employee</p>
                                                        <p class="card-title">{{ $totalEmployeePfInactive->groupBy('employee_id')->count() }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-money-bill text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Tax Disable Amount</p>
                                                        <p class="card-title">{{ $totalEmployeePfInactive->sum('amount') }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="paper col-sm-3">
                                                    <div class="card card-stats">
                                                        <div class="card-body ">
                                                            <div class="row">
                                                                <div class="col-5 col-md-4">
                                                                    <div class="icon-big text-center icon-warning"><i
                                                                            class="fas fa-users-cog text-theme-2"></i></div>
                                                                </div>
                                                                <div class="col-7 col-md-8">
                                                                    <div class="numbers"><p class="card-category">Functional</p>
                                                                        <p class="card-title">139</p>
                                                                        <p></p></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table-bordered text-primary" width="100%">
                                                    <tr>
                                                        <th colspan="2">PF Active Employee</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Employee</td>
                                                        <td>Amount</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $totalActive['employee'] ?? 0 }}</td>
                                                        <td>{{  $totalActive['amount'] ?? 0 }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}

                                <!-- <div class="col-md-2"><div class="dbox dbox--color-3"><div class="dbox__body"><span class="dbox__count">{{ $totalActive['employee'] ?? '' }}</span> <span class="dbox__title">PF Active Employee</span></div></div></div>
                                <div class="col-md-2"><div class="dbox dbox--color-3"><div class="dbox__body"><span class="dbox__count">{{ $totalActive['amount'] ?? '' }}</span> <span class="dbox__title">PF Active Amount</span></div></div></div>
                                <div class="col-md-2"><div class="dbox dbox--color-3"><div class="dbox__body"><span class="dbox__count">{{ $totalInactive['employee'] ?? '' }}</span> <span class="dbox__title">PF Inactive Employee</span></div></div></div>
                                <div class="col-md-2"><div class="dbox dbox--color-3"><div class="dbox__body"><span class="dbox__count">{{ $totalInactive['amount'] ?? '' }}</span> <span class="dbox__title">PF Inactive Amount</span></div></div></div> -->

                            </div>

                            <form class="kt-form" action="{{ route('payroll.tax.index')  }}" method="GET">

                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control month-pick" readonly autocomplete="false"
                                                       placeholder="Select Date"
                                                       id="" name="date_from" value="{{ Request::get('date_from') }}"/>
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control month-pick" readonly autocomplete="false"
                                                       placeholder="Select Date"
                                                       id="" name="date_to" value="{{ Request::get('date_to') }}"/>
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  placeholder="Employee ID" name="employee_id" value="{{ Request::get('employee_id') }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            
                            

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#enable" role="tab">Tax Enable Employee</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#disable" role="tab">Tax Disable Employee</a>
                                </li>
                            </ul>

                          


                             <div class="tab-content">
                                <div class="tab-pane active" id="enable" role="tabpanel">
                                    <div class="table-responsive">
                                    @if(sizeof($pfActive) !=  0)
                                        <table class="table table-striped table-nowrap mb-0" width="100%" id="lookup">
                                            <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Gross Salary</th>
                                                <th>Cumulative PF</th>
                                                <th>Payable PF</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pfActive as $row)
                                                <tr>
                                                    <td>{{ $row['employee_id'] ?? '' }}</td>
                                                    <td>{{ $row['name'] ?? '' }}</td>
                                                    <td>{{ $row['gross'] ?? '' }}</td>
                                                    <td>{{ $row['cumulative'] ?? '' }}</td>
                                                    <td>{{ $row['payable'] }} </td>
                                                    <td>
                                                        <a href="#" class="btn-sm btn-info pull-right globalModal" title="View Details" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.tax.fund.details', ['id'=>$row['emp_id']]) }}">View Details&nbsp;</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>


                                <div class="tab-pane" id="disable" role="tabpanel">
                                    <div class="table-responsive">
                                    @if(sizeof($pfInactive) != 0)
                                        <table class="table table-striped table-nowrap mb-0" width="100%" id="lookup">
                                        <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Gross Salary</th>
                                            <th>Cumulative PF</th>
                                            <th>Payable PF</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pfInactive as $row)
                                            <tr>
                                                <td>{{ $row['employee_id'] ?? '' }}</td>
                                                <td>{{ $row['name'] ?? '' }}</td>
                                                <td>{{ $row['gross'] ?? '' }}</td>
                                                <td>{{ $row['cumulative'] ?? '' }}</td>
                                                <td>{{ $row['payable'] }} </td>
                                                <td>
                                                    <a href="#" class="btn-sm btn-info pull-right globalModal" title="View Details" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.tax.fund.details', ['id'=>$row['emp_id']]) }}">View Details&nbsp;</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection




@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

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
        $('.month-pick').datepicker({
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

        $(document).on('change', '#reward', function () {
            if($("#reward option:selected" ).val() != '-1'){
                $('#other').hide();
            }else{
                $('#other').show();
            }
        });

    </script>

@endpush






