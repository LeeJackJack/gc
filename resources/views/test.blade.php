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
        #home {
            padding: 15px;
        }

        .title {
            text-align: center;
            width: 100%;
            height: 100px;
            line-height: 50px;
            font-size: 26px;
            color: #333333;
            margin-bottom: 30px;
        }
        .el-form-item__label {

            color: white;

        }
    </style>

</head>
<body>
<div id="home">
    <template>
        <el-row v-loading="loading" justify="center" align="middle" type="flex">
            <el-col :xs="23" :sm="23" :md="10" :lg="10" :xl="10">
                {{--标题--}}
                <div style="text-align: center;">
                    <img src="https://bocuhui.oss-cn-beijing.aliyuncs.com/images/back-title-eng.jpg" alt=""
                         style="width: 100%;">
                </div>
                <div style="font-size: 14px;line-height: 30px;color:white;margin-top: -10px;background-color:#016ed5;padding-top: 20px;padding-left: 20px;">
                    主办单位：广东省科学技术厅<br/>
                    承办单位：广东省科技合作研究促进中心<br/>
                    Host: &nbsp;Guangdong Science and Technology Department<br/>
                    Organizer: &nbsp;Department of Science and Technology of Guangdong Province<br/>
                </div>
            </el-col>
        </el-row>
        <el-row v-loading="loading" :gutter="10" justify="center" type="flex" align="middle" style="margin: 0px;" >
            {{--表单开始--}}
            <el-col :xs="23" :sm="23" :md="10" :lg="10" :xl="10" style="background-color: #016ed5;padding: 15px;">
                <div style="color:white;font-size: 20px;margin-bottom: 10px;font-weight: 400;text-align: center">活动报名表 / Enroll</div>
                <el-form ref="form" :model="form" label-width="30%" label-position="top">


                    {{--报名人姓名--}}
                    <el-form-item
                            label="姓名 / Name"
                            prop="name"
                            :rules="[{ required: true, message: '请输入姓名 / Require Name' },]">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    {{--性别 0：男 1：女--}}
                    <el-form-item
                            label="性别 / Gender"
                            prop="gender"
                            :rules="[{ required: true, message: '请选择性别 / Require Gender' },]">
                        <el-select v-model="form.gender">
                            <el-option label="男 / Male" value="0"></el-option>
                            <el-option label="女 / Female" value="1"></el-option>
                        </el-select>
                    </el-form-item>

                    {{--出生--}}
                    <el-form-item
                            label="出生日期 / Date Of Birth"
                            prop="birthday"
                            :rules="[{ required: true, message: '请填写出生日期  / Require Date Of Birth ' },]">
                        <el-input v-model="form.birthday" placeholder="请填写出生日期，格式如：1990-01-01  / Please fill in your date of birth, for example, 1990-01-01"></el-input>
                    </el-form-item>

                    {{--国籍 0：中国 1：国外--}}
                    <el-form-item
                            label="国籍 / Nationality"
                            prop="region"
                            :rules="[{ required: true, message: '请选择国籍 / Require Nationality' },]">
                        <el-select v-model="form.region">
                            <el-option label="中国 / China" value="0"></el-option>
                            <el-option label="国外 / Others" value="1"></el-option>
                        </el-select>
                    </el-form-item>

                    {{--省份--}}
                    <el-form-item
                            label="省份 / Province"
                            prop="province"
                            v-if="form.region == '0'"
                            :rules="[{ required: true, message: '请选择省份 / Require Province' },]">
                        <el-select v-model="form.province">
                            <el-option
                                    v-for="(province,index) in provinces"
                                    :label="province.label"
                                    :value="province.label"
                                    :rules="[{ required: true, message: '请选择省份 / Require Province' },]">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    {{--国籍国家--}}
                    <el-form-item
                            label="国籍国家 / Nationality"
                            v-if="form.region == '1'"
                            prop="country"
                            :rules="[{ required: true, message: '请填写国籍国家 / Require Nationality' },]">
                        <el-input v-model="form.country"></el-input>
                    </el-form-item>
                    <el-form-item
                            label="境外居住国家(或地区) / Country or region of residence overseas"
                            prop="settleCountry"
                            :rules="[{ required: true, message: '请填写境外居住国家 / Require Country or region of residence overseas' },]">
                        <el-input v-model="form.settleCountry"></el-input>
                    </el-form-item>

                    {{--住址--}}
                    <el-form-item
                            label="境外居住城市 / Overseas Residential Cities"
                            prop="settleCity"
                            :rules="[{ required: true, message: '请填写境外居住城市 / Require Overseas Residential Cities' },]">
                        <el-input v-model="form.settleCity"></el-input>
                    </el-form-item>

                    {{--有效证件 0：护照 1：身份证--}}
                    <el-form-item
                            label="有效证件类型 / Type of Valid  Documentation"
                            prop="idCard"
                            :rules="[{ required: true, message: '请选择有效证件类型 / Require Type of Valid  Documentation' },]">
                        <el-select v-model="form.idCard">
                            <el-option label="护照 / Passport" value="0"></el-option>
                            <el-option label="身份证 / ID" value="1"></el-option>
                        </el-select>
                    </el-form-item>

                    {{--有效证件号码--}}
                    <el-form-item
                            label="有效证件号码 / Valid Documentation Number"
                            prop="idCardNum"
                            :rules="[{ required: true, message: '请填写有效证件号码 / Require Valid Documentation Number' },]">
                        <el-input v-model="form.idCardNum"></el-input>
                    </el-form-item>

                    {{--学历--}}
                    <el-form-item
                            label="最高学历 / Highest Degree"
                            prop="edu"
                            :rules="[{ required: true, message: '请选择最高学历 / Require Highest Degree' },]">
                        <el-select v-model="form.edu">
                            <el-option label="在读博士 / PH.D student" value="在读博士"></el-option>
                            <el-option label="已获博士学位 / PH.D" value="已获博士学位"></el-option>
                        </el-select>
                    </el-form-item>


                    {{--毕业学校--}}
                    <el-form-item
                            label="最高学历学校 / Graduated school"
                            prop="school"
                            :rules="[{ required: true, message: '请填写最高学历学校 / Require Graduated school' },]">
                        <el-input v-model="form.school"></el-input>
                    </el-form-item>

                    {{--专业--}}
                    <el-form-item
                            label="专业 / Major"
                            prop="major"
                            :rules="[{ required: true, message: '请填写您的专业 / Require Major' },]">
                        <el-input v-model="form.major"></el-input>
                    </el-form-item>

                    {{--社团及职务--}}
                    <el-form-item label="参加社团及职务 / Club and Position" prop="corporation">
                        <el-input v-model="form.corporation"></el-input>
                    </el-form-item>

                    {{--单位及职务--}}
                    <el-form-item label="现任职单位及职务 / Employer And Position" prop="job">
                        <el-input v-model="form.job"></el-input>
                    </el-form-item>

                    {{--国内电话--}}
                    <el-form-item label="国内电话 / Domestic Phone Numbers" prop="phone">
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>

                    {{--国外电话--}}
                    <el-form-item
                            label="国外电话 / Overseas Phone Numbers"
                            prop="foreignPhone"
                            :rules="[{ required: true, message: '请填写国外电话 / Require Overseas Phone Number' },]">
                        <el-input v-model="form.foreignPhone"></el-input>
                    </el-form-item>

                    {{--Email--}}
                    <el-form-item
                            label="E-mail"
                            prop="email"
                            :rules="[{ required: true, message: '请填写email / Require E-mail' },]">
                        <el-input v-model="form.email"></el-input>
                    </el-form-item>

                    {{--微信号--}}
                    <el-form-item label="微信号 / WeChat" prop="wechat">
                        <el-input v-model="form.wechat"></el-input>
                    </el-form-item>

                    {{--项目--}}
                    <el-form-item label="若有意向开展项目合作，请填写项目简介（300字以内）/ If you are interested in project cooperation, please fill in the project brief (less than 300 words) " prop="project">
                        <el-input type="textarea" v-model="form.project" rows="8"></el-input>
                    </el-form-item>

                    {{--推荐机构--}}
                    <el-form-item
                        label="推荐机构 / Recommending institutions"
                        prop="organization">
                        <el-input v-model="form.organization"></el-input>
                    </el-form-item>

                    {{--提交按钮--}}
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit('form')">提交 / Attend</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </template>
</div>
<script>
    let home = new Vue({
        el: '#home',
        data: {
            loading: true,
            form: {
                organization: '',
                name: '',
                gender: '',
                birthday: '',
                region: '',
                province: '',
                country: '',
                settleCountry: '',
                settleCity: '',
                idCard: '',
                idCardNum: '',
                school: '',
                major: '',
                edu: '',
                corporation: '',
                job: '',
                phone: '',
                foreignPhone: '',
                email: '',
                wechat: '',
                project: '',
            },
            provinces:{!! $provinces !!},
        },
        compute: {
            //
        },
        methods: {
            onSubmit(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        // console.log(this.form);
                        this.loading = true;

                        //ajax请求
                        axios.get("/oversea-signUp/save", {
                            params: {
                                form: this.form
                            },
                        }).then(res => {
                            this.loading = false;
                            console.log(res);
                            if (res.data.code == '888') {
                                // this.$message({
                                //     type: 'success',
                                //     message: '报名成功，工作人员将尽快审核您的报名信息，有结果后工作人员会与您取得联系'
                                // });
                                window.location.href = '{{ route('success') }}';

                            } else if (res.data.code == '555') {
                                this.$message({
                                    type: 'warning',
                                    message: '您已成功提交过报名申请，请耐心等待工作人员审核'
                                });
                            }
                            else {
                                this.$message({
                                    type: 'error',
                                    message: '报名失败，请重新整理资料提交尝试'
                                });
                            }
                        }).catch(function (err) {
                            this.$message({
                                type: 'error',
                                message: '报名失败，请重新整理资料提交尝试'
                            });
                        });

                    } else {
                        //console.log('error submit!!');
                        return false;
                    }
                });
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
