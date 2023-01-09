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
                                Closing application status
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('admin.clearance.status.report')  }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Select Date</label>
                                            <div class="input-group date"><input required="" type="text" readonly="readonly" placeholder="Select date" id="month-pick" name="month" value="" class="form-control" aria-invalid="false">
                                                <div class="input-group-append"><span class="input-group-text"><i class="la la-calendar-check-o"></i></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee" class="form-control kt-selectpicker" id="employeeList" data-live-search="true">
                                                    <option value="">Select Employee</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Select Process</label>
                                            <div class="input-group">
                                                <select name="process" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($processes as $key=> $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                @if(!empty($result))
                                <table style="overflow-x:auto;" class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px !important;">#</th>
                                        <th>Employee</th>
                                        <th>Final Closing</th>
                                        <th>Last Working Day</th>
                                        <th>Admin</th>
                                        <th>IT</th>
                                        <th>Accounts</th>
                                        <th>HR</th>
                                        <th>Own Department</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($result as $row)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $row['employee'] ?? '' }}</td>
                                        <td>{!! $row['final'] ?? '' ; !!}</td>
                                        <td>{{ $row['lwd'] ?? '' }}</td>
                                        <td>{!! $row['admin'] ?? ''; !!} </td>
                                        <td>{!! $row['it'] ?? ''; !!}</td>
                                        <td>{!! $row['accounts'] ?? ''; !!}</td>
                                        <td>{!! $row['hr'] ?? ''; !!}</td>
                                        <td>{!! $row['own_dept'] ?? ''; !!}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @endif
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
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>
    <script>
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


        //Employee List
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

        addSelect2Ajax('#employeeList', "{{route('employee.all')}}");

        //data table scroll
        $(document).ready(function() {
            $('#lookup').dataTable({
                "scrollX": true
            });
        } );
    </script>
@endpush








