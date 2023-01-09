@extends('layouts.app')

@section('content-main')

<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
        <div class="kt-login__container">
            <div class="kt-login__logo text-center" style="margin-top: 120px; margin-bottom:30px">
                <a href="#">
                    <img width="200" src="{{ asset('assets/media/company-logos/logo-2.png') }}">
                </a>

            </div>
            <div class="text-center">
                <div class="kt-login__head">
                    <h2 class="kt-login__title">GENEX HUMAN RESOURCE MANAGEMENT SYSTEM</h2>
                </div>
                <div class="" style="padding: 30px;">
                    <div class="kt-login__head" style="margin-bottom: 15px;">
                        <h3 class="kt-login__title">Forgotten Password ?</h3>
                        <div class="kt-login__desc">Enter your email to reset your password:</div>
                    </div>
                    <form class="kt-form"  method="POST" action="{{ route('password.email') }}">
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
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
                        </div>
                        <div class="kt-login__actions" style="margin-top:15px;">
                            <button id="" class="btn btn-outline-success btn-pill ">Request</button>&nbsp;&nbsp;
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('css')
<link href="{{ asset('assets/css/demo1/pages/general/login/login-2.css') }}" rel="stylesheet" type="text/css" />
<style>
    body {
        background: #ffffff !important;
    }
</style>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo2/pages/login/login-general.js') }}" type="text/javascript"></script>
@endpush
