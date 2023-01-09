@push('css')
    <style>
        #process_ordering_table tr{
            cursor: row-resize;
        }
        #process_ordering_table tr:hover {
            background: rebeccapurple;
        }
    </style>
@endpush

<div class="container text-center">
    <div class="group-inline row">
        <select class="col-md-10 pull-right form-control kt-selectpicker" id="selectPerson" data-live-search="true" name="selectPerson">
            @foreach ($employees as $employee)
                <option value="{{ $employee->employeeDetails->id }}">{{ $employee->employeeDetails->employer_id }} - {{ $employee->employeeDetails->FullName }}</option>
            @endforeach
        </select>
        <span class="group-inline col-md-2 pull-right">
            <button type="button" id="addMember" class="btn btn-outline-info pull-right">Add</button>
        </span>
    </div>


    <form class="kt-form" id="process-ordering" action="{{ route('process.ordering.save') }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $team_workflow_id }}" name="team_workflow_id">
        <table class="table pagin-table css-serial" id="process_ordering_table">
            <tbody>

                @foreach ($exitemp as $key=> $emp)
                <tr class="ui-sortable-handle">
                <td><i class="fas fa-arrows-alt text-info"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$key+1}}</td>
                    @foreach ($employees as $employee)
                        @if($emp->emp_id == $employee->employeeDetails->id)
                            <td class="text-left">{{ $employee->employeeDetails->employer_id }} - {{ $employee->employeeDetails->FullName }}<input type="hidden" class="employee_name" value="{{  $employee->employeeDetails->id }}" name="member[]"></td>
                        @endif
                    @endforeach
                    <td><span class="delete pull-right" style="cursor:pointer"><i class="flaticon-delete text-danger"></i></span></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </form>





    <div class="modal-footer">
        <button class="btn btn-outline-danger modal-close" data-dismiss="modal">Close</button>
        <button class="btn btn-outline-success" id="save-process-ordering-btn" type="button" tabindex="-1">Save</button>
    </div>
</div>


    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>


   <script src="{{ asset('assets/js/demo1/pages/components/extended/sweetalert2.js') }}" type="text/javascript"></script>
   <script type="text/javascript">


        //Add new person to approval process
        $('.container').on('click', '#addMember', function (e) {
            e.preventDefault();
            var mySelectValue = $('#selectPerson').val();
            var mySelectText = $('#selectPerson').find('option:selected').text();

            //duplicate selected employee alert and prevent
            var allEmployee = getAllAddEmployee();
            if (jQuery.inArray(mySelectValue, allEmployee)!='-1') {
                swal.fire("<span class='error'>Duplicate!</span>", mySelectText+" is already added!", "");
                return false;
            }

            //add employee
            var newRow = '<tr class="ui-sortable-handle"><td></td><td class="text-left">'+mySelectText+'<input type="hidden" class="employee_name" value="'+mySelectValue+'" name="member[]"></td><td><span class="delete pull-right" style="cursor:pointer"><i class="flaticon-delete text-danger"></i></span></td></tr>';
            $('#process_ordering_table > tbody:last-child').append(newRow).sortable();
            addSerialNumber(); // for serial number
        });

        //remove
        $('#process_ordering_table').on('click', 'span.delete', function () {
            $(this).closest('tr').remove();
            return false;
        });

        // Sortable employee list
        $('tbody').sortable();


        //serial number set
        var addSerialNumber = function () {
            $('#process_ordering_table tr').each(function(index) {
                $(this).find('td:nth-child(1)').html('<i class="fas fa-arrows-alt text-info"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+(index+1));
            });
        };


        //save data to process_ordering table
        $(".modal-footer").on('click', '#save-process-ordering-btn', function (e) {
            var form_data = $('#process-ordering').serialize();
            var form_url = $('#process-ordering').attr("action");
            var form_method = $('#process-ordering').attr("method").toUpperCase();
            $.ajax({
                url: form_url,
                type: form_method,
                data: form_data,
                cache: false,
                success: function (returnhtml) {
                    if(returnhtml){
                        swal.fire("Success!", "Process ordering successfully saved!", "success");
                    }
                }
            });
        });


        //get all add employee list in array
        function getAllAddEmployee() {
            var _elems = $('.employee_name');
            // we store the inputs value inside this array
            var values = [];
            // loop through elements
            _elems.each(function () {
                values.push(this.value);
            });
            return values;
        }



        //select init
        var KTBootstrapSelect = function () {
            // Private functions
            var demos = function () {
                // minimum setup
                $('.kt-selectpicker').selectpicker();

            }
            return {
                // public functions
                init: function () {
                    demos();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTBootstrapSelect.init();
        });

   </script>

