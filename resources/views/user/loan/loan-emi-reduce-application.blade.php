@extends('layouts.container')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                    <h3 class="kt-portlet__head-title">
                        EMI Reduce Application
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form class="kt-form" action="{{ route('loam.emi.reduce.application.store') }}" method="POST">
                    @csrf

                    <div class="kt-portlet__body">


                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label>Ref. No.</label>
                                    <select name="reference_id" id="reference_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($ref as $row)
                                            <option value="{{ $row->id  }}">{{ $row->reference_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label>Remarks</label>
                                <div class="input-group">
                                    <textarea name="remarks" required class="form-control" id="" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- end:: Content -->
@endsection

@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endpush
