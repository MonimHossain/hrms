    <!-- start -->
    <div class="row">
        @foreach($birthdayData as $key=> $data)
        <div class="col-md-3">
            <div class="profile-cart">
                <div class="images">
                    <img src="{{ ($data->userDetails->employeeDetails) ? (($data->userDetails->employeeDetails->profile_image) ? asset('/storage/employee/img/thumbnail/'.$data->userDetails->employeeDetails->profile_image) : (($data->userDetails->employeeDetails->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}" alt="">
                </div>
                <div class="social-area">
                    <h5>{{ $data->FullName }} ({{ $data->employer_id }})</h5>
                    {{-- <h6>{{ $data->employeeJourney->designation->name }} | {{ $data->teamMember()->wherePivot('member_type', \App\Utils\TeamMemberType::MEMBER)->first()->name ?? null }}</h6> --}}
                    <h6>{{  session()->get('division') }} | {{ session()->get('center') }}</h6>
                    <h6>Date : {{  \Carbon\Carbon::parse($data->date_of_birth)->format('d F') }}</h6>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- end -->

