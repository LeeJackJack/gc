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
            <div class="col-sm-6">
                <!-- 标题 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>职位名称：</span>
                    <input value="{{isset($job) ? $job->title : ''}}" name="title" type="text"
                           class="form-control" id="title" placeholder="职位名称...">
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0 ;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 职位薪资 -->
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>请填写职位薪酬：</span>
                    <input value="{{isset($job) ? $job->salary : ''}}" name="salary" type="text"
                           class="form-control" id="salary" placeholder="职位薪酬...">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 招聘人数 -->
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;"><span
                        style="color: red;">*</span>招聘人数：</span>
                    <input value="{{isset($job->hire_count) ? $job->hire_count : ''}}" name="hire_count"
                           type="text"
                           class="form-control" id="hire_count" placeholder="请填写招聘人数...">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 推荐奖金 -->
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;"><span
                        style="color: red;">*</span>推荐奖金：</span>
                    <input value="{{isset($job->reward) ? $job->reward : ''}}" name="reward"
                           type="text"
                           class="form-control" id="reward" placeholder="请填写推荐成功奖励...">
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <!-- 职位学历 -->
            <div class="col-sm-4">
                <div class="input-group">
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>请填写职位学历：</span>
                    <input value="{{isset($job) ? $job->education : ''}}" name="education" type="text"
                           class="form-control" id="education" placeholder="职位学历...">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 职位经验 -->
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;"><span
                        style="color: red;">*</span>职位经验：</span>
                    <input value="{{isset($job->experience) ? $job->experience : ''}}" name="experience"
                           type="text"
                           class="form-control" id="experience" placeholder="如：有科研能力、有工作经历等">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 职位类型 -->
                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;"><span
                        style="color: red;">*</span>职位专业：</span>
                    <input value="{{isset($job->type) ? $job->type : ''}}" name="type"
                           type="text"
                           class="form-control" id="type" placeholder="如：生物医药、材料学等">
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <!-- 选择职位所在城市及行业 -->
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="input-group">
                    <!-- 省份 -->
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>请选择省份：</span>
                    <select id="province" class="form-control" name="province">
                        <option value="">无</option>
                        @foreach($provinces as $p)
                            <option value="{{$p}}">{{$p->label}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <!-- 城市 -->
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>请选择城市：</span>
                    <select id="city" class="form-control" name="city"></select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <!-- 行业 -->
                    <span for="" class="input-group-addon"><span style="color: red;">*</span>请选择行业：</span>
                    <select id="industry" class="form-control" name="industry">
                        <option value="">无</option>
                        @foreach($industries as $i)
                            <option value="{{$i}}">{{$i->label}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <div class="col-md-12">
            <div class="col-sm-6">
                <!-- 地址 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;"><span
                                style="color: red;">*</span>上班地址：</span>
                    <input value="{{isset($job) ? $job->address : ''}}" name="address" type="text"
                           class="form-control" id="address" placeholder="上班地址...">
                </div>
            </div>
            <div class="col-sm-6">
                <!-- 排序号 -->
                <div class="input-group">
                    <span for="" class="input-group-addon" style="text-align: left;">排序号：</span>
                    <input value="{{isset($job) ? $job->order_id : ''}}" name="order_id" type="number"
                           class="form-control" id="order_id" placeholder="数字越大排序越后...">
                </div>
            </div>
        </div>

        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <!-- 绑定企业 -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><span
                                    style="color: red;">*</span>输入企业名称进行绑定：</span>
                        <input class="form-control" id="company" name="company"
                               placeholder="请输入企业名称进行搜索...">
                    </div>
                </div>
                <div class="col-sm-2">
                    <button id="searchBtn" type="button" class="btn btn-sm btn-info"
                            onclick="searchCompanies();" data-loading-text="搜索中...">搜索
                    </button>
                </div>
            </div>
            <div id="com_list" style="margin: 20px 0 0 0 ;"></div>
        </div>

        <!-- 分隔线 -->
        <div class="col-sm-12" style="padding: 10px 0;">
            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
        </div>
        <!-- 职位描述 -->
        <div class="col-md-12">
            {{--<div class="col-md-12">--}}
                {{--<div class="input-group">--}}
                    {{--<span for="" class="input-group-addon" style="text-align: left;"><span--}}
                                {{--style="color: red;">*</span>职位描述：</span>--}}
                    {{--<textarea value="{{isset($job) ? $job->detail : ''}}" name="detail" rows="8" wrap="hard"--}}
                              {{--class="form-control" placeholder="职位描述...">{{isset($job) ? $job->detail : ''}}</textarea>--}}
                {{--</div>--}}
            {{--</div>--}}

            <!-- 职位内容，调整为富文本格式 -->
                <script id="job_ueditor" name="detail_rich_text" type="text/plain">请在此输入职位详情...</script>
                @if(isset($job))
                    <code id="job_con" style="display:none;">
                        {!! $job->detail_rich_text !!}
                    </code>
                @endif
        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#product_basic_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');

    });

    //城市级联
    $("#province").bind("change", function () {

        var city = JSON.parse($(this).val()).city;

        var content = '';

        content += '<option value="">无</option>';

        //处理城市
        for (var c in city) {
            var data = city[c];
            content += '<option value="' + data.code + '">' + data.label + '</option>';
        }

        $('#city').html(content);
    });

    //搜索企业
    function searchCompanies() {
        var $btn = $('#searchBtn').button('loading')
        $('#com_list').slideUp(100);
        $.ajax({
            url: "/com_search",
            method: "GET",
            data: {
                "com_name": $('#company').val(),
            },
            dataType: "json",
            success: function success(data) {
                $btn.button('reset');
                var res = data.company;
                var content = '';
                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {
                        content += '<label class="btn btn-sm " style="margin: 5px 10px 15px 0;background-color: #eeeeee;">' +
                            '<input type="radio" name="com_name" value="' + res[i].ids + '">';
                        content += res[i].name + '</label>';
                    }
                } else {
                    content += '<div style="text-align: center;margin: 10px;color: rgb(130,130,130);">暂无内容...</div>';
                }
                $('#com_list').html(content).slideDown(100);
            },
            error: function error(error) {
                $btn.button('reset');
                var content = '';
                content += '<div style="text-align: center;margin: 10px;color: rgb(130,130,130);">网络异常...</div>';
                $('#com_list').html(content).slideDown(100);
            }
        });
    }

    //实例化编辑器
    var job_ue = UE.getEditor('job_ueditor', {
        initialFrameHeight: 600,
    });
    if ('{{isset($job)}}') {
        job_ue.ready(function () {
            job_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            job_ue.setContent($('#job_con').html());
        });
    } else {
        job_ue.ready(function () {
            job_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    }

</script>