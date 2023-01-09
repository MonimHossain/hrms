@extends('layouts.app')

@section('content-main')



<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{ asset('assets/media/bg/bg-genex.jpeg') }}); background-size:cover;">
		<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
			<div class="kt-login__container">
				<div class="kt-login__logo">
					<a href="#">
						<img width="200" src="{{ asset('assets/media/company-logos/logo-2-white.png') }}">
					</a>

				</div>
				<div class="kt-login__signin">
					<div class="kt-login__head">
						<h2 class="kt-login__title">GENEX HUMAN RESOURCE MANAGEMENT SYSTEM</h2>
					</div>
					<form class="kt-form" method="POST" action="{{ route('login') }}" data-url="{{ route('login') }}">
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

                            <div class="input-group kt-input-icon kt-input-icon--left">
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" placeholder="Email / Employee ID" name="email" value="{{ old('email') }}" required autocomplete="email" >
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="fa fa-user"></i></span>
                                </span>
{{--                                @if ($errors->has('email'))--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
                            </div>


                            <div class="input-group kt-input-icon kt-input-icon--left">
                                <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="Password" name="password" required>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="fa fa-unlock-alt"></i></span>
                                </span>
{{--                                @if ($errors->has('password'))--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
                            </div>
                            <div class="row kt-login__extra">
                                <div class="col kt-align-right">
                                    <a href="javascript:;" id="kt_login_forgot" class="kt-link kt-login__link" style="color: #31a2b6;">Forget Password ?</a>
                                </div>
                            </div>
                            <div class="kt-login__actions">
{{--                                <button  class="btn btn-success btn-elevate btn-lg " style="padding: 5px 20px; background: #31a2b6;">LOGIN</button>--}}
                                <button id="" class="btn btn-brand btn-pill btn-lg btn-elevate" style="padding: 5px 20px;">LOGIN</button>
                            </div>
                            <div class="note-div">
                                * For any assistance please contact with HR department.
                            </div>
                            <div class="app-download">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="">
                                            <b>
                                                You can download the android and ios version of the HRMS from here:
                                            </b>
                                        </p>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('app-download') }}" class="btn btn-sm btn-block btn-outline-primary"><i class="fab fa-android"></i> ANDROID</a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('app-download') }}" class="btn btn-sm btn-block btn-outline-primary"><i class="fab fa-apple"></i> iOS</a>
                                    </div>
                                </div>
                            </div>
					</form>
				</div>
                <div class="kt-login__forgot">
                    <div class="kt-login__head">
                        <h3 class="kt-login__title">Forgotten Password ?</h3>
                        <div class="kt-login__desc">Enter your email to reset your password:</div>
                    </div>
                    <form class="kt-form"  method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
                        </div>
                        <div class="kt-login__actions">
                            <button id="" class="btn btn-outline-success btn-pill ">Request</button>&nbsp;&nbsp;
                            <button id="kt_login_forgot_cancel" class="btn btn-outline-danger btn-pill ">Cancel</button>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>
</div>
	</div>

<!-- end:: Page -->

@endsection

@push('css')
<link href="{{ asset('assets/css/demo1/pages/general/login/login-2.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo2/pages/login/login-general.js') }}" type="text/javascript"></script>
@endpush
