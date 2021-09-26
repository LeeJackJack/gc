<!DOCTYPE html>
<html lang="zh">
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
    .listBg {
        min-height: 80px;
        height: auto;
        overflow: hidden;
        padding-bottom: 10px;
        background-color: white;
    }

    .listDetail {
        background: white;
        min-height: 25px;
        height: auto;
        font-size: 14px;
        height: auto;
        margin-top: 5px;
    }

    .listDetailTitle {
        line-height: 22px;
        text-align: left;
        font-size: 15px;
        color: #222222;
        letter-spacing: 1px;
        font-weight: bolder;
        padding-left: 10px;
    }

    .listDetailTitle {
        line-height: 22px;
        text-align: left;
        font-size: 15px;
        color: #222222;
        letter-spacing: 1px;
        font-weight: bolder;
        padding-left: 10px;
    }

    .label_bs {
        background-color: #cccccc;
        color: #ffffff;
        float: left;
        margin-right: 5px;
        padding: 4px 5px;
        font-size: 10px;
        margin-bottom: 5px;
        border-radius: 5px;
    }
</style>
<body>
<div id="foShanIndex">
    <template>
        <el-row :gutter="10" v-loading="loading">
            <el-col :xs="{span: 22, offset: 1}" :sm="{span: 18, offset: 3}" :md="{span: 12, offset: 5}" :lg="{span: 12,
            offset: 5}" :xl="{span: 12, offset: 5}">
                <el-image
                        style="width: 100%;"
                        src="https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-11-11/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20191111141816.png"
                        fit="scale-down"></el-image>
                <div v-if="data.length == 0">
                    <el-alert
                            title="内容正在密锣紧鼓的搜集中，敬请期待。
                            如果你想展示您的博士履历，请点击公众号下方菜单栏“简历发布”，让更多的单位了解到您的人才信息！"
                            type="success"
                            :closable="false">
                    </el-alert>
                </div>
                <div class="listBg" v-for="( value , index ) in data" @click="goToDetail(value.id)">
                    <div style="float:left;margin-left: 10px;margin-top: 25px;">
                        <div style="float:left;margin-right:5px;">
                            <img style="width:30px;height:30px;border-radius: 50%;"
                                 :src="'http://gaolin.oss-cn-shenzhen.aliyuncs.com/bochuanghui/touxiang' + (Math.round
                                 (Math.random() * 9)+1) + '.png'">
                            </img>
                        </div>
                    </div>
                    <div style="float:left;width: 60%;">
                        <div class="listDetail">
                            <p class="listDetailTitle" style="padding-top:12px;">@{{ value.name.substring(0,1) }}博士
                                <span style="font-size:11px;color:#999999;font-weight: normal;">@{{ value.school }}</span>
                            </p>
                        </div>
                        <div class="listDetail" style="min-height:30px;padding-left:5px;width: 100%;">
                            <div>
                                <div class="label_bs">@{{ value.major }}</div>
                                <div class="label_bs" v-if="value.experience">项目</div>
                                <div class="label_bs" v-if="value.paper">著作</div>
                                <div class="label_bs" v-if="value.expertise">专长</div>
                                <div class="label_bs" v-if="value.honor">荣誉</div>
                            </div>
                        </div>
                    </div>
                    <div style="float:left;width: 23%;line-height: 80px;font-size:12px;margin-top: 30px;
                        color:#4aa3ff;text-align: right;">@{{ value.likeCount }}人感兴趣</div>
                </div>
            </el-col>
        </el-row>
    </template>
</div>

<!-- Scripts -->
<script>
    //led
    let foShanIndex = new Vue({
        el: '#foShanIndex',
        data: {
            data: [],
            show: true,
            loading: true,
        },
        methods: {
            getData() {
                var _this = this;
                //请求服务器
                axios.get("/api/doctor/getList", {
                    params: {
                        //
                    },
                }).then(res => {
                    _this.data = res.data.data;
                    setTimeout(function () {
                        _this.loading = false;
                    }, 1000)
                    // console.log(res.data);
                }).catch(function (err) {
                    //console.log(err);
                });
            },
            goToDetail(id) {
                // this.loading = true;
                window.location.href = '/activity/doctorDetail?sid=' + id;
            }
        },
        created: function () {
            this.getData();
        },
        mounted: function () {
            this.loading = false;
        },
    });
</script>
</body>
</html>
