@extends('layouts.container')

@section('content')



<div class="kt-content  kt-grid__item   id" id="kt_content">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Employee Journey
                </h3>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Form-->
                    <form class="kt-form center-division-form" action="{{ route('employee.export') }}" method="POST">
                        @csrf

                        <div class="kt-portlet__body">

                            <div class="form-group row @error('division_id') validated @enderror @error('center_id') validated @enderror ">
                                <div class="col-sm-4">
                                    <label for="division">Division</label>
                                    <select class="form-control division" id="" name="division_id" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('division_id')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="center">Center</label>
                                    <select class="form-control center" id="" name="center_id" required>
                                        <option value="">Select Center</option>
                                    </select>
                                    @error('center_id')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="center">Employment Type </label>
                                    <select class="form-control" id="" name="employment_type_id" required>
                                        <option value="">Select Type</option>
                                        @foreach ($employmentTypes as $item)
                                            <option value="{{ $item->id }}" {{ (old('employment_type_id') == $item->id) ? 'selected' : '' }}>{{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                    @error('employment_type_id')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Export</button>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
<script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

<script>
    $(".division").on('change', function () {
        let divisionID = $(this).val();
        let url = '{{ route("get.center",':divisionID' ) }}';
        url = url.replace(':divisionID', divisionID);
        let that = $(this);
        axios.get(url)
            .then(function (response) {
                // handle success
                that.closest('.center-division-form').children().find(".center").empty();
                that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>');
                $.each(response.data, function(id, value){
                    that.closest('.center-division-form').children().find(".center").append('<option value="'+ value.id +'">'+ value.center +'</option>')
                });
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                that.closest('.center-division-form').children().find(".center").empty();
                that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>')
            })
    });

    $(".center").on('change', function () {
        let centerID = $(this).val();
        let url = '{{ route("get.department",':centerID' ) }}';
        url = url.replace(':centerID', centerID);
        let that = $(this);
        axios.get(url)
            .then(function (response) {
                // handle success
                that.closest('.center-division-form').children().find(".department").empty();
                that.closest('.center-division-form').children().find(".department").append('<option value="">Select Department</option>');
                $.each(response.data, function(id, value){
                    that.closest('.center-division-form').children().find(".department").append('<option value="'+ value.id +'">'+ value.name +'</option>')
                });
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                that.closest('.center-division-form').children().find(".department").empty();
                that.closest('.center-division-form').children().find(".department").append('<option value="">Select Department</option>')
            })
    });
</script>
@endpush




