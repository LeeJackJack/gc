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
<div id="foShanInput">
    <template>
        <el-row :gutter="10" v-loading="loading">
            <el-col :xs="{span: 22, offset: 1}" :sm="{span: 18, offset: 3}" :md="{span: 12, offset: 5}" :lg="{span: 12,
            offset: 5}" :xl="{span: 12, offset: 5}">
                <el-image
                        style="width: 100%;"
                        src="https://bocuhui.oss-cn-beijing.aliyuncs.com/covers/2019-11-11/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20191111141816.png"
                        fit="scale-down"></el-image>
                <el-alert
                        title="填写完整的履历，有助于企业快速的了解您，与您展开进一步的沟通交流。"
                        center
                        type="info"
                        :closable="false"
                        style="margin: 20px 0">
                </el-alert>
                <el-form ref="form" :model="form" label-width="90px" style="margin-bottom: 100px;">
                    <el-form-item
                            label="姓名"
                            prop="name"
                            :rules="[{ required: true, message: '请输入姓名', trigger: 'blur' },]">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item
                            label="毕业学校"
                            prop="school"
                            :rules="[{ required: true, message: '请输入学校', trigger: 'blur' },]">
                        <el-input v-model="form.school"></el-input>
                    </el-form-item>
                    <el-form-item
                            label="联系方式"
                            prop="phone"
                            :rules="[{ required: true, message: '请输入联系电话', trigger: 'blur' },]">
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>
                    <el-form-item
                            label="邮箱"
                            prop="email"
                            :rules="[{ required: true, message: '请输入邮箱', trigger: 'blur' },]">
                        <el-input v-model="form.email"></el-input>
                    </el-form-item>
                    <el-form-item
                            label="专业"
                            prop="major"
                            :rules="[{ required: true, message: '请输入专业', trigger: 'blur' }]">
                        <el-input v-model="form.major" placeholder="如：机械自动化"></el-input>
                    </el-form-item>
                    <el-form-item label="教育经历" prop="education" :rules="[{ required: true, message: '请输入您的教育经历',
                    trigger:
                    'blur' },]">
                        <el-input @change="eduChange" v-model="edu1" style="margin-bottom: 10px;"
                                  placeholder="2011-2014 中山大学 本科"></el-input>
                        <el-input @change="eduChange" v-model="edu2" style="margin-bottom: 10px;"
                                  placeholder="2014-2016 中山大学 硕士"></el-input>
                        <el-input @change="eduChange" v-model="edu3" placeholder="2016-2011 中山大学 博士"></el-input>
                    </el-form-item>
                    <el-form-item label="项目（工作经历）">
                        <el-input type="textarea" v-model="form.experience" rows="6"></el-input>
                    </el-form-item>
                    <el-form-item label="专利论文或著作">
                        <el-input type="textarea" v-model="form.paper" rows="4"></el-input>
                    </el-form-item>
                    <el-form-item label="技术特长">
                        <el-input type="textarea" v-model="form.expertise" rows="4"></el-input>
                    </el-form-item>
                    <el-form-item label="荣誉">
                        <el-input type="textarea" v-model="form.honor" rows="4"></el-input>
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
    let foShanInput = new Vue({
        el: '#foShanInput',
        data: {
            form: {
                name: '', school: '', major: '', phone: '',email:'', education: [], experience: '', paper: '',
                expertise:
    '',
        honor: ''
            },
            edu1: '',
            edu2: '',
            edu3: '',
            show: true,
            loading: true,
        },
        methods: {
            onSubmit(formName) {
                let _this = this;
                _this.$refs[formName].validate((valid) => {
                    if (valid) {
                        _this.loading = true;
                        // console.log(_this.form);
                        // 请求服务器
                        axios.get("/api/doctor/submitDoctor", {
                            params: {
                                form: _this.form,
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
                        _this.$message.error('请完整填写您的个人信息');
                    }
                });
            },
            eduChange(value)
            {
                this.form.education = [];
                if (this.edu1) {this.form.education.push(this.edu1);}
                if (this.edu2) this.form.education.push(this.edu2);
                if (this.edu3) this.form.education.push(this.edu3);
            }
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
