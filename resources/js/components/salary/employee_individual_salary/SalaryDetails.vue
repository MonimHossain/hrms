<template>
    <div>
        <!--begin::Portlet-->
        <div class="kt-portlet">

            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <div class="row">
                        <div class="col-sm-12">
                            <div>
                                <h3 style="float: left;" class="kt-portlet__head-title">
                                    Manage Salary
                                </h3>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="employee-list-form" enctype="multipart/form-data" method="POST" action="">
<!--                @csrf-->
                <div class="kt-portlet__body">

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Select Employee:</label>
                            <div class="col-lg-6">
                                <select id="employee_id" name="employee_id" class="form-control kt-selectpicker " data-live-search="true"
                                        data-placeholder="Select Employee" v-model="employeeid">
                                </select>
                                {{ employee_id }}
                            </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="kt-form__actions">
                                    <button type="submit" name="submit" value="apply_wild_leave" class="btn btn-outline-primary" style="margin-top: 0px">
                                        Go
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--end::Form-->

        </div>
        <!--end::Portlet-->
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="">
            <!--        @csrf-->

            <div class="row">
                <div class="col-sm-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>
                                            <h3 style="float: left;" class="kt-portlet__head-title">
                                                Salary Details
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Gross Salary:</label>
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" value="" name="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->


                <div class="col-sm-6">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>
                                            <h3 style="float: left;" class="kt-portlet__head-title">
                                                Allowances
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">House Rent Allowance:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Medical Allowance:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Special Allowance:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Provident Fund Contribution:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Other Allowance:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->

                <div class="col-sm-6">


                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>
                                            <h3 style="float: left;" class="kt-portlet__head-title">
                                                Diduction
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Tax Deduction:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Provident Fund Deduction:</label>
                                <div class="col-sm-8">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>


                        </div>

                    </div>


                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>
                                            <h3 style="float: left;" class="kt-portlet__head-title">
                                                Total Salary Details
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Gross Salary:</label>
                                <div class="col-sm-12">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Total Deduction:</label>
                                <div class="col-sm-12">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">Net Salary:</label>
                                <div class="col-sm-12">
                                    <input class="form-control " type="text" value="" name="">
                                </div>
                            </div>

                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit"
                                                class="btn btn-primary pull-right">
                                            <i class="la la-edit"></i>
                                            Update Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Portlet-->
        </form>
        <!--end::Form-->
    </div>
</template>

<script>
    export default {
        name: "SalaryDetails",
        data() {
            return {
                employeeid: ''
            }
        },
        mounted: function () {
            var vm = this;
            $(this.$el)
                // init select2
                .select2({ data: this.options })
                .val(this.value)
                .trigger('change')
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', this.value)
                })
        },
        watch: {
            value: function (value) {
                // update value
                $(this.$el)
                    .val(value)
                    .trigger('change')
            },
            options: function (options) {
                // update options
                $(this.$el).empty().select2({ data: options })
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>

<style scoped>

</style>
