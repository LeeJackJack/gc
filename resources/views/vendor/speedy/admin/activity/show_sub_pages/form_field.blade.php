<!-- 主要表单 -->
<div id="form_field" class="form-horizontal" style="display: none;">
    <div class="col-sm-12">

        <!-- 添加报名必填项-->
        <div class="form-group">
            <input type="text" hidden id="forms" name="forms">
            <div style="height: auto;min-height: 150px;margin-top: 20px;">
                @if(isset($activity))
                    <code id="sign_up_form" style="display:none;">
                        {!! $activity->form_field !!}
                    </code>
                @endif
                <div class="row" id="form_show">
                    <div class="col-sm-3 col-md-3">
                        <div class="thumbnail">
                            <div class="caption">
                                <h3>暂无字段</h3>
                                <p>...</p>
                                <p><a href="#" class="btn btn-sm btn-danger" role="button"
                                      disabled="disabled">待添加...</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $('#form_field_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#activity_basic_nav').removeClass('active');
        $('#activity_sign_up_nav').removeClass('active');

        $('#form_field').fadeIn(200);
        $('#activity_basic').fadeOut(200);
        $('#activity_sign_up').fadeOut(200);
    })

    //添加服务步骤
    var formArray = [];
    if ('{{isset($activity)}}') {
        formArray = JSON.parse($('#sign_up_form').html());
        setupFormContent();
        $('#forms').val(JSON.stringify(formArray));
    }

    //建立步骤显示页面
    function setupFormContent() {
        var content = '';

        if (formArray.length > 0) {
            for (var i = 0; i < formArray.length; i++) {
                content += '<div class="col-sm-3 col-md-3"><div class="thumbnail"><div class="caption">';
                content += '<h3>' + formArray[i].formTitle + '</h3>';
                content += '<h3>' + formArray[i].formTitleEn + '</h3>';
                content += '<p>' + formArray[i].formType + '</p>';
                content += '<p><a href="#" class="btn btn-sm btn-danger" role="button" disabled="disabled" onclick="delForm(' + i + ');">删除此字段</a></p></div></div></div>';
            }
        } else {
            content += '<div class="col-sm-3 col-md-3"><div class="thumbnail">';
            content += '<div class="caption">';
            content += '<h3>暂无内容</h3>';
            content += '<p>...</p>\n';
            content += '<p><a href="#" class="btn btn-sm btn-danger" role="button"';
            content += 'disabled="disabled">待添加...</a></p></div></div></div>';
        }
        $('#form_show').html(content).fadeIn(300);
    }

</script>
