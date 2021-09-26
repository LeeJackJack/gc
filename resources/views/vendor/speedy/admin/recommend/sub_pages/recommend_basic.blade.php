<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="recommend_basic" style="display:block;">
    <div class="page-header" style="margin: 0 0 20px 0;">
        <h3 style="letter-spacing: 2px;">推荐人基本信息 <small>基本信息仅供查看无法修改</small></h3>
    </div>
    <div class="row" style="margin: 0 0 20px 0;">
        <div class="col-md-12" style="margin: 20px 0 0 0;">
            <div class="col-md-3">
                <!-- 被推荐人姓名 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">被推荐人姓名：</span>
                    <input value="{{isset($recommend) ? $recommend->name : ''}}" name="name" type="text"
                           class="form-control " id="name" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- 邮箱 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">邮箱：</span>
                    <input value="{{isset($recommend) ? $recommend->email  : ''}}" name="email" type="text"
                           class="form-control" id="email" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- 推荐类型 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">推荐类型：</span>
                    <input value="{{isset($recommend) ? $recommend->type == 0 ? '自荐':'推荐他人' : ''}}" name="type" type="text"
                           class="form-control" id="type" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- 被推荐人电话 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">被推荐人联系方式：</span>
                    <input value="{{isset($recommend) ? $recommend->phone : ''}}" name="phone" type="text"
                           class="form-control" id="phone" disabled>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <div class="col-sm-4">
                <!-- 被推荐人学历 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">被推荐人学历：</span>
                    <input value="{{isset($recommend) ? $recommend->education : ''}}" name="education" type="text"
                           class="form-control" id="education" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 被推荐人专业 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">被推荐人专业：</span>
                    <input value="{{isset($recommend) ? $recommend->major : ''}}" name="major" type="text"
                           class="form-control" id="major" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 被推荐人专业 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">被推荐人学校：</span>
                    <input value="{{isset($recommend) ? $recommend->school : ''}}" name=school" type="text"
                           class="form-control" id="school" disabled>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <div class="col-sm-4">
                <!-- 推荐人微信名称 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">推荐人微信名称：</span>
                    <input value="{{isset($recommend) ? $recommend->belongsToUser->name : ''}}" name="belongUser"
                           type="text"
                           class="form-control" id="belongUser" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 推荐职位 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">推荐职位：</span>
                    <input value="{{isset($recommend) ? $recommend->belongsToJob->title : ''}}" name="belongJob"
                           type="text"
                           class="form-control" id="belongJob" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 推荐职位 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">职位企业：</span>
                    <input value="{{isset($recommend) ? $recommend->belongsToJob->belongsToCompany->name : ''}}"
                           name="com" type="text"
                           class="form-control" id="belongJob" disabled>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#recommend_basic_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#send_email_nav').removeClass('active');
        $('#hint_control_nav').removeClass('active');

        $('#recommend_basic').fadeIn(200);
        $('#send_email').fadeOut(200)
        $('#hint_control').fadeOut(200)
    });

</script>