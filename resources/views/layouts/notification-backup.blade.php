<div class="kt-header__topbar-item dropdown">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="false">
                            <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
                                <i class="flaticon-alert"></i>
                                @if (auth()->user()->unreadNotifications->count())
                                    <span class="kt-pulse__ring"></span>
                                @endif
                            </span>


        @if (auth()->user()->unreadNotifications->count())
            <span class="kt-badge kt-badge--danger" style="margin: 18px 0 0 -12px;">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg" x-placement="bottom-end"
         style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(44px, 64px, 0px);">
        <form>

            <!--begin: Head -->
            <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url({{ asset('assets/media/misc/bg-1.jpg')}})">
                <h3 class="kt-head__title">
                    Notifications
                    &nbsp;
                    <span class="btn btn-success btn-sm btn-bold btn-font-md">{{ auth()->user()->unreadNotifications->count() }}</span>
                </h3>
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">

                </ul>
            </div>
            <a class="nav-link active show pull-left" href="{{ route('user.notification.markAllRead', ['user' => auth()->user()->id]) }}">Mark all as read</a>
            <a class="nav-link active show pull-right" href="{{ route('user.notification.deleteAll', ['user' => auth()->user()->id]) }}">Delete All</a>
            <br>
            <div class="clearfix"></div>
            <!--end: Head -->
            <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll ps" data-scroll="true" data-height="300" data-mobile-height="200"
                 style="height: 300px; overflow: hidden;">
                @foreach (auth()->user()->unreadNotifications as $notification)

                    @include('layouts.partials.notification.'.snake_case(class_basename($notification->type)))

                @endforeach
                @foreach (auth()->user()->readNotifications as $notification)
                    @include('layouts.partials.notification.'.snake_case(class_basename($notification->type)))
{{--                                                        <a href="{{ route($notification->data['route']) }}" class="kt-notification__item">--}}
{{--                                                            <div class="kt-notification__item-icon">--}}
{{--                                                                <i class="flaticon-info kt-font-success"></i>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="kt-notification__item-details">--}}
{{--                                                                <div class="kt-notification__item-title text-black-50">--}}
{{--                                                                    {{ $notification->data['data'] }}--}}
{{--                                                                </div>--}}
{{--                                                                 <div class="kt-notification__item-time">--}}
{{--                                                                    2 hrs ago--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </a>--}}
                @endforeach


                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                </div>
            </div>

        </form>
    </div>
</div>
