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
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="kt-checkbox-inline">
                            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                <input type="checkbox" {{ ($file->download_status === 1)?'checked="checked"':'' }} name="is_download"> Is Downloadable
                                <span></span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            </div>
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
