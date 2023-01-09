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
                    Team: {{$teamList->name}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">


            <!--begin: Datatable -->
            <div id="example">
                @can(_permission(\App\Utils\Permissions::ADMIN_TEAM_CREATE))
                <div class="row">
                    <button title="Add Team Member" data-toggle="modal" data-target="#kt_modal"
                        action="{{ route('employee.team.member.create', ['id'=>$id]) }}"
                        class="btn btn-primary custom-btn globalModal" class="btn btn-outline-primary">Add
                        New Member
                    </button>
                </div>
                @endcan
                <br>
                <div class="row">
                    <div class="kt-portlet__body kt-portlet__body--fit">

                        {{-- Testing --}}
                        <table class="table table-condensed" style="border-collapse:collapse;" id="team-member-list">
                            <thead>
                                <tr>
                                    <th title="Field #1">#</th>
                                    <th title="Field #2">Name</th>
                                    <th title="Field #3">Employee ID</th>
                                    <th title="Field #4">Member Type</th>
                                    <th title="Field #5">Email</th>
                                    <th title="Field #6">Phone</th>
                                    <th title="Field #7">Joining Date</th>
                                    @can(_permission(\App\Utils\Permissions::ADMIN_TEAM_DELETE))
                                    <th title="Field #8">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teamList->employees as $item)
                                {{-- Team leaders child team calculation --}}
                                <?php
                                    $empTeamsHasChild = $item->teamMember()->whereHas('children')->wherePivot('member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();
                                    $teamIds = [];
                                    foreach ($empTeamsHasChild as $teamId) {
                                        $teamIds[] = $teamId->id;
                                    }
                                    $empTeamsHasNotChild = $item->teamMember()->doesntHave('children')->whereNotIn('parent_id', $teamIds)->wherePivot('member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();
                                    $teamService = new \App\Services\TeamService();
                                    $teamTree = $teamService->teamList($empTeamsHasChild);
                                ?>

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if (isset($item->profile_image))

                                        <img class="rounded float-left img-fluid" width='35' style="margin-right:10px;"
                                            src="{{  asset('storage/employee/img/thumbnail/'.$item->profile_image) }}"
                                            alt="user-image">
                                        @elseif(isset($item->gender) && $item->gender == "Male")
                                        <img class="rounded float-left img-fluid" width='35' style="margin-right:10px;"
                                            src="{{  asset('assets/media/users/default_male.png') }}" alt="user-image">
                                        @else
                                        <img class="rounded float-left img-fluid" width='35' style="margin-right:10px;"
                                            src="{{  asset('assets/media/users/default_female.png') }}"
                                            alt="user-image">
                                        @endif
                                        <a href="{{ route('employee.profile', ['id' => $item->id]) }}" target="_blank"
                                            class="kt-link">{{ $item->FullName }}</a>
                                    </td>
                                    <td>{{ $item->employer_id }}</td>
                                    <td>{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->contact_number }}</td>
                                    <td>{{ $item->employeeJourney->doj }}</td>
                                    <td>
                                    <a href="{{ route('employee.permissions.view', ["id" => $item->id]) }}" target="_blank" rel="noopener" class="btn-sm btn-outline-primary btn-elevate btn-icon" data-skin="dark" data-toggle="kt-tooltip" data-placement="top" data-original-title="Role & Permission"  title=""><i class="la la-user-secret"></i></a>&nbsp;


                                        @if($empTeamsHasNotChild->count())
                                        <a data-toggle="collapse" data-target="#demo{{$item->employer_id}}"
                                            class="accordion-toggle" href="#"
                                            class="btn-sm btn-danger team_member_remove"><i data-skin="dark"
                                                data-toggle="kt-tooltip" data-placement="top" title="Click to expand"
                                                class="flaticon-eye"></i></a>
                                        @endif
                                        @can(_permission(\App\Utils\Permissions::ADMIN_TEAM_CREATE))
                                        @if(($item->pivot->member_type == \App\Utils\TeamMemberType::MEMBER) ||
                                        $item->pivot->member_type == \App\Utils\TeamMemberType::ASSTMEMBER)
                                        @if($empTeamsHasNotChild->count())/@endif <a  href="#"
                                            class="text-warning transfer-member" data-toggle="modal" data-target="#transfermodal" data-present-team='{{ $teamList->name }}' data-employeeid="{{ $item->id }}" data-teamid="{{ $teamList->id }}">
                                            <i data-skin="dark" data-toggle="kt-tooltip" data-placement="top"
                                                title="Transfer to another team" class="flaticon-paper-plane-1"></i></a>
                                        @endif
                                        @endcan
                                        @can(_permission(\App\Utils\Permissions::ADMIN_TEAM_DELETE))
                                        @if(($item->pivot->member_type == \App\Utils\TeamMemberType::MEMBER) ||
                                        $item->pivot->member_type == \App\Utils\TeamMemberType::ASSTMEMBER)
                                        / <a id="{{ $item->id }}" team="{{ $teamList->id }}" href="#"
                                            class="text-danger team_member_remove"><i class="flaticon2-trash"></i></a>
                                        @endif
                                        @endcan
                                    </td>
                                </tr>

                                @if($empTeamsHasNotChild->count())
                                <tr>
                                    <td colspan="8" class="hiddenRow">
                                        <div class="accordian-body collapse" id="demo{{$item->employer_id}}">
                                            <table class="table table-condensed" style="margin: 0">
                                                <tbody>
                                                    <tr>
                                                        {{-- here --}}
                                                        <td>
                                                            <div class="teamTree"
                                                                data-teamtree="{{ json_encode($teamTree) }}"
                                                                data-treeid="empteamtree{{$item->employer_id}}">
                                                                <div id="empteamtree{{$item->employer_id}}"></div>
                                                                @foreach($empTeamsHasNotChild as $childTeam)
                                                                <li class="list-group-item node-empteamtree392"><span
                                                                        class="icon glyphicon"></span><span
                                                                        class="icon node-icon"></span><a
                                                                        href="{{ route('employee.setting.team.list', ['id' => $childTeam->id]) }}"
                                                                        style="color:inherit;">{{ $childTeam->name }}
                                                                        <span
                                                                            class="kt-badge kt-badge--unified-{{ ($childTeam->is_functional) ? 'success' : 'warning'}} kt-badge--inline kt-badge--pill">{{ ($childTeam->is_functional) ? 'Functional' : 'Non-functional'}}</span></a>
                                                                </li>
                                                                @endforeach
                                                            </div>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>

                        {{-- End Testing --}}
                    </div>
                </div>
            </div>
            <!--end: Datatable -->

            <!-- Transfer Modal -->
            <div class="modal custom-modal fade" id="transfermodal" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Member Transfer from <span class="text-success" id="present-team"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="kt-form mt-3" action="{{ route('employee.team.treansfer') }}"
                                method="post">
                                @csrf

                                <input type="hidden" value="" name="team_id" id="teamid">
                                <input type="hidden" value="" name="employee_id" id="employeeid">
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="team_lead_id">Team list</label>
                                            <select id="team_lead_id" name="transfer_team_id" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach ($teams as $team)
                                                    <option value="{{$team->id}}"
                                                            data-tokens="{{ $team->name }}">{{ $team->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Applicable From <span class="text-danger">*</span></label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" autocomplete="off" required placeholder="Select date" id="kt_datepicker_3" name="added_at" value="{{ old('added_at') }}"/>
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
                                            <div class="kt-form__actions" style="margin-top: 26px;">
                                                <button type="submit" class="btn btn-primary">Transfer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- /Attendance Modal -->

</div>
</div>
</div>
@endsection
@push('css')
<link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />
<style>
    #team-member-list.table tr {
        cursor: pointer;
    }

    #team-member-list .hiddenRow {
        padding: 0 4px !important;
        background-color: #eeeeee;
        font-size: 13px;
    }

</style>
@endpush

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-treeview@1.2.0/dist/bootstrap-treeview.min.css">
@endpush

@push('library-js')
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script>
{{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>--}}
@endpush

@push('js')
<script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-treeview@1.2.0/dist/bootstrap-treeview.min.js"></script>


<script>
    $(document).ready(function () {

        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
            //.collapse('toggle')
        });

        //Delete Team member
        $("#team-member-list").on('click', '.team_member_remove', function () {
            var id = $(this).attr('id');
            var team = $(this).attr('team');
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
                    window.location.href =
                        "{{ route('employee.team.member.remove', ['', '']) }}/" + id + "/" +
                        team;
                }
            });
        });

        $('.teamTree').each(function (index, value) {
            var id = $(this).data("treeid");
            $('#' + id).treeview({
                enableLinks: true,
                showTags: true,
                highlightSelected: true,
                selectedBackColor: '#782B90',
                levels: 1,
                data: $(this).data("teamtree"),
                showBorder: true,
                expandIcon: 'la la-plus',
                collapseIcon: 'la la-minus',
            });
        });

        $(document).on("click", ".transfer-member", function () {
            var employeeid = $(this).data('employeeid');
            var teamid = $(this).data('teamid');
            var presentTeam = $(this).data('present-team');
            // alert(employeeid);
            $("#transfermodal .modal-body #employeeid").val( employeeid );
            $("#transfermodal .modal-body #teamid").val( teamid );
            $("#transfermodal #present-team").html( presentTeam );
            // As pointed out in comments,
            // it is unnecessary to have to manually call the modal.
            // $('#addBookDialog').modal('show');
        });
    })

</script>
@endpush
