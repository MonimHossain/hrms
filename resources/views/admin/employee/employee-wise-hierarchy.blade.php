@extends('layouts.container')

@section('content')






        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">


            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon-users-1"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Employee Wise Hierarchy
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin::Portlet-->

                <div id="kt_tree_2" class="tree-demo">
                <?php

                        function olLiTree($tree )
                        {
                            echo '<ul>';
                            foreach ( $tree as $item ) {
                                echo "<li> $item[text]";
                                    // " ",
                                    // "<span title='Add New Hierarchy' data-toggle='modal' data-target='#kt_modal' action='".route('employee.hierarchy.add', ['id'=>$item['id']])."' class='btn-sm btn-success globalModal'><i class='flaticon-plus'></i></span>",
                                    // "<span class='btn-sm btn-info'><i class='flaticon-edit'></i></span>",
                                    // "<span class='btn-sm btn-danger'><i class='flaticon-delete'></i></span>";

                                if ( isset( $item['nodes'] ) ) {
                                    olLiTree( $item['nodes'] );
                                }
                            }
                            echo '</li></ul>';
                        }

                        olLiTree($resultData);

                ?>
                </div>

                    <!--end::Portlet-->

                </div>
            </div>
        </div>





@endsection

@push('css')
<link href="{{ asset('assets/vendors/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
<style>
.custom-btn{
    color: whitesmoke;
    background: blueviolet;
    padding: 1px;
    border-radius: 4px;
    margin-left: 8px;
}
</style>
@endpush



@push('js')
<script src="{{ asset('assets/vendors/custom/jstree/jstree.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/components/extended/treeview.js') }}" type="text/javascript"></script>
@endpush




