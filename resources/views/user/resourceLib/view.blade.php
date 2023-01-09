<p>
{{--<iframe src='{{ url('public/storage/uploads/resources/'.$document_name) }}#toolbar=0&navpanes=0&scrollbar=0' width='100%' height='565px' id="iframe"> </iframe>--}}
<iframe src='{{URL::asset('/storage/uploads/resources/'.$document_name)}}#toolbar=0&navpanes=0&scrollbar=0' width='100%' height='565px' id="iframe"> </iframe>
</p>


@push('js')
    <script>
        jQuery('#iframe').load(function(){
            jQuery('#iframe').contents().find("#toolbarViewerRight").hide();
        });
    </script>
@endpush


