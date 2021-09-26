<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script src="{{mix('/js/app.js')}}"></script>
    <style>
        #success {
            padding: 15px;
        }

    </style>

</head>
<body>
<div id="success">
    <template>
        <el-row  justify="center" align="middle" type="flex">
            <el-col :xs="23" :sm="23" :md="10" :lg="10" :xl="10">
                {{--标题--}}
                <div style="text-align: center;">
                    <img src="https://bocuhui.oss-cn-beijing.aliyuncs.com/images/bm_success.jpg" alt=""
                         style="width: 100%;">
                </div>
            </el-col>
        </el-row>

    </template>
</div>
<script>
    let success = new Vue({
        el: '#success',
        data: {
            //
        },
        compute: {
            //
        },
        methods: {
            //
        },
        created: function () {
            //
        },
        mounted: function () {
            //
        },
    });
</script>
</body>
</html>
