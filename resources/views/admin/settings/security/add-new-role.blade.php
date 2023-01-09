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
                            Add New Role
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{ route('settings.manage.role.add') }}" method="POST">
                    @csrf
                    {{-- <div class="kt-portlet__body">
                        <div class="form-group ">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Add New Role" name="name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">ADD</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                <!--end::Form-->

                {{-- All Role view table --}}
                <div class="kt-portlet__body">

                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            {{-- <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Role Name</th>
                                        <th>Guard Name</th>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <th scope="row">{{ $role->id }}</th>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->guard_name }}</td>
                                            <td>
                                                @foreach ($role->getPermissionNames() as $item)
                                                <span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ $item }}</span>
                                                @endforeach

                                            <td><a target="_blank" href="" class="editor_edit edit-role" data-rolename="{{ $role->name }}" data-toggle="modal" data-target="#kt_modal_4"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                            @foreach ($permissions as $module => $items)
                            <h5>{{ $module }}</h5>
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                <tr>
                                    <th>
                                        <label class="kt-checkbox kt-checkbox--success">
                                            <input type="checkbox" class="checkbox tableCheckedAll">
                                            <span></span>
                                        </label>
                                    </th>
                                    <th width="30%">Module Name</th>
                                    <th>View</th>
                                    <th>Create</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as  $key => $item)
                                    <tr>
                                        <td>
                                            <label class="kt-checkbox kt-checkbox--success">
                                                <input type="checkbox" class="checkbox rowCheckedAll">
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            {{ $key }}
                                        </td>
                                        <td>
                                            <label class="kt-checkbox kt-checkbox--success">
                                                <input type="checkbox" class="checkbox" name="permissions[]" value="{{ implode(',', $item['View']['name']) }}" >
                                                <span></span>
                                            </label>

                                        </td>
                                        <td>
                                            <label class="kt-checkbox kt-checkbox--success">
                                                <input type="checkbox" class="checkbox" name="permissions[]" value="{{ implode(',', $item['Create']['name']) }}" >
                                                <span></span>
                                            </label>

                                        </td>
                                        <td>
                                            <label class="kt-checkbox kt-checkbox--success">
                                                <input type="checkbox" class="checkbox" name="permissions[]" value="{{ implode(',', $item['Edit']['name']) }}" >
                                                <span></span>
                                            </label>

                                        </td>
                                        <td>
                                            <label class="kt-checkbox kt-checkbox--success">
                                                <input type="checkbox" class="checkbox" name="permissions[]" value="{{ implode(',', $item['Delete']['name']) }}" >
                                                <span></span>
                                            </label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <br><br>
                            @endforeach



                        </div>
                    </div>
                    <!--end::Section-->


                </div>
                </form>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection


@push('css')
    <style>
        .kt-checkbox {
            margin-bottom: 15px;
        }
    </style>
@endpush


@push('js')

<script>
    $(document).ready(function () {
        $('input.rowCheckedAll').on('click', function(){
            var row = $(event.target).closest('tr');
            $(this).is(":checked") ? $('td input:checkbox:not(.rowCheckedAll)', row).prop('checked', true) : $('td input:checkbox:not(.rowCheckedAll)', row).prop('checked', false);
        });

        $('input.tableCheckedAll').on('click', function(){
            var table = $(event.target).closest('table');
            $(this).is(':checked') ? $('td input:checkbox:not(.tableCheckedAll)',table).prop('checked', true) : $('td input:checkbox:not(.tableCheckedAll)',table).prop('checked', false);
        });
    });



</script>

@endpush
