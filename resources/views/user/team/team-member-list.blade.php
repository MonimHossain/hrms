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
                        {{ $team->name }} team's Members
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                {{-- <!--begin: Datatable -->
                <div id="example">
                    @can(_permission(\App\Utils\Permissions::TEAM_CREATE))
                        <button title="Add Team Member" data-toggle="modal" data-target="#kt_modal" action="{{ route('user.team.member.create', ['id'=>$user_id]) }}"
                                class="btn btn-sm btn-primary custom-btn globalModal mb-4" class="btn btn-outline-primary">Add New Member
                        </button>
                    @endcan
                    <br>
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <!--begin: Datatable -->
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th title="Field #1">#</th>
                                    <th title="Field #2">Name</th>
                                    <th title="Field #3">Employee ID</th>
                                    <th title="Field #4">Member Type</th>
                                    <th title="Field #5">Email</th>
                                    <th title="Field #6">Phone</th>
                                    <th title="Field #7">Joining Date</th>
                                    @can(_permission(\App\Utils\Permissions::TEAM_DELETE))
                                        <th title="Field #8">Action</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($teamMemberLists as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (isset($item->profile_image))

                                                <img class="rounded float-left img-fluid" width='35'
                                                     style="margin-right:10px;"
                                                     src="{{  asset('storage/employee/img/thumbnail/'.$item->profile_image) }}"
                                                     alt="user-image">
                                            @elseif(isset($item->gender) && $item->gender == "Male")
                                                <img class="rounded float-left img-fluid" width='35'
                                                     style="margin-right:10px;"
                                                     src="{{  asset('assets/media/users/default_male.png') }}"
                                                     alt="user-image">
                                            @else
                                                <img class="rounded float-left img-fluid" width='35'
                                                     style="margin-right:10px;"
                                                     src="{{  asset('assets/media/users/default_female.png') }}"
                                                     alt="user-image">
                                            @endif
                                            <a href="{{ route('employee.profile', ['id' => $item->id]) }}" target="_blank" class="kt-link">{{ $item->FullName }}</a>
                                        </td>
                                        <td>{{ $item->employer_id }}</td>
                                        <td>{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->contact_number }}</td>
                                        <td>{{ $item->employeeJourney->doj }}</td>
                                        @can(_permission(\App\Utils\Permissions::TEAM_DELETE))
                                            <td>
                                                <a href="{{ route('user.team.member.remove', ['employe_id'=>$item->id, 'user_id'=>$user_id]) }}"
                                                   class="btn btn-sm btn-danger">Remove</a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <!--end: Datatable --> --}}


                <div class="row">
                    @foreach ($teamMemberLists as $item)
                    <div class="col-sm-3">
                        <div data-wow-delay="0.6s" class="osr-team-thumb">
                            <figure class="center-block">
                                @if (isset($item->profile_image))

                                    <img class="rounded-circle img-fluid" src="{{  asset('storage/employee/img/'.$item->profile_image) }}"
                                            alt="user-image">
                                @elseif(isset($item->gender) && $item->gender == "Male")
                                    <img class="rounded-circle img-fluid" src="{{  asset('assets/media/users/default_male.png') }}"
                                            alt="user-image">
                                @else
                                    <img class="rounded-circle img-fluid" src="{{  asset('assets/media/users/default_female.png') }}" alt="user-image">
                                @endif
                            {{-- <img src="extra-images/team-img5.jpg" alt=""> --}}
                            </figure>
                            <div class="text">
                                <h6 class="title">
                                {{-- <a href="#">Jhon Doe</a> --}}
                                <a href="#" target="_blank" class="">{{ $item->FullName }}</a>
                                </h6>
                                <div class="designation">ID - {{ $item->employer_id }}</div>
                                <div class="designation">{{ $item->employeeJourney->designation->name }}</div>
                                <div class="designation">{{ _lang('team-member-type.member_type',$item->pivot->member_type) }}</div>
                                {{-- <ul class="social-list long">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                </ul> --}}
                                {{-- <a href="{{ route('employee.profile', ['id' => $item->id]) }}" data-toggle="tooltip" title="View Profile" class="btn btn-icon btn-outline-primary btn-circle " style="margin: 15px 0px 27px"><i class="flaticon-file"></i></a> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>



            </div>
        </div>
    </div>



@endsection

@push('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush







