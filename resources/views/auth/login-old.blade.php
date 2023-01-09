@extends('layouts.app')

@section('content-main')



    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content"
                     style="background-image: url({{ asset('assets/media/bg/login.png') }}); z-index: 1;">
                    <div id="overlay"></div>
                    <div class="kt-login__section">
                        <div class="kt-login__block">
                            <h5 class="kt-login__title" style="font-size: 3.0rem;margin-bottom: 1rem; text-shadow: #222 1px 0 10px;">WELCOME TO GENEX HRMS</h5>
                            <div class="kt-login__desc text-center" style="text-shadow: #222 1px 0 10px;">
                                SIGN IN TO ACESS YOUR ACCOUNT
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
                    <div class="kt-login__wrapper">
                        <div class="kt-login__container">
                            <div class="kt-login__body">
                                <div class="kt-login__logo">
                                    <a href="/">
                                        <img src="{{ asset('assets/media/company-logos/logo-2.png') }}">
                                    </a>
                                </div>

                                <div class="kt-login__signin">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title">Sign In</h3>
                                    </div>
                                    <div class="kt-login__form">
                                        <form class="kt-form" method="post" action="{{ route('login') }}" data-url="{{ route('login') }}">
                                            @csrf
                                            @if ($errors->has('email') ||$errors->has('password') )
                                            <div class="kt-alert kt-alert--outline alert alert-danger alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                                <span>Incorrect username or password. Please try again.</span>
                                            </div>
                                            @endif
                                            @if (session('status'))
                                                <div class="kt-alert kt-alert--outline alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                                    <span>{{ session('status') }}</span>
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Email / Employee ID"
                                                       name="email" autocomplete="email" autofocus value="{{ old('email') }}">
{{--                                                @if ($errors->has('email'))--}}
{{--                                                    <span class="invalid-feedback" role="alert">--}}
{{--                                                        <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                                    </span>--}}
{{--                                                @endif--}}
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-last" type="password"
                                                       placeholder="Password" name="password">
{{--                                                @if ($errors->has('password'))--}}
{{--                                                    <span class="invalid-feedback" role="alert">--}}
{{--                                                        <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                                    </span>--}}
{{--                                                @endif--}}
                                            </div>
                                            <div class="kt-login__extra">
                                                <label class="kt-checkbox">
                                                    {{--                                                    <input type="checkbox" name="remember"> Remember me--}}
                                                    {{--                                                    <span></span>--}}
                                                </label>
                                                <a href="javascript:;" id="kt_login_forgot">Forget Password ?</a>
                                            </div>
                                            <div class="kt-login__actions">
                                                <button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate">Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{--                                <div class="kt-login__signup">--}}
                                {{--                                    <div class="kt-login__head">--}}
                                {{--                                        <h3 class="kt-login__title">Sign Up</h3>--}}
                                {{--                                        <div class="kt-login__desc">Enter your details to create your account:</div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="kt-login__form">--}}
                                {{--                                        <form class="kt-form" action="">--}}
                                {{--                                            <div class="form-group">--}}
                                {{--                                                <input class="form-control" type="text" placeholder="Fullname" name="fullname">--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="form-group">--}}
                                {{--                                                <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="form-group">--}}
                                {{--                                                <input class="form-control" type="password" placeholder="Password" name="password">--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="form-group">--}}
                                {{--                                                <input class="form-control form-control-last" type="password" placeholder="Confirm Password" name="rpassword">--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="kt-login__extra">--}}
                                {{--                                                <label class="kt-checkbox">--}}
                                {{--                                                    <input type="checkbox" name="agree"> I Agree the <a href="#">terms and conditions</a>.--}}
                                {{--                                                    <span></span>--}}
                                {{--                                                </label>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="kt-login__actions">--}}
                                {{--                                                <button id="kt_login_signup_submit" class="btn btn-brand btn-pill btn-elevate">Sign Up</button>--}}
                                {{--                                                <button id="kt_login_signup_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>--}}
                                {{--                                            </div>--}}
                                {{--                                        </form>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <div class="kt-login__forgot">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title">Forgotten Password ?</h3>
                                        <div class="kt-login__desc">Enter your email to reset your password:</div>
                                    </div>
                                    <div class="kt-login__form">
                                        <form class="kt-form"  method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="email" autofocus value="{{ old('email') }}" >
                                            </div>
                                            <div class="kt-login__actions">
                                                <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill btn-elevate">Request</button>
                                                <button id="kt_login_forgot_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="kt-login__account">--}}
                        {{--                            <span class="kt-login__account-msg">--}}
                        {{--                                Don't have an account yet ?--}}
                        {{--                            </span>&nbsp;&nbsp;--}}
                        {{--                            <a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Sign Up!</a>--}}
                        {{--                        </div>--}}
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- end:: Page -->

@endsection

@push('css')
    <link href="{{ asset('assets/css/demo1/pages/general/login/login-6.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/login/login-general.js') }}" type="text/javascript"></script>
@endpush
