@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            @if("add" === $flag)
                                                Add New
                                            @elseif("view" === $flag)
                                                Details                                                
                                            @else
                                                Update Asset
                                            @endif                                                 
                                        </h3>                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->


                    @if("add" === $flag)
                        <form class="kt-form" action="{{ route('asset.create') }}" method="POST">
                    @else
                        <form class="kt-form" action="{{ route('asset.update', ['id'=>$id]) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                    @endif

                        @csrf
                        <div class="col-md-12">
                            <div class="kt-portlet__body">
                                @if($rows)
                                    @if($flag == 'view')
                                        <table class="table">
                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $rows->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Asset ID</td>
                                                <td>{{ $rows->asset_id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Asset Type</td>
                                                <td>{{ $rows->AssetType->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Details</td>
                                                <td>{{ $rows->details }}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td>{{  $rows->price }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>{{ $status[$rows->status] }}</td>
                                            </tr>
                                        </table>
                                    @else 
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Asset Name</label>
                                                <label>
                                                    <input type="text" class="form-control" required name="name" placeholder="Enter Asset Name"
                                                        value="{{ $rows->name }}">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Asset ID</label>
                                                <label>
                                                    <input type="text" class="form-control" required name="asset_id" placeholder="Enter Asset ID"
                                                        value="{{ $rows->asset_id }}">
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Asset type</label>
                                                <label>
                                                    <select name="type_id" class="form-control" id="">
                                                        <option value="">Select type</option>
                                                        @foreach($asset_types as $asset_type)
                                                            <option value="{{ $asset_type->id }}" {{ ($asset_type->id == $rows->type_id) ? 'selected':'' }} >{{ $asset_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Details</label>
                                                <label>
                                                    <textarea name="details" class="form-control" id="" cols="30" rows="10">{{ $rows->details }}</textarea>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Price</label>
                                                <label>
                                                    <input type="text" class="form-control" required name="price" placeholder="Enter Amount"
                                                        value="{{ $rows ->price }}">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-md-2" style="text-align: right">Status</label>
                                                <label>
                                                    <select name="status" class="form-control" id="">                                                    
                                                        <option value="1" {{ ($rows->status == 1) ? 'selected':''  }} >Active</option>
                                                        <option value="0" {{ ($rows->status == 0) ? 'selected':''  }} >Inactive</option>
                                                        <option value="2" {{ ($rows->status == 2) ? 'selected':''  }} >Allicated</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Asset Name</label>
                                            <label>
                                                <input type="text" class="form-control" required name="name" placeholder="Enter Asset Name"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Asset ID</label>
                                            <label>
                                                <input type="text" class="form-control" required name="asset_id" placeholder="Enter Asset ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Asset Type</label>
                                            <label>
                                                <select name="type_id" required class="form-control" id="">
                                                    <option value="">Select type</option>
                                                    @foreach($asset_types as $asset_type)
                                                        <option value="{{ $asset_type->id }}">{{ $asset_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Details</label>
                                            <label>
                                                <textarea name="details" class="form-control" id="" cols="30" rows="10"></textarea>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Price</label>
                                            <label>
                                                <input type="text" class="form-control" required name="price" placeholder="Enter Price" value="">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Status</label>
                                            <label>
                                                <select name="status" class="form-control" id="">                                                    
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                    <option value="2">Allicated</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if("view" != $flag)
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <label for="" class="offset-1">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </label>
                            </div>
                        </div>
                        @endif
                    </form>

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script>
        function getFilePath() {
            // var input = document.getElementById("customFile");
            // var fReader = new FileReader();
            // fReader.readAsDataURL(input.files[0]);
            // fReader.onloadend = function(event){
            //     $("#customFileLabel").empty();
            //     $("#customFileLabel").append(event.target.result);
            // }
            $("#customFileLabel").empty();
            $("#customFileLabel").append(document.getElementById("customFile").files[0].name);
        }


        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }
        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });

        $(document).on('change', '#reward', function () {
            if($("#reward option:selected" ).val() != '-1'){
                $('#other').hide();
            }else{
                $('#other').show();
            }
        });

    </script>

@endpush
