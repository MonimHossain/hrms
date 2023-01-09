 <!--begin::Form-->
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ isset($file) ? route('resource.update') : route('resource.insert') }}">
          @if(isset($file))
            <input type="hidden" name="id" value="{{ $file->id }}">
          @endif
        {{ csrf_field() }}
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="">File Name</label>
                    <div class="custom-file">
                        <input type="text" name="name" class="form-control" value="{{ isset($file) ? $file->name : '' }}" required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Note</label>
                    <div class="custom-file">
                        <textarea name="note" class="form-control" id="">{{ isset($file) ? $file->note : '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div data-repeater-item class="form-group row align-items-center">
                    <div class="col-md-2">
                        <div class="kt-form__group--inline">
                            <label for="exampleSelectd">Division </label>
                            <select class="form-control division" id="division" name="division">
                                <option value="">Select</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}"> {{ $division->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="kt-form__group--inline">
                            <label for="exampleSelectd">Center </label>
                            <select class="form-control center" id="center" name="center">
                                <option value="">Select</option>
                                {{--@foreach($centers as $center)
                                    <option {{ ($center->id === 1)?'selected':'' }} value="{{ $center->id }}"> {{ $center->center }} </option>
                                @endforeach--}}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Department </label>
                            </div>
                            <div class="kt-form__control">
                                <select class="form-control department"
                                        name="department" id="department">
                                    <option value="">Select</option>
                                    {{--@foreach($departments as $department)
                                        <option
                                            value="{{ $department->id }}"> {{ $department->name }} </option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="d-md-none kt-margin-b-10"></div>
                    </div>


                    <div class="col-md-2">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Process </label>
                            </div>
                            <div class="kt-form__control">
                                <select class="form-control process" name="process" id="process">
                                    <option value="">Select</option>
                                    {{--@foreach($processes as $process)
                                        <option
                                            value="{{ $process->id }}"> {{ $process->name }} </option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="d-md-none kt-margin-b-10"></div>
                    </div>


                    <div class="col-md-2">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Process Segment:</label>
                            </div>
                            <div class="kt-form__control">
                                <select class="form-control processSegment"
                                        name="processSegment" id="processSegment">
                                    <option value="">Select</option>
                                    {{--@foreach($processSegments as $processSegment)
                                        <option
                                            value="{{ $processSegment->id }}"> {{ $processSegment->name }} </option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="d-md-none kt-margin-b-10"></div>
                    </div>


                    <div class="col-md-2">
                        <a href="javascript:;" style="margin-top: 25px;"
                           data-repeater-delete=""
                           class="btn-sm btn btn-label-danger btn-bold">
                            <i class="la la-trash-o"></i></a>
                    </div>
                </div>
            </div>
            @if(!isset($file))
                <div class="row">
                    <div class="form-group col-md-8">
                        <label class="">File</label>
                        <div class="custom-file">
                            <input type="file" name="file" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-brand">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

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

        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }
        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });
    </script>

@endpush
