<style>
    #file {
        opacity: 1; /*设置此控件透明度为零，即完全透明*/
        filter: alpha(opacity=0); /*设置此控件透明度为零，即完全透明针对IE*/
        font-size: 16px;
    }
</style>
<div class="container" id="activity_sign_up" style="display:block;">
    <div class="row">
        <div class="col-md-12">
            <!-- 报名人员 -->
        @if(count($sign_ups)>0)
            @if($sign_ups[0]->field)
                <!-- 动态报名表单 -->
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            @foreach(json_decode($sign_ups[0]->field) as $v)
                                <th style="text-align: center">{{$v->formTitle}}</th>
                            @endforeach
                            <th style="text-align: center">{{ trans('view.admin.activity.sign_phone') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.updated_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.is_handle') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sign_ups as $sign_up)
                            <tr>
                                @foreach(json_decode($sign_up->field) as $v)
                                    <td style="vertical-align: middle;">{{$v->content}}</td>
                                @endforeach
                                <td style="vertical-align: middle;">{{ $sign_up->phone}}</td>
                                <td style="vertical-align: middle;">{{ $sign_up->created_at}}
                                <td style="vertical-align: middle;">{{ $sign_up->updated_at}}</td>
                                <td style="vertical-align: middle;">
                                    <form method="post"
                                          action="{{ route('admin.sign_up.update',['id' => $sign_up->ids]) }}">
                                        {{ csrf_field() }}
                                        {{ isset($sign_up) ? method_field('PUT') : '' }}
                                        <button class="{{ $sign_up->is_handle ? 'btn btn-default' : 'btn btn-danger'}}"
                                                {{ $sign_up->is_handle ? 'disabled':''}}
                                                type="submit">
                                            {{$sign_up->is_handle ? '已联系' : '未联系'}}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            @else
                <!-- 固定报名表单 -->
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.activity.sign_name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.sign_phone') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.sign_company') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.sign_job') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.email') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.updated_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.is_handle') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sign_ups as $sign_up)
                            <tr>
                                <td style="vertical-align: middle;">{{ $sign_up->name }}</td>
                                <td style="vertical-align: middle;">{{ $sign_up->phone}}</td>
                                <td style="vertical-align: middle;">{{ $sign_up->company}}</td>
                                <td style="vertical-align: middle;">{{ $sign_up->job }}</td>
                                <td style="vertical-align: middle;">{{ $sign_up->email }}</td>
                                <td style="vertical-align: middle;">{{ $sign_up->created_at}}
                                <td style="vertical-align: middle;">{{ $sign_up->updated_at}}</td>
                                <td style="vertical-align: middle;">
                                    <form method="post"
                                          action="{{ route('admin.sign_up.update',['id' => $sign_up->ids]) }}">
                                        {{ csrf_field() }}
                                        {{ isset($sign_up) ? method_field('PUT') : '' }}
                                        <button class="{{ $sign_up->is_handle ? 'btn btn-default' : 'btn btn-danger'}}"
                                                {{ $sign_up->is_handle ? 'disabled':''}}
                                                type="submit">
                                            {{$sign_up->is_handle ? '已联系' : '未联系'}}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            @else
                暂无报名信息...
            @endif
        </div>
    </div>

</div>
<script type="text/javascript">

    //导航栏切换
    $('#activity_sign_up_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#activity_basic_nav').removeClass('active');
        $('#form_field_nav').removeClass('active');

        $('#activity_sign_up').fadeIn(200);
        $('#activity_basic').fadeOut(200);
        $('#form_field').fadeOut(200);
    });

</script>