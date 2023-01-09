
<form class="kt-form" action="{{ route('employee.hierarchy.save') }}" method="POST">
        @csrf
        <ul id="sortable_nav" class="sortable ui-sortable card-body">

            <li class="ui-state-default" style=""><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                Team Lead :
                <input type="hidden" value="{{ $team->id }}" name="team_emp_id[]">
                <div class="ui-state-default sortable-number">
                    1
                </div>
            </li>

            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                Supervisor One :
                <input type="hidden" value="{{ $supOne->id }}" name="team_emp_id[]">
                <div class="ui-state-default sortable-number">
                    2
                </div>
            </li>

            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                Supervisor Two :
                <input type="hidden" value="{{ $supTwo->id }}" name="team_emp_id[]">
                <div class="ui-state-default sortable-number">
                    3
                </div>
            </li>

            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                Supervisor Three :
                <input type="hidden" value="{{ $supThree->id }}" name="team_emp_id[]">
                <div class="ui-state-default sortable-number">
                    4
                </div>
            </li>

        </ul>



       <div class="modal-footer">
           <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-primary">Save</button>
       </div>
   </form>









