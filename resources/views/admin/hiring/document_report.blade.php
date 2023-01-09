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
                                Document History
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        <form action="{{ route('admin.letter.document.report') }}" method="psot">

                            <div class="row">
                                <div class="form-group col-md-2"><label>Select Month-Year</label>
                                    <div class="input-group date"><input type="text" readonly="readonly"
                                                                         placeholder="Select date" id="month-pick"
                                                                         name="monthYear" value="{{ Request::get('start_date') }}" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text"><i
                                                    class="la la-calendar-check-o"></i></span></div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Select Document Type</label>
                                    <select name="docType" class="form-control kt-selectpicker" data-live-search="true">
                                        <option value="">Select Type</option>
                                        @foreach($docTypes as $docType)
                                            <option {{ ($docType->id == Request::get('doc_type')) ? 'selected':'' }} value="{{ $docType->id }}">{{ $docType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Select Department</label>
                                    <select name="department" class="form-control kt-selectpicker" data-live-search="true">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $depart)
                                            <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Select Process</label>
                                    <select name="process" class="form-control kt-selectpicker" data-live-search="true">
                                        <option value="">Select Process</option>
                                        @foreach($processes as $process)
                                            <option value="{{ $process->id }}">{{ $process->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="submit" id="search-btn" value="Search" class="btn btn-outline-primary">
                                </div>
                            </div>
                        </form>

                        <div class="filter_keys">
                        @if(Request::get('monthYear') == 'null')
                            <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Month Year</strong>: Not Selected</span>
                        @else
                            <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Month Year</strong>: {{ Request::get('monthYear') }}</span>
                        @endif
                        @if(Request::get('docType'))
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Document Type</strong>: {{ Request::get('docType') }}</span>
                        @endif
                        @if(Request::get('department'))
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Department</strong>: {{ Request::get('department') }}</span>
                        @endif
                        @if(Request::get('process'))
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Process</strong>: {{ Request::get('process') }}</span>
                        @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Request</th>
                                    <th>Generate</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $new_total =0;
                                    $done_total =0;
                                    $gnd_total =0;
                                @endphp
                                @if($documentResult)
                                    @foreach($documentResult as $row )
                                        @php
                                        $new_total += $row->new_cnt;
                                        $done_total += $row->done_cnt;
                                        $gnd_total += $row->total_cnt;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $row->document->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $row->new_cnt }}
                                            </td>
                                            <td>
                                                {{ $row->done_cnt }}
                                            </td>
                                            <td>
                                                {{ $row->total_cnt }}
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <th>
                                            Grand Total
                                        </th>
                                        <th>
                                            {{ $new_total }}
                                        </th>
                                        <th>
                                            {{ $done_total }}
                                        </th>
                                        <th>
                                            {{ $gnd_total }}
                                        </th>

                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>




@endsection
@include('layouts.lookup-setup-delete')

@push('css')
    <style>
        div {
            text-align: justify;
            text-justify: inter-word;
        }

        .textarea_hidden {
            visibility: hidden;
            display: none;
        }
        td{
            padding: 5px;
        }
    </style>
@endpush


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
    </script>
@endpush



