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
                                Manage Nearby Locations
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class=" form" action="{{ route('settings.manage.nearbyLocations.create') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row margin-top-10">
                                <div class="input-group col-md-4">
                                    <input type="text" class="form-control" placeholder="Location" name="nearby" required>
                                </div>
                                <div class="input-group col-md-4">
                                    <select name="center_id" id="" class="form-control" required>
                                        <option value="">Select center</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->division->name }} - {{ $center->center }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group col-md-4">
                                    <button class="btn btn-primary" type="submit">ADD</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->

                    <div class="kt-portlet__body">

                        <!--begin::Section-->
                        <div class="kt-section">
                            <div class="kt-section__content">
                                <table class="table table-striped table-hover" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Center</th>
                                        <th>Location</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                                    @foreach ($nearbyLocations as $nearbyLocation)--}}
                                    {{--                                        <tr>--}}
                                    {{--                                            <td>{{ $nearbyLocation->center->center }}</td>--}}
                                    {{--                                            <td>{{ $nearbyLocation->nearby }}</td>--}}
                                    {{--                                            <td>--}}
                                    {{--                                                <a href="{{route('settings.manage.nearbyLocations.edit', ['id' => $nearbyLocation->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;--}}
                                    {{--                                                <a href="#" redirect="settings.manage.nearbyLocations" modelName="NearbyLocation" id="{{ $nearbyLocation->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>--}}
                                    {{--                                            </td>--}}
                                    {{--                                        </tr>--}}
                                    {{--                                    @endforeach--}}

                                    @foreach ($nearbyLocations->groupBy('center_id') as $center => $nearby)
                                        @foreach($nearby as $nearbyLocation)
                                            <tr>
                                                <td>
                                                    @if ($loop->first)
                                                        {{ $nearbyLocation->where('center_id', $center)->first()->center->division->name }} - {{ $nearbyLocation->where('center_id', $center)->first()->center->center }}
                                                    @endif
                                                </td>
                                                <td>{{ $nearbyLocation->nearby }}</td>
                                                <td>
                                                    <a href="{{route('settings.manage.nearbyLocations.edit', ['id' => $nearbyLocation->id])}}" class="editor_edit"><i
                                                            class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                    <a href="#" redirect="settings.manage.nearbyLocations" modelName="NearbyLocation" id="{{ $nearbyLocation->id }}"
                                                       class="lookup_remove"><i class="flaticon-delete"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $nearbyLocations->links() }}
                            </div>
                        </div>
                        <!--end::Section-->

                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@include('layouts.lookup-setup-delete')
