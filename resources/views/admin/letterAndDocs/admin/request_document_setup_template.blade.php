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
                            List of Document Template
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
{{--                    <form action="{{ route('admin.document.template.search') }}" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label>Document Type</label>--}}
{{--                                <select name="search" class="form-control" id="docType">--}}
{{--                                    <option value="">Select Type</option>--}}
{{--                                    @foreach($docTypes as $docType)--}}
{{--                                        <option value="{{ $docType->id }}">{{ $docType->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>&nbsp;</label><br>--}}
{{--                                <input type="submit" id="search-btn" value="Search" class="btn btn-outline-primary">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <label>&nbsp;</label><br>--}}
{{--                                <a class="btn btn-outline-primary pull-right" href="{{ route('admin.document.template.create') }}">+ Create New</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                    <div class="row">
                        <div class="pull-left">
                            <label>&nbsp;</label><br>
                            @can(_permission(\App\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE))<a class="btn btn-outline-primary pull-right" href="{{ route('admin.request.doc.setup.create') }}">+ Create New</a>@endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable">
                            <thead>
                            <tr>
                                <th>Document Type</th>
                                <th>Created at</th>
                                <th>Created by</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($templates as $template)
                            <tr>
                                <td>
                                    {{ $template->document->name }}
                                </td>
                                <td>
                                    {{ $template->created_at }}
                                </td>
                                <td>
                                    {{ $template->employee->FullName ?? '' }}
                                </td>
                                <td class="text-bold text-center">
                                    <a class="btn btn-outline-primary" href="{{ route('admin.request.doc.setup.edit', ['id'=>$template->id]) }}"><i class="fas fa-pen"></i></a>&nbsp;
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>

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
                <h3 class="modal-title" id="exampleModalCenterTitle">View Document Template View</h3>
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


        $(document).on('click', '#view-btn', function ()
        {
            var id = $(this).attr('docTemplateId');

            $.ajax({
                url: "{{ route('get.document.template') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}","doc_id": id},
                success: function(data) {
                    $('.textContent').html(data);
                }
            });
        });


        $(document).on('click', '.active-btn', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change this status",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    var id = $(this).attr('docTemplateId');
                    $.ajax({
                        url: "{{ route('change.status.document.template') }}",
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", "doc_id": id},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                location.reload(true);
                            }
                        }
                    });
                }
            });
        });


    </script>
@endpush
