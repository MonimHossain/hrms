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
                            Request Document Setup Template
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Document Header Name</label>
                            <p><b>{{ $documentHeaders->name }}</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Document Header File</label>
                            <img style="border: 1px solid #6b6f8d" src="{{ asset('storage/hrmsDocs/template/'. $documentHeaders->header_path) }}" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Document Footer File</label>
                            <img style="border: 1px solid #6b6f8d" src="{{ asset('storage/hrmsDocs/template/'. $documentHeaders->footer_path) }}" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>


                    </div>


                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>


{{--Start Modal here--}}


{{--    End modal here--}}


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


@push('js')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

    <script>

        $('.textarea').ckeditor();


        {{--//Load view load by doc type--}}
        {{--$(document).on('click', '#search-btn', function()--}}
        {{--{--}}
        {{--    var type = $('#docType').val();--}}
        {{--    var employee = $('#employer_id').val();--}}
        {{--    $.ajax({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        },--}}
        {{--        url: "{{ route('load.doc.type.page') }}",--}}
        {{--        type: 'POST',--}}
        {{--        data: {"type": type, "employer_id": employee},--}}
        {{--        success: function(data) {--}}
        {{--            CKEDITOR.instances.editor1.setData(data);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}


        //Get all Query data by ajax
        {{--$(document).on('click', '#saveAndPrint', function()--}}
        {{--{--}}
        {{--    var employee = $('#employer_hide_id').val();--}}
        {{--    var html = $('#textContent').html();--}}
        {{--    var content = JSON.stringify(html);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('save.letter.and.documents') }}",--}}
        {{--        type: 'POST',--}}
        {{--        data: {"_token": "{{ csrf_token() }}","employee": employee, "content": content},--}}
        {{--        success: function(data) {--}}
        {{--            console.log(data);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}


        // $(document).on('click', '#generate-btn', function ()
        // {
        //     var data = CKEDITOR.instances.editor1.getData();
        //     var employeeId = $('#employer_id').val();
        //
        //     $('.employer_hide_id').val(employeeId);
        //     $('.textContent').html(data);
        //     $('.textarea_hidden').text(data);
        // })


    </script>
@endpush
