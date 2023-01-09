<!--begin::Form-->
<form class="kt-form permissions-form" action="{{ route('employee.permissions.submit') }}" method="POST">
    @csrf

    {{-- employee id --}}
    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
    <input type="hidden" id="all_permissions" name="all_permissions" value="">

    {{-- All Role view table --}}
    <div class="kt-portlet__body">

        <!--begin::Section-->
        <div class="kt-section">
            <div class="kt-section__content">
                {{-- Roles --}}
                <div class="form-group">
                    <h5>Assign Role</h5>
                    @if(!$isSuperAdmin)
                        <div class="kt-checkbox-inline">
                            @foreach ($roles as $item)
                                <label class="kt-checkbox kt-checkbox--info">
                                    @if($item->name != 'Super Admin')
                                        <input id="userRoles" {{ ($employee->userDetails && $employee->userDetails->hasRole($item)) ? 'checked' : '' }} type="checkbox"
                                               name="roles[]" value="{{ $item->name }}"> {{ $item->name }}
                                        <span></span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    @endif
                    @if($isSuperAdmin)
                        <div class="kt-checkbox-inline">
                            @foreach ($roles as $item)
                                <label class="kt-checkbox kt-checkbox--info">
                                    <input {{ ($employee->userDetails && $employee->userDetails->hasRole($item)) ? 'checked' : '' }} type="checkbox"
                                           name="roles[]" value="{{ $item->name }}"> {{ $item->name }}
                                    <span></span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

{{--                <hr>--}}
                <hr class="hr-text" data-content="Admin Permissions">

                {{-- All Permissions table --}}
                @foreach ($permissions as $module => $items)
                    @if(!strpos($module, 'User Permissions'))
                    <h5>{{ $module }}</h5>
                    <table class="table table-striped table-bordered table-hover">
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
                                @if(isset($item['View']['name'][0]))
                                <td>
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" class="checkbox" name="permissions[]"
                                               value="{{ implode(',', $item['View']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['View']['name'][0])) ? 'checked' : '' }}>
                                        <span></span>
                                    </label>

                                </td>
                                @endif
                                @if(isset($item['Create']['name'][0]))
                                <td>
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" class="checkbox" name="permissions[]"
                                               value="{{ implode(',', $item['Create']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['Create']['name'][0])) ? 'checked' : '' }}>
                                        <span></span>
                                    </label>

                                </td>
                                @endif
                                @if(isset($item['Edit']['name'][0]))
                                <td>
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" class="checkbox" name="permissions[]"
                                               value="{{ implode(',', $item['Edit']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['Edit']['name'][0])) ? 'checked' : '' }}>
                                        <span></span>
                                    </label>

                                </td>
                                @endif
                                @if(isset($item['Delete']['name'][0]))
                                <td>
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" class="checkbox" name="permissions[]"
                                               value="{{ implode(',', $item['Delete']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['Delete']['name'][0])) ? 'checked' : '' }}>
                                        <span></span>
                                    </label>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        <br><br>
                    @endif
                @endforeach

{{--                <div class="kt-separator kt-separator--dashed" style="border-bottom:1px dashed #0abb87"></div>--}}
                <hr class="hr-text" data-content="Users Permissions">
                <br>
                @foreach ($permissions as $module => $items)
                    @if(strpos($module, 'User Permissions'))
                        <h5>{{ $module }}</h5>
                        <table class="table table-striped table-bordered table-hover">
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
                                            <input type="checkbox" class="checkbox" name="permissions[]"
                                                   value="{{ implode(',', $item['View']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['View']['name'][0])) ? 'checked' : '' }}>
                                            <span></span>
                                        </label>

                                    </td>
                                    <td>
                                        <label class="kt-checkbox kt-checkbox--success">
                                            <input type="checkbox" class="checkbox" name="permissions[]"
                                                   value="{{ implode(',', $item['Create']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['Create']['name'][0])) ? 'checked' : '' }}>
                                            <span></span>
                                        </label>

                                    </td>
                                    <td>
                                        <label class="kt-checkbox kt-checkbox--success">
                                            <input type="checkbox" class="checkbox" name="permissions[]"
                                                   value="{{ implode(',', $item['Edit']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['Edit']['name'][0])) ? 'checked' : '' }}>
                                            <span></span>
                                        </label>

                                    </td>
                                    <td>
                                        <label class="kt-checkbox kt-checkbox--success">
                                            <input type="checkbox" class="checkbox" name="permissions[]"
                                                   value="{{ implode(',', $item['Delete']['name']) }}" {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item['Delete']['name'][0])) ? 'checked' : '' }}>
                                            <span></span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br><br>
                    @endif
                @endforeach

            </div>
        </div>
        <!--end::Section-->


    </div>
</form>
<!--end::Form-->

<div class="kt-portlet__foot">
    <div class="kt-form__actions">
        <button id="form_submit" class="btn btn-outline-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </div>
</div>
