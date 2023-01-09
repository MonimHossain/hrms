@extends('layouts.app')

@section('content-main')

    <div class="log-form">
        <h2>Please Change the password first.</h2>
        <form method="post" action="{{ route('force-change-password') }}">
            @csrf

            <input type="password" title="New Password" placeholder="New Password" name="password"/>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <input type="password" title="Confirm New Password" placeholder="Confirm New Password" name="password_confirmation"/>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-outline-success center">Change</button>
        </form>
    </div><!--end log form -->


@endsection

@push('css')
<style>
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 300;
        src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v17/mem5YaGs126MiZpBA-UN_r8OUuhs.ttf) format('truetype');
    }
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFVZ0e.ttf) format('truetype');
    }
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 600;
        src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v17/mem5YaGs126MiZpBA-UNirkOUuhs.ttf) format('truetype');
    }
    @font-face {
        font-family: 'Open Sans Condensed';
        font-style: normal;
        font-weight: 300;
        src: local('Open Sans Condensed Light'), local('OpenSansCondensed-Light'), url(https://fonts.gstatic.com/s/opensanscondensed/v14/z7NFdQDnbTkabZAIOl9il_O6KJj73e7Ff1GhDuXMQg.ttf) format('truetype');
    }
    @font-face {
        font-family: 'Open Sans Condensed';
        font-style: normal;
        font-weight: 700;
        src: local('Open Sans Condensed Bold'), local('OpenSansCondensed-Bold'), url(https://fonts.gstatic.com/s/opensanscondensed/v14/z7NFdQDnbTkabZAIOl9il_O6KJj73e7Ff0GmDuXMQg.ttf) format('truetype');
    }
    * {
        box-sizing: border-box;
    }
    body {
        font-family: 'open sans', helvetica, arial, sans;
        background: url(http://farm8.staticflickr.com/7064/6858179818_5d652f531c_h.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .log-form {
        width: 40%;
        min-width: 320px;
        max-width: 475px;
        background: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.25);
    }
    @media (max-width: 40em) {
        .log-form {
            width: 95%;
            position: relative;
            margin: 2.5% auto 0 auto;
            left: 0%;
            -webkit-transform: translate(0%, 0%);
            -moz-transform: translate(0%, 0%);
            -o-transform: translate(0%, 0%);
            -ms-transform: translate(0%, 0%);
            transform: translate(0%, 0%);
        }
    }
    .log-form form {
        display: block;
        width: 100%;
        padding: 2em;
    }
    .log-form h2 {
        color: #fff;
        font-family: 'open sans condensed';
        font-size: 1.35em;
        display: block;
        background: #782B90 !important;
        width: 100%;
        text-transform: uppercase;
        padding: 0.75em 1em 0.75em 1.5em;
        box-shadow: inset 0px 1px 1px rgba(255, 255, 255, 0.05);
        /*border: 1px solid #1d1d1d;*/
        margin: 0;
        font-weight: 200;
    }
    .log-form input {
        display: block;
        margin: auto auto;
        width: 100%;
        margin-bottom: 2em;
        padding: 0.5em 0;
        border: none;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 1.25em;
        color: #757575;
    }
    .log-form input:focus {
        outline: none;
    }
    .log-form  .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: -22px !important;
        margin-bottom: 10px;
        font-size: 80%;
        color: #fd397a;
    }
</style>
@endpush
