@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-sm-6">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Add Bank
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" method="POST" action="{{ route('add.new.bank.submit') }}">
                        @csrf
                        <div class="kt-portlet__body">

                            <div class="form-group">
                                <label>Bank Name:</label>
                                <input class="form-control" type="text" value="" id="" name="bank_name" required>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit"
                                                class="btn btn-primary pull-right">
                                            <i class="la la-edit"></i>
                                            Add Bank
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->

            </div>

            <div class="col-sm-6">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Add Branch
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" method="POST" action="{{ route('add.new.branch.submit') }}">
                        @csrf
                        <div class="kt-portlet__body">

                            <div class="form-group">
                                <label>Bank Name:</label>
                                <select id="bank" name="bank_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Bank Branch Name:</label>
                                <input class="form-control" type="text" value="" id="" name="bank_branch_name" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Routing:</label>
                                <input class="form-control" type="text" value="" id="" name="bank_routing" required>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit"
                                                class="btn btn-primary pull-right">
                                            <i class="la la-edit"></i>
                                            Add Branch
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->

            </div>


            <div class="col-sm-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Bank List
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <div class="kt-section">
                            <div class="kt-section__content">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bank Name</th>
                                        <th>Branches</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($banks as $bank)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>

                                            <td>
                                                {{ $bank->bank_name }}
                                                <a target="_blank" href="" data-toggle="modal" data-bankid="{{ $bank->id }}" data-target="#editBankModal" class="editor_edit"><i
                                                        class="flaticon-edit"></i></a>
                                            </td>
                                            <td>
                                                <!--begin::Timeline 1-->
                                                <div class="kt-list-timeline">
                                                    <div class="kt-list-timeline__items">
                                                        @foreach($bank->bankBranches as $branch)

                                                            <div class="kt-list-timeline__item" style="width: auto;">
                                                                <span class="kt-list-timeline__badge"></span>
                                                                <span class="kt-list-timeline__text" style="padding: 0 0 0 15px;">{{ $branch->bank_branch_name }} <a target="_blank"
                                                                                                                                                                     href=""
                                                                                                                                                                     data-branchid="{{ $branch->id }}"
                                                                                                                                                                     data-toggle="modal"
                                                                                                                                                                     data-target="#editBranchModal"
                                                                                                                                                                     class="editor_edit"><i
                                                                            class="flaticon-edit" style="font-size: 12px"></i></a></span>

                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                <!--end::Timeline 1-->
                                                {{--                                            @foreach($bank->bankBranches as $branch)--}}
                                                {{--                                                {{ $branch->bank_branch_name }}--}}
                                                {{--                                                @if(!$loop->last)--}}
                                                {{--                                                    ,--}}
                                                {{--                                                @endif--}}
                                                {{--                                            @endforeach--}}
                                            </td>
                                            <td>
                                                <a href="{{ route('delete.bank', ['id' => $bank->id]) }}" class="editor_edit"><i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end::Portlet-->

            </div>
        </div>
    </div>



    <!--begin::Modal edit bank-->
    <div class="modal fade" id="editBankModal" tabindex="-1" role="dialog" aria-labelledby="editBank" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBank">Edit bank:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right modal-form" method="POST" action="{{ route('edit.bank.submit') }}">
                        @csrf
                        <input type="hidden" name="bank_id" id="bank-id">
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label>Bank Name:</label>
                                <input class="form-control" type="text" value="" id="edit-bank-name" name="edit_bank_name" required>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit"
                                                class="btn btn-primary pull-right">
                                            <i class="la la-edit"></i>
                                            Update Bank
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->


    <!--begin::Modal edit branch-->
    <div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranch" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranch">Edit Branch:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right modal-form" method="POST" action="{{ route('edit.branch.submit') }}">
                        @csrf
                        <input type="hidden" name="branch_id" id="branch-id">
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label>Branch Name:</label>
                                <input class="form-control" type="text" value="" id="edit-branch-name" name="edit_branch_name" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Routing:</label>
                                <input class="form-control" type="text" value="" id="edit-bank-routing" name="edit_bank_routing" required>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit"
                                                class="btn btn-primary pull-right">
                                            <i class="la la-edit"></i>
                                            Update Branch
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>
        $('#editBankModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('bankid');
            var modal = $(this);
            var url = '{{route('get.bank', ['id' => ':recipient'])}}';
            url = url.replace(':recipient', recipient);

            axios.get(url)
                .then(function (response) {
                    console.log(response.data.bank_name);
                    modal.find('#bank-id').val(response.data.id);
                    modal.find('#edit-bank-name').val(response.data.bank_name);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    modal.find('.modal-form')[0].reset();
                })
        });
    </script>

    <script>
        $('#editBranchModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('branchid');
            var modal = $(this);
            var url = '{{route('get.branchByBranchId', ['id' => ':recipient'])}}';
            url = url.replace(':recipient', recipient);
            console.log(url)
            axios.get(url)
                .then(function (response) {
                    console.log(response.data)
                    modal.find('#branch-id').val(response.data.id);
                    modal.find('#edit-branch-name').val(response.data.bank_branch_name);
                    modal.find('#edit-bank-routing').val(response.data.bank_routing);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    modal.find('.modal-form')[0].reset();
                })
        });
    </script>

@endpush
