<form action="{{ route('admin.report.account-completion-email-send', ['id'=> $id]) }}" method="post">
@csrf
    <div class="form-group">
        <!-- Your Account Completed {{ $id }}%.  -->
        <textarea name="body" id="" cols="30" rows="2" class="form-control">Please be informed, your HRMS profile is not up to date. Please update your profile urgently</textarea>
        <br>
        <input type="submit" value="Submit" class="btn btn-primary">
    </div>
</form>