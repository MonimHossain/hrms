
<!--end: Form Wizard Form-->


<div class="kt-portlet" id="kt_portlet">
    <div class="kt-portlet__body">

        <img src="{{ asset('storage/hrmsDocs/event/banners/'. $calendarData->banner) }}" alt=""
             class="img-fluid">
        <br>

        <div class="text-left">
            <br>

            <h4>{{ $calendarData->title }}</h4>
            <span><small>{{ $calendarData->created_at->format('d M Y') }}</small></span>
            <hr>
            <p>{{ $calendarData->content }}</p>
        </div>
    </div>
</div>



