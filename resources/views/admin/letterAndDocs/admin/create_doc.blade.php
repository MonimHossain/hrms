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
                            Document Create for Individual Employee
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="kt-portlet__body">
                    <form action="{{ route('admin.document.save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Document Type *</label>
                                <select name="docType" class="form-control" id="docType" required>
                                    <option value="">Select Type</option>
                                    @foreach($docTypes as $docType)
                                    <option value="{{ $docType->id }}">{{ $docType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Select Document *</label>
                                <select name="document_name" class="form-control" id="document_name" required>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Select Pad Template *</label>
                                <select name="pad_id" class="form-control kt-select2" id="pad_id" required>
                                    <option value="">Select Pad Template</option>
                                    @foreach($documentTemplates as $documentTemplate)
                                        <option value="{{ $documentTemplate->id }}">{{ $documentTemplate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Select Employee</label>
                                <select name="employee_id" class="form-control kt-selectpicker" id="employeeList" data-live-search="true">
                                    <option value="">Select Employee</option>
                                    {{--@foreach($employees as $employee)
                                        <option value="{{ $employee->employer_id }}">{{ $employee->employer_id. ' '. $employee->FullName }}</option>
                                    @endforeach--}}
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Ref. Number *</label>
                                <input type="text" name="ref_number" required class="form-control" id="">
                            </div>

                            <div class="form-group col-md-2">
                                <label>&nbsp;</label><br>
                                <input type="button" id="process-btn" value="Process" class="btn btn-outline-primary">
                            </div>
                        </div>

                        <div id="content-around-info-message"></div>

                        <!--begin::Section-->
                        <div id="ck-editor-content">

                                <div class="kt-section">
                                    <div class="kt-section__content">
                                        <textarea id="" class="textarea" cols="30" rows="100" name="editor1"></textarea>
                                    </div>
                                </div>
                                <!--end::Section-->

                               <div class="form-group">
                                   <button type="submit" class="btn btn-outline-primary">Save</button>
                               </div>

                        </div>
                    </form>
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
                <button type="submit" target="_blank" id="saveAndPrint" title="Save and Print" class="btn btn-outline-primary">Save</button>


            </div>
        </div>
    </div>
</div>

{{--    End modal here--}}


@endsection
@include('layouts.lookup-setup-delete')

@push('css')



    <style>
        table.info-table, .info-table td {   border: 1px solid whitesmoke;   border-collapse: collapse; }
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
        #process-btn{
            display: none;
        }
        #ck-editor-content {
            display: none;
        }
    </style>
@endpush

@push('js')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>

        $('.textarea').ckeditor();
        //Load view load by doc type
        $(document).on('change', '#docType', function()
        {
            var id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('load.doc.name') }}",
                type: 'POST',
                data: {"id": id},
                success: function(data) {
                    $("#document_name").html("<option value='0'>Select Document</option>");
                    $("#process-btn").hide();
                    $("#ck-editor-content").hide();
                    if(data.document){
                        $.each(data.document, function( index, value ) {
                            $("#document_name").append("<option value='"+ index +"' >"+ value +"</option>");
                            $("#process-btn").show();
                        });
                    }

                    if(data.prefix){
                        $('input[name="ref_number"]').val(data.prefix);
                    }
                }
            });
        });

        $(document).on('change', '#document_name', function () {
            var id = $(this).val();
            // alert(id)
            if(id == '0'){
                $("#ck-editor-content").hide();
                $("#process-btn").hide();
            }else{
                $("#ck-editor-content").show();
                $("#process-btn").show();
            }

        });


        $(document).on('click', '#process-btn', function()
        {
            $("#ck-editor-content").show();
            var id = $('#document_name').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('load.doc.content') }}",
                type: 'POST',
                data: {"id": id},
                success: function(data) {
                    console.log(data)
                    if(data){
                        CKEDITOR.instances['editor1'].setData(data[0])
                    }
                }
            });
        });




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


    <script>

        function addSelect2Ajax($element, $url, $changeCallback, data) {
            var placeHolder = $($element).data('placeholder');

            if (typeof $changeCallback == 'function') {
                $($element).change($changeCallback)
            }

            // $($element).hasClass('select2') && $($element).select2('destroy');

            return $($element).select2({
                allowClear: true,
                width: "resolve",
                ...data,
                placeholder: placeHolder,
                ajax: {
                    url: $url,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        }
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj, index) {
                                return {id: obj.id, text: obj.name};
                            })
                        };
                    }
                }
            });

        }

        addSelect2Ajax('#employeeList', "{{route('employee.all')}}");
    </script>
    <script>
        $(document).on('change', '#employeeList', function()
        {
            $('#content-around-info-message').html('');
            var id = $(this).val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('load.doc.employee.information') }}",
                type: 'POST',
                dataType : 'html',
                data: {"id": id},
                success: function(data) {
                    if(data){
                        $('#content-around-info-message').html(data);
                    }
                }
            });
        });
    </script>


@endpush
