
<form class="kt-form kt-form--label-right " action="{{ route('user.lead.evaluation.save',['id' => $id]) }}" method="POST">
    @csrf
    <div class="kt-portlet__body">



        <input type="hidden" name="arrayCount" value="{{ count($questionList) }}">

        @foreach($questionList as $question)
           <?php $keyName = $loop->iteration; ?>
            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="">{{ $question->name }} :</label>

                        @foreach($question->labels as $key => $field)
                            @if($field->type == 'textarea')
                                <input type="hidden" name="qstType{{ $keyName }}" value="{{ $field->type }}">
                                <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->marks }}">
                                <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $field->mst_id }}">
                                <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->name }}">
                                <textarea name="ansText{{ $keyName }}" id="" cols="30" rows="2" class="form-control"></textarea>
                            @endif
                        @endforeach

                        @if(!empty($question))
                            @foreach($question->labels as $key => $field)
                                @if($field->type == 'input')
                                    <input type="hidden" name="qstType{{ $keyName }}" value="{{ $field->type }}">
                                    <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->marks }}">
                                    <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $field->mst_id }}">
                                    <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->name }}">
                                    <input type="text" name="ansValue{{ $keyName }}" value="{{ json_encode([$field->value=>$field->label], JSON_FORCE_OBJECT) }}" id="" class="form-control">
                                @endif
                            @endforeach
                        @endif

                        @if(!empty($question))
                            @foreach($question->labels as $key => $field)
                                @if($field->type == 'check')
                                    <label class="kt-checkbox kt-checkbox--info">
                                        <input type="hidden" name="qstType{{ $keyName }}" value="{{ $field->type }}">
                                        <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->marks }}">
                                        <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $field->mst_id }}">
                                        <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->name }}">
                                        <input type="checkbox" name="ansValue{{ $keyName }}" value="{{ json_encode([$field->value=>$field->label], JSON_FORCE_OBJECT) }}"> {{ $field->label }}
                                        <span></span>
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @endif
                            @endforeach
                        @endif

                        @foreach($question->labels as $key => $field)
                            @if($field->type == 'radio')
                                <label class="kt-radio kt-radio--info">
                                    <input type="hidden" name="qstType{{ $keyName }}" value="{{ $field->type }}">
                                    <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->marks }}">
                                    <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $field->mst_id }}">
                                    <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->name }}">
                                    <input type="radio" name="ansValue{{ $keyName }}" value="{{ json_encode([$field->value=>$field->label], JSON_FORCE_OBJECT) }}"> {{ $field->label }}
                                    <span></span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @endif
                        @endforeach

                    </div>

                </div>
            </div>

        @endforeach

    </div>

    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-4">
                    <button type="submit"
                            class="btn btn-primary">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>



@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script !src="">
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
        $('.month-pick').datepicker({
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
    </script>
@endpush






