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
                            Edit Request Document Setup Template
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
                <form action="{{ route('admin.request.doc.setup.update', ['id'=> $activeRow->id]) }}" method="POST" id="requestDocTemplate">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Select Document Type</label>
                            <select name="type_id" class="form-control" id="documentType">
                                <option value="">Select Document Type</option>
                                @foreach($docTypes as $docType)
                                <option {{ ($activeRow->type_id == $docType->id)?'selected="selected"':'' }} value="{{ $docType->id }}">{{ $docType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">

                            <textarea name="content_text" id="" class="textarea" cols="30" rows="100">{{ $activeRow->content }}</textarea>

                        </div>
                    </div>
                    <!--end::Section-->

                   <div class="form-group">
                       <button type="submit" class="btn btn-outline-primary" id="generate-btn" data-toggle="modal" data-target=".bd-example-modal-lg">Update</button>
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

        $('.textarea').ckeditor();


        $(document).on('click', '#generate-btn', function (ev)
        {
            ev.preventDefault();
            var documentType = $('#documentType').val();
            var content = CKEDITOR.instances.content_text.getData();
            if( content === "" || documentType === ""){
                Swal.fire({
                    title: 'Fill up all required fields',
                    type: 'warning',
                    showConfirmButton: false,
                    showCancelButton: true,
                });
            }else{
                $('#requestDocTemplate').submit();
            }
        });

    </script>
@endpush
