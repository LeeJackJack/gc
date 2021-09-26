@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="recommendEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="22" :offset="1">
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="2">
                            <span slot="label"><i class="el-icon-document"></i> 个人简历</span>
                            <div style="display: block;">
                                <div class="digitalResume">
                                    <el-col :span="14" :offset="1">
                                        <el-input v-model="form.resume_url" :disabled="true">
                                            <template slot="prepend">电子简历</template>
                                        </el-input>
                                    </el-col>
                                    <el-col :span="6" :offset="1">
                                        <el-button plain type="primary" @click="digitalResume">下载电子简历</el-button>
                                    </el-col>
                                </div>
                            </div>
                            <div class="sysResume">
                                <el-col :span="18" :offset="1">
                                    <div class="download">
                                        <el-button
                                                size="medium"
                                                plain
                                                type="primary"
                                                @click="downloadPdf"
                                                :loading="downloadLoading">下载系统简历
                                        </el-button>
                                    </div>
                                </el-col>
                            </div>
                            <div class="resume">
                                <div class="logo-wrapper">
                                    <img src="{{asset('pic/headhunterBg.png')}}"
                                         class="logo-wrapper-size">
                                </div>
                                <div class="userAvatarBlock">
                                    <div class="userAvatar">
                                        <div>
                                            <img :src="form.belongs_to_user ? form.belongs_to_user.icon : ''"
                                                 class="avatarPic"></div>
                                    </div>
                                    <div style="margin-left: 35px;">
                                        <div class="userName"><i class="el-icon-user-solid"></i> @{{
                                            form.name}}
                                        </div>
                                        <div class="telNum"><i class="el-icon-mobile"></i> @{{
                                            form.phone }}
                                        </div>
                                        <div class="emailAddress"><i class="el-icon-message"></i> @{{
                                            form.email }}
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="infoBlock">--}}
                                {{--<div class="majorAndDegree">--}}
                                {{--<i class="el-icon-s-opportunity" style="margin-top: 4px;"></i>--}}
                                {{--<div class="school">@{{ form.school }}</div>--}}
                                {{--<div class="major">@{{ form.major }}</div>--}}
                                {{--<div class="degree">@{{ form.education }}</div>--}}
                                {{--</div>--}}
                                {{--<div class="telNum"><i class="el-icon-mobile"></i> @{{ form.phone }}</div>--}}
                                {{--<div class="emailAddress"><i class="el-icon-message"></i> @{{ form.email }}</div>--}}
                                {{--</div>--}}
                                <div>
                                    <el-divider style="font-size: 18px">求职</el-divider>
                                    <div class="jobInfoBlock">
                                        <div class="jobName">应聘职位： @{{ form.belongs_to_job.title }}
                                        </div>
                                        <div class="companyName">应聘企业： @{{
                                            form.belongs_to_job.belongs_to_company.name }}
                                        </div>
                                    </div>
                                </div>
                                <div v-show="form.eduBg">
                                    <el-divider>教育背景</el-divider>
                                    <div v-if="version == '1'" class="eduBgBlockNew">
                                        <div class="eduBg"
                                             v-for="(value,index) in JSON.parse(form.eduBg)">
                                            @{{ value.start_time }} 至 @{{ value.end_time }} @{{
                                            value.school
                                            }} @{{ value.degree }} @{{ value.major }}
                                        </div>
                                    </div>
                                    <div v-else class="eduBgBlock">
                                        <div class="eduBg">@{{ form.eduBg ? form.eduBg : '暂未填写...' }}
                                        </div>
                                    </div>
                                </div>
                                <div v-show="form.experience">
                                    <el-divider>项目或工作经验</el-divider>
                                    <div v-if="version == '1'">
                                        <div
                                                class="experience"
                                                v-for="(value,index) in JSON.parse(form.experience)"
                                        >@{{ value.start_time }} 至 @{{ value.end_time }} @{{
                                            value.company
                                            }}
                                            @{{ value.job }}
                                            <div style="margin-top: 5px;font-weight: 400;">@{{
                                                value.content
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="experienceBlock">
                                        <div class="experience" v-text="">@{{ form.experience ?
                                            form.experience : '暂未填写' }}
                                        </div>
                                    </div>
                                </div>
                                <div v-show="form.skill">
                                    <el-divider>技术特长</el-divider>
                                    <div class="skillBlock">
                                        <div class="skill">@{{ form.skill ? form.skill : '暂未填写' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div v-if="version == '1'">
                                        <div v-show="JSON.parse(form.honor).length > 0">
                                            <el-divider>获得荣誉</el-divider>
                                            <div class="honor"
                                                 v-for="(value,index) in JSON.parse(form.honor)">@{{
                                                value.time }} @{{ value.title}}
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div v-show="form.honor != null">
                                            <el-divider>获得荣誉</el-divider>
                                            <div class="honor">@{{ form.honor }}</div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div v-show="form.honor">--}}
                                {{--<el-divider>获得荣誉</el-divider>--}}
                                {{--<div v-if="version == '1'">--}}
                                {{--<div class="honor" v-for="(value,index) in JSON.parse(form.honor)">--}}
                                {{--<div>@{{ value }}</div>--}}
                                {{--<div v-if="value != ''">@{{ value.time }} @{{ value.title}}--}}
                                {{--</div>--}}
                                {{--<div v-else>暂未填写...</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div v-else class="honorBlock">--}}
                                {{--<div class="honor">@{{ form.honor ? form.honor : '暂未填写' }}</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div v-show="form.intro ">
                                    <el-divider>自我介绍</el-divider>
                                    <div class="skillBlock">
                                        <div class="skill">@{{ form.intro }}</div>
                                    </div>
                                </div>
                            </div>
                        </el-tab-pane>

                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-finished"></i> 推荐状态</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在更新本条推荐内容的状态，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="16" :offset="4">
                                        <el-form ref="form" :model="form" label-width="150px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="联系状态"
                                                    prop="is_handle">
                                                <el-switch
                                                        v-model="form.is_handle"
                                                        active-value="1"
                                                        inactive-value="0"
                                                        active-text="已联系"
                                                        inactive-text="未联系">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item
                                                    label="推荐奖金"
                                                    prop="is_pay">
                                                <el-switch
                                                        v-model="form.is_pay"
                                                        active-value="1"
                                                        inactive-value="0"
                                                        active-text="已领取"
                                                        inactive-text="未领取">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item
                                                    label="简历状态"
                                                    prop="status">
                                                <el-select
                                                        value-key="status"
                                                        v-model="form.status"
                                                        placeholder="简历状态">
                                                    <el-option
                                                            v-for="item in options"
                                                            :key="item.value"
                                                            :label="item.text"
                                                            :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            style="display: inline-block"
                                            type="primary"
                                            @click="onSubmit"
                                            :loading="btnLoading"
                                            size="small">提交
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="1">
                                <span slot="label"><i class="el-icon-message"></i>
                                     邮件通知 <el-badge :value="form.email_handle" type="primary"/>
                                </span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您可以操作下列邮件步骤，通知用户应聘进度。
                                            同时系统会检测用户提交推荐后24小时，后台是否有上传此用户简历，
                                            如无则会自动发送邮件提示，如在24小时内也可以手动发送。"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    {{--<el-row style="margin-top: 30px;margin-bottom: 40px;" :gutter="20">--}}
                                    {{--<el-col :span="24" style="margin-bottom: 25px;">--}}
                                    {{--<el-tag v-if="form.is_send_required_resume_email == 0" type="info"--}}
                                    {{--effect="dark"><i class="el-icon-message"></i> 通知用户发送简历--}}
                                    {{--</el-tag>--}}
                                    {{--<el-tag v-else type="success" effect="dark"><i class="el-icon-message"></i>--}}
                                    {{--通知用户发送简历--}}
                                    {{--</el-tag>--}}
                                    {{--</el-col>--}}
                                    {{--<el-col :span="9">--}}
                                    {{--<el-input--}}
                                    {{--placeholder="无记录"--}}
                                    {{--prefix-icon="el-icon-date"--}}
                                    {{--:disabled="true"--}}
                                    {{--v-model="form.created_at">--}}
                                    {{--<template slot="prepend">推荐时间</template>--}}
                                    {{--</el-input>--}}
                                    {{--</el-col>--}}
                                    {{--<el-col :span="9">--}}
                                    {{--<el-input--}}
                                    {{--placeholder="无记录"--}}
                                    {{--prefix-icon="el-icon-date"--}}
                                    {{--:disabled="true"--}}
                                    {{--v-model="resumeInform">--}}
                                    {{--<template slot="prepend">系统发送时间</template>--}}
                                    {{--</el-input>--}}
                                    {{--</el-col>--}}
                                    {{--<el-col :span="4">--}}
                                    {{--<el-button--}}
                                    {{--:loading="resumeBtnLoading"--}}
                                    {{--@click="informSendResume(form.ids)"--}}
                                    {{--v-if="form.is_send_required_resume_email == 0" type="primary">--}}
                                    {{--现在发送--}}
                                    {{--</el-button>--}}
                                    {{--<el-button v-else type="success" plain :disabled="true">已发送</el-button>--}}
                                    {{--</el-col>--}}
                                    {{--</el-row>--}}

                                    {{--<el-divider direction="horizontal"></el-divider>--}}

                                    <el-row style="margin-top: 40px;margin-bottom: 40px" :gutter="20">
                                        <el-col :span="24" style="margin-bottom: 25px;">
                                            <el-tag v-if="form.is_send_received_resume_email == 0" type="info"
                                                    effect="dark"><i class="el-icon-message"></i> 通知用户简历已收到
                                            </el-tag>
                                            <el-tag v-else type="success" effect="dark"><i class="el-icon-message"></i>
                                                通知用户简历已收到
                                            </el-tag>
                                        </el-col>
                                        <el-col :span="9">
                                            <el-input
                                                    placeholder="无记录"
                                                    prefix-icon="el-icon-date"
                                                    :disabled="true"
                                                    v-model="userInform">
                                                <template slot="prepend">系统发送时间</template>
                                            </el-input>
                                        </el-col>
                                        <el-col :span="4">
                                            <el-button
                                                    :loading="userBtnLoading"
                                                    @click="informReceivedResume(form.ids)"
                                                    v-if="form.is_send_received_resume_email == 0" type="primary">
                                                现在发送
                                            </el-button>
                                            <el-button v-else type="success" plain :disabled="true">已发送</el-button>
                                        </el-col>
                                    </el-row>

                                    {{--<el-divider direction="horizontal"></el-divider>--}}

                                    {{--<el-row style="margin-top: 40px;margin-bottom: 40px" :gutter="20">--}}
                                    {{--<el-col :span="24" style="margin-bottom: 25px;">--}}
                                    {{--<el-tag v-if="form.is_send_inform_company_email == 0" type="info"--}}
                                    {{--effect="dark"><i class="el-icon-message"></i> 通知企业有应聘者--}}
                                    {{--</el-tag>--}}
                                    {{--<el-tag v-else type="success" effect="dark"><i class="el-icon-message"></i>--}}
                                    {{--通知企业有应聘者--}}
                                    {{--</el-tag>--}}
                                    {{--</el-col>--}}
                                    {{--<el-col :span="9">--}}
                                    {{--<el-input--}}
                                    {{--placeholder="无记录"--}}
                                    {{--prefix-icon="el-icon-date"--}}
                                    {{--:disabled="true"--}}
                                    {{--v-model="companyInform">--}}
                                    {{--<template slot="prepend">系统发送时间</template>--}}
                                    {{--</el-input>--}}
                                    {{--</el-col>--}}
                                    {{--<el-col :span="4">--}}
                                    {{--<el-button--}}
                                    {{--:loading="comBtnLoading"--}}
                                    {{--@click="informCompanyEmail(form.ids)"--}}
                                    {{--v-if="form.is_send_inform_company_email == 0" type="primary">--}}
                                    {{--现在发送--}}
                                    {{--</el-button>--}}
                                    {{--<el-button v-else type="success" plain :disabled="true">已发送</el-button>--}}
                                    {{--</el-col>--}}
                                    {{--</el-row>--}}
                                </el-main>
                                <el-footer style="text-align: right;">
                                    {{----}}
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                    </el-tabs>
                </el-col>
            </el-row>
        </template>
        <form name="submitForm"
              action="{{ isset($recommend) && $recommend ? route('admin.recommend.update', ['id' => $recommend->ids]) :  route('admin.recommend.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($recommend) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="is_handle">
            <input type="text" name="status">
            <input type="text" name="is_pay">
        </form>
    </div>
    <style>
        .el-header {
            height: 80px;
        }

        .el-footer {
            background-color: rgb(247, 247, 247);
            line-height: 60px;
        }

        .userAvatar {
            display: flex;
            justify-content: space-between;
        }

        .logo-wrapper {
            text-align: right;
            margin-top: -25px;
        }

        .logo-wrapper-size {
            width: 200px;
        }

        .userAvatarBlock {
            margin: -50px auto 40px auto;
            text-align: justify;
            white-space: pre-wrap;
            display: flex;
        }

        .infoBlock, .jobInfoBlock, .eduBgBlock, .experienceBlock, .skillBlock {
            margin: 30px auto;
            text-align: justify;
            white-space: pre-wrap;
        }

        .eduBgBlockNew {
            text-align: justify;
        }

        .infoBlock {
            line-height: 15px;
        }

        .userAvatarBlock {
            height: auto;
        }

        .infoBlock {
            /*height: 200px;*/
        }

        .avatarPic {
            margin: 0 auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }

        .userName {
            font-size: 20px;
            font-weight: 600;
            color: #111111;
        }

        .userName, .telNum, .emailAddress {
            height: 30px;
        }

        .jobName, .companyName, .createdTime {
            display: flex;
            justify-content: flex-start;
        }

        .school, .major, .degree, .telNum, .emailAddress, .jobName, .companyName, .createdTime, .eduBg, .experience,
        .skill, .honor {
            font-size: 14px;
            font-weight: 500;
            color: #333333;
            letter-spacing: 2px;
            text-align: left;
            line-height: 30px;
        }

        .telNum, .emailAddress {
            font-size: 14px;
            margin: -2px 0;
            font-weight: 400;
            letter-spacing: 2px;
            text-align: left;
        }

        .experience, .eduBg, .skill, .honor {
            margin: 5px 0;
        }

        .majorAndDegree {
            display: flex;
            justify-content: flex-start;
        }

        .experienceBlock, .skillBlock, .honorBlock {
            text-align: left;
        }

        .skill, .experience, .honor, .eduBg {
            width: 100%;
            height: auto;
            word-wrap: break-word;
            word-break: break-all;
            overflow: hidden;
        }

        .digitalResume {
            height: 60px;
            line-height: 60px;
            margin-bottom: 30px;
        }

        .resume {
            margin: 40px;
            padding: 30px;
            border: 1px solid #eaecf5;
            text-align: center;
            /*transition: box-shadow .2s;*/
            background-color: white;
            border-radius: 6px;
            /*box-shadow: rgba(0, 0, 0, 0.05) 0 1px 3px 0;*/
            width: 850px;
            height: auto;
        }

        .download {
            margin: 30px 0;
            /*text-align: right;*/
            /*width: 900px;*/
        }

        .el-divider__text.is-center {
            font-size: 18px;
            color: rgb(66, 87, 178);
        }

        .sysResume
        {
            height: 100px;
        }

    </style>
    <script>
        let recommendEdit = new Vue({
            el: '#recommendEdit',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                form: {!! isset($recommend)? $recommend:'{}' !!},
                loading: true,
                btnLoading: false,
                active: '2',
                options: [
                    {text: '已接收', value: '0'},
                    {text: '面试中', value: '1'},
                    {text: '不匹配', value: '2'},
                    {text: '入职中', value: '3'},
                    {text: '入职成功', value: '4'},
                ],
                {{--resumeInform: '{!! $recommend->hasManyEmailLogs->where('type','0')->first() ?--}}
                        {{--$recommend->hasManyEmailLogs->where('type','0')->first()->created_at : null !!}',--}}
                userInform: '{!! $recommend->hasManyEmailLogs->where('type','1')->count() > 0 ?
                $recommend->hasManyEmailLogs->where('type','1')->first()->created_at : null !!}',
                {{--companyInform: '{!! $recommend->hasManyEmailLogs->where('type','2')->count() > 0 ?--}}
                        {{--$recommend->hasManyEmailLogs->where('type','2')->first()->created_at : null !!}',--}}
                resumeBtnLoading: false,
                userBtnLoading: false,
                comBtnLoading: false,
                downloadLoading: false,
                version: '1',
            },
            compute: {
                //
            },
            methods: {
                //通知用户发送简历
                informSendResume(id) {
                    //console.log('发送简历邮件');
                    this.resumeBtnLoading = true;
                    axios.get("/informSendResume", {
                        params: {
                            ids: id
                        },
                    }).then(res => {
                        this.resumeBtnLoading = false;
                        let data = res.data;
                        if (data.code == '888') {
                            this.form.is_send_required_resume_email = '1';
                            this.form.email_handle -= 1;
                            this.resumeInform = data.created_at.date.substring(0, 19);
                        }
                        this.$notify({
                            title: data.result,
                            message: data.msg,
                            type: data.result
                        });
                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                //告知用户已收到简历
                informReceivedResume(id) {
                    //console.log('发送用户邮件');
                    this.userBtnLoading = true;
                    axios.get("/informReceivedResume", {
                        params: {
                            ids: id
                        },
                    }).then(res => {
                        this.userBtnLoading = false;
                        //console.log(res);
                        let data = res.data;
                        if (data.code == '888') {
                            this.form.is_send_received_resume_email = '1';
                            this.form.email_handle -= 1;
                            this.userInform = data.created_at.date.substring(0, 19);
                        }
                        this.$notify({
                            title: data.result,
                            message: data.msg,
                            type: data.result
                        });
                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                //告知企业有应聘者
                informCompanyEmail(id) {
                    //console.log('发送企业邮件');
                    this.comBtnLoading = true;
                    axios.get("/informCompanyEmail", {
                        params: {
                            ids: id
                        },
                    }).then(res => {
                        this.comBtnLoading = true;
                        //console.log(res);
                        let data = res.data;
                        if (data.code == '888') {
                            this.form.is_send_inform_company_email = '1';
                            this.form.email_handle -= 1;
                            this.companyInform = data.created_at.date.substring(0, 19);
                        }
                        this.$notify({
                            title: data.result,
                            message: data.msg,
                            type: data.result
                        });
                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    $('input[name^=is_handle]').val(this.form.is_handle);
                    $('input[name^=status]').val(this.form.status);
                    $('input[name^=is_pay]').val(this.form.is_pay);
                    document.forms['submitForm'].submit();
                },
                downloadPdf() {
                    this.downloadLoading = true;
                    html2canvas(document.querySelector('.resume'), {
                        allowTaint: true, useCORS: true,
                    }).then(function (canvas) {
                            let contentWidth = canvas.width;
                            let contentHeight = canvas.height;
                            let pageHeight = contentWidth / 592.28 * 841.89;
                            let leftHeight = contentHeight;
                            let position = 0;
                            let imgWidth = 595.28;
                            let imgHeight = 592.28 / contentWidth * contentHeight;
                            let pageData = canvas.toDataURL('image/png', 1.0);
                            let PDF = new jsPDF('', 'pt', 'a4');
                            if (leftHeight < pageHeight) {
                                PDF.addImage(pageData, 'png', 0, 0, imgWidth, imgHeight);
                            } else {
                                while (leftHeight > 0) {
                                    PDF.addImage(pageData, 'png', 0, position, imgWidth, imgHeight);
                                    leftHeight -= pageHeight;
                                    position -= 841.89;
                                    if (leftHeight > 0) {
                                        PDF.addPage();
                                    }
                                }
                            }
                            PDF.save('resume.pdf');
                        }
                    );
                    let __this = this;
                    setTimeout(function () {
                        __this.downloadLoading = false;
                    }, 2000);
                },
                digitalResume() {
                    window.open(this.form.resume_url, '_blank');
                }
            },
            created: function () {
                //新旧简历格式兼容
                if (this.form.experience != null) {
                    try {
                        if (JSON.parse(this.form.experience)) {
                            this.version = '1';
                        }
                    } catch (e) {
                        this.version = '0';
                    }
                } else {
                    this.version = '0';
                }
            },
            mounted: function () {
                this.loading = false;
                // console.log('version:'+this.version);
                // console.log('honor:'+this.form.honor);
            },
            destroy: function () {
                //
            }
        });
    </script>
@endsection