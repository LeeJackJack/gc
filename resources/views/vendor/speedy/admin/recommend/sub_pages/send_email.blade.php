<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="send_email" style="display:none;">
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
            <div class="page-header" style="margin: 0 0 20px 0;">
                <h3 style="letter-spacing: 2px;">发送邮件提示用户发送简历
                    <small>系统检测用户提交推荐后24小时，后台是否有上传此用户简历，如无则会自动发送邮件提示，24小时内也可以手动发送。</small>
                </h3>
            </div>
            <div class="col-md-3" style="margin-top: 20px;">
                <div class="input-group">
                    <span for="" class="input-group-addon">推荐提交时间：</span>
                    <input value="{{str_replace( ' ' , 'T' , $recommend->created_at )}}" name="created_at"
                           type="datetime-local"
                           class="form-control" id="created_at" disabled>
                </div>
            </div>
            <div class="col-md-3" style="margin-top: 20px;">
                <div class="input-group">
                    <span for="" class="input-group-addon">发送记录：</span>
                    <input
                            value="{{$recommend->is_send_required_resume_email && $recommend->hasManyEmailLogs->where('type','0')->first() ?
                        str_replace( ' ' , 'T' , $recommend->hasManyEmailLogs->where('type','0')->first()->created_at ) : '-'}}"
                            name=""
                            type="{{$recommend->is_send_required_resume_email ? 'datetime-local' : 'text'}}"
                            class="form-control" id="informSendResumeInput" disabled>
                </div>
            </div>
            <div class="col-md-6" style="margin-top: 20px;">
                <div class="input-group">
                    <button
                            id="informSendResumeBtn"
                            type="button"
                            class="btn btn-info"
                            onclick="{{$recommend->is_send_required_resume_email ? '' : 'informSendResume('."'". $recommend->ids."'" .');' }}"
                            {{$recommend->is_send_required_resume_email ? 'disabled' : ''}}
                            data-loading-text="正在发送中...">
                        {{$recommend->is_send_required_resume_email ? '已发送' : '现在发送'}}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 30px;">
            <div class="page-header">
                <h3 style="letter-spacing: 2px;">发送邮件通知用户简历已经收到
                    <small>需要管理员手动点击发送按钮来触发</small>
                </h3>
            </div>
            <div class="col-md-3" style="margin-top: 20px;">
                <div class="input-group">
                    <span for="" class="input-group-addon">发送记录：</span>
                    <input value="{{$recommend->is_send_received_resume_email  &&
                    $recommend->hasManyEmailLogs->where('type','1')->count() > 0 ?
                        str_replace( ' ' , 'T' , $recommend->hasManyEmailLogs->where('type','1')->first()->created_at ) : '-'}}"
                           name=""
                           type="{{$recommend->is_send_received_resume_email ? 'datetime-local' : 'text'}}"
                           class="form-control" id="informReceivedResumeInput" disabled>
                </div>
            </div>
            <div class="col-md-6" style="margin-top: 20px;">
                <div class="input-group">
                    <button
                            id="informReceivedResumeBtn"
                            type="button"
                            class="btn btn-info"
                            onclick="{{$recommend->is_send_received_resume_email ? '' : 'informReceivedResume('."'". $recommend->ids."'" .');' }}"
                            {{$recommend->is_send_received_resume_email ? 'disabled' : ''}}
                            data-loading-text="正在发送中..."
                    >{{$recommend->is_send_received_resume_email ? '已发送' : '现在发送'}}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 30px;">
            <div class="page-header">
                <h3 style="letter-spacing: 2px;">发送邮件通知企业有博士应聘
                    <small>需要管理员手动点击发送按钮来触发</small>
                </h3>
            </div>
            <div class="col-md-3" style="margin-top: 20px;">
                <div class="input-group">
                    <span for="" class="input-group-addon">发送记录：</span>
                    <input value="{{$recommend->is_send_inform_company_email &&
                    $recommend->hasManyEmailLogs->where('type','2')->count() > 0 ?
                        str_replace( ' ' , 'T' , $recommend->hasManyEmailLogs->where('type','2')->first()->created_at ) : '-'}}"
                           id="informCompanyEmailBtnInput"
                           name=""
                           type="{{$recommend->is_send_inform_company_email ? 'datetime-local' : 'text'}}"
                           class="form-control" id="is_send_inform_company_emailInput" disabled>
                </div>
            </div>
            <div class="col-md-6" style="margin-top: 20px;">
                <div class="input-group">
                    <button
                            id="informCompanyEmailBtn"
                            type="button"
                            class="btn btn-info"
                            onclick="{{$recommend->is_send_inform_company_email ? '' : 'informCompanyEmail('."'". $recommend->ids."'" .');' }}"
                            {{$recommend->is_send_inform_company_email ? 'disabled' : ''}}
                            data-loading-text="正在发送中...">
                        {{$recommend->is_send_inform_company_email ? '已发送' : '现在发送'}}</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#send_email_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#recommend_basic_nav').removeClass('active');
        $('#hint_control_nav').removeClass('active');

        $('#send_email').fadeIn(200);
        $('#recommend_basic').fadeOut(200);
        $('#hint_control').fadeOut(200);
    });

    function informSendResume(id) {
        var $btn = $('#informSendResumeBtn').button('loading');
        $.ajax({
            url: "/informSendResume",
            method: "GET",
            data: {
                "ids": id,
            },
            dataType: "json",
            success: function success(data) {
                //console.log(data);
                if (data.code == '888') {
                    $("#informSendResumeBtn").attr("disabled", true).text('已发送');
                    $("#informSendResumeInput").val(new Date(JSON.stringify(data.created_at.date)).toLocaleString());
                } else {
                    $("#informSendResumeBtn").attr("disabled", true).text('错误');
                    $("#informSendResumeInput").val(data.msg);
                }
            },
            error: function error(error) {
                //console.log(error);
                $("#informSendResumeBtn").attr("disabled", true).text('错误');
                $("#informSendResumeInput").val(data.msg);
            }
        });
    }

    function informReceivedResume(id) {
        var $btn = $('#informReceivedResumeBtn').button('loading');
        $.ajax({
            url: "/informReceivedResume",
            method: "GET",
            data: {
                "ids": id,
            },
            dataType: "json",
            success: function success(data) {
                //console.log(data);
                if (data.code == '888') {
                    $("#informReceivedResumeBtn").attr("disabled", true).text('已发送');
                    $("#informReceivedResumeInput").val(new Date(JSON.stringify(data.created_at.date)).toLocaleString());
                } else {
                    $("#informReceivedResumeBtn").attr("disabled", true).text('错误');
                    $("#informReceivedResumeInput").val(data.msg);
                }
            },
            error: function error(error) {
                //console.log(error);
                $("#informReceivedResumeBtn").attr("disabled", true).text('错误');
                $("#informReceivedResumeInput").val(data.msg);
            }
        });
    }

    function informCompanyEmail(id) {
        var $btn = $('#informCompanyEmailBtn').button('loading');
        $.ajax({
            url: "/informCompanyEmail",
            method: "GET",
            data: {
                "ids": id,
            },
            dataType: "json",
            success: function success(data) {
                //console.log(data);
                if (data.code == '888') {
                    $("#informCompanyEmailBtn").attr("disabled", true).text('已发送');
                    $("#informCompanyEmailBtnInput  ").val(new Date(JSON.stringify(data.created_at.date)).toLocaleString());
                } else {
                    $("#informCompanyEmailBtn").attr("disabled", true).text('错误');
                    $("#informCompanyEmailBtnInput").val(data.msg);
                }
            },
            error: function error(error) {
                //console.log(error);
                $("#informCompanyEmailBtn").attr("disabled", true).text('错误');
                $("#informCompanyEmailBtnInput").val(data.msg);
            }
        });
    }

</script>