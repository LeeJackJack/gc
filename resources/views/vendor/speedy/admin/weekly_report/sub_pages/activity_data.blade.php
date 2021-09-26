<div class="panel panel-info">
    <div class="panel-heading">活动数据</div>
    <div class="panel-body">
        <div class="col-md-10 col-md-offset-1" id="activities_chart">
            {!! $activities_data['chart']->container() !!}
        </div>
    </div>
    <div class="panel-footer">
        <p>本周活动浏览数量 <span
                    style="font-size: 18px;color: red;">{{$activities_data['this_week_activities_count']}}</span> 次，环比上周
            <span style="{{$activities_data['activities_week_on_week_basis'] > 0 ? 'color:red;':'color:green;'}}font-size:18px;">
                                {{$activities_data['activities_week_on_week_basis'] > 0 ?
                                '增长'.$activities_data['activities_week_on_week_basis']:
                                '减少'.$activities_data['activities_week_on_week_basis']}} %</span>。
            其中本周新增发布活动 <span
                    style="font-size: 18px;color: red;">{{$activities_data['new_activities_count']}}</span> 个，
            新增活动带来浏览量 <span
                    style="font-size: 18px;color: red;">{{$activities_data['new_activities_view_count']}}</span> 个，
            占本周浏览量 <span
                    style="font-size: 18px;color: red;">{{ $activities_data['this_week_activities_count'] == 0 ? 0
                    : round
                    ($activities_data['new_activities_view_count'] /
                    $activities_data['this_week_activities_count'] , 4) *100}}
                %。</span></p>
        <p>本周活动报名数量 <span
                    style="font-size: 18px;color: red;">{{$activities_data['new_sigh_ups']}}</span> 个，
            其中新增活动报名 <span
                    style="font-size: 18px;color: red;">{{$activities_data['new_activities_sign_up_count']}}</span> 个。
        </p>
        <p>平台累计发布活动 <span
                    style="font-size: 18px;color: red;">{{$activities_data['total_activities_count']}}</span> 个。</p>
    </div>
</div>
{!! $activities_data['chart']->script() !!}
