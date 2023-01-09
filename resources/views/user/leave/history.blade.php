@extends('layouts.container')


@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">

                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Leave History List
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($leaves as $key=> $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->fromEmployee->FullName }}</td>
                            <td>{{ $item->toEmployee->FullName }}</td>
                            <td>{{ trans('leave.status.'.$item->status) }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->remarks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                <!--end::Form-->

            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
@endpush
