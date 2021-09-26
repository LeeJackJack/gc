<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="talent_basic" style="display:block;">
    <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-sm-3">
                <!-- 姓名 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">人才姓名：</span>
                    <input value="{{isset($talent) ? $talent->name : ''}}" name="name" type="text"
                           class="form-control" id="name" placeholder="人才姓名..." disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- 专业 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">专业：</span>
                    <input value="{{isset($talent) ? $talent->major : ''}}" name="major" type="text"
                           class="form-control" id="major" placeholder="专业..." disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- 毕业学校 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">毕业学校：</span>
                    <input value="{{isset($talent) ? $talent->school : ''}}" name="school" type="text"
                           class="form-control" id="school" placeholder="毕业学校..." disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- 联系电话 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">联系电话：</span>
                    <input value="{{isset($talent) ? $talent->phone : ''}}" name="phone" type="text"
                           class="form-control" id="phone" placeholder="联系电话..." disabled>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 联系邮箱 -->
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">联系邮箱：</span>
                    <input value="{{isset($talent) ? $talent->email : ''}}" name="email" type="text"
                           class="form-control" id="email" placeholder="联系邮箱..." disabled>
                </div>
            </div>
            <!-- 是否已联系 -->
            <div class="col-md-4">
                <div class="input-group">
                    <span for="" class="input-group-addon">是否已联系：</span>
                    <select id="if_contact" class="form-control" name="if_contact" disabled>
                        <option value="0" {{isset($talent) && $talent->if_contact == 1 ? 'selected':''}}>是</option>
                        <option value="0" {{isset($talent) && $talent->if_contact == 0 ? 'selected':''}}>否</option>
                    </select>
                </div>
            </div>
            <!-- 是否已对接企业 -->
            <div class="col-md-4">
                <div class="input-group">
                    <span for="" class="input-group-addon">是否已对接企业：</span>
                    <select id="if_contact" class="form-control" name="if_contact" disabled>
                        <option value="0" {{isset($talent) && $talent->if_contact_com == 1 ? 'selected':''}}>是</option>
                        <option value="0" {{isset($talent) && $talent->if_contact_com == 0 ? 'selected':''}}>否</option>
                    </select>
                </div>
            </div>
        </div>
    @if(isset($talent))
        <!-- 分隔线 -->
            <div class="col-sm-12" style="padding: 10px 0;">
                <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
            </div>
            <div class="col-md-12" style="margin-bottom: 20px;">
                <!-- 创建时间 -->
                <div class="col-sm-4">
                    <div class="input-group">
                        <span for="" class="input-group-addon">创建时间：</span>
                        <input value="{{isset($talent) ? $talent->created_at : ''}}" name="created_at"
                               type="text"
                               class="form-control" id="created_at" placeholder="创建时间..." disabled>
                    </div>
                </div>
                <!-- 更新时间 -->
                <div class="col-sm-4">
                    <div class="input-group">
                        <span for="" class="input-group-addon">更新时间：</span>
                        <input value="{{isset($talent) ? $talent->updated_at : ''}}" name="updated_at"
                               type="text"
                               class="form-control" id="updated_at" placeholder="更新时间..." disabled>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#talent_basic_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#talent_contact_nav').removeClass('active');
        $('#talent_wanted_job_nav').removeClass('active');
        $('#upload_resume_nav').removeClass('active');

        $('#talent_basic').fadeIn(200);
        $('#talent_contact').fadeOut(200);
        $('#talent_wanted_job').fadeOut(200);
        $('#upload_resume').fadeOut(200);
    });

</script>