<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
    <!-- begin:: Header Menu -->
    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
            class="la la-close"></i></button>
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">

    </div>

    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->
    <div class="kt-header__topbar">

        @if(session()->exists('division') && session()->exists('center') && session()->get('validateRole') != 'User')
            <div class="dropdown switch-dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ session()->get('division') }} - {{ session()->get('center') }}
                </button>
                <div class="dropdown-menu">
                    <form class="px-4 py-3 center-division-form" action="{{ route('switch.division.center') }}" method="post">
                        @csrf
                        <div class="form-group center-division-item">
                            <label for="division">Division</label>
                            <select class="form-control division" id="" name="division_id" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $item)
                                    <option {{ (session()->get('division') == $item->name) ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group center-division-item">
                            <label for="center">Choose Default Center</label>
                            <select class="form-control center" id="" name="center_id" required>
                                <option value="">Select Center</option>
                                @if ($centers)
                                    @foreach($centers as $item)
                                        <option {{ (session()->get('center') == $item->center) ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->center }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('center_id')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox kt-checkbox--success">
                                    <input type="checkbox" class="form-check-input" id="dropdownCheck" name="set_default"> Set as default
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Switch</button>
                    </form>
                </div>
            </div>
        @endif

        <notification :userid="(_=>_)({{ auth()->user()->id }})" :unreads="(_=>_)({{ auth()->user()->unreadNotifications }})" :reads="(_=>_)({{ auth()->user()->readNotifications }})"></notification>

        <!--begin: User Bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                    <span class="kt-header__topbar-username kt-hidden-mobile">{{ (auth()->user()->employee_id) ? auth()->user()->employeeDetails->first_name : 'Admin' }}</span>
                    <img class="header-user-image" alt="Pic"
                         src="{{ (auth()->user()->employeeDetails) ? ((auth()->user()->employeeDetails->profile_image) ? asset('/storage/employee/img/thumbnail/'.auth()->user()->employeeDetails->profile_image) : ((auth()->user()->employeeDetails->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}"/>

                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                    <span class="kt-badge kt-hidden kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">S</span>
                </div>
            </div>
            <div
                class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                <!--begin: Head -->
                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                     style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
                    <div class="kt-user-card__avatar">
                        <img class="header-user-image" alt="Pic"
                             src="{{ (auth()->user()->employeeDetails) ? ((auth()->user()->employeeDetails->profile_image) ? asset('/storage/employee/img/thumbnail/'.auth()->user()->employeeDetails->profile_image) : ((auth()->user()->employeeDetails->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}"/>

                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <span class="kt-badge kt-hidden kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">S</span>
                    </div>
                    <div class="kt-user-card__name">
                        {{ (auth()->user()->employee_id) ? auth()->user()->employeeDetails->FullName : 'Admin' }}
                    </div>
                </div>

                <!--end: Head -->

                <!--begin: Navigation -->
                <div class="kt-notification">
                    <a href="javascript: void(0);" class="kt-notification__item">
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                Last Login : {{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans() }}
                            </div>
                            <div class="kt-notification__item-time">
                                Last Login IP: {{ auth()->user()->last_login_ip }}
                            </div>
                        </div>
                    </a>
                    @role('Super Admin')
                    <a href="{{ route('super.admin.change.password') }}" class="kt-notification__item">
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                Change Super Admin Password
                            </div>
                        </div>
                    </a>
                    @endrole
                    @if(session()->get('validateRole') == 'User')
                    <a href="{{route('user.home')}}" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-calendar-3 kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                My Profile
                            </div>
                            <div class="kt-notification__item-time">
                                Account settings and more
                            </div>
                        </div>
                    </a>
                    @endif

                    <div class="kt-notification__custom kt-space-between">
                        @if(Auth::user()->isImpersonating())
                            <a href="{{ route('stopImpersonate') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Stop Impersonate</a>
                        @else
                            @if(auth()->user()->hasAnyRole('Super Admin|Admin') && request()->session()->get('validateRole') == 'User')
                                <a href="" data-toggle="modal" data-target="#admin_login_pass" class="btn btn-label btn-label-brand btn-sm btn-bold">Login as Admin</a>
                            @elseif(auth()->user()->hasRole('User') && request()->session()->get('validateRole') == 'Admin')
                                <a href="{{ route('user.loginAsAdmin') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Login as User</a>
                            @endif
                        @endif


                        <a href="{{ route('logout') }}" target="_blank"
                           class="btn btn-label btn-label-brand btn-sm btn-bold float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }} </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

                <!--end: Navigation -->
            </div>
        </div>

        <!--end: User Bar -->
    </div>

    <!-- end:: Header Topbar -->
</div>

<!-- end:: Header -->


<!--Start::Modal-Global-Modal-->
<div class="modal fade" data-backdrop="static" id="kt_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Title</h5>
                <button type="button" class="close" data-dismiss="modal">&nbsp;</button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<!--End::Modal-Global-Modal-->


<!--begin::Modal-->
<div class="modal fade" id="admin_login_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Switch Account:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('user.loginAsAdmin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="employee_id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                        <label for="password" class="form-control-label">Password:</label>
                        <input type="password" class="form-control" id="password" autofocus name="password">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-danger col-12" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-outline-primary col-12">Login as Admin</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->


