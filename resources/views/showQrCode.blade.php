<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>生物医药博士交流</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{asset('bch_logo.ico')}}" rel="SHORTCUT ICON"/>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{mix('/js/app.js')}}"></script>
</head>
<style>
    html {
        /*background-image: url("https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-10-31/led.png");*/
    }

    body {
        font-family: "PingFang SC", "Helvetica Neue", Helvetica, "Hiragino Sans GB", "Microsoft YaHei",
        "微软雅黑", Arial, sans-serif;
        background-color: transparent;
    }

    * {
        letter-spacing: 2px;
    }

    body, p {
        margin: 0;
    }

    .content {
        border-radius: 3px;
        margin: 10px;
    }

    .left-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .title {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .qrcode-wrapper {
        width: 200px;
        height: 200px;
    }

    .hint-wrapper
    {
        text-align: center;
        color: #333;
        font-size: 14px;
        font-weight: 500;
        margin: 10px 20px;
    }

    .bottom-wrapper
    {
        text-align: center;
        margin: 5px;
    }
    .title-content
    {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
</style>
<body>
<div id="qrCode">
    <template>
        <el-row type="flex" justify="center">
            <el-col :xs="22" :sm="18" :md="12" :lg="12" :xl="12">
                {{--头部banner--}}
                <div class="top_bg">
                    <img style="width:100%;" src="{{asset('pic/headhunterBg.png')}}">
                </div>
                <div class="content">
                    <div class="title-content">生物医药博士人才交流群</div>
                    <div class="title">
                        <img :src="qrCode" class="qrcode-wrapper">
                    </div>
                </div>
                <div class="hint-wrapper">
                    长按识别二维码，立即加入群聊（请备注：姓名-学校/单位名称-专业）
                </div>
                <div class="bottom-wrapper">
                    <el-link type="primary" href="/writerQrCode"><i class="el-icon-question"></i>有问题？马上联系药博士</el-link>
                </div>
            </el-col>
        </el-row>
    </template>
</div>

<!-- Scripts -->
<script>
    let qrCode = new Vue({
        el: '#qrCode',
        data: {
            data: [],
            show: true,
            qrCode:'',
        },
        methods: {
            getData() {
                this.show = false;
                //请求服务器
                axios.get("/api/wx/share/getQrCode", {
                    params: {
                        //
                    },
                }).then(res => {
                    this.qrCode = res.data.data.writer_qr_code;
                    // console.log(this.data);
                    // console.log(res);
                    this.show = true;
                }).catch(function (err) {
                    //console.log(err);
                });
            },
        },
        created: function () {
            this.getData();
        },
        mounted: function () {
            //
        },
    });
</script>
</body>
</html>
