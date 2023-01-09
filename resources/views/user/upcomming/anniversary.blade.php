  <!-- start -->
  <div class="row">
    @foreach($anniversary as $key=> $data)
    <div class="col-md-3">
        <div class="profile-cart">
            <div class="images"><img src="{{ ($data->employeeDetails) ? (($data->employeeDetails->profile_image) ? asset('/storage/employee/img/thumbnail/'.$data->employeeDetails->profile_image) : (($data->employeeDetails->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}" alt=""></div>
            <div class="social-area">
                <h5>{{ $data->FullName }} ({{ $data->employer_id }})</h5>
                {{-- <h6>{{ $data->employeeJourney->designation->name }} | {{ $data->teamMember()->wherePivot('member_type', \App\Utils\TeamMemberType::MEMBER)->first()->name ?? null }}</h6> --}}
                <h6>{{  session()->get('division') }} | {{ session()->get('center') }}</h6>
                <h6>Date : {{  \Carbon\Carbon::parse($data->employeeJourney->doj)->format('d M, Y') }}</h6>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- end -->
