<?php echo $checklist->questions; ?>
<br>
<br>

<form class="kt-form" action="{{ route('request.clearance.it.approved', ['id'=>$id]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-xl-12">
            <div class="form-group">
                <label>Remarks</label>
                <div class="input-group">
                    <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="kt-form__actions">
                    <button type="submit" class="btn btn-primary ">Approval</button>
                </div>
            </div>
        </div>
    </div>
</form>


