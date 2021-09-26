<div class="container" id="talent_contact" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    @if(count($talent->contacts))
                        <div class="col-sm-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <button type="button" class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#formModal">新建联系记录</button>
                                </div>
                                <div class="panel-body" id="content_body">
                                    <table class="table table-bordered table-hover"
                                           style="text-align: center;table-layout: fixed;">
                                        <thead>
                                        <tr class="active">
                                            <th style="text-align: center" width="10%">{{ trans('view.admin.talent.contact_name') }}</th>
                                            <th style="text-align: center" width="50%">{{ trans('view.admin.talent.contact_content') }}</th>
                                            <th style="text-align: center" width="15%">{{ trans('view.admin.talent.contact_created_at') }}</th>
                                            <th style="text-align: center" width="15%">{{ trans('view.admin.talent.contact_updated_at') }}</th>
                                            <th style="text-align: center" width="10%">{{ trans('view.admin.public.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($talent->contacts as $contact)
                                            <tr>
                                                <td style="vertical-align: middle;">{{ $contact->name }}</td>
                                                <td style="vertical-align: middle;text-align: left;padding: 15px;">{!! $contact->content !!}</td>
                                                <td style="vertical-align: middle;">{{ $contact->created_at}}</td>
                                                <td style="vertical-align: middle;">{{ $contact->updated_at}}</td>
                                                <td style="vertical-align: middle;">
                                                    <a id="delBtn{{$contact->id}}" class="btn btn-danger btn-sm"
                                                       href="javascript:;"
                                                       onclick="delContactInfo({{$contact->id}});"
                                                       data-loading-text="删除中...">{{ trans('view.admin.public.destroy') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <button type="button" class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#formModal">新建联系记录</button>
                                </div>
                                <div class="panel-body" id="content_body">
                                    暂无内容...
                                </div>
                            </div>
                        </div>
                    @endif
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
                <h4 class="modal-title">添加联系信息</h4>
            </div>
            <div class="modal-body">
                <!-- 表单内容 -->
                <div class="input-group" style="margin: 10px 0 10px 0;">
                    <label class="input-group-addon" for=""><span
                                style="color: red;">*</span>联系人姓名：</label>
                    <input class="form-control" type="text" name="form_name" placeholder="请输入联系客服名称...">
                </div>
                <div class="input-group" style="margin: 10px 0 10px 0;">
                    <label class="input-group-addon" for=""><span
                                style="color: red;">*</span>联系内容：</label>
                    <textarea class="form-control" type="text" name="form_content" placeholder="请输入联系内容..." rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"
                        data-dismiss="modal" onclick="createContact({{$talent->id}});">Save
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#talent_contact_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#talent_basic_nav').removeClass('active');
        $('#upload_resume_nav').removeClass('active');

        $('#talent_contact').fadeIn(200);
        $('#talent_basic').fadeOut(200)
        $('#upload_resume').fadeOut(200);
    });

    function delContactInfo(id) {
        var $btn = $('#delBtn'+id).button('loading');
        $.ajax({
            url: "/api/delContactInfo",
            method: "GET",
            data: {
                "id": id,
            },
            dataType: "json",
            success: function success(data) {
                $btn.button('reset');
                $('#content_body').hide();
                if (data.code === '888')
                {
                    setupContent(data.contacts);
                }
            },
            error: function error(error) {
                $btn.button('reset');
            }
        });
    }

    function createContact(id) {
        var name = $(" input[ name='form_name' ] ").val();
        var content = $(" textarea[ name='form_content' ] ").val();
        $.ajax({
            url: "/api/createContact",
            method: "GET",
            data: {
                "id": id,
                "name":name,
                "content":content,
            },
            dataType: "json",
            success: function success(data) {
                $('#content_body').hide();
                if (data.code === '888')
                {
                    setupContent(data.contacts);
                }
            },
            error: function error(error) {
                //
            }
        });
    }

    function setupContent(data) {
        var content = '';
        content +='<table class="table table-bordered table-hover"';
        content +='style="text-align: center;table-layout: fixed;">';
        content +='<thead>';
        content +='<tr class="active">';
        content +='<th style="text-align: center" width="10%">{{ trans('view.admin.talent.contact_name') }}</th>';
        content +='<th style="text-align: center" width="50%">{{ trans('view.admin.talent.contact_content') }}</th>';
        content +='<th style="text-align: center" width="15%">{{ trans('view.admin.talent.contact_created_at') }}</th>';
        content +='<th style="text-align: center" width="15%">{{ trans('view.admin.talent.contact_updated_at') }}</th>';
        content +='<th style="text-align: center" width="10%">{{ trans('view.admin.public.action') }}</th>';
        content +='</tr>';
        content +='</thead>';
        content +='<tbody>';
        for (var i = 0; i < data.length; i++) {
            content +='<tr>';
            content +='<td style="vertical-align: middle;">'+data[i].name+'</td>';
            content +='<td style="vertical-align: middle;padding:15px;text-align: left;">'+data[i].content+'</td>';
            content +='<td style="vertical-align: middle;">'+data[i].created_at+'</td>';
            content +='<td style="vertical-align: middle;">'+data[i].updated_at+'</td>';
            content +='<td style="vertical-align: middle;">';
            content +='<a id="delBtn'+data[i].id+'" class="btn btn-danger btn-sm"';
            content +='href="javascript:;"';
            content +='onclick="delContactInfo('+data[i].id+');"';
            content +='data-loading-text="删除中...">{{ trans('view.admin.public.destroy') }}</a>';
            content +='</td>';
            content +='</tr>';
        }
        content +='</tbody>';
        content +='</table>';
        $('#content_body').html(content).fadeIn(300);
    }

</script>