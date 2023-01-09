<span><b>Last Working Day : </b>{{ \Carbon\Carbon::parse($application->lwd)->format('d M, Y') }}</span>
<span><br><br><b>Applicant's request :</b><br></span>
{!! $application->application; !!}

<form class="kt-form" action="{{ route('request.clearance.clearance.approved', ['id'=>$id]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-md-12">
            <div class="kt-checkbox-inline">
                @foreach(\App\Utils\EmployeeClosing::CheckList[$userType[0]] as $key=>$value)
                    @if ($value != $loop->last)
                        <br><label class="no_margin" class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                            <input type="checkbox"
                                   <?php
                                   $column = $userType[0].'_checklist';
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
                <label>{{ ucwords($userType[0]) }} Clearance</label>
                <div class="input-group">
                    <textarea name="remarks" class="form-control textarea" id="" cols="30" rows="2">
                    <?php

                        $field = $userType[0].'_clearance';

                        if(!empty($applicationStatus->{$field})){
                           echo $applicationStatus->{$field};
                        }else{
                           echo $setting->{$field.'_template'};
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


