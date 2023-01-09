<div class="col-sm-12">
    <div class="kt-portlet kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Change Password<small>change or reset your account password</small></h3>
            </div>
        </div>
        <form class="kt-form kt-form--label-right" action="{{ route('user.change.password') }}" method="post">
            @csrf
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
{{--                                <div class="alert alert-solid-danger alert-bold fade show kt-margin-t-20 kt-margin-b-40" role="alert">--}}
{{--                                    <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>--}}
{{--                                    <div class="alert-text">Configure user passwords to expire periodically. Users will need warning that their passwords are going to expire, <br>or they might inadvertently get locked out of the system!</div>--}}
{{--                                    <div class="alert-close">--}}
{{--                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                            <span aria-hidden="true"><i class="la la-close"></i></span>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control" value="" placeholder="Current password" name="current_password">
{{--                                @error('current_password')--}}
{{--                                <div id="username-error" class="error">{{ $message }}</div>--}}
{{--                                @enderror--}}
                                @if($errors->has('current_password'))
                                    <div class="error">{{ $errors->first('current_password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control" value="" placeholder="New password" name="new_password">
{{--                                @error('new_password')--}}
{{--                                <div id="username-error" class="error">{{ $message }}</div>--}}
{{--                                @enderror--}}
                                @if($errors->has('new_password'))
                                    <div class="error">{{ $errors->first('new_password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-group-last row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control" value="" placeholder="Verify password" name="new_confirm_password">
{{--                                @error('new_confirm_password')--}}
{{--                                <div id="username-error" class="error">{{ $message }}</div>--}}
{{--                                @enderror--}}
                                @if($errors->has('new_confirm_password'))
                                    <div class="error">{{ $errors->first('new_confirm_password') }}</div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3">
                        </div>
                        <div class="col-lg-9 col-xl-9">
                            <button type="submit" class="btn btn-brand btn-bold">Change Password</button>&nbsp;
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
