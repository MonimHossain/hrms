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
                        Team(s)
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="kt-section">
                    <div class="kt-section__content">

                        <h5>My Teams</h5>
                        <table class="table table-bordered" id="html_table">
                            <thead>
                            <tr>
                                <th title="Field #1">#</th>
                                <th title="Field #2">Team Name</th>
                                <th title="Field #3">Member Type</th>
                                <th title="Field #4">Total Members</th>
                                <th title="Field #5">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($leadingTeam as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span
                                            class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</span>
                                    </td>
                                    <td>{{ $item->employees->count() }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('user.team.member.list.view', $item->id) }}">View</a>
                                        @can(_permission(\App\Utils\Permissions::USER_ROSTER_CREATE))| <a target="_blank" href="{{ route('user.team.roster.create.view', $item->id) }}">Create
                                            Roster</a>@endcan
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($teamSuperviseLists as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }} </td>
                                    <td><span
                                            class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</span>
                                    </td>
                                    <td>{{ $item->employees->count() }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('user.team.member.list.view', $item->id) }}">View</a>
                                        @can(_permission(\App\Utils\Permissions::USER_ROSTER_CREATE))| <a target="_blank" href="{{ route('user.team.roster.create.view', $item->id) }}">Create
                                            Roster</a>@endcan
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($teamBelongLists as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span
                                            class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</span>
                                    </td>
                                    <td>{{ $item->employees->count() }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('user.team.member.list.view', $item->id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- Team tree --}}
                        @if ($leadingTeam->count())
                        <h6>Teams Tree View</h6>
                        <div id="tree"></div>
                        @endif
                        @foreach($teamLeadListsHasNotChild as $childTeam)
                            <li class="list-group-item node-empteamtree392"><span class="icon glyphicon"></span><span
                                    class="icon node-icon"></span><a
                                    href="{{ route('employee.setting.team.list', ['id' => $childTeam->id]) }}"
                                    style="color:inherit;">{{ $childTeam->name }} <span
                                        class="kt-badge kt-badge--unified-{{ ($childTeam->is_functional) ? 'success' : 'warning'}} kt-badge--inline kt-badge--pill">{{ ($childTeam->is_functional) ? 'Functional' : 'Non-functional'}}</span></a>
                            </li>
                        @endforeach
                    </div>
                </div>

                {{-- @can(_permission(\App\Utils\Permissions::TEAM_VIEW))
                    <div class="kt-section">
                        <div class="kt-section__content">

                        <h5>Teams I'm Leading</h5>
                        @if ($leadingTeam->count())
                                <!--begin: Datatable -->
                                <table class="table table-bordered" id="html_table">
                                    <thead>
                                    <tr>
                                        <th title="Field #1">#</th>
                                        <th title="Field #2">Team Name</th>
                                        <th title="Field #3">Member Type</th>
                                        <th title="Field #4">Total Members</th>
                                        <th title="Field #5">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($leadingTeam as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><span
                                                    class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</span>
                                            </td>
                                            <td>{{ $item->employees->count() }}</td>
                                            <td>
                                                <a target="_blank" href="{{ route('user.team.member.list.view', $item->id) }}">View</a>
                                                @can(_permission(\App\Utils\Permissions::USER_ROSTER_CREATE))| <a target="_blank" href="{{ route('user.team.roster.create.view', $item->id) }}">Create
                                                    Roster</a>@endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end: Datatable -->
                            @else
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    You are not leading any Team.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>


                        @if ($leadingTeam->count())
                        <h6>Teams Tree View</h6>
                        <div id="tree"></div>
                        @endif
                        @foreach($teamLeadListsHasNotChild as $childTeam)
                            <li class="list-group-item node-empteamtree392"><span class="icon glyphicon"></span><span
                                    class="icon node-icon"></span><a
                                    href="{{ route('employee.setting.team.list', ['id' => $childTeam->id]) }}"
                                    style="color:inherit;">{{ $childTeam->name }} <span
                                        class="kt-badge kt-badge--unified-{{ ($childTeam->is_functional) ? 'success' : 'warning'}} kt-badge--inline kt-badge--pill">{{ ($childTeam->is_functional) ? 'Functional' : 'Non-functional'}}</span></a>
                            </li>
                        @endforeach
                    </div>

                    <hr>
                @endcan


                @can(_permission(\App\Utils\Permissions::SUPERVISOR_VIEW))
                        @if ($teamSuperviseLists->count())
                        <div class="kt-section">
                        <div class="kt-section__content">

                            <h5>Teams I'm Supervising</h5>
                            <!--begin: Datatable -->
                                <table class="table table-bordered" id="html_table">
                                    <thead>
                                    <tr>
                                        <th title="Field #1">#</th>
                                        <th title="Field #2">Team Name</th>
                                        <th title="Field #3">Member Type</th>
                                        <th title="Field #4">Total Members</th>
                                        <th title="Field #5">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($teamSuperviseLists as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }} </td>
                                            <td><span
                                                    class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</span>
                                            </td>
                                            <td>{{ $item->employees->count() }}</td>
                                            <td>
                                                <a target="_blank" href="{{ route('user.team.member.list.view', $item->id) }}">View</a>
                                                @can(_permission(\App\Utils\Permissions::USER_ROSTER_CREATE))| <a target="_blank" href="{{ route('user.team.roster.create.view', $item->id) }}">Create
                                                    Roster</a>@endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end: Datatable -->
                        </div>
                        </div>
                        @endif
                    @endcan

                <div class="kt-section">
                    <div class="kt-section__content">

                        <h5>Teams Where I Belongs</h5>
                    @if ($teamBelongLists->count())
                        <!--begin: Datatable -->
                            <table class="table table-bordered" id="html_table">
                                <thead>
                                <tr>
                                    <th title="Field #1">#</th>
                                    <th title="Field #2">Team Name</th>
                                    <th title="Field #3">Member Type</th>
                                    <th title="Field #4">Total Members</th>
                                    <th title="Field #5">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($teamBelongLists as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><span
                                                class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</span>
                                        </td>
                                        <td>{{ $item->employees->count() }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('user.team.member.list.view', $item->id) }}">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        @else
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                You are not in any Team as a member.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-treeview@1.2.0/dist/bootstrap-treeview.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-treeview@1.2.0/dist/bootstrap-treeview.min.js"></script>
    <script !src="">
        let teams = `{!! json_encode($teamTree) !!}`;
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
    </script>

@endpush


