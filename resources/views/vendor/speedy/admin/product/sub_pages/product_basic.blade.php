<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="product_basic" style="display:block;">
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-4">
                <!-- 标题 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>产品标题：</span>
                    <input value="{{isset($product) ? $product->title : ''}}" name="title" type="text"
                           class="form-control" id="title" placeholder="产品标题...">
                </div>
            </div>
            <!-- 产品简介 -->
            <div class="col-sm-8">
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>产品简介：</span>
                    <textarea value="{{isset($product) ? $product->cx_intro : ''}}" name="cx_intro" rows="3"
                              class="form-control" placeholder="产品简介...">{{isset($product) ? $product->cx_intro : ''}}</textarea>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 产品类别 -->
            <div class="col-sm-4">
                <div class="input-group">
                    <!-- 选择 -->
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>请选择类别：</span>
                    <select id="type" class="form-control" name="type">
                        <option value="">无</option>
                        @foreach($types as $t)
                            <option value="{{$t}}" {{isset($product) && $product->type == $t->code ? $product->type? 'selected':'' :''}}>{{$t->label ? $t->label : ''}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 排序号 -->
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">排序号：</span>
                    <input value="{{isset($product->order_id) ? $product->order_id : ''}}" name="order_id"
                           type="number"
                           class="form-control" id="order_id" placeholder="排序（小的置顶）...">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 是否推荐 -->
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">是否推荐：</span>
                    <select id="is_recommend" class="form-control" name="is_recommend">
                        <option value="" {{isset($product) && $product->is_recommend == null ? 'selected':''}}>无</option>
                        <option value="1" {{isset($product) && $product->is_recommend == '1' ? 'selected':''}}>是</option>
                        <option value="0" {{isset($product) && $product->is_recommend == '0' ? 'selected':''}}>否</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <!-- 上传产品封面 -->
        <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon">产品封面 ：</span>
                    <input type="file" name="pic" value="{{isset($product->pic) ? $product->pic : ''}}">
                    @if(isset($product->pic))
                        <img src="{{$product->pic}}" alt="" class="img-rounded" style="margin: 30px 0 0 0;width: 60%;">
                    @endif
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon">内容页封面 ：</span>
                    <input type="file" name="detail_pic" value="{{isset($product->detail_pic) ? $product->detail_pic : ''}}">
                    @if(isset($product->detail_pic))
                        <img src="{{$product->detail_pic}}" alt="" class="img-rounded" style="margin: 30px 0 0 0;width: 60%;">
                    @endif
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>

        <!-- 填写音频地址及标题 -->
        <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>创始人名称：</span>
                    <input type="text" name="founder_name" value="{{isset($product) ? $product->founder_name : '-' }}" class="form-control" placeholder="请准确填写创始人姓名，否则匹配相关语音...">
                </div>
            </div>
        </div>

        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#product_basic_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#cx_people_nav').removeClass('active');
        $('#cx_principle_nav').removeClass('active');
        $('#cx_story_nav').removeClass('active');
        $('#cx_tech_nav').removeClass('active');

        $('#product_basic').fadeIn(200);
        $('#cx_people').fadeOut(200);
        $('#cx_principle').fadeOut(200);
        $('#cx_story').fadeOut(200);
        $('#cx_tech').fadeOut(200);
    });

</script>