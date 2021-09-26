<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>海珠统计结果</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{asset('bch_logo.ico')}}" rel="SHORTCUT ICON"/>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{mix('/js/app.js')}}"></script>
</head>
<style>
    {{----}}
</style>
<body>
<div id="haiZhu" style="text-align: center;margin: 5%;">
    <template>
        <table border="1" bordercolor="black" style="text-align: center;" cellspacing="0" cellpadding="5">
            <tr>
                <th rowspan="3">指标名称</th>
                <th rowspan="3">总数</th>
                <th colspan="3"></th>
                <th colspan="5">学历状况</th>
                <th colspan="7">年龄状况</th>
                <th colspan="4">本企业工作年限状况</th>
            </tr>
            <tr>
                <th rowspan="2">女性</th>
                <th rowspan="2">港澳台/外籍</th>
                <th rowspan="2">留学回国人员</th>
                <th rowspan="2">研究生</th>
                <th rowspan="2">大学 本科</th>
                <th rowspan="2">大学 专科</th>
                <th rowspan="2">高中/中专/技校</th>
                <th rowspan="2">初中及以下</th>
                <th rowspan="2">1999年以后</th>
                <th rowspan="2">1994年-1998年</th>
                <th rowspan="2">1993年-1989年</th>
                <th rowspan="2">1988年-1979年</th>
                <th rowspan="2">1978年-1969年</th>
                <th rowspan="2">1968年-1959年</th>
                <th rowspan="2">1959年前出生</th>
                <th rowspan="2">1年及以下</th>
                <th rowspan="2">1-3年（含3年）</th>
                <th rowspan="2">3-5年（含5年）</th>
                <th rowspan="2">5年以上</th>
            </tr>
            <tr></tr>
            <tr>
                <td>1.从业人员</td>
                @foreach(explode(',',$data->line1) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>2.产业技能人才</td>
                @foreach(explode(',',$data->line2) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>（1）研发人员</td>
                @foreach(explode(',',$data->line3) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>（2）生产人员</td>
                @foreach(explode(',',$data->line4) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>（3）服务人员</td>
                @foreach(explode(',',$data->line5) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>3.持证人员</td>
                @foreach(explode(',',$data->line6) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>（1）评定了专业技术资格，具有人社部门颁发的专业技术资格证书的人员</td>
                @foreach(explode(',',$data->line7) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>a.高级</td>
                @foreach(explode(',',$data->line8) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>b.中级</td>
                @foreach(explode(',',$data->line9) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>c.初级及员级</td>
                @foreach(explode(',',$data->line10) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>（2）参加了国家职业技能鉴定，并取得职业资格证书的人员</td>
                @foreach(explode(',',$data->line11) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>a.高级技师</td>
                @foreach(explode(',',$data->line12) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>b.技师</td>
                @foreach(explode(',',$data->line13) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>c.高级工</td>
                @foreach(explode(',',$data->line14) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>d.中级工与初级工</td>
                @foreach(explode(',',$data->line15) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
            <tr>
                <td>（3）参加过社会培训机构、行业组织培训，且获得培训证书的人员</td>
                @foreach(explode(',',$data->line16) as $l)
                    <td>{{$l}}</td>
                @endforeach
            </tr>
        </table>
    </template>
</div>

<!-- Scripts -->
<script>
    //led
    let haiZhu = new Vue({
        el: '#haiZhu',
        data: {
            //
        },
        methods: {
            //
        },
        created: function () {
            // this.getData();
        },
        mounted: function () {
            //
        },
    });
</script>
</body>
</html>
