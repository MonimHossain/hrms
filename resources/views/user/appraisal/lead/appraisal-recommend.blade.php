<form action="{{ route('user.lead.appraisal.recommend.store', ['id'=>$id]) }}" method="post">
    @csrf
    <input type="hidden" name="_method" value="put">
<div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-5"><label class="bold">Name:</label></div>
                <div class="col-7">{{ $userData->employee->FullName }}</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-5"><label class="bold">Login ID:</label></div>
                <div class="col-7">{{ $userData->employee->employer_id }}</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-5"><label class="bold">Email:</label></div>
                <div class="col-7">{{ $userData->employee->email }}</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-5"><label class="bold">Score:</label></div>
                <div class="col-7">{{ $userData->score }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <label for=""><b>Recommendation For:</b></label>
            <div class="form-group">
                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::CONFIRMATION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::CONFIRMATION) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::EXTENSION_OF_PROBATION_PERIOD }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::EXTENSION_OF_PROBATION_PERIOD) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::PROMOTION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::PROMOTION) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::INCREMENT }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::INCREMENT) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::TRANSFER }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::TRANSFER) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::TERMINATION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::TERMINATION) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::DEMOTION }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::DEMOTION) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="kt-checkbox kt-checkbox--info">
                    <input type="checkbox" name="recommend[]" value="{{ \App\Utils\RecommendationFor::OTHERS }}"> {{ trans('recommendation-for.status.'.\App\Utils\RecommendationFor::OTHERS) }}
                    <span></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <label for=""><b>Recommendation:</b></label>
            <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-outline-primary">Submit</button>
        </div>
    </div>
</div>
</form>

