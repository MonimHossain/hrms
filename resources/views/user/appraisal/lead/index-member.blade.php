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
                             Lead Evaluation History
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            @php

                                $text = ['p'=>'Pending', 'a'=>'Accepted', 'r'=>'Rejected'];
                                $color = ['p'=> 'text-warning', 'a'=>'text-success', 'r'=>'text-danger'];

                            @endphp

                            <div class="table-responsive">
                                <table class="table table-striped custom-table" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Team Member</th>
                                        <th>Designation</th>
                                        <th>Employee Status</th>
                                        <th>Evaluation Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($members as $member)
                                    <tr>
                                        <td>{{ $member->createdBy->employer_id }} - {{ $member->createdBy->FullName }}</td>
                                        <td>{{ $member->createdBy->employeeJourney->designation->name ?? null }}</td>
                                        <td>
                                            <span class="{{ $color[$member->approved_by_employee] }}">{{ $text[$member->approved_by_employee] }}</span>
                                            (<span class="text-small">{{ \Carbon\Carbon::parse($member->updated_at)->format('d M, Y | H:i:s') }}</span>)
                                        </td>
                                        <td>
                                            {{--<a href="" style="position: relative; top: 5px" title="Team Member's Evaluation"Save form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.lead.evaluation.review.member', ['employeeId'=>$member->createdBy->id, 'evaluationId'=> $evaluation]) }}" class="text-primary custom-btn globalModal">
                                                <span class="btn btn-outline-primary">Evaluate</span>
                                            </a>--}}

                                            <a href="" style="position: relative; top: 5px" title="Team Member's Evaluation"Save form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.lead.evaluation.review.member', ['mstId'=>$member->id]) }}" class="text-primary custom-btn globalModal">
                                                <span class="btn btn-outline-{{ ($member->lead_id != null)?'info':'success' }}">Evaluate</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script !src="">
        $('.textarea').ckeditor();

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
    </script>
@endpush




