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
                        Employee List
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">

{{--                <select id="table-filter" class="col-sm-3">--}}
{{--                    <option value="">All</option>--}}
{{--                    <option>London</option>--}}
{{--                    <option>San Francisco</option>--}}
{{--                    <option>Engineer</option>--}}
{{--                    <option>Developer</option>--}}
{{--                </select>--}}
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table_1">

                    <thead>
                    <tr>
                        {{--                        <th>ID</th>--}}
                        {{-- <th>Pic</th> --}}
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Division-Center</th>
                        <th>Department</th>
                        <th>Process</th>
                        <th>Blood Group</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

                <!--end: Datatable -->


                <!--begin::Modal edit branch-->
                <div class="modal fade" id="employeeState" tabindex="-1" role="dialog" aria-labelledby="editBranch" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBranch">Employee Info:</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id='modal-data'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
    <!--begin::Page Vendors -->
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function ($) {
            var t = $('#kt_table_1').DataTable({
                'responsive': true,
                'searching': true,
                'processing': true,
                'serverSide': true,
                "deferRender": true,
                "orderable": false,
                // "dom": 'frtlip',
                // "buttons": [
                //     'copy',
                //     'csv',
                //     'excel'
                // ],
                'ajax': {
                    url: "{{ route('employee.list') }}",
                    data: function (d) {
                        d.search = $('input[type="search"]').val()
                    },
                },

                'columns': [
                    // {
                    //     "data": null,"sortable": false,
                    //     render: function (data, type, row, meta) {
                    //                 return meta.row + meta.settings._iDisplayStart + 1;
                    //     }
                    // },
                    {
                        'data': 'employer_id',
                        orderable: false
                    },
                    {
                        'data': "name",
                        "render": function (data, type, JsonResultRow, meta) {
                            var url;
                            if (data.image) {
                                url = "{{ asset('/storage/employee/img/') }}" + "/" + data.image;
                            } else {
                                url = (data.gender == 'Female') ? "{{ asset('assets/media/users/default_female.png') }}" : "{{ asset('assets/media/users/default_male.png') }}";
                            }
                            return '<span ><div class="kt-user-card-v2"><div class="kt-user-card-v2__pic"><img alt="photo" src=' + url + '></div><div class="kt-user-card-v2__details"><a class="kt-user-card-v2__name" href="#">' + data.name + '</a></div></div></span>';
                        },
                        orderable: false
                    },
                    {
                        'data': 'email',
                        orderable: false
                    },
                    {
                        'data': 'designation',
                        orderable: false
                    },
                    {
                        'data': 'center',
                        orderable: false
                    },
                    {
                        'data': 'department',
                        orderable: false
                    },
                    {
                        'data': 'process',
                        orderable: false
                    },
                    {
                        'data': 'blood_group',
                        orderable: false
                    },
                    {
                        'data': 'contact_number',
                        orderable: false
                    },
                    {
                        'data': 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center blog_delete",
                        orderable: false,
                        searchable: true,
                        // defaultContent: '<a target="_blank" href="" class="editor_edit"><i class="flaticon-eye"></i></a> / <a target="_blank" href="" class="editor_edit"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a>'
                    }
                ],
                "columnDefs": [ {
                    "targets": 0,
                    orderable: false
                }],

                // search: {
                //     "regex": true
                // }
            });


            // Delete employee
            $("#kt_table_1").on('click', '.employee_remove', function () {
                var employeeId = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this employee",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "{{ route('delete.employee', ['']) }}/" + employeeId;
                        Swal.fire(
                            'Deleted!',
                            'Employee has been deleted.',
                            'success'
                        )
                    }
                });
            });

            // employee details modal
            $(document).on("click", ".employeeStateIcon", function () {
                var employeeId = $(this).data('employee-id');
                // $("#employeeState .modal-body #holidayid").val(holidayId);
                $('#modal-data').html('');
                $.ajax({
                    type:'POST',
                    url:'{{ route("info.state") }}',
                    data: {employee_id: employeeId},
                    success:function(data){
                        console.log(data);
                        $('#modal-data').html(data);
                    }
                });
            });

        });
    </script>
@endpush


