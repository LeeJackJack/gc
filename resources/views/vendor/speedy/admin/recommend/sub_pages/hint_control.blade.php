<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="hint_control" style="display:none;">
    <div class="page-header" style="margin: 0 0 20px 0;">
        <h3 style="letter-spacing: 2px;">推荐状态 <small>选择已联系可以取消未读信息条数提示，其他选择会显示在用户小程序推荐状态上...</small></h3>
    </div>
    <div class="row" style="margin: 0 0 20px 0;">
        <!-- 选择推荐状态及支付状态 -->
        <div class="col-md-12" style="margin: 20px 0 0 0;">
            <div class="col-sm-4">
                <!-- 是否已联系 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>是否已联系：</span>
                    <select id="is_handle" class="form-control" name="is_handle">
                        <option value="0" {{$recommend->is_handle == 0 ? 'selected = "selected"':''}}>未联系</option>
                        <option value="1" {{$recommend->is_handle == 1 ? 'selected = "selected"':''}}>已联系</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 推荐状态 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">推荐状态：</span>
                    <select id="status" class="form-control" name="status">
                        <option value="0" {{$recommend->status == 0 ? 'selected = "selected"':''}}>已接收</option>
                        <option value="1" {{$recommend->status == 1 ? 'selected = "selected"':''}}>面试中</option>
                        <option value="2" {{$recommend->status == 2 ? 'selected = "selected"':''}}>不匹配</option>
                        <option value="3" {{$recommend->status == 3 ? 'selected = "selected"':''}}>入职中</option>
                        <option value="4" {{$recommend->status == 4 ? 'selected = "selected"':''}}>入职成功</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 奖金领取状态 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">奖金领取状态：</span>
                    <select id="is_pay" class="form-control" name="is_pay">
                        <option value="0" {{$recommend->is_pay == 0 ? 'selected = "selected"':''}}>未领取</option>
                        <option value="1" {{$recommend->is_pay == 1 ? 'selected = "selected"':''}}>已领取</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#hint_control_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#recommend_basic_nav').removeClass('active');
        $('#send_email_nav').removeClass('active');

        $('#hint_control').fadeIn(200);
        $('#recommend_basic').fadeOut(200)
        $('#send_email').fadeOut(200)
    });

</script>