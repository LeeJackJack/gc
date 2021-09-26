<div class="container" id="talent_wanted_job" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    @if(isset($talent->wanted_job) && count($talent->wanted_job) > 0)
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover"
                                   style="text-align: center;table-layout: fixed;">
                                <thead>
                                <tr class="active">
                                    <th style="text-align: center">{{ trans('view.admin.job.title') }}</th>
                                    <th style="text-align: center">{{ trans('view.admin.job.com') }}</th>
                                    <th style="text-align: center">{{ trans('view.admin.job.industry') }}</th>
                                    <th style="text-align: center">{{ trans('view.admin.job.salary') }}</th>
                                    <th style="text-align: center">{{ trans('view.admin.job.hire_count') }}</th>
                                    <th style="text-align: center">{{ trans('view.admin.job.reward') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($talent->wanted_job as $job)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $job->title }}</td>
                                        <td style="vertical-align: middle;">{{ $job->belongsToCompany->name}}</td>
                                        <td style="vertical-align: middle;">{{ $job->belongsToIndustry->label}}</td>
                                        <td style="vertical-align: middle;">{{ $job->salary}}</td>
                                        <td style="vertical-align: middle;">{{ $job->hire_count}}</td>
                                        <td style="vertical-align: middle;">{{ $job->reward}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-sm-12">
                            暂无内容...
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#talent_wanted_job_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#talent_basic_nav').removeClass('active');
        $('#talent_contact_nav').removeClass('active');
        $('#upload_resume_nav').removeClass('active');

        $('#talent_wanted_job').fadeIn(200);
        $('#talent_basic').fadeOut(200);
        $('#talent_contact').fadeOut(200);
        $('#upload_resume').fadeOut(200);
    });

</script>