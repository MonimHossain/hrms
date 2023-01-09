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
                                Salary Settings
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        <form class="kt-form" action="{{ route('salarySettings') }}" method="POST">
                            @csrf
                            <div id="kt_repeater_2">
                                <div class="form-group form-group-last row" id="kt_repeater_2">
                                    <label class="col-lg-2 col-form-label"><b>Salary Breakdown</b>:</label>

                                    <div data-repeater-list="salary_breakdown" class="col-lg-12">
                                        @foreach($salaryBreakdownSettings as $key => $item)
                                        <div data-repeater-item class="form-group row align-items-center">

                                            <div class="col-md-3">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Name:</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                        <input type="text" class="form-control" placeholder="Title" name="salary_breakdown[{{ $key }}][name]" value="{{ $item->name }}" >
                                                    </div>
                                                </div>
                                                <div class="d-md-none kt-margin-b-10"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Percentage:</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                        <input type="text" class="form-control" placeholder="Title" name="salary_breakdown[{{ $key }}][percentage]" value="{{ $item->percentage }}" >
                                                    </div>
                                                </div>
                                                <div class="d-md-none kt-margin-b-10"></div>
                                            </div>
{{--                                            <div class="col-md-2">--}}
{{--                                                <div class="kt-checkbox-list">--}}
{{--                                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-4">--}}
{{--                                                        <input type="checkbox" {{ ($item->is_basic) ? 'checked' : '' }}  name="salary_breakdown[{{ $key }}][is_basic]"> Is Basic?--}}
{{--                                                        <span></span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                                <div class="d-md-none kt-margin-b-10"></div>--}}
{{--                                            </div>--}}


{{--                                            <div class="col-md-3">--}}
{{--                                                <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">--}}
{{--                                                    <i class="la la-trash-o"></i>--}}
{{--                                                    Delete--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
{{--                                <div class="form-group form-group-last row">--}}
{{--                                    <div class="col-lg-4">--}}
{{--                                        <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">--}}
{{--                                            <i class="la la-plus"></i> Add--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <br>

                            <div class="kt-portlet__foot pl-0">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit"
                                                    class="btn btn-primary ">
                                                <i class="la la-edit"></i>
                                                save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!--end::Form-->

                    <div class="kt-portlet__body">


                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@include('layouts.lookup-setup-delete')

@push('library-js')
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>
@endpush
