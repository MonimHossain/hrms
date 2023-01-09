@extends('layouts.container')


@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
	<div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title ">
                            Manage Role
                        </h3>

                    </div>
                </div>

                <!--begin::Form-->
                {{-- <form class="kt-form" action="{{ route('settings.manage.role.add') }}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Add New Role" name="name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">ADD</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form> --}}
                <!--end::Form-->

                {{-- All Role view table --}}
                <div class="kt-portlet__body">
                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            {{-- add new role button --}}
                            <a href="{{ route('settings.manage.role.add.view') }}" class="btn btn-label btn-label-brand btn-sm btn-bold float-right"  ><i class="flaticon2-plus"></i> Add New Role</a>

                            {{-- role table --}}
                            <table class="table table-striped table-hover">
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
                            </table>
                        </div>
                    </div>
                    <!--end::Section-->

                    <!--begin::Modal-->
                    <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="role-name"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form action="{{ route('settings.manage.role.assignPermission') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="role" name="role" >
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Give permission to role:</label>
                                            <div class="kt-checkbox-inline">
                                                @foreach ($permissions as $item)
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" name="permissions[]" value="{{ $item->name }}"> {{ $item->name }}

                                                        <span></span>
                                                    </label>
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$('.edit-role').on('click', function(){
    let name = $(this).data('rolename');
    $('#role').val(name);
    $('#role-name').text(name);

})
</script>
@endpush
