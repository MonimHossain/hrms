@extends('layouts.container')


@section('content')



@push('library-js')
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
@endpush


<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
	<div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Workflow Setup
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="kt_tree_2" class="tree-demo">
                                @include('admin.settings.workflow._list-item',['tree' => $data])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="kt-portlet__body">
                                <div class="kt-widget12">
                                    <div class="kt-widget12__content">
                                        <div class="kt-widget12__item">
                                            <div class="kt-widget12__info">
                                                <div class="card" id="process-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
<link href="{{ asset('assets/vendors/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush






@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<script src="{{ asset('assets/vendors/custom/jstree/jstree.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/components/extended/treeview.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>

<script>

    $(document).on('click', '.selected-item', function () {
        var getId = $(this).attr('item-id');
        var actionUrl = 'process/workflow/' + getId;
        $.ajax({
            type: 'GET',
            dataType: 'HTML',
            url: actionUrl,
            success: function (response) {
                $('#process-list').html(response);
                var addProcessUrl = '/settings/manage/workflow/process/add/' + getId;
                $('#add-process-button').attr('action', addProcessUrl);
            }
        });
    });


    // Common modal for approval process
    $(document).on('click', '.approvalProcessModal', function (event) {
        var size_attr = $(this).attr('form-size');
        var form_width = (typeof size_attr !== typeof undefined && size_attr !== false) ? $(this).attr("form-size") : 'modal-lg';
        var form_title = $(this).attr("title");
        var form_url = $(this).attr("action");
        var form_method = "GET";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: form_url,
            type: form_method,
            cache: false,
            success: function (returnhtml) {
                $('.modal-dialog').addClass(form_width);
                $('.modal-title').text(form_title);
                $(".modal-body").html(returnhtml);
            }
        });
    });



    //remove modal



</script>
@endpush
