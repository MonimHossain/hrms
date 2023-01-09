

<form class="kt-form center-division-form" action="{{ route('broadcast.setting.update', ['id'=>$id]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="row">
        <div class="col-xl-5">
            <div class="form-group">
                <label>Email Address</label>
                <div class="kt-form__actions">
                    <input type="text" name="email" value="{{ $emails->email }}" id="" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="kt-form__actions">
                    <button type="submit" class="btn btn-primary ">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>

                        