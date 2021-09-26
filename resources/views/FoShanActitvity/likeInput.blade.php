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
</style>
<body>
<div id="likeInput">
    <template>
        <el-row :gutter="10" v-loading="loading">
            <el-col :xs="{span: 22, offset: 1}" :sm="{span: 18, offset: 3}" :md="{span: 12, offset: 5}" :lg="{span: 12,
            offset: 5}" :xl="{span: 12, offset: 5}">
                <el-image
                        style="width: 100%;"
                        src="https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-11-11/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20191111141816.png"
                        fit="scale-down"></el-image>
                <el-alert
                        title="请留下您的联系方式，以便博士能与您取得联系。"
                        center
                        type="info"
                        :closable="false"
                        style="margin: 20px 0">
                </el-alert>
                <el-form ref="form" :model="form" label-width="100px" style="margin-bottom: 100px;">
                    <el-form-item
                            label="姓名"
                            prop="name"
                            :rules="[{ required: true, message: '请输入姓名', trigger: 'blur' },]">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item
                            label="联系电话"
                            prop="phone"
                            :rules="[{ required: true, message: '请输入联系电话', trigger: 'blur' }]">
                        <el-input v-model="form.phone" placeholder="固话或手机..."></el-input>
                    </el-form-item>
                    <el-form-item
                            label="单位"
                            prop="company"
                            :rules="[{ required: true, message: '请输入单位名称', trigger: 'blur' }]">
                        <el-input v-model="form.company"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <div class="bottomBtn" @click="onSubmit('form')">提交</div>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </template>
</div>

<!-- Scripts -->
<script>
    //led
    let likeInput = new Vue({
        el: '#likeInput',
        data: {
            form: {
                name: '', phone: '', company: ''
            },
            loading: true,
        },
        methods: {
            onSubmit(formName) {
                let _this = this;
                let id = this.getQueryVariable('sid');
                _this.loading = true;
                _this.$refs[formName].validate((valid) => {
                    if (valid) {
                        // console.log(_this.form);
                        // 请求服务器
                        axios.get("/api/doctor/submitLike", {
                            params: {
                                form: _this.form,
                                id: id
                            },
                        }).then(res => {
                            // console.log(res.data);
                            setTimeout(function () {
                                _this.loading = false;
                                _this.$message({
                                    message: res.data.msg,
                                    type: res.data.result,
                                });
                            }, 1000);
                        }).catch(function (err) {
                            //console.log(err);
                        });
                    } else {
                        _this.loading = false;
                        _this.$message.error('请完整填写您的联系方式');
                    }
                });
            },
            getQueryVariable(name) {
                let query = window.location.search.substring(1);
                let vars = query.split("&");
                for (let i = 0; i < vars.length; i++) {
                    let pair = vars[i].split("=");
                    if (pair[0] == name) {
                        return pair[1];
                    }
                }
                return (false);
            },
        },
        created: function () {
            //
        },
        mounted: function () {
            this.loading = false;
        },
    });
</script>
</body>
</html>
