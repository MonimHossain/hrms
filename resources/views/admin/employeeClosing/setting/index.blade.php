@extends('layouts.container')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Close Clearance Settings
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
                                  action="{{ route('admin.clearance.checklist.update', ['id'=> 1]) }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                @php
                                    $admin_hod_id = $rows->admin_hod_id ?? 0;
                                    $admin_in_charge_id = $rows->admin_in_charge_id ?? 0;
                                    $accounts_hod_id = $rows->accounts_hod_id ?? 0;
                                    $accounts_in_charge_id = $rows->accounts_in_charge_id ?? 0;
                                    $it_hod_id = $rows->it_hod_id ?? 0;
                                    $it_in_charge_id = $rows->it_in_charge_id ?? 0;
                                    $hr_hod_id = $rows->hr_hod_id ?? 0;
                                    $hr_in_charge_id = $rows->hr_in_charge_id ?? 0;
                                @endphp

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for=""><span class="bold text-primary">Admin</span></label>
                                        <hr>
                                        <div class="form-group">
                                            <label class="">HOD</label>
                                            <select name="admin_hod" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($admin_hod_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Supervisor</label>
                                            <select name="admin_in_charge" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($admin_in_charge_id  == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class=""><b>Checklist</b></label>
                                            {{--<textarea name="admin_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                {{ $rows->admin_clearance_template ?? null }}
                                            </textarea>--}}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="kt-checkbox-inline">
                                                @foreach(\App\Utils\EmployeeClosing::CheckList['admin'] as $key=>$value)
                                                    @if ($value != $loop->last)
                                                        <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name=""> {{ $value }} <br>
                                                            <span></span>
                                                        </label>
                                                    @endif
                                                    @if($loop->last)
                                                        <br><label class="">{{ $value }}</label>
                                                        <textarea name="admin_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                        {{ $rows->admin_clearance_template ?? null }}
                                                    </textarea>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <label for=""><span class="bold text-primary">Accounts</span></label>
                                        <hr>
                                        <div class="form-group">
                                            <label class="">HOD</label>
                                            <select name="accounts_hod" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($accounts_hod_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Supervisor</label>
                                            <select name="accounts_in_charge" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($accounts_in_charge_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class=""><b>Checklist</b></label>
                                            {{--<textarea name="accounts_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                {{ $rows->accounts_clearance_template ?? null  }}
                                            </textarea>--}}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="kt-checkbox-inline">
                                                @foreach(\App\Utils\EmployeeClosing::CheckList['accounts'] as $key=>$value)
                                                    @if ($value != $loop->last)
                                                        <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name=""> {{ $value }} <br>
                                                            <span></span>
                                                        </label>
                                                    @endif
                                                    @if($loop->last)
                                                        <br><label class="">{{ $value }}</label>
                                                        <textarea name="accounts_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                        {{ $rows->accounts_clearance_template ?? null }}
                                                    </textarea>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for=""><span class="bold text-primary">IT</span></label>
                                        <hr>
                                        <div class="form-group">
                                            <label class="">HOD</label>
                                            <select name="it_hod" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($it_hod_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Supervisor</label>
                                            <select name="it_in_charge" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($it_in_charge_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class=""><b>Checklist</b></label>
                                            {{--<textarea name="it_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                {{ $rows->it_clearance_template ?? null }}
                                            </textarea>--}}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="kt-checkbox-inline">
                                                @foreach(\App\Utils\EmployeeClosing::CheckList['it'] as $key=>$value)
                                                    @if ($value != $loop->last)
                                                        <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name=""> {{ $value }} <br>
                                                            <span></span>
                                                        </label>
                                                    @endif
                                                    @if($loop->last)
                                                        <br><label class="">{{ $value }}</label>
                                                        <textarea name="it_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                        {{ $rows->it_clearance_template ?? null }}
                                                    </textarea>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <label for=""><span class="bold text-primary">HR</span></label>
                                        <hr>
                                        <div class="form-group">
                                            <label class="">HOD</label>
                                            <select name="hr_hod" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($hr_hod_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Supervisor</label>
                                            <select name="hr_in_charge" id="" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($employees as $employee)
                                                    <option {{ ($hr_in_charge_id == $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class=""><b>Checklist</b></label>
                                            {{--<textarea name="hr_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                {{ $rows->hr_clearance_template ?? null  }}
                                            </textarea>--}}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="kt-checkbox-inline">
                                                @foreach(\App\Utils\EmployeeClosing::CheckList['hr'] as $key=>$value)
                                                    @if ($value != $loop->last)
                                                        <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                            <input type="checkbox" name=""> {{ $value }} <br>
                                                            <span></span>
                                                        </label>
                                                    @endif
                                                    @if($loop->last)
                                                        <br><label class="">{{ $value }}</label>
                                                        <textarea name="hr_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                        {{ $rows->hr_clearance_template ?? null }}
                                                    </textarea>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <hr>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for=""><span class="bold text-primary">Where Employee Work(Default)</span></label>
                                        <hr>
                                        <div class="form-check-inline">
                                            <label class=""><b>Checklist</b></label>
                                            {{--<textarea name="default_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                {{ $rows->default_clearance_template ?? null }}
                                            </textarea>--}}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="kt-checkbox-inline">
                                                @foreach(\App\Utils\EmployeeClosing::CheckList['whereYouWork'] as $key=>$value)
                                                    @if ($value != $loop->last)
                                                    <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                                        <input type="checkbox" name=""> {{ $value }} <br>
                                                        <span></span>
                                                    </label>
                                                    @endif
                                                    @if($loop->last)
                                                    <br><label class="">{{ $value }}</label>
                                                    <textarea name="default_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                        {{ $rows->default_clearance_template ?? null }}
                                                    </textarea>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <label for=""><span class="bold text-primary">Employee Clearance Template</span></label>
                                        <hr>
                                        <div class="form-group">
                                            <label class="">Checklist</label>
                                            <textarea name="application_clearance_template" class="form-control textarea" id="" cols="30" rows="2">
                                                {{ $rows->clearance_application_template ?? null }}
                                            </textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="kt-portlet__foot">
                                    <div class="kt-form__actions">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <button type="submit" class="btn btn-brand">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

    <script !src="">
        $(document).ready(function () {
            $('.textarea').ckeditor();
            $('.kt-selectpicker').selectpicker();
        })
    </script>
@endpush




