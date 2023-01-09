@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Appraisal KPI Percentage Setting
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->

                    @php
                        $status = ['Incomplete', 'Complete'];
                        $icon = ['<i class="text-danger fa fa-times"></i>', '<i class="text-success fa fa-check"></i>']
                    @endphp

                    <div class="kt-portlet__body">

                        <form class="kt-form" action="{{ route('own.leading.evaluation.list') }}" method="GET">
                            <div class="row">

                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label>Evaluation</label>
                                        <div class="input-group">
                                            <select name="evaluation" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($evaluationList as $key=> $row)
                                                    <option value="{{ $row->id }}">{{ ucwords($row->name) }}</option>
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
                        <div class="row">
                            <table class="table table-responsive">
                                <tr>
                                    <th>#SI</th>
                                    <th>Team Name</th>
                                    <th>Team Lead Name</th>
                                    <th>Status</th>
                                </tr>
                                @foreach($teamEvaluationStatus as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->team->name }}</td>
                                    <td>
                                            {{ $value->team->leader->FullName ?? '' }}
                                    </td>
                                    <td>{!! $icon[$value->lead_status] !!} &nbsp; {{ $status[$value->lead_status] }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
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

        $(document).on('change', '#reward', function () {
            if($("#reward option:selected" ).val() != '-1'){
                $('#other').hide();
            }else{
                $('#other').show();
            }
        });

    </script>

@endpush
