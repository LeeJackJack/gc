<!-- 主要表单 -->
<div id="form_field" class="form-horizontal" style="display: none;">
    <div class="col-sm-12">

        <!-- 添加报名必填项-->
        <div class="form-group">
            <button class="btn btn-lg btn-info" type="button"
                    data-toggle="modal"
                    data-target="#formModal"
            >+添加报名必填项
            </button>
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

<!-- 弹层 -->
<div id="formModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加报名必填项</h4>
            </div>
            <div class="modal-body">
                <!-- 表单内容 -->
                <div class="input-group" style="margin: 10px 0 10px 0;">
                    <label class="input-group-addon" for=""><span
                                style="color: red;">*</span>字段名称：</label>
                    <input class="form-control" type="text" name="form_title" placeholder="请输入字段名称...">
                </div>
                <div class="input-group" style="margin: 10px 0 10px 0;">
                    <label class="input-group-addon" for=""><span
                                style="color: red;">*</span>字段名称(英文)：</label>
                    <input class="form-control" type="text" name="form_title_en" placeholder="请输入字段名称的英文...">
                </div>
                <div class="input-group" style="margin: 10px 0 10px 0;">
                    <label class="input-group-addon" for=""><span
                                style="color: red;">*</span>字段类型：</label>
                    <select name="form_type" id="form_type" class="form-control">
                        <option value="text">文本</option>
                        <option value="number">数值</option>
                        <option value="email">邮箱</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"
                        data-dismiss="modal" onclick="addForms();">Save
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#form_field_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#activity_basic_nav').removeClass('active');

        $('#form_field').fadeIn(200);
        $('#activity_basic').fadeOut(200);
    })

    //添加服务步骤
    var formArray = [];
    if ('{{isset($activity)}}') {
        formArray = JSON.parse($('#sign_up_form').html());
        setupFormContent();
        $('#forms').val(JSON.stringify(formArray));
    }

    //添加步骤
    function addForms() {
        $('#form_show').hide();
        var formTitle = $(" input[ name='form_title' ] ").val();
        var formTitleEn = $(" input[ name='form_title_en' ] ").val();
        var formType = $("#form_type option:selected").val();

        var formJson = {
            'formTitle': formTitle,
            'formTitleEn': formTitleEn,
            'formType': formType,
        };
        formArray.push(formJson);
        setupFormContent();
        $('#forms').val(JSON.stringify(formArray));
    }

    //删除步骤
    function delForm(i) {
        $('#form_show').hide();
        formArray.splice(i, 1);
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
                content += '<p><a href="#" class="btn btn-sm btn-danger" role="button" onclick="delForm(' + i + ');">删除此字段</a></p></div></div></div>';
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
