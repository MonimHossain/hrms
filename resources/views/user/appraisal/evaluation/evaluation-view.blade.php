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

                            <div class="col-lg-12">
                                <hr>
                                <div class="form-group">
                                    <label class=""><b>Lead Remarks :</b></label>
                                    <p>{{ $eval->lead_remarks }}</p>
                                </div>
                            </div>
                        </div>

                @endforeach

            </div>
        </div>

        <hr>
       {{-- @php
            $checkListArray = (!empty($eval->recommendation_for)) ? $eval->recommendation_for : [];
            print_r($checkListArray);
        @endphp

        <div class="row">
            <div class="col-lg-12">
                <label for=""><b>Recommendation For:</b></label>
                <div class="form-group">
                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (in_array(\App\Utils\RecommendationFor::CONFIRMATION, $checkListArray))?'checked':'' }} value="{{ \App\Utils\RecommendationFor::CONFIRMATION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::CONFIRMATION) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (in_array(\App\Utils\RecommendationFor::EXTENSION_OF_PROBATION_PERIOD, $checkListArray))?'checked':'' }} value="{{ \App\Utils\RecommendationFor::EXTENSION_OF_PROBATION_PERIOD }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::EXTENSION_OF_PROBATION_PERIOD) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (in_array(\App\Utils\RecommendationFor::PROMOTION, $checkListArray))?'checked':'' }} value="{{ \App\Utils\RecommendationFor::PROMOTION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::PROMOTION) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (in_array(\App\Utils\RecommendationFor::INCREMENT, $checkListArray))?'checked':'' }} value="{{ \App\Utils\RecommendationFor::INCREMENT }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::INCREMENT) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (in_array(\App\Utils\RecommendationFor::TRANSFER, $checkListArray))?'checked':'' }} value="{{ \App\Utils\RecommendationFor::TRANSFER }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::TRANSFER) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (in_array(\App\Utils\RecommendationFor::TERMINATION, $checkListArray))?'checked':'' }} value="{{ \App\Utils\RecommendationFor::TERMINATION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::TERMINATION) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (!in_array(\App\Utils\RecommendationFor::DEMOTION, $checkListArray))?'':'checked' }} value="{{ \App\Utils\RecommendationFor::DEMOTION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::DEMOTION) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="kt-checkbox kt-checkbox--info">
                        <input type="checkbox" name="recommend[]" {{ (!in_array(\App\Utils\RecommendationFor::OTHERS, $checkListArray))?'':'checked' }} value="{{ \App\Utils\RecommendationFor::OTHERS }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::OTHERS) }}
                        <span></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </div>--}}

        <div class="row">
            @if(!empty($eval->recommendation_for))
                <div class="col-lg-12">
                    <label for=""><b>Recommendation For:</b></label>
                    @foreach(json_decode($eval->recommendation_for, true) as $key => $val)
                    <div class="form-group">{{ $key+1 }} - {{ _lang('recommendation-for.status.'.$val) }}</div>
                    @endforeach
                </div>
            @endif
        </div>



        <!--end::Section-->



    </div>


