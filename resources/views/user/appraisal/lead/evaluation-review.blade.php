<form action="{{ route('user.lead.evaluation.review.store', ['id'=>$mstId]) }}" method="POST">
    @csrf

    <input type="hidden" name="_method" value="put">

    <!--begin::Section-->
    <div id="ck-editor-content">

        <div class="kt-section">
            <div class="kt-section__content">
                <input type="hidden" name="arrayCount" value="{{ count($evaluations->evaluationList) }}">
                @foreach($evaluations->evaluationList as $keyName => $question)
                    <?php $keyName = $loop->iteration; ?>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="">{{ $question->qst_name }} :</label>
                                    @if($question->qst_type == 'textarea')
                                        <input type="hidden" name="qstType{{ $keyName }}" value="{{ $question->qst_type }}">
                                        <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->qst_mark }}">
                                        <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $question->evaluation_mst }}">
                                        <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->qst_name }}">
                                        <textarea name="ansText{{ $keyName }}" id="" cols="30" rows="2" class="form-control">{{ $question->ans_value }}</textarea>
                                    @endif

                                @if(!empty($question))
                                    @if($question->qst_type == 'input')
                                        <input type="hidden" name="qstType{{ $keyName }}" value="{{ $question->qst_type }}">
                                        <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->qst_mark }}">
                                        <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $question->evaluation_mst }}">
                                        <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->qst_name }}">
                                        <input type="text" name="ansValue{{ $keyName }}" value="{{ $question->ans_value }}" id="" class="form-control">
                                    @endif
                                @endif

                                @if(!empty($question))
                                    @if($question->qst_type == 'check')
                                        @foreach($question->qstList as $qst)
                                                <label class="kt-checkbox kt-checkbox--info">
                                                    <input type="hidden" name="qstType{{ $keyName }}" value="{{ $question->qst_type }}">
                                                    <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->qst_mark }}">
                                                    <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $question->evaluation_mst }}">
                                                    <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->qst_name }}">
                                                    <input type="checkbox" name="ansValue{{ $keyName }}" {{ in_array($qst->label, json_decode($question->ans_value, true)) ? 'checked="checked"':'' }} value="{{ json_encode([$qst->value => $qst->label], JSON_FORCE_OBJECT) }}" id="" class="form-control">{{ $qst->label }}
                                                    <span></span>
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endforeach
                                    @endif
                                @endif

                                @if(!empty($question))
                                    @if($question->qst_type == 'radio')
                                        @foreach($question->qstList as $qst)
                                                    <label class="kt-radio kt-radio--info">
                                                        <input type="hidden" name="qstType{{ $keyName }}" value="{{ $question->qst_type }}">
                                                        <input type="hidden" name="qstMark{{ $keyName }}" value="{{ $question->qst_mark }}">
                                                        <input type="hidden" name="qstNo{{ $keyName }}" value="{{ $question->qst_no }}">
                                                        <input type="hidden" name="qstName{{ $keyName }}" value="{{ $question->qst_name }}">
                                                        <input type="radio" name="ansValue{{ $keyName }}" {{ in_array($qst->label, json_decode($question->ans_value, true)) ? 'checked="checked"':'' }} value="{{ json_encode([$qst->value => $qst->label], JSON_FORCE_OBJECT) }}" id="" class="form-control">{{ $qst->label }}
                                                        <span></span>
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endforeach
                                    @endif
                                @endif

                            </div>

                        </div>
                    </div>

                @endforeach

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <label for="lead_remarks">Remarks</label>
                <textarea name="lead_remarks" id="" cols="30" class="form-control" rows="2">
                    {{ $evaluations->lead_remarks }}
                </textarea>
            </div>
        </div>

        <hr>
        @php
            $checkListArray = (!empty($evaluations->recommendation_for)) ? json_decode($evaluations->recommendation_for, true) : [];
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
        </div>


        <!--end::Section-->

        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </div>

    </div>
</form>

