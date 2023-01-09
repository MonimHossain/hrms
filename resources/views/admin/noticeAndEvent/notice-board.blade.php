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
                                        Notice Board
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="row">
                                    @foreach($calendarDataset as $calendarData)
                                    <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                        <div class="card">
                                            <div class="card-block">
                                                <div class="meta">
                                                    <a> <span class="flaticon-calendar-2"></span>&nbsp; {{ date('d/m/Y', strtotime($calendarData->event_date)) }}</a>
                                                    <?php
                                                    if($calendarData->is_pinned == 1){
                                                    ?>
                                                    <i class="pull-right text-bold fas fa-map-pin"></i>
                                                    <?php } ?>
                                                </div>
                                                <h6 class="card-title mt-3">{{ $calendarData->title }}</h6>
                                            </div>
                                            <div class="card-footer">
                                                <a href="{{ route('edit.notices.event', ['id'=> $calendarData->id]) }}">Edit</a> |
                                                <a title="Event Details" data-toggle="modal" data-target="#kt_modal" action="{{ route('show.notices.event', ['id'=> $calendarData->id]) }}" class="card-text custom-btn globalModal">
                                                    Details
                                                </a>
                                                <a href="#">{{ _lang('notice-and-event.status', $calendarData->status) }}</a>
                                            </div>
                                        </div>
                                    </div>
                                     @endforeach

                                </div>
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

@push('css')
    <style>
        .custom-btn {
            cursor: pointer;
            color: #2dbdb6;
            text-decoration: none;
            background-color: transparent;
        }
        .card {
            font-size: 1em;
            overflow: hidden;
            padding: 0;
            border: none;
            border-radius: .28571429rem;
            box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
        }

        .card-block {
            font-size: 1em;
            position: relative;
            margin: 0;
            padding: 1em;
            border: none;
            border-top: 1px solid rgba(34, 36, 38, .1);
            box-shadow: none;
        }

        .card-block h6 {
            font-size: 14px;
            text-align: justify;
        }

        .card-img-top {
            display: block;
            width: 100%;
            height: auto;
        }

        .card-title {
            font-size: 1.28571429em;
            font-weight: 400;
            line-height: 1.2em;
        }

        .card-text {
            clear: both;
            margin-top: .5em;
            color: rgba(0, 0, 0, .68);
        }

        .card-footer {
            font-size: 1em;
            position: static;
            top: 0;
            left: 0;
            max-width: 100%;
            padding: .75em 1em;
            color: rgba(0, 0, 0, .4);
            border-top: 1px solid rgba(0, 0, 0, .05) !important;
            background: #fff;
        }

        .card-inverse .btn {
            border: 1px solid rgba(0, 0, 0, .05);
        }

        .profile {
            position: absolute;
            top: -12px;
            display: inline-block;
            overflow: hidden;
            box-sizing: border-box;
            width: 25px;
            height: 25px;
            margin: 0;
            border: 1px solid #fff;
            border-radius: 50%;
        }

        .profile-avatar {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .profile-inline {
            position: relative;
            top: 0;
            display: inline-block;
        }

        .profile-inline ~ .card-title {
            display: inline-block;
            margin-left: 4px;
            vertical-align: top;
        }

        .text-bold {
            font-weight: 700;
        }

        .meta {
            font-size: 1em;
            color: rgba(0, 0, 0, .4);
        }

        .meta a {
            text-decoration: none;
            color: rgba(0, 0, 0, .4);
        }

        .meta a:hover {
            color: rgba(0, 0, 0, .87);
        }
    </style>
@endpush
