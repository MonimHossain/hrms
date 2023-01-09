@extends('layouts.container')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="step-first">
                    <div class="kt-grid__item">
                        <!--end: Form Wizard Form-->

                        <div class="kt-portlet" id="kt_portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="flaticon-calendar-2"></i>
												</span>
                                    <h3 class="kt-portlet__head-title">
                                        Event Calender
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div id="kt_calendar"></div>
                            </div>
                        </div>

                        <!--end: Form Wizard Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- end:: Content -->
@endsection


@push('js')
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript">
    </script>

    <!--end::Page Vendors -->

    <!--begin::Page Scripts(used by this page) -->

    <script>
    $(function () {

        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        $('#kt_calendar').fullCalendar({
            isRTL: KTUtil.isRTL(),
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            businessHours: true, // display business hours

            events: [
                @foreach($calendarDataset as $calendarData)
                {
                    title: '{{ $calendarData->title }}',
                    start: '{{ $calendarData->event_date }}',
                    description: '{{ $calendarData->content }}',
                    className: "fc-event-danger fc-event-solid-success"
                },
                @endforeach
            ],

            eventRender: function(event, element) {
                if (element.hasClass('fc-day-grid-event')) {
                    element.data('content', event.description);
                    element.data('placement', 'top');
                    KTApp.initPopover(element);
                } else if (element.hasClass('fc-time-grid-event')) {
                    element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                    element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                }
            }
        });

    });
    </script>
@endpush
