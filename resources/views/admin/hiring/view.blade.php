<div id="collapseOne4" aria-labelledby="headingOne" data-parent="#accordionExample4" class="collapse show" style="">
    <div class="card-body">
        <div class="card-content">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-3"><label class="bold">Job Title:</label></div>
                        <div class="col-9">{{ $views->job_title ?? '' }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-5"><label class="bold">Vacancy:</label></div>
                        <div class="col-7">{{ $views->number_of_vacancy ?? '' }}</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-5"><label class="bold">Status:</label></div>
                        <div class="col-7">{{ _lang('document-and-letter.status', $views->status) }}</div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-4"><label class="bold">Date:&nbsp;</label></div>
                        <div class="col-6">{{  date_format(date_create("$views->expected_date"),"d/m/Y") }}</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-4"><label class="bold">Proposed By:</label></div>
                        <div class="col-8">{{ $views->createdBy->employer_id ?? '' }}-{{ $views->createdBy->FullName ?? '' }}</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-5"><label class="bold">Approved By:</label></div>
                        <div class="col-7">{{ $views->approvedBy->employer_id ?? '' }}-{{ $views->approvedBy->FullName ?? '' }}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-3"><label class="bold">Min Salary:</label></div>
                        <div class="col-9">{{ $views->min_salary ?? '' }}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-3"><label class="bold">Max Salary:</label></div>
                        <div class="col-9">{{ $views->max_salary ?? '' }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <label class="bold">Job Requirement</label>
                    <div class="col-7">
                        {!! $views->job_requirement ?? '' !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <label class="bold">Job Description</label>
                    <div class="col-7">
                        {!! $views->job_description ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
