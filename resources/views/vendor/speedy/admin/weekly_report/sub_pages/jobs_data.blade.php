<div class="panel panel-info">
    <div class="panel-heading">职位数据</div>
    <div class="panel-body">
        <div class="col-md-10 col-md-offset-1" id="jobs_chart">
            {!! $jobs_data['chart']->container() !!}
        </div>
    </div>
    <div class="panel-footer">
        <p>本周职位浏览数量 <span
                    style="font-size: 18px;color: red;">{{$jobs_data['jobs_view_count']}} </span>次，环比上周
            <span style="{{$jobs_data['jobs_week_on_week_basis'] > 0 ? 'color:red;':'color:green;'}}font-size:18px;">
                                {{$jobs_data['jobs_week_on_week_basis'] > 0 ?
                                '增长'.$jobs_data['jobs_week_on_week_basis']:
                                '减少'.$jobs_data['jobs_week_on_week_basis']}}
                %</span>。其中本周新增发布职位 <span
                    style="font-size: 18px;color: red;">{{$jobs_data['new_jobs_count']}}</span> 个，
            新增职位带来浏览量 <span
                    style="font-size: 18px;color: red;">{{$jobs_data['new_jobs_view_count']}}</span> 个，
            占本周浏览量 <span
                    style="font-size: 18px;color: red;">{{round($jobs_data['new_jobs_view_count'] / $jobs_data['jobs_view_count'] , 4) *100}} </span>%。
        </p>
        <p>本周新增推荐数量 <span
                    style="font-size: 18px;color: red;">{{$jobs_data['new_recommends_count']}}</span> 个，
            @if($jobs_data['new_recommends_count'] == 0)
                其中新发布职位所带来的推荐量占比 0%,
                旧职位带来的推荐量占比 100%。
            @else
                其中新发布职位所带来的推荐量占比 <span
                        style="font-size: 18px;color: red;">{{round($jobs_data['new_jobs_recommend_count']/$jobs_data['new_recommends_count'] ,4) * 100}}
                </span> %，旧职位带来的推荐量占比 <span
                        style="font-size: 18px;color: red;">{{(1-round($jobs_data['new_jobs_recommend_count']/$jobs_data['new_recommends_count'] ,4))*100}}
                </span> %。
            @endif
        </p>
        <p>平台累计发布职位 <span
                    style="font-size: 18px;color: red;">{{$jobs_data['total_jobs_count']}}</span> 个，推荐人数 <span
                    style="font-size: 18px;color: red;">{{$jobs_data['total_recommend_count']}}</span> 个。</p>
    </div>
</div>
{!! $jobs_data['chart']->script() !!}