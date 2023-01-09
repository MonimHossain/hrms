@extends('layouts.container')


@section('content')



@push('library-js')
<script src="https://code.jquery.com/ui/jquery-ui-git.js" type="text/javascript"></script>
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

                    {{-- // --}}

                    {{-- // --}}

                </div>
            </div>

            <!--end::Portlet-->
        </div>
    </div>
</div>

@endsection


@push('css')
<link href="{{ asset('assets/vendors/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/dot-luv/jquery-ui.css" />

<style>
.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
.sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 40px; -webkit-box-shadow: 2px -2px 20px 0px #000000;
box-shadow: 2px -2px 20px 0px #000000; background: lightyellow; color: #333; }
.sortable li span { position: absolute; margin-left: -1.3em; }
.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
.sortable-number { width: 25px;float: right;line-height: 1em;text-align: center;font-weight: bold; cursor: move }


.remScnt{
    color:red; cursor:pointer; height:25px; width:25px; background:whitesmoke; text-align:center; border-radius:25px
}


.custom-btn{
    color: whitesmoke;
    background: blueviolet;
    padding: 1px;
    border-radius: 4px;
    margin-left: 8px;
}

.dropdown{
      display: inline-block;
      margin: 0;
      padding: 0;
      position: relative !important;
      right: 0 !important;
      top: -5px !important;
      width: 90%;
  }

</style>
@endpush



@push('js')
<script src="{{ asset('assets/vendors/custom/jstree/jstree.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/components/extended/treeview.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>

<script>

    $(document).on('click','.selected-item', function(){
        var getId = $(this).attr('item-id');
        var actionUrl = 'process/workflow/'+getId;
            $.ajax({
                type: 'GET',
                dataType: 'HTML',
                url: actionUrl,
                success: function (response) {
                    $('#process-list').html(response);
                    var addProcessUrl = '/settings/manage/workflow/process/add/'+getId;
                    $('#add-process-button').attr('action', addProcessUrl);
                }
            });
    });


    // Common modal for approval process
    $(document).on('click', '.approvalProcessModal', function () {
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

                //Sortable function
                //add more function
                jQuery(document).ready(function () {
                $("#sortable_nav").sortable({
                    placeholder: "ui-state-highlight",
                    helper: 'clone',
                    sort: function (e, ui) {
                        $(ui.placeholder).html(Number($("#sortable_nav > li:visible").index(ui.placeholder)) + 1);
                    },
                    update: function (event, ui) {
                        var $lis = $(this).children('li');
                        $lis.each(function () {
                            var $li = $(this);
                            var newVal = $(this).index() + 1;
                            $(this).children('.sortable-number').html(newVal);
                            $(this).children('.sortable').val(newVal);
                            // $(this).children('.sortable-item').val(newVal);
                            $(this).children('#item_display_order').val(newVal);
                        });
                    }
                });
                $("#sortable_nav").disableSelection();


                    KTFormRepeater.init();
                });

            }
        });
    });

</script>
@endpush
