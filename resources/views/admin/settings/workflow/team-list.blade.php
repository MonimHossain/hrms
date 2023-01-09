
@if($workflows)

<div class="card-header alert-info">
    <b>Team List</span></b>
</div>
<ul class="list-group list-group-flush">
    @foreach($workflows as $workflow)
    <li class="list-group-item">{{ $workflow->name }} <span title="Approval Hierarchy Ordering" data-toggle="modal" form-size="modal-md" data-target="#kt_modal" action="{{ route('workflow.approval.hierarchy', ['team_workflow_id'=> $workflow->pivot->workflow_id, 'team_id'=>$workflow->pivot->team_id]) }}" style="cursor: pointer" class="btn-sm btn-outline-info approvalProcessModal pull-right"><i class="fas fa-people-carry"></i></span></li>

    @endforeach
</ul>
@endif
