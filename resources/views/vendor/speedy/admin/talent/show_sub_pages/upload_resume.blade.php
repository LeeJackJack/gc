<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="upload_resume" style="display:none;">
    <div class="row">
        <div class="col-md-6" style="margin-top: 20px;">
            <div class="input-group">
                @if(isset($talent->resume_url))
                    <span for="" class="input-group-addon">已传简历 ：</span>
                    <input value="{{isset($talent) ? $talent->resume_url: ''}}" name="resume_url"
                           type="text"
                           class="form-control" id="resume_url" disabled>
                @else
                    未传简历...
                @endif
            </div>
        </div>
        @if(isset($talent->resume_url))
            <div class="col-md-6" style="margin-top: 20px;">
                <div class="input-group">
                    <a type="button" href="{{$talent->resume_url}}" class="btn btn-info" target="_blank">查看</a>
                </div>
            </div>
        @endif
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#upload_resume_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#talent_basic_nav').removeClass('active');
        $('#talent_wanted_job_nav').removeClass('active');
        $('#talent_contact_mav').removeClass('active');

        $('#upload_resume').fadeIn(200);
        $('#talent_contact').fadeOut(200);
        $('#talent_basic').fadeOut(200);
        $('#talent_wanted_job').fadeOut(200);

    });

</script>