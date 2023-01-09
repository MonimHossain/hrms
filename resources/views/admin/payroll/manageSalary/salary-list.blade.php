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
                        Employee Salary List
                    </h3>
                </div>
                @can(_permission(\App\Utils\Permissions::ADMIN_SALARY_CREATE))
                <span class="pull-right"><a href="{{ route('manage.salary.view') }}" class="btn btn-outline-success" style="position: relative; top: 12px;">New Entry</a></span>
                @endcan
            </div>
            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        {{--                        <th>ID</th>--}}
                        {{-- <th>Pic</th> --}}
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Payment Type</th>
                        <th>Pay Cycle</th>
                        <th>Bank</th>
                        <th>Branch</th>
                        <th>Account</th>
                        <th>Account Type</th>
                        <th>Type</th>
                        <th>Applicable From</th>
                        <th>Rate 1</th>
                        <th>Rate 2</th>
                        {{-- <th>Pf</th>
                        <th>Tax</th> --}}
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>

                <!--end: Datatable -->
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
        jQuery(document).ready(function($){
            let t = $('#kt_table_1').DataTable({
                'responsive': true,
                'searching': true,
                'processing': true,
                'serverSide': true,
                "deferRender": true,
                'ajax': {
                    url: "{{ route('manage.salary.list') }}",
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
                    { 'data' : 'employer_id' },
                    { 'data' : "name",
                        "render": function (data, type, JsonResultRow, meta) {
                            var url, link;
                            link="{{ route('employee.profile',['id' => ""]) }}/"+data.id;
                            if(data.image){
                                url = "{{ asset('/storage/employee/img/') }}"+"/"+data.image;
                            }else{
                                url = (data.gender == 'Female') ? "{{ asset('assets/media/users/default_female.png') }}" : "{{ asset('assets/media/users/default_male.png') }}";
                            }
                            return '<span ><div class="kt-user-card-v2"><div class="kt-user-card-v2__pic"><img alt="photo" src='+url+'></div><div class="kt-user-card-v2__details"><a class="kt-user-card-v2__name" href='+link+'>'+ data.name +'</a></div></div></span>';
                        }
                    },
                    { 'data' : 'paymentType' },
                    { 'data' : 'payCycle' },
                    { 'data' : 'bankInfo' },
                    { 'data' : 'bankBranch' },
                    { 'data' : 'bank_account' },
                    { 'data' : 'accountType' },
                    { 'data' : 'type' },
                    { 'data' : 'applicable_from' },
                    // { 'data' : 'hourly_rate' },
                    // { 'data' : 'gross_salary' },
                    // { 'data' : 'pf' },
                    // { 'data' : 'tax' },
                    { 'data' : 'payable' },
                    { 'data' : 'kpirate' },
                    // { 'data' : 'pfInfo' },
                    // { 'data' : 'taxInfo' },                    
                    { 'data' : 'status' },                    
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center blog_delete",
                        orderable: true,
                        searchable: true,
                        // defaultContent: '<a target="_blank" href="" class="editor_edit"><i class="flaticon-eye"></i></a> / <a target="_blank" href="" class="editor_edit"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a>'
                    }
                ],
                dom: 'Bftiprl',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdfHtml5',
                //     'print'
                // ],
                buttons: [
                    {
                        extend: 'excel',
                        text: '<span class="fa fa-file-excel-o"></span> Excel Export',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            },
                            customizeData: function (d) {
                                var exportBody = GetDataToExport();
                                d.body.length = 0;
                                d.body.push.apply(d.body, exportBody);
                            }
                        }
                    }
                ],
            });
            

            function GetDataToExport() {
                var jsonResult = $.ajax({
                    url: "{{ route('manage.salary.query') }}",
                    data: {search: $("#search").val()},
                    success: function (result) {

                    },
                    async: false
                });
                console.log(jsonResult)
                exportBody = jsonResult.responseJSON;
                return exportBody.map(function (el) {
                    console.log('el', el);
                    return Object.keys(el).map(function (key) { 
                        console.log('el[key] ', el[key] );
                        return el[key] 
                    });
                });
            }


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
                        window.location.href = "{{ route('delete.employee', ['']) }}/"+employeeId;
                        Swal.fire(
                            'Deleted!',
                            'Employee has been deleted.',
                            'success'
                        )
                    }
                });
            });

        });
    </script>
@endpush


