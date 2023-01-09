@push('js')
    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>

    <script>
        // Delete employee
        $(document).on('click', '.confirm', function () {
            var route = $(this).attr('route');
            var smg = $(this).attr('smg');
            Swal.fire({
                title: 'Are you sure?',
                text: smg,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = route;
                }
            });
        });


        var isConfirm = false;
        $('.btn-submit').on('click',function(e){
            e.preventDefault();
            var smg = $(this).attr('smg');
            var form = $(this).parents('form');
            Swal.fire({
                title: 'Are you sure?',
                text: smg,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm!'
            }).then((result) => {
                isConfirm = true;
                if (isConfirm) form.submit();
            });
        });
    </script>
@endpush

