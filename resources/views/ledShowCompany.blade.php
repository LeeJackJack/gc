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
    html {
        background-image: url("https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-10-31/led.png");
    }

    body {
        font-family: "微软雅黑", Arial, sans-serif;
        background-color: transparent;
    }

    .top_bg {
        height: auto;
        width: 100%;
    }

    .list {
        /*margin-left: 38px;*/
        /*margin-right: 38px;*/
        /*margin: 30px 38px;*/
        margin: 15px;
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
    }

    .list_item_title {
        font-size: 22px;
        font-weight: 500;
        color: #222222;
        letter-spacing: 2px;
        margin: 10px 15px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 30px;
        min-height: 60px;
        -webkit-line-clamp: 2;
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
        height: 160px;
        width: calc(25% - 20px);
        margin-right: 20px;
        background-color: rgba(255,255,255,1);
    }

    .item_block {
        height: auto;
    }

    .list_item_label {
        color: #666666;
        font-size: 18px;
        letter-spacing: 2px;
        margin: 0 15px;
        height: 25px;
        font-weight: 500;
        line-height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 95%;
    }

    .list_item_label_text {
        float: left;
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .list_item_line {
        clear: both;

    }

    .list_item_line_hr {
        BORDER: rgba(235, 235, 235, 1) 1px dashed;
        OVERFLOW: hidden;
        /*HEIGHT: 1px;*/
        margin-left: 18px;
        margin-right: 18px;
    }

    .list_item_position_count {
        color: #222222;
        font-size: 16px;
        margin-left: 18px;
        margin-right: 18px;
    }

    .qr_code_div {
        position: absolute;
        right: 0;
        bottom: 40px;
        width: 167px;
        height: 184px;
        background: #409EFF;
        font-weight: bold;
        /*font-weight: 600;*/
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
        text-align: center;
        opacity: 1;
    }

    .qr_code_pic {
        width: 131px;
        height: 131px;
        margin-top: 11px;
    }

    .qr_code_text {
        font-size: 12px;
        /*font-weight: 500;*/
        color: white;
        padding: 2px 5px;
    }
</style>
<body>
<div id="led">
    <template>

        {{--头部banner--}}
        <div class="top_bg">
            <img alt="" style="width:100%;"
                 src="https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-11-12/1.png">
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
                            <div class="child"
                                 v-for="(sValue,sIndex) in value.companies">
                                <div class="item_block">
                                    <div style="float: left;width: 65%">
                                        <div class="list_item_title">@{{ sValue.name }}</div>
                                        <div class="list_item_label">
                                            <div class="list_item_label_text" v-if="sValue.property">@{{ sValue.property
                                                }}
                                            </div>
                                            <div v-if="sValue.scale" class="list_item_label_text" style="margin: 0 5px">
                                                |
                                            </div>
                                            <div class="list_item_label_text" v-if="sValue.scale">@{{ sValue.scale }}
                                            </div>
                                            <div v-if="sValue.type" class="list_item_label_text" style="margin: 0 5px">|
                                            </div>
                                            <div class="list_item_label_text" v-if="sValue.type">@{{ sValue.type }}
                                            </div>
                                        </div>
                                        <div class="list_item_line">
                                            <hr class="list_item_line_hr">
                                        </div>
                                        <div class="list_item_position_count"><span
                                                    style="color:#409EFF;font-weight: 600;font-size: 20px;">@{{
                                        sValue.jobCounts  }}个</span>  在招职位
                                        </div>
                                    </div>
                                    <div style="float: right;width: 32%;text-align: center;height: 160px;display:flex;">
                                        <img
                                                :src="sValue.qr_code_subject"
                                                style="width: 90%;align-self: center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition-group>

        {{--二维码--}}
        {{--<div class="qr_code_div">--}}
            {{--<img src="https://bocuhui.oss-cn-beijing.aliyuncs.com/qr_code/2019-11-07/5dc379ac599b8.png" alt=""--}}
                 {{--class="qr_code_pic">--}}
            {{--<p class="qr_code_text">更多信息请扫二维码查阅</p>--}}
        {{--</div>--}}

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
                var _this = this;
                //请求服务器
                axios.get("/api/led/getCompany", {
                    params: {
                        //
                    },
                }).then(res => {
                    setTimeout(function () {
                        _this.show = false;
                        _this.setData(res.data.data);
                    }, 2000)
                    // console.log(this.data);
                }).catch(function (err) {
                    //console.log(err);
                });
            },
            setData(data) {
                this.data = data;
                this.show = true;
            }
        },
        created: function () {
            this.getData();
        },
        mounted: function () {
            //循环获取数据
            let _this = this;
            setInterval(function () {
                _this.getData();
            }, 8000);
        },
    });
</script>
</body>
</html>
