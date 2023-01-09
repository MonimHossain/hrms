<form class="kt-form" action="{{ route('workflow.process.save') }}" method="POST">
     @csrf
    <div class="form-group validated">
        <label for="inputWarning" class="form-control-label">Team Name:</label>
        <input type="hidden" name="workflow_id" value="{{ $id }}">
        <div class="input-group">
            <select name="team_id" id="inputWarning" required class="form-control select2-container--bootstrap">
                <option value="">Select</option>
                @foreach ($teams as $team)
                <option value="{{$team->id}}">{{ $team->name }} </option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>
