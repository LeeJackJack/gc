<div class="panel panel-info">
    <div class="panel-heading">注册用户数据</div>
    <div class="panel-body">
        <div class="col-md-10 col-md-offset-1" id="register_users_chart">
            {!! $register_user_data['chart']->container() !!}
        </div>
    </div>
    <div class="panel-footer">
        <p>累计绑定用户增长至 <span
                    style="font-size: 18px;color: red;">{{$register_user_data['total_register_users_count']}}</span>
            位，其中本周新增绑定 <span
                    style="font-size: 18px;color: red;">{{$register_user_data['this_week_increase_register_users_count']}} </span>位，环比对比上周
            <span style="{{$register_user_data['register_users_week_on_week_basis']>0 ? 'color:red;':'color:green;' }}font-size:18px;">
                            {{$register_user_data['register_users_week_on_week_basis']>0?
                            '增长'.$register_user_data['register_users_week_on_week_basis'] :
                            '减少'.$register_user_data['register_users_week_on_week_basis']}}
                %</span>。
        </p>
    </div>
</div>
{!! $register_user_data['chart']->script() !!}