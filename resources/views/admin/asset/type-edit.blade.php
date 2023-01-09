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
                            Manage Types
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                    <form class="kt-form" action="{{route('asset.types.update', ['id' => $asset->id])}}" method="POST">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group ">
                                <div class="input-group">
                                    <input type="hidden" name="fld_id" value="{{$asset->id}}">
                                    <input type="text" class="form-control" value="{{$asset->name}}" placeholder="Add New Type" name="name">
                                    <input type="hidden" class="form-control" required placeholder="Add New Type" name="status" value="1">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="input-group">
                                    <textarea class="form-control" required placeholder="Add Detals" name="details" id="" cols="30" rows="10">{{$asset->details}}</textarea>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="input-group">
                                    <div class="input-group">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                <!--end::Form-->

                <div class="kt-portlet__body">

                    <div class="kt-section">
                        <div class="kt-section__content">
                            <table class="table table-striped table-hover" id="lookup">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $asset)
                                        <tr>
                                            <td>{{ $asset->name }}</td>
                                            <td>{{ $asset->details }}</td>
                                            <td>
                                                <a href="{{route('asset.types.edit', ['id' => $asset->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="add.new.type" modelName="AssetType" id="{{ $asset->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
