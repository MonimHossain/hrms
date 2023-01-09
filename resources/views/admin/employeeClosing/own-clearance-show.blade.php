<span><b>Last Working Day : </b>{{ \Carbon\Carbon::parse($application->lwd)->format('d M, Y') }}</span>
<span><br><br><b>Applicant's request :</b><br></span>
{!! $application->application; !!}
<form class="kt-form" action="{{ route('own.department.to.clearance.approved', ['id'=>$id,'flag'=>$flag]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-md-12">
            <div class="kt-checkbox-inline">
                @foreach(\App\Utils\EmployeeClosing::CheckList['whereYouWork'] as $key=>$value)
                    @if ($value != $loop->last)
                        <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                            <input type="checkbox"
                                   <?php
                                   $column = 'own_dept_checklist';
                                   ?>
                                   @if($applicationStatus->{$column})
                                   {{
                                    (in_array($key, $applicationStatus->{$column}))?'checked="checked"':''
                                   }}
                                   @endif
                                   name="checklist[]" value="{{ $key }}"> {{ $value }} <br>
                            <span></span>
                        </label>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-xl-12">
            <div class="form-group">
                <label>Own Department Clearance</label>
                <div class="input-group">
                    <textarea name="remarks" class="form-control textarea" id="" cols="30" rows="2">
                    <?php

                        if(!empty($applicationStatus->own_dept_clearance)){
                           echo $applicationStatus->own_dept_clearance;
                        }else{
                           echo $setting->default_clearance_template;
                        }
                    ?>
                    </textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="form-group">
                <label class="kt-radio kt-radio--tick kt-radio--success"><input
                        type="radio" checked="checked" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['approval']['approved'] }}" name="approval_status" class="is_fixed_officetime">
                    Approved
                    <span></span>
                </label>
                <br>
                <label class="kt-radio kt-radio--tick kt-radio--success"><input
                        type="radio" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['approval']['rejected'] }}"  name="approval_status" class="is_fixed_officetime">
                    Rejected
                    <span></span>
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="kt-form__actions">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>


