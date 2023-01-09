
<form class="kt-form" id="process-ordering" action="{{ route('process.ordering.save') }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $team_workflow_id }}" name="team_workflow_id">

            <ul id="sortable_nav" class="sortable ui-sortable card-body area">
                @foreach ($exitemp as $key=> $emp)
                    <li class="ui-state-default" style=""><span class="remScnt">X</span>&nbsp;<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        <select name="emp_id[]" class="form-control dropdown">
                                @foreach ($employees as $employee)
                                    <option <?php if($emp->emp_id == $employee->id) echo"selected"; ?> value="{{  $employee->id }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>
                                @endforeach
                        </select>
                        <input type="hidden" class="sortable" name="order_number[]" value="{{ $key+1 }}">
                        <div class="ui-state-default sortable-number">
                            {{ $key+1 }}
                        </div>
                    </li>
                @endforeach
            </ul>

        <button id="addButton" style="margin-left: 20px" class="btn btn-success" type="button">Add</button>
       <div class="modal-footer">
           <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Close</button>
           <button type="button" id="form-submit-button" class="btn btn-primary">Save</button>
       </div>
   </form>

  <style>
  .dropdown{
      display: inline-block;
      margin: 0;
      padding: 0;
      position: relative !important;
      right: 0 !important;
      top: -5px !important;
      width: 90%;
  }
  </style>

   <script>
   var i = $('#sortable_nav li').length;
   $('#addButton').click(function () {
        i++;
        $('.area').append('<li class="ui-state-default"><span class="remScnt">X</span>&nbsp;<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'
        +'<select name="emp_id[]" class="form-control dropdown">'

        @foreach ($employees as $employee)
        +'<option value="{{ $employee->id }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>'
        @endforeach

        +'</select>'
        +'<input class="sortable-number" type="hidden" name="order_number[]" value="'+i+'"><div class="ui-state-default sortable-number">'
        +i+'</div></li>');
   });

    $(document).on('click', '.remScnt', function(){
        $(this).parents('li').remove();
    });


    //save data to process_ordering table
    $("#form-submit-button").click(function (e) {
        var checker = {};
        $(".dropdown").each(function () {
            var selection = $(this).val();
            if (checker[selection]) {
                alert('Duplicate employee');
                return false;
                e.stopPropagation();
                e.preventDefault();
            } else {
                checker[selection] = true;
            }
        });



        var form_data = $('#process-ordering').serialize();
        var form_url = $('#process-ordering').attr("action");
        var form_method = $('#process-ordering').attr("method").toUpperCase();
        $.ajax({
            url: form_url,
            type: form_method,
            data: form_data,
            cache: false,
            success: function (returnhtml) {
                $("#result").html(returnhtml);
            }
        });


    });




   </script>









