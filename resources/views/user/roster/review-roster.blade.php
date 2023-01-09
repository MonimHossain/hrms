@extends('layouts.container')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                    <h3 class="kt-portlet__head-title">
                        Review Roster
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    <div class="kt-section__content ">
                        <form class="kt-form" action="{{ route('user.roster.review.view') }}" method="get">
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label>Date From</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control date_from" readonly placeholder="Select Start Date"
                                                   id="kt_datepicker_3" name="date_from" value="{{ Request::get('date_from') }}"/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label>Date To</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control date_to" readonly placeholder="Select End Date"
                                                   id="kt_datepicker_3" name="date_to" value="{{ Request::get('date_to') }}"/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <button type="reset" class="btn btn-secondary reset-button">Reset</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        @if ($rosters)

                            <form class="pull-right" action="{{ route('user.roster.review.submit') }}" method="POST">
                                @csrf
                                @foreach ($rosterRequests->groupBy('employee_id') as $item)
                                    <input type="hidden" name="employee_id[]" value="{{ $item->first()->employee->id }}">
                                @endforeach
                                <button class="btn btn-success pull-right mb-4" type="submit">Approval Roster</button>
                            </form>

                            <br>

                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                @php
                                    $arr = array_unique(array_column($rosterRequests->toArray(), 'date'));
                                @endphp
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    @foreach ($arr as $item)
                                        <th>{{ \Carbon\Carbon::create($item)->toFormattedDateString() }}</th>
                                    @endforeach

                                    {{-- <th>Actions</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rosterRequests->groupBy('employee_id') as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->first()->employee->employer_id }}</td>
                                        <td class="text-center">{{ $item->first()->employee->FullName }}</td>
                                        @foreach ($item as $item2)
                                            <td class="text-center {{ (!$item2->roster) ? 'text-danger' : '' }} employee-single-roster" data-id="{{ $item2->id }}">
                                                {{ ($item2->roster) ? $item2->roster->RosterTime : 'Off Day' }}
                                            </td>
                                        @endforeach
                                        {{-- <td class="text-center"><a target="_blank" href="" class="editor_edit text-center" data-id="{{ $item->first()->id }}" data-toggle="modal" data-target="#kt_modal_4"><i class="flaticon-edit text-center"></i></a></td> --}}
                                    </tr>
                                @endforeach

                                @foreach ($rosters as $roster)
                                    <tr class="table-branding">
                                        <td colspan="2" class="text-center">{{ $roster->RosterTime }}</td>
                                        @foreach ($headers as $header)
                                            <td class="text-center">{{ $rosterCount[$roster->id][$header] ?? '-' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>

                            <!--begin::Modal-->
                            <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="role-name">Change Roster Time</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <form id="roster-update-form" action="{{ route('user.roster.revise.change') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="table-id" name="id">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>Roster</label>
                                                            <select name="roster_id" class="form-control" id="roster-id">
                                                                <option value="">Select</option>
                                                                @foreach ($rosters as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->roster_start }} - {{ $item->roster_end }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">

                                                            <div class="kt-checkbox-inline" style="margin-top: 35px">
                                                                <label class="kt-checkbox kt-checkbox--info">
                                                                    <input type="checkbox" name="is_offday" id="off-day"> Off Day
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" id="submit-change" class="btn btn-primary">Change</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--end::Modal-->
                        @else
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                No Data!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                    @endif

                    {{-- <table class="table table-bordered table-hover table-responsive">
                            <thead>
                                @php
                                    $arr = array_unique(array_column($rosterRequests->toArray(), 'date'));
                                @endphp
                                <tr>
                                    <th>#</th>
                                    <th colspan="2">Roster</th>
                                    @foreach ($headers as $header)
                                    <th>{{ \Carbon\Carbon::create($header)->toFormattedDateString() }}</th>
                                    @endforeach
                                    <!-- <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rosters as $roster)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td >{{ $roster->RosterTime }}</td>
                                    @foreach ($headers as $header)
                                    <td>{{ $rosterCount[$roster->id][$header] ?? ' - ' }}</td>
                                    @endforeach

                                    <!-- <td class="text-center"><a target="_blank" href="" class="editor_edit text-center" data-id="{{ $item->first()->id }}" data-toggle="modal" data-target="#kt_modal_4"><i class="flaticon-edit text-center"></i></a></td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table> --}}


                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- end:: Content -->
@endsection

@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>


    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>


    <script>

        $('.editor_edit').on('click', function () {
            let id = $(this).data('id');
            $('#table-id').val(id);
        });

        $('.employee-single-roster').on('click', function () {
            let id = $(this).data('id');
            $('#table-id').val(id);
            $('#kt_modal_4').modal('show');
        });

        $('#off-day').on('click', function () {
            if ($('#off-day').is(":checked")) {
                $('#roster-id').prop('selectedIndex', 0);
                $('#roster-id').prop('disabled', 'disabled');
            } else {
                $('#roster-id').prop('disabled', false);
            }
        });

        $('#submit-change').on('click', function () {
            let rosterID = $('#roster-id').val();
            let offDay = $('#off-day').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change this roster",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    $("#roster-update-form").submit();
                }
            });
        })
    </script>
@endpush
