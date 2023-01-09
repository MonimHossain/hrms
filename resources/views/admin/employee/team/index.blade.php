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
                        Team Management List
                    </h3>
                </div>
                <span class="pull-right">
                    <a href="{{ route('employee.team.create') }}" class="btn btn-outline-success mt-3">Create New Team</a>
                </span>
            </div>
            <div class="kt-portlet__body">

                <div class="kt-section">

                    <!--begin: Datatable -->
                    <div id="example">
                        <div class="row">

                            {{-- functional team count --}}
                            <div class="paper col-sm-3">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                            <i class="fas fa-users-cog text-theme-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                            <p class="card-category">Functional</p>
                                            <p class="card-title">{{ $teamAll->where('is_functional', 1)->count() }}</p><p>
                                            </p></div>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- non functional team count --}}
                            <div class="paper col-sm-3">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                            <i class="fas fa-users text-theme-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                            <p class="card-category">Non Functional</p>
                                            <p class="card-title">{{ $teamAll->where('is_functional', 0)->count() }}</p><p>
                                            </p></div>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="tree"></div>
                            </div>
                        </div>
                    </div>
                    <!--end: Datatable -->


                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-treeview@1.2.0/dist/bootstrap-treeview.min.css">
@endpush




@push('js')
    <!--begin::Page Vendors -->
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-treeview@1.2.0/dist/bootstrap-treeview.min.js"></script>

    <script>
        let teams = `{!! json_encode($teams) !!}`;
        $('#tree').treeview({
            enableLinks: true,
            showTags: true,
            highlightSelected: true,
            selectedBackColor: '#782B90',
            levels: 1,
            data: teams,
            showBorder: true,
            expandIcon: 'la la-plus',
            collapseIcon: 'la la-minus',
        });


        //Delete Team
        $("#tree").on('click', '.team_remove', function () {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this entry",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = "{{ route('employee.setting.team.delete', ['']) }}/" + id;
                }
            });
        });

    </script>
@endpush


