<div class="panel panel-info">
    <div class="panel-heading">用户数据</div>
    <div class="panel-body">
        <div class="col-md-10 col-md-offset-1" id="users_chart">
            {!! $user_data['chart']->container() !!}
        </div>
    </div>
    <div class="panel-footer" style="background-color: rgb(240,240,240);">
        <p>累计用户增长至 <span style="font-size: 18px;color: red;">{{$user_data['total_users_count']}}</span> 位，
            其中本周增长 <span style="font-size: 18px;color: red;">{{$user_data['this_week_increase_users_count']}}</span>
            位，环比对比上周<span style="{{$user_data['users_week_on_week_basis']>0 ? 'color:red;':'color:green;'}}font-size:18px;">
                {{ $user_data['users_week_on_week_basis'] > 0 ? '增长'.$user_data['users_week_on_week_basis'] :
                '减少'.$user_data['users_week_on_week_basis'] }}%</span>。</p>
    </div>
</div>
{!! $user_data['chart']->script() !!}
