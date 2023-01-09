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
                                Details Log
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">


                                <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="">
                                            <thead>
                                            <tr>
                                                <th>Appraisal Year</th>
                                                <th>Employee</th>
                                                <th>Score</th>
                                                <th>Recommendation</th>
                                                <th>Comments</th>
                                                <th>Recommendation By</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($yearlyAppraisalChd as $value)
                                            <tr>
                                                <td>{{ $value->parent->year }}</td>
                                                <td>{{ $value->employee->employer_id }} - {{ $value->employee->FullName }}</td>
                                                <td>{{ $value->score ?? '' }}</td>
                                                <td>
                                                  @if(isset($value->recommendation_for))
                                                   @foreach ($value->recommendation_for as $val)
                                                    {{ _lang('recommendation-for.status.'.$val) }}
                                                    {!! "<br>" !!}
                                                    @endforeach
                                                   @endif
                                                </td>
                                                <td>{{ $value->comments ?? ''  }}</td>
                                                <td>{{ $value->recommendBy->employer_id ?? '' }} - {{ $value->recommendBy->FullName ?? ''  }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script !src="">
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
        // enable clear button
        $('.year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years'
        });

    </script>
@endpush




