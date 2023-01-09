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
                                Appraisal Answer setup
                            </h3>
                        </div>
                        <a href="" style="position: relative; top: 5px" title="Setup Answer for Question" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.employee.appraisal.answer.setting.create') }}" class="text-primary custom-btn globalModal">
                            <span class="btn btn-outline-primary">Add Answer to Question</span>
                        </a>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('admin.employee.appraisal.answer.setting') }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Question</label>
                                            <div class="input-group">
                                                <select name="question_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($questions as $question)
                                                        <option value="{{ $question->id }}">{{ $question->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Question Type</label>
                                            <div class="input-group">
                                                <select name="question_type" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach(\App\Utils\Appraisal::QUESTIONTYPE as $key => $question)
                                                        <option value="{{ $key }}">{{ $key }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px !important;">#</th>
                                        <th>Question</th>
                                        <th>Question Type</th>
                                        <th>label</th>
                                        <th>Value</th>
                                        <th>Field Type</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($questionsList as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $question->question->name }}</td>
                                            <td>{{ $question->question->type_id }}</td>
                                            <td>{{ $question->label }}</td>
                                            <td>{{ $question->value }}</td>
                                            <td>{{ ucwords($question->type) }}</td>
                                            <td>
                                                <a href="" style="position: relative; top: 5px" title="Setup Interview Question" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.employee.appraisal.answer.setting.edit', ['id'=>$question->id]) }}" class="text-primary custom-btn globalModal">
                                                    <span class="btn btn-outline-primary">Edit</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            //add field
            $(document).on('click', '#labelFieldAdd', function (e) {
                e.preventDefault();
                var newRow = '<div class="appended-field row container"><div class="col-lg-6"><input type="text" name="label[]" class="form-control" id=""></div><div class="col-lg-4"><input type="text" name="value[]" class="form-control value" id=""></div><div class="col-lg-2"><br><a href="#" class="btn-sm btn-outline-danger delete"><i class="fas fa-times"></i></a></div></div>';
                $('#labelFieldContainer').append(newRow);
            });


            //remove
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                $(this).closest('.appended-field').remove();

                /*resume*/
                var sum = 0;
                $('.value').each(function() {
                    sum += Number($(this).val());
                });
                $('.totalMark').html(sum);
            });

           //sum column
           $(document).on('keyup', '.value', function (e) {
               var sum = 0;
               $('.value').each(function() {
                   sum += Number($(this).val());
               });
               var qstValue = parseFloat($('#questionList :selected').attr('mark'));
               if(qstValue >= sum){
                   $('.totalMark').html(sum);
               }else{
                   toastr.error("Your input invalid!");
                   $('.value').val(0);
               }
           });

           /*Number Validation*/
            $(document).on('keyup', '.value', function (e) {
                $(this).val().replace('/^\\d+(?:\\.\\d{1,2})?$/', '');
            });

        });


        $(document).on('change', '#questionFor', function (e) {
            var id = $(this).val();

            $.ajax({
                url: "{{ route('filter.appraisal.question.list') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}","id": id},
                success: function(data) {
                    if(data)
                    {
                        $('#questionList').html("<option value='0'>Select </option>");
                        $.each(data, function(id, value){
                            $('#questionList').append("<option value='"+ value.id +"' mark='"+value.marks+"' >"+ value.name +' ('+value.marks+')'+"</option>");
                        });
                    }
                }
            });
        });



    </script>

@endpush





