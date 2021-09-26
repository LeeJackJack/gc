<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="company_basic" style="display:block;">
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-4">
                <!-- 标题 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>企业名称：</span>
                    <input value="{{isset($company) ? $company->name : ''}}" name="name" type="text"
                           class="form-control" id="name" placeholder="企业全称...">
                </div>
            </div>
            <div class="col-sm-8"></div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <div class="col-md-4">
                <!-- 企业属性 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>企业属性：</span>
                    <input value="{{isset($company) ? $company->property : ''}}" name="property" type="text"
                           class="form-control" id="property" placeholder="民营或国有等...">
                </div>
            </div>
            <div class="col-md-4">
                <!-- 企业规模 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>企业规模：</span>
                    <input value="{{isset($company) ? $company->scale : ''}}" name="scale" type="text"
                           class="form-control" id="scale" placeholder="如：50-100 ...">
                </div>
            </div>
            <div class="col-md-4">
                <!-- 企业类型 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>企业类型：</span>
                    <input value="{{isset($company) ? $company->type : ''}}" name="type" type="text"
                           class="form-control" id="type" placeholder="如：互联网/生物医药等 ...">
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>是否已上市：</span>
                    <select id="is_ipo" class="form-control" name="is_ipo">
                        <option value="0" {{isset($company) && $company->is_ipo == 0 ?  'selected':''}}>否</option>
                        <option value="1" {{isset($company) && $company->is_ipo == 1 ?  'selected':''}}>是</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 企业介绍 -->
            <div class="col-sm-8">
                <div class="input-group">
                    <!-- 选择 -->
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>企业介绍：</span>
                    <textarea id="com_intro" class="form-control" name="com_intro" rows="7" >
                        {{isset($company) ? $company->com_intro : '请填写企业介绍...'}}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    //导航栏切换
    $('#company_basic_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        // $('#cx_people_nav').removeClass('active');
        // $('#cx_principle_nav').removeClass('active');
        // $('#cx_story_nav').removeClass('active');
        // $('#cx_tech_nav').removeClass('active');

        // $('#product_basic').fadeIn(200);
        // $('#cx_people').fadeOut(200);
        // $('#cx_principle').fadeOut(200);
        // $('#cx_story').fadeOut(200);
        // $('#cx_tech').fadeOut(200);
    });

</script>