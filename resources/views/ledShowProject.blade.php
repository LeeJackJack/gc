<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>博创英才</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{asset('bch_logo.ico')}}" rel="SHORTCUT ICON"/>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{mix('/js/app.js')}}"></script>
</head>
<style>
    html{
        background-image: url("https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-10-31/led.png");
    }

    body {
        font-family: "PingFang SC",, "Helvetica Neue", Helvetica, "Hiragino Sans GB", "Microsoft YaHei",
        "微软雅黑", Arial, sans-serif;
        background-color: transparent;
    }

    * {
        letter-spacing: 2px;
    }

    .top_bg {
        height: auto;
        width: 100%;
    }

    .list {
        /*margin-left: 38px;*/
        /*margin-right: 38px;*/
        margin:  30px 38px;
    }

    .line_left {
        width: 10%;
        height: 40px;
        font-size: 24px;
        font-weight: 500;
        color: #010E99;
        float: left;
        letter-spacing: 3px;
        font-weight: bold;
    }

    .line_right {
        width: 90%;
        height: 30px;
        float: left;
        margin-top: 6px;
    }

    .list_line {
        height: 40px;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .list_item_title {
        font-size: 22px;
        font-weight: 500;
        color: #222222;
        letter-spacing: 2px;
        margin-left: 18px;
        margin-right: 18px;
        margin-top: 15px;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        -ms-text-overflow: ellipsis;
        white-space: nowrap;
    }

    .list_item_content {
        font-size: 19px;
        color: #333;
        margin: 20px 18px;
        font-weight: 500;
        display: -webkit-box;
        letter-spacing: 2px;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 40px;
        min-height: 160px;
        -webkit-line-clamp: 4;
    }

    body, p {
        margin: 0;
    }

    .parentWrap {
        overflow: hidden;
    }

    .parent {
        overflow: hidden;
        margin-right: -20px;
    }

    .child {
        float: left;
        height: 50%;
        width: calc(50% - 20px);
        margin-right: 20px;
    }

    .list_item_label {
        color: #444444;
        margin: 25px 18px;
        height: 25px;
    }

    .list_item_label_text {
        float: left;
        line-height: 25px;
        background: #cccccc;
        border-radius: 4px;
        color: white;
        padding: 3px 15px;
        margin-right: 10px;
        font-size: 18px;
        font-weight: 500;
    }

    .list_item_line {
        clear: both;
    }

    .list_item_line_hr {
        BORDER: rgba(235,235,235,1) 1px dashed;
        OVERFLOW: hidden;
        /*HEIGHT: 1px;*/
        margin-left: 18px;
        margin-right: 18px;
    }

    .qr_code_div{
        position: absolute;
        right: 0;
        top: 200px;
        width:167px;
        height:184px;
        background:rgba(1, 13, 152, 1);
        box-shadow:0px 3px 6px rgba(0,0,0,0.16);
        text-align: center;
        opacity:1;
    }

    .qr_code_pic
    {
        width: 131px;
        height: 131px;
        margin-top: 11px;
    }

    .qr_code_text{
        font-size:12px;
        font-weight: 400;
        color: white;
        padding: 2px 5px;
    }
</style>
<body>
<div id="led">
    <template>

        {{--头部banner--}}
        <div class="top_bg">
            <img alt="" style="width:100%;" src="https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-11-12/2.png">
        </div>

        {{--数据部分--}}
        <transition-group name="el-fade-in">
            <div v-for="(value,index) in data" :key="value.label" v-show="show">
                <div class="list">
                    <div class="list_line">
                        <div class="line_left">@{{ value.label }}</div>
                        {{--<div class="line_right">--}}
                        {{--<hr style="border-top: #03129D 2px dashed; overflow: hidden; height: 2px;">--}}
                        {{--</div>--}}
                    </div>
                    <div class="parentWrap">
                        <div class="parent" style="background-color: transparent;">
                            <div class="child" style="background-color: white;"
                                 v-for="(sValue,sIndex) in value.projects">
                                <div class="list_item_title" v-if="sValue">@{{ sValue.title }}</div>
                                <div class="list_item_content" v-if="sValue">@{{ sValue.description }}</div>
                                <div class="list_item_line" v-if="sValue">
                                    <hr class="list_item_line_hr">
                                </div>
                                <div class="list_item_label" v-if="sValue">
                                    <div class="list_item_label_text" v-if="sValue.industryLabel">@{{
                                        sValue.industryLabel }}
                                    </div>
                                    <div class="list_item_label_text" v-if="sValue.maturityLabel">@{{
                                        sValue.maturityLabel }}
                                    </div>
                                    <div class="list_item_label_text" v-if="sValue.cooperationLabel">@{{
                                        sValue.cooperationLabel }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition-group>

        {{--二维码--}}
        <div class="qr_code_div">
            <img src="https://bocuhui.oss-cn-beijing.aliyuncs.com/qr_code/2019-11-07/5dc379e56d5d9.png" alt="" class="qr_code_pic">
            <p class="qr_code_text">更多信息请扫二维码查阅</p>
        </div>
    </template>
</div>

<!-- Scripts -->
<script>
    //led
    let led = new Vue({
        el: '#led',
        data: {
            data: [],
            show: true,
        },
        methods: {
            getData() {
                this.show = false;
                //请求服务器
                axios.get("/api/led/getProject", {
                    params: {
                        //
                    },
                }).then(res => {
                    this.data = res.data.data;
                    // console.log(this.data);
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
            //循环获取数据
            let _this = this;
            setInterval(function () {
                _this.getData();
            }, 10000);
        },
    });
</script>
</body>
</html>
