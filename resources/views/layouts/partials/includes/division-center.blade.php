<script src="{{ asset('assets/js/demo1/axios.min.js') }}"></script>
<script>

    $(document).ready(function () {

        let divisionCenter = (_=>_)({!! json_encode((auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->divisionCenters()->where('is_main', 1)->first() : null) !!});

        // $(".center").each(function() {
        //     let division = $(this).closest('.center-division-item').prev().find('.division');
        //     if(division.val()){
        //         let url = '{{ route("get.center",':divisionID') }}';
        //         url = url.replace(':divisionID', division.val());
        //         let that = division;
        //         axios.get(url).then(function (response) {
        //             that.closest('.center-division-form').children().find(".center").empty();
        //             that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>');
        //             $.each(response.data, function(id, value){
        //                 let selected = ((divisionCenter.center_id == value.id) ? "selected" : "");
        //                 that.closest('.center-division-form').children().find(".center").append('<option '+selected+' value="'+ value.id +'">'+ value.center +'</option>')
        //             });
        //         })
        //         .catch(function (error) {
        //             that.closest('.center-division-form').children().find(".center").empty();
        //             that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>')
        //         })
        //     }
        // });

        $(".division").on('change', function () {
            let divisionID = $(this).val();
            let url = '{{ route("get.center",':divisionID' ) }}';
            url = url.replace(':divisionID', divisionID);
            let that = $(this);
            axios.get(url)
                .then(function (response) {
                    // handle success
                    that.closest('.center-division-form').children().find(".center").empty();
                    that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>');
                    $.each(response.data, function(id, value){
                        that.closest('.center-division-form').children().find(".center").append('<option value="'+ value.id +'">'+ value.center +'</option>')
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    that.closest('.center-division-form').children().find(".center").empty();
                    that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>')
                })
        });

        $(".center").on('change', function () {
            let centerID = $(this).val();
            let url = '{{ route("get.department",':centerID' ) }}';
            url = url.replace(':centerID', centerID);
            let that = $(this);
            axios.get(url)
                .then(function (response) {
                    // handle success
                    that.closest('.center-division-form').children().find(".department").empty();
                    that.closest('.center-division-form').children().find(".department").append('<option value="">Select Department</option>');
                    $.each(response.data, function(id, value){
                        that.closest('.center-division-form').children().find(".department").append('<option value="'+ value.id +'">'+ value.name +'</option>')
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    that.closest('.center-division-form').children().find(".department").empty();
                    that.closest('.center-division-form').children().find(".department").append('<option value="">Select Department</option>')
                })
        });

        $(".department").on('change', function () {
            let processID = $(this).val();
            let url = '{{ route("get.process",':processID' ) }}';
            url = url.replace(':processID', processID);
            let that = $(this);
            axios.get(url)
                .then(function (response) {
                    // handle success
                    that.closest('.center-division-form').children().find(".process").empty();
                    that.closest('.center-division-form').children().find(".process").append('<option value="">Select Process</option>');
                    $.each(response.data, function(id, value){
                        that.closest('.center-division-form').children().find(".process").append('<option value="'+ value.id +'">'+ value.name +'</option>')
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    that.closest('.center-division-form').children().find(".process").empty();
                    that.closest('.center-division-form').children().find(".process").append('<option value="">Select Process</option>')
                })
        });

        $(".process").on('change', function () {
            let processSegmentID = $(this).val();
            let url = '{{ route("get.processSegment",':processSegmentID' ) }}';
            url = url.replace(':processSegmentID', processSegmentID);
            let that = $(this);
            axios.get(url)
                .then(function (response) {
                    // handle success
                    that.closest('.center-division-form').children().find(".process-segment").empty();
                    that.closest('.center-division-form').children().find(".process-segment").append('<option value="">Select Process Segment</option>');
                    $.each(response.data, function(id, value){
                        that.closest('.center-division-form').children().find(".process-segment").append('<option value="'+ value.id +'">'+ value.name +'</option>')
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    that.closest('.center-division-form').children().find(".process-segment").empty();
                    that.closest('.center-division-form').children().find(".process-segment").append('<option value="">Select Process Segment</option>')
                })
        });

    });
</script>
