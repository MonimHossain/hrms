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
                                Assign Role and Permissions to <b class="text-success">{{ $employee->FullName }}</b>
                            </h3>
                        </div>
                        <span class="pull-right"><a href="{{ route('sync.permission') }}" class="btn btn-outline-success" style="position: relative; top: 12px;"><i class="flaticon-refresh"></i>Sync Permissions</a></span>
                    </div>

                    <input type="hidden" id="old_permissions" value="{{ $employee->userDetails->getPermissionNames() }}">
                    <form class="kt-form kt-form--label-right center-division-form" action="{{ route('set.default.center.division') }}" method="POST">

                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <div class="kt-portlet__body" style="padding-bottom: 0px">

                            <!--begin::Section-->
                            <div class="kt-section">
                                <div class="kt-section__content">
                                    <div class="form-group row">
                                        <div class="col-sm-3 center-division-item">
                                            <label for="division">Division</label>
                                            <select class="form-control division" id="selected_division" name="division_id" required>
                                                <option value="">Select Division</option>
                                                @foreach($divisions as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('division_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 center-division-item">
                                            <label for="center">Center</label>
                                            <select class="form-control center" id="selected_center" name="center_id" required>
                                                <option value="">Select Center</option>
                                            </select>
                                            @error('center_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="submit" value="Filter" class="btn btn-primary" style="margin-top: 26px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- permission view form --}}
                    <div id="permission-layout"></div>
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
    @include('layouts.partials.includes.division-center')
    <script>
        $(document).ready(function () {
            var allPermissions = [];
            var permissions = [];
            var uncheckedInputs = [];
            var liveRoles = [];
            var old_permissions = JSON.parse($('#old_permissions').val());

            $('.center-division-form').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serializeArray();
                // console.log(formData);
                let division_id, center_id, employee_id;
                $.each(formData, function (id, value) {

                    if (value['name'] == 'employee_id') {
                        employee_id = value['value'];
                    }
                    if (value['name'] == 'division_id') {
                        division_id = value['value'];
                    }
                    if (value['name'] == 'center_id') {
                        center_id = value['value'];
                    }
                });
                let url = "{{ route('employee.permissions.details.view', ['', '', ''] ) }}" + "/" + employee_id + "/" + division_id + "/" + center_id;
                let localPermission = allPermissions;
                axios.get(url)
                    .then(function (response) {
                        $('#permission-layout').html(response.data);

                        $("input[name='roles[]']").map(function () {
                            if(liveRoles.length){
                                if(liveRoles.includes($(this).val())){
                                    $(this).prop('checked', true);
                                } else {
                                    $(this).prop('checked', false);
                                }
                            }
                        }).get();

                        $("input[name='roles[]']:checked").map(function () {
                            liveRoles.push($(this).val());
                        }).get();

                        var division = $('#selected_division').val();
                        var center = $('#selected_center').val();
                        if(localPermission[division] == undefined){
                            localPermission[division] = [];
                        }
                        if(localPermission[division][center] == undefined){
                            localPermission[division][center] = [];
                        }

                        if(localPermission[division][center]){
                            $("input[name='permissions[]']").map(function () {
                                if(localPermission[division][center].includes($(this).val())){
                                    $(this).prop('checked', true);
                                }
                                if(uncheckedInputs.includes($(this).val())){
                                    $(this).prop('checked', false);
                                }
                            }).get();
                        }

                        allPermissions[division][center] = $("input[name='permissions[]']:checked")
                            .map(function () {
                                return $(this).val();
                            }).get();

                        $("input[name='permissions[]']:checked").map(function () {
                            if(old_permissions.includes($(this).val())){
                                old_permissions.splice( old_permissions.indexOf($(this).val()), 1 );
                            }
                        }).get();
                    })
                    .catch(function (error) {
                        $('#permission-layout').empty();
                        console.log(error)
                    })

            });


            $(document).on('click', 'input.rowCheckedAll', function () {
                var row = $(event.target).closest('tr');
                $(this).is(":checked") ? $('td input:checkbox:not(.rowCheckedAll)', row).prop('checked', true) : $('td input:checkbox:not(.rowCheckedAll)', row).prop('checked', false);
            });

            $(document).on('click', 'input.tableCheckedAll', function () {
                var table = $(event.target).closest('table');
                $(this).is(':checked') ? $('td input:checkbox:not(.tableCheckedAll)', table).prop('checked', true) : $('td input:checkbox:not(.tableCheckedAll)', table).prop('checked', false);
            });

            $(document).on('change', 'input:checkbox', function() {
                var ischecked = $(this).is(':checked');
                if(!ischecked){
                    if(!uncheckedInputs.includes($(this).val())){
                        uncheckedInputs.push($(this).val());
                    }
                } else {
                    if(uncheckedInputs.includes($(this).val())){
                        uncheckedInputs.splice( uncheckedInputs.indexOf($(this).val()), 1 );
                    }
                }
            });

            $(document).on('change', "input[name='roles[]']", function() {
                liveRoles = []
                $("input[name='roles[]']:checked").map(function () {
                    liveRoles.push($(this).val());
                }).get();
            });

            $(document).on('click', "input:checkbox", function () {
                var division = $('#selected_division').val();
                var center = $('#selected_center').val();
                if(allPermissions[division] == undefined){
                    allPermissions[division] = [];
                }
                if(allPermissions[division][center] == undefined){
                    allPermissions[division][center] = [];
                }
                allPermissions[division][center] = $("input[name='permissions[]']:checked")
                    .map(function () {
                        return $(this).val();
                    }).get();

                $("input[name='permissions[]']:checked").map(function () {
                    if(old_permissions.includes($(this).val())){
                        old_permissions.splice( old_permissions.indexOf($(this).val()), 1 );
                    }
                }).get();

                permissions = [];
                allPermissions.forEach(function (b, j) {
                    b.forEach(function (val, index) {
                        val.forEach(function (data, i) {
                            permissions.push(data);
                        })
                    })
                });
            });
            $(document).on('click', '#form_submit', function (e) {
                permissions = old_permissions;
                allPermissions.forEach(function (b, j) {
                    b.forEach(function (val, index) {
                        val.forEach(function (data, i) {
                            if(!permissions.includes(data)){
                                permissions.push(data);
                            }
                        })
                    })
                });
                $(document).find('#all_permissions').val(permissions);
                $(document).find('.permissions-form').submit();
            });
        });


    </script>

@endpush
