<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="activity_basic" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-6">
                <!-- 标题 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">活动标题：</span>
                    <input value="{{isset($activity) ? $activity->name : ''}}" name="name" type="text"
                           class="form-control" id="name" placeholder="活动标题..." disabled>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 活动时间 -->
            <div class="col-sm-6">
                <div class="input-group">
                    <span for="" class="input-group-addon">活动开始时间：</span>
                    <input value="{{isset($start_time) ? $start_time : ''}}" name="start_time" type="datetime-local"
                           class="form-control" id="start_time" placeholder="开始时间..." disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">活动结束时间：</span>
                    <input value="{{isset($end_time) ? $end_time : ''}}" name="end_time" disabled
                           type="datetime-local"
                           class="form-control" id="end_time" placeholder="请填写活动结束时间...">
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 活动价格 -->
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>活动费用：</span>
                    <input value="{{isset($activity) ? $activity->price : ''}}" name="price" type="text"
                           class="form-control" id="price" placeholder="活动费用..." disabled>
                </div>
            </div>
            <!-- 活动地址 -->
            <div class="col-sm-8">
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;"><span
                        style="color: red;">*</span>活动地址：</span>
                    <input value="{{isset($activity->address) ? $activity->address : ''}}" name="address"
                           type="text"
                           class="form-control" id="address" placeholder="请填写活动地址..." disabled>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="input-group">
                    <span for="" class="input-group-addon">活动封面 ：</span>
                    <img src="{{$activity->pic}}" alt="" class="img-rounded" style="width: 60%;">
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <!-- 活动内容 -->
        <div class="col-md-12">
        {{--<div class="col-md-12">--}}
        {{--<div class="input-group">--}}
        {{--<span for="" class="input-group-addon" style="text-align: left;">活动内容：</span>--}}
        {{--<textarea value="{{isset($activity) ? $activity->detail : ''}}" name="detail" rows="8"--}}
        {{--class="form-control" placeholder="活动内容..."--}}
        {{--disabled>{{isset($activity) ? $activity->detail : ''}}</textarea>--}}
        {{--</div>--}}
        {{--</div>--}}

        <!-- 活动内容，调整为富文本格式 -->
            <script id="activity_ueditor" name="detail_rich_text" type="text/plain">请在此输入活动详情...</script>
            @if(isset($activity))
                <code id="activity_con" style="display:none;">
                    {!! $activity->detail_rich_text !!}
                </code>
            @endif

        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#activity_basic_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#activity_sign_up_nav').removeClass('active');
        $('#form_field_nav').removeClass('active');

        $('#activity_basic').fadeIn(200);
        $('#activity_sign_up').fadeOut(200);
        $('#form_field').fadeOut(200);
    });

    //实例化编辑器
    var activity_ue = UE.getEditor('activity_ueditor', {
        initialFrameHeight: 600,
    });

    activity_ue.ready(function () {
        activity_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        activity_ue.setContent($('#activity_con').html());
        activity_ue.setDisabled();
    });

</script>