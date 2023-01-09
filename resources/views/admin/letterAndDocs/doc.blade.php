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
                            Manage Letter and Document
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Select Document Type</label>
                            <select name="leaveType" class="form-control" id="docType">
                                <option value="">Select Type</option>
                                @foreach($docTypes as $docType)
                                <option value="{{ $docType->url }}">{{ $docType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Employee</label>
                            <select name="employer_id" class="form-control" id="employer_id">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->employer_id }}">{{ $employee->employer_id. ' '. $employee->FullName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>&nbsp;</label><br>
                            <input type="button" id="search-btn" value="Search" class="btn btn-outline-primary">
                        </div>
                    </div>
                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <textarea name="" id="" class="textarea" cols="30" rows="100" required></textarea>
                        </div>
                    </div>
                    <!--end::Section-->

                   <div class="form-group">
                       <button type="button" class="btn btn-outline-primary" id="generate-btn" data-toggle="modal" data-target=".bd-example-modal-lg">Generate and View</button>
                   </div>

                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>


{{--Start Modal here--}}

<div class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Letter and Document View</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table width="760" border="0" align="center" cellpadding="39" cellspacing="0">
                    <tbody>
                        <tr>
                            <td bgcolor="#FFFFFF" style="border:1px solid #d9d9d9">
                                <table width="700" bgcolor="#ffffff" cellspacing="0" border="0" cellpadding="0" style="width:620px;margin:0 auto">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="textContent"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" title="Close" class="btn btn-outline-primary" data-dismiss="modal">&nbsp;&nbsp;<i class="far fa-times-circle"></i></button>
                <form action="{{ route('save.letter.and.documents.print') }}" method="POST">
                    @csrf
                    <input name="employer_id" type="hidden" class="employer_hide_id" value="">
                    <textarea name="content_hidden" class="textarea_hidden">visiblity is hidden</textarea>
                    <button type="submit" target="_blank" id="saveAndPrint" title="Save and Print" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="fas fa-print"></i></button>
                </form>
                <form action="{{ route('save.letter.and.documents.pdf') }}" method="POST">
                    @csrf
                    <input name="employer_id" type="hidden" class="employer_hide_id" value="">
                    <textarea name="content_hidden" class="textarea_hidden">visiblity is hidden</textarea>
                    <button type="submit" id="saveAndPdf" title="Save and pdf Download" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="fas fa-file-pdf"></i></button>
                </form>
                <form action="{{ route('save.letter.and.documents.word') }}" method="POST">
                    @csrf
                    <input name="employer_id" type="hidden" class="employer_hide_id" value="">
                    <textarea name="content_hidden" class="textarea_hidden">visiblity is hidden</textarea>
                    <button type="submit" id="saveAndWord" title="Save and world Download" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="far fa-file-word"></i></button>
                </form>
                <form action="{{ route('save.letter.and.documents.email') }}" method="POST">
                    @csrf
                    <input name="employer_id" type="hidden" class="employer_hide_id" value="">
                    <textarea name="content_hidden" class="textarea_hidden">visiblity is hidden</textarea>
                    <button type="submit" id="saveAndMail" title="Save and print" class="btn btn-outline-primary">&nbsp;&nbsp;<i class="fas fa-envelope-open-text"></i></button>
                </form>

            </div>
        </div>
    </div>
</div>

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
        //Load view load by doc type
        $(document).on('click', '#search-btn', function()
        {
            var type = $('#docType').val();
            var employee = $('#employer_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('load.doc.type.page') }}",
                type: 'POST',
                data: {"type": type, "employer_id": employee},
                success: function(data) {
                    CKEDITOR.instances.editor1.setData(data);
                }
            });
        });


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


        $(document).on('click', '#generate-btn', function ()
        {
            var data = CKEDITOR.instances.editor1.getData();
            var employeeId = $('#employer_id').val();

            $('.employer_hide_id').val(employeeId);
            $('.textContent').html(data);
            $('.textarea_hidden').text(data);
        })


    </script>
@endpush
