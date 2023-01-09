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

            <!--begin: Datatable -->
            <div id="example">
                <div class="form-group">
                    <input type="search" id="searchField" class='k-textbox' placeholder="Search.."  style="width: 230px;"/>
                </div>
                <div class="row">
                    <div id="tabledatabinding" class="col-xs-12 col-md-12"></div>
                </div>

            </div>

            <!--end: Datatable -->
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.km-touch-scrollbar {
    position: absolute;
    visibility: hidden;
    z-index: 200000;
    height: .3em;
    width: .3em;
    background-color: #333;
    -moz-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    -o-transform-origin: 0 0;
    transform-origin: 0 0;
    -webkit-transition: opacity 0.3s linear;
    -moz-transition: opacity 0.3s linear;
    -o-transition: opacity 0.3s linear;
    opacity: 0;
    -moz-border-radius: .4em;
    -webkit-border-radius: .4em;
    border-radius: .4em;
}
.km-vertical-scrollbar {
    height: 100%;
    right: 1px;
    top: 0;
}
.km-horizontal-scrollbar {
    width: 100%;
    left: 0;
    bottom: 1px;
}
.km-scroll-container {
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
}
</style>
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2013.1.514/styles/kendo.common.min.css">
{{--<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.3.1118/styles/kendo.default.min.css">--}}
<link rel="stylesheet" href="{{ asset('assets/css/kendo.custom/kendo.custom.css') }}">

<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.3.1118/styles/kendo.mobile.all.min.css">

<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2013.1.514/js/kendo.web.min.js">
@endpush




@push('js')
<!--begin::Page Vendors -->
<script src="https://kendo.cdn.telerik.com/2019.2.514/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2019.2.514/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2019.2.514/js/kendo.all.min.js"></script>


<script>

        $(document).ready(function () {



            function isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }



            function getBoolean(str) {
                if ("true".startsWith(str)) {
                    return true;
                } else if ("false".startsWith(str)) {
                    return false;
                } else {
                    return null;
                }
            }


            //data source for kendo grid
            dataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        url: "{{ route('employee.all.list') }}",
                        dataType: "json", //reading data

                        // parameterMap: function (options, operation) {
                        //     // if (operation !== "read" && options.models) {
                        //     //     return {
                        //     //         models: kendo.stringify(options.models)
                        //     //     };
                        //     // }
                        // }

                    },
                },

                schema: {
                    model: {
                        id: "id",
                        fields: {
                            id: {
                                editable: false,
                                nullable: true,
                                type: "number"
                            },
                            login_id: {
                                editable: false,
                                nullable: true,
                                type: "number"
                            },
                            first_name: {
                                editable: false,
                                nullable: true,
                                type: "string"
                            },
                            location: {
                                editable: false,
                                nullable: true,
                                type: "string"
                            },
                            employee_journey: {
                                editable: false,
                                nullable: true,
                                type: "json"
                            },
                            department: {
                                editable: false,
                                nullable: true,
                                type: "string"
                            },
                            process: {
                                editable: false,
                                nullable: true,
                                type: "string"
                            },
                            process: {
                                editable: false,
                                nullable: true,
                                type: "string"
                            },
                            created_at: {
                                editable: false,
                                nullable: true,
                                type: "date"
                            },
                            contact_number: {
                                editable: false,
                                nullable: true,
                                type: "string"
                            }

                        }
                    }
                }
            });




            $("#tabledatabinding").kendoGrid({

                toolbar: ["excel", "pdf"], //displays a button in grid toolbar

                excel: {
                    fileName: "Kendo UI Grid Export.xlsx",
                },

                dataSource: dataSource, //binging the above data source to grid
                sortable: true, //sortable
                pageSize: 20,
                serverPaging: true,

                columns: [
                {
                    field: "login_id",
                    title: "Login Id",
                    filterable: true,
                    width: 80
                },{
                    title: "Name",
                    template: "#= first_name + ' ' + last_name #",
                    field: "first_name",
                    width: 140
                },{
                    field: "center",
                    title: "Location",
                    width: 150,
                },{
                    field: "employee_journey.designation.name",
                    title: "Designation",
                    width: 200,
                },{
                    field: "employee_journey.department.name",
                    title: "Department",
                    width: 120
                },{
                    field: "employee_journey.process.name",
                    title: "Process",
                    width: 150,
                },{
                    field: "created_at",
                    title: "Created Date",
                    format: "{0:dd/MM/yyyy}",
                    width: 110
                },{
                    field: "contact_number",
                    title: "Contact Number",
                    width: 150,

                },
                {
                    // template: "@can('Employee Profile View')<a target='_blank' href='{{ route('employee.profile', '') }}/#=id#' class='customView k-button k-button-icontext k-grid-view'><i class='flaticon-eye'></i></a>@endcan @can('Employee Profile View')<a target='_blank' href='{{ route('employee.profile', '') }}/#=id#' class='customView k-button k-button-icontext k-grid-view'><i class='flaticon-eye'></i></a>@endcan @can('Employee Profile View')<a target='_blank' href='{{ route('employee.profile', '') }}/#=id#' class='customView k-button k-button-icontext k-grid-view'><i class='flaticon-eye'></i></a>@endcan",
                    template: "@can('Employee Profile View')<a href='{{ route('employee.profile', '') }}/#=id#' target='_blank' class='editor_edit'><i class='flaticon-eye'></i></a>@endcan @can('Employee Edit')<a href='{{ route('employee.update.view', '') }}/#=id#' target='_blank' class='editor_edit'><i class='flaticon-edit'></i></a>@endcan @can('Employee Delete')<a id='#=id#' click='deleteEmployee();' class='employee_remove'><i class='flaticon-delete'></i></a>@endcan",
                    title: "Action",
                    width: 100
                }
                ],

                filterable: true, //we can filter tae data using filter options
                columnMenu: true,
                reorderable: true,
                resizable: true,
                height: "550px",
                pageable: {
                    refresh: true,
                    pageable: true,
                    pageSizes: true,
                    buttonCount: 10
                },
            }).data("kendoGrid");

            //kemdo view Profile




            $('#searchField').on('input', function (e) {
                var grid = $('#tabledatabinding').data('kendoGrid');
                var columns = grid.columns;

                var filter = {
                    logic: 'or',
                    filters: []
                };

                columns.forEach(function (x) {
                    if (x.field) {
                        //var type = grid.dataSource.options.schema.model.fields[x.field].typeof;
                        // console.log(type);
                        //if (type == 'string') {
                            filter.filters.push({
                                field: x.field,
                                operator: 'contains',
                                value: e.target.value
                            })
                            //}
                            //  else if (type == 'number') {
                            //     if (isNumeric(e.target.value)) {
                            //         filter.filters.push({
                            //             field: x.field,
                            //             operator: 'eq',
                            //             value: e.target.value
                            //         });
                            //     }

                            // } else if (type == 'date') {
                            //     var data = grid.dataSource.data();
                            //     for (var i = 0; i < data.length; i++) {
                            //         var dateStr = kendo.format(x.format, data[i][x.field]);
                            //         // change to includes() if you wish to filter that way https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes
                            //         if (dateStr.startsWith(e.target.value)) {
                            //             filter.filters.push({
                            //                 field: x.field,
                            //                 operator: 'eq',
                            //                 value: data[i][x.field]
                            //             })
                            //         }
                            //     }
                            // } else if (type == 'boolean' && getBoolean(e.target.value) !== null) {
                            //     var bool = getBoolean(e.target.value);
                            //     filter.filters.push({
                            //         field: x.field,
                            //         operator: 'eq',
                            //         value: bool
                            //     });
                            // }
                    }
                });
                grid.dataSource.filter(filter);
            });


            // Delete employee
            function deleteEmployee(e) {
                e.preventDefault();
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
            }



        });

</script>


@endpush


