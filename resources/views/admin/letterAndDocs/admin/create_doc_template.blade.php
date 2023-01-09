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
                            Create Document Template
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
                <form action="{{ route('save.document.template') }}" method="post" id="documentTemplate">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Document Name *</label>
                            <input type="text" name="name" class="form-control" id="documentName">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Select Document Type *</label>
                            <select name="type_id" class="form-control" id="documentType">
                                <option value="">Select Type</option>
                                @foreach($docTypes as $docType)
                                <option value="{{ $docType->id }}">{{ $docType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <textarea name="content_text" id="" class="textarea" cols="30" rows="100"></textarea>
                        </div>
                    </div>
                    <!--end::Section-->

                   <div class="form-group">
                       <button type="submit" class="btn btn-outline-primary" id="generate-btn" data-toggle="modal" data-target=".bd-example-modal-lg">Save</button>
                   </div>
                </form>

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

        //Load view load by doc type
        CKEDITOR.replace( 'content_text' );


        $(document).on('click', '#generate-btn', function (ev)
        {
            ev.preventDefault();
            var name = $('#documentName').val();
            var documentType = $('#documentType').val();
            var content = CKEDITOR.instances.content_text.getData();
            if( content === "" || name === "" || documentType === ""){
                Swal.fire({
                    title: 'Fill up all required fields',
                    type: 'warning',
                    showConfirmButton: false,
                    showCancelButton: true,
                });
            }else{
                $('#documentTemplate').submit();
            }
        });


    </script>
@endpush
