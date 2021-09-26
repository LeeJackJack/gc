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
    .shuxian {
        width: 4px;
        height: 15px;
        background: #000000;
        float: left;
        margin-top: 4px;
    }

    .title {
        float: left;
        font-size: 15px;
        color: #222222;
        font-weight: bold;
        margin-left: 5px;
    }

    .itemText {
        margin: 10px;
        color: #666666;
        font-size: 14px;
        letter-spacing: 2px;
    }

    .bottomBtn {
        border-radius: 5px;
        background-color: #4BC7ED;
        height: 50px;
        line-height: 50px;
        font-size: 17px;
        text-align: center;
        width: 88%;
        bottom: 0;
        margin-bottom: 10px;
        z-index: 101;
        left: 6%;
        color: white;
        position: fixed;
    }

    .item {
        height: 20px;
        padding-left: 10px;
        font-size: 9px;
        color: #cccccc;
        padding-top: 24px;
    }

    .doctorName
    {
        font-size: 20px;
        color: #333333;
        font-weight: bold;
        margin-right: 10px;
    }

    .doctorSchool
    {
        font-size:15px;
        color:#999999;
        font-weight:normal;
    }
</style>
<body>
<div id="foShanDetail">
    <template>
        <el-row :gutter="10" v-loading="loading">
            <el-col :xs="{span: 22, offset: 1}" :sm="{span: 20, offset: 2}" :md="{span: 16, offset: 4}" :lg="{span: 12,
            offset: 5}" :xl="{span: 12, offset: 5}">
                <el-image
                        style="width: 100%;"
                        src="https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-11-11/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20191111141816.png"
                        fit="scale-down"></el-image>
                <div style="min-height: 30px; margin-top: 21px; padding-left: 10px; overflow: hidden;">
                    <div style="width: 90%; float: left">
                        <div id="fxb_info_div" style="width: 100%; float: left;">
                            <div class="doctorName">
                                @{{ String(data.name).substring(0,1) }}博士
                                <span class="doctorSchool">&nbsp;&nbsp;@{{  data.school }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="shuxian"></div>
                    <div class="title">专业</div>
                </div>
                <div class="itemText">@{{ data.major }}</div>

                <div class="item">
                    <div class="shuxian"></div>
                    <div class="title">教育经历</div>
                </div>
                <div class="itemText" v-for="(value,index) in education">@{{ value }}</div>

                <div v-if="data.experience">
                    <div class="item">
                        <div class="shuxian"></div>
                        <div class="title">项目（工作）经历</div>
                    </div>
                    <div class="itemText" v-for="(value,index) in data.experience.split('\n')">@{{ value }}</div>
                </div>

                <div v-if="data.paper">
                    <div class="item">
                        <div class="shuxian"></div>
                        <div class="title">专利论文著作</div>
                    </div>
                    <div class="itemText" v-for="(value,index) in data.paper.split('\n')">@{{ value }}</div>
                </div>

                <div v-if="data.expertise">
                    <div class="item">
                        <div class="shuxian"></div>
                        <div class="title">技术特长</div>
                    </div>
                    <div class="itemText" v-for="(value,index) in data.expertise.split('\n')">@{{ value }}</div>
                </div>

                <div v-if="data.honor">
                    <div class="item">
                        <div class="shuxian"></div>
                        <div class="title">荣誉</div>
                    </div>
                    <div class="itemText" v-for="(value,index) in data.honor.split('\n')">@{{ value }}</div>
                </div>

                <div style="height: 100px"></div>

                <!-- 输入资料按钮 -->
                <div style="width: 100%;">
                    <div class="bottomBtn" @click="likeAction">感兴趣</div>
                </div>
            </el-col>
        </el-row>
    </template>
</div>

<!-- Scripts -->
<script>
    //led
    let foShanDetail = new Vue({
        el: '#foShanDetail',
        data: {
            data: [],
            show: true,
            loading: true,
            education: [],
        },
        methods: {
            getData() {
                let _this = this;
                let id = _this.getQueryVariable('sid');
                //请求服务器
                axios.get("/api/doctor/getDetail", {
                    params: {
                        id: id
                    },
                }).then(res => {
                    _this.data = res.data.data;
                    _this.education = _this.data.education.split(',');
                    setTimeout(function () {
                        _this.loading = false;
                    }, 1000)
                    // console.log(res.data);
                }).catch(function (err) {
                    //console.log(err);
                });
            },
            getQueryVariable(name) {
                var query = window.location.search.substring(1);
                var vars = query.split("&");
                for (var i = 0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if (pair[0] == name) {
                        return pair[1];
                    }
                }
                return (false);
            },
            likeAction() {
                let id = this.getQueryVariable('sid');
                // this.loading = true;
                window.location.href = '/activity/likeInput?sid=' + id;
            }
        },
        created: function () {
            this.getData();
        },
        mounted: function () {
            // this.loading = false;
        },
    });
</script>
</body>
</html>
