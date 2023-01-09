@push('js')

    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>

    <script>
        // Delete employee
        $("#lookup").on('click', '.lookup_remove', function () {
            var id = $(this).attr('id');
            var modelName = $(this).attr('modelName');
            var redirect = $(this).attr('redirect');
            var getRouteId = (typeof $(this).attr('getRouteId') !== "undefined") ? $(this).attr('getRouteId') : null;
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this entry",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = "{{ route('settings.manage.delete', ['', '', '']) }}/"+id+'/'+modelName+'/'+redirect+'/'+getRouteId;
                }
            });
        });
    </script>
@endpush
