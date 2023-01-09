    <!--begin::Section-->
    <div id="ck-editor-content">

        <div class="kt-section">
            <div class="kt-section__content">

                @foreach($evaluations as $eval)

                    <input type="hidden" name="arrayCount" value="{{ count($eval->evaluationList) }}">
                    <input type="hidden" name="evaluation_mst" value="{{ $eval->id }}">

                        <div class="form-group row">
                            <div class="col-lg-12">
                                @foreach($eval->evaluationList as $keyName => $question)
                                <div class="form-group">
                                    <label class=""><b>{{ $question->questions->name }} :</b></label>
                                    <input type="hidden" name="id{{ $keyName }}" value="{{ $question->id }}">

                                    @foreach($question->questions->labels as $key => $field)
                                        @if($field->type == 'textarea')
                                            <p>{{ $question->ans_text }}</p>
                                        @endif
                                    @endforeach

                                    @if(!empty($question->questions))
                                        @foreach($question->questions->labels as $key => $field)
                                            @if($field->type == 'input')
                                                <input type="text" disabled name="ansValue{{ $keyName }}" id="" class="form-control">
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(!empty($question->questions))
                                        @foreach($question->questions->labels as $key => $field)
                                            @if($field->type == 'check')
                                                <label class="kt-checkbox kt-checkbox--info">
                                                    <input disabled type="checkbox" {{ (in_array($field->label,json_decode($question->ans_value, true)))?'checked':'' }} name="ansValue{{ $keyName }}" value="{{ $field->value }}"> {{ $field->label }}
                                                    <span></span>
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @endif
                                        @endforeach
                                    @endif

                                    @foreach($question->questions->labels as $key => $field)
                                        @if($field->type == 'radio')
                                            <label class="kt-radio kt-radio--info">
                                                <input type="radio" disabled {{ (in_array($field->label,json_decode($question->ans_value, true)))?'checked':'' }} name="ansValue{{ $keyName }}" value="{{ $field->value }}"> {{ $field->label }}
                                                <span></span>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endif
                                    @endforeach
                                </div>
                                @endforeach
                            </div>


                        </div>

                @endforeach

            </div>
        </div>


        <!--end::Section-->



    </div>


