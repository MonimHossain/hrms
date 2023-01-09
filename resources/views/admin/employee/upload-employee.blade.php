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
                                            Upload Employee from CSV file
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                        <span style="margin-top:20px;" class="float-right">
                            <a href="{{ asset('hrmsDocs/csv/sample_emp_data_upload_format.csv') }}" class="">Employee Format Download&nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        </span>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="{{ route('employee.bulk.upload.view') }}">
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="alert alert-warning">
                                Upload max 100 employees at a time.
                            </div>
                            {{-- <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Employee File Upload</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" onchange="getFilePath()" name="file">
                                        <label class="custom-file-label selected" style="text-align: left" for="customFile" id="customFileLabel"></label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="file">File</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" onchange="getFilePath()" name="file">
                                        <label class="custom-file-label selected" style="text-align: left" for="customFile" id="customFileLabel"></label>
                                    </div>
                                    @error('file')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
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
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-9 ">
                                        <button type="submit" class="btn btn-brand">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->

                    {{-- show upload error --}}
                    @if ($errors->any())
                    <div class="kt-portlet__body">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('js')
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
    </script>
    <script>
        $(".division").on('change', function () {
            let divisionID = $(this).val();
            let url = '{{ route("get.center",':divisionID' ) }}';
            url = url.replace(':divisionID', divisionID);
            let that = $(this);
            axios.get(url)
                .then(function (response) {
                    // handle success
                    $(".center").empty();
                    $(".center").append('<option value="">Select Center</option>');
                    $.each(response.data, function(id, value){
                        $(".center").append('<option value="'+ value.id +'">'+ value.center +'</option>')
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    $(".center").empty();
                    $(".center").append('<option value="">Select Center</option>')
                })
        });
    </script>
@endpush
