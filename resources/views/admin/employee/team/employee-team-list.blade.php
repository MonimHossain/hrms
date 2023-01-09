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
                    Employee Team List
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="col-md-8 offset-3">
                    <form class="form-inline" action="{{ route('employee.team.lists') }}" method="GET">
                        <div class="col-sm-6 mb-2">
                            <label for="inputPassword2" class="sr-only">Employee ID</label>
                            <!-- <input type="text" name="employee_id" value="{{ Request::get('employee_id') ? Request::get('employee_id') : '' }}" class="form-control" placeholder="Employee ID"> -->
                            <select  class="form-control kt-selectpicker @error('team_lead_id') validated @enderror" data-live-search="true" id="team_lead_id"
                                    name="employee_id" required>
                                <option value="">Select</option>
                                    @foreach ($employees as $employee)
                                        <option {{ Request::get('employee_id') == $employee->id ? 'selected' : '' }} value="{{$employee->id}}">{{ $employee->employer_id }} - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </form>
                </div>
                @if($employee_teams)
                    <div class="col-md-10 offset-1">
                        @if($employee_teams->teamMember->count())

                            <table class="table table-bordered">
                                <thead>
                                    <th>Team Name</th>
                                    <th>Member type</th>
                                </thead>
                                @foreach($employee_teams->teamMember as $team)
                                    <tr>
                                        <td>
                                            <a href="{{ route('employee.setting.team.list', ['id'=>$team->id])  }}">{{ $team->name }}</a>
                                        </td>
                                        <td>{{ _lang('team-member-type.member_type',$team->pivot->member_type) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <hr>
                            <h5 class='text-center'>No team found</h5>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
@endpush
