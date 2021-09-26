@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="companyEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card">
                        <el-tab-pane>
                            <span v-if="form.ids && !show" slot="label"><i class="el-icon-edit"></i> 修改</span>
                            <span v-else-if="show" slot="label"><i class="el-icon-document"></i> 详情</span>
                            <span v-else slot="label"><i class="el-icon-plus"></i> 创建</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            v-if="show == '0'"
                                            title="您正在编辑企业信息，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="form" :model="form" label-width="170px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="单位名称"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入单位名称' },]">
                                                <el-input v-model="form.name" class="el-input" :disabled="show"
                                                          placeholder="请输入单位名称..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="单位属性"
                                                    prop="property">
                                                <el-input v-model="form.property" class="el-input" :disabled="show"
                                                          placeholder="高校、科研机构、医疗机构、企业..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="单位资质"
                                                    prop="scale">
                                                <el-input v-model="form.scale" class="el-input" :disabled="show"
                                                          placeholder="博士后科研工作站、博士后科研流动站、创新实践基地、高新技术企业..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="所属行业"
                                                    prop="type">
                                                <el-input v-model="form.type" class="el-input" :disabled="show"
                                                          placeholder="互联网，生物医药等..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="联系人"
                                                    prop="contact">
                                                <el-input v-model="form.contact" class="el-input" :disabled="show"
                                                          placeholder="单位联系..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="联系人职务"
                                                    prop="position">
                                                <el-input v-model="form.position" class="el-input" :disabled="show"
                                                          placeholder="单位联系人职务..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="联系人手机"
                                                    prop="cellPhone">
                                                <el-input v-model="form.cellPhone" class="el-input" :disabled="show"
                                                          placeholder="联系人手机..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="联系人座机"
                                                    prop="phone">
                                                <el-input v-model="form.phone" class="el-input" :disabled="show"
                                                          placeholder="联系人座机..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="联系人邮箱"
                                                    prop="email">
                                                <el-input v-model="form.email" class="el-input" :disabled="show"
                                                          placeholder="企业邮箱..."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item label="上市">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.is_ipo"
                                                        active-text="已上市"
                                                        inactive-text="未上市"
                                                        :disabled="show">
                                                </el-switch>
                                            </el-form-item>
                                            <el-form-item
                                                    label="介绍"
                                                    prop="com_intro"
                                                    :rules="[{ required: true, message: '如：企业介绍等...' },]">
                                                <el-input v-model="comTextArea" rows="18"
                                                          type="textarea"
                                                          name="comTextArea"
                                                          class="el-input" :disabled="show"
                                                          placeholder="企业介绍等..."></el-input>
                                            </el-form-item>
                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            v-if="!show"
                                            type="primary"
                                            @click="onSubmit"
                                            :loading="btnLoading"
                                            size="small">提交
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>
                        <el-tab-pane v-if="form.ids">
                            <span slot="label"><i class="el-icon-share"></i> 企业二维码</span>
                            <el-container>
                                <el-header></el-header>
                                <el-main>
                                    <el-col :span="20" :offset="2" style="text-align: center">
                                        <el-image
                                                v-if="form.qr_code"
                                                style="width: 200px; height: 200px"
                                                :src="form.qr_code"
                                                :preview-src-list="previewQrCodeList">
                                        </el-image>
                                        <el-image
                                                v-else
                                                style="width: 200px; height: 200px"
                                                src="">
                                            <div slot="error" class="image-slot">
                                                <el-alert
                                                        title="暂无二维码图片"
                                                        description="请点击‘生成’按钮生成二维码"
                                                        type="warning"
                                                        :closable="false"
                                                        show-icon>
                                                </el-alert>
                                            </div>
                                        </el-image>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            v-if="!form.qr_code"
                                            type="primary"
                                            @click="create_qr_code"
                                            :loading="btnLoading"
                                            size="small">生成
                                    </el-button>
                                    <el-button
                                            v-else
                                            type="success"
                                            :disabled="true"
                                            size="small">已生成
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>
        </template>
        <form name="submitForm"
              action="{{ isset($company) && $company ? route('admin.company.update', ['id' => $company->ids]) :  route('admin.company.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($company) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="name">
            <input type="text" name="property">
            <input type="text" name="scale">
            <input type="text" name="email">
            <input type="text" name="type">
            <input type="text" name="is_ipo">
            <input type="text" name="contact">
            <input type="text" name="phone">
            <input type="text" name="cellPhone">
            <input type="text" name="position">
            <textarea type="text" name="com_intro"></textarea>
        </form>
    </div>
    <style>
        .el-table .cell.el-tooltip {
            white-space: pre-wrap;
        }
    </style>
    <script>
        let companyEdit = new Vue({
            el: '#companyEdit',
            data: {
                form: {!! isset($company)? $company:'{}' !!},
                loading: true,
                btnLoading: false,
                previewQrCodeList: [''],
                show: {{ $show }} ? true : false,
                comTextArea:'',
            },
            compute: {
                //
            },
            methods: {
                //生成企业二维码
                create_qr_code() {
                    this.btnLoading = true;
                    axios.get("/api/wx/getComQrCode", {
                        params: {
                            scene: this.form.ids
                        },
                    }).then(res => {
                        this.loading = false;
                        this.btnLoading = false;
                        //console.log(res);
                        this.form.qr_code = res.data.url;
                        this.previewQrCodeList[0] = this.form.qr_code;

                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    $('input[name^=name]').val(this.form.name);
                    $('input[name^=property]').val(this.form.property);
                    $('input[name^=scale]').val(this.form.scale);
                    $('input[name^=type]').val(this.form.type);
                    $('input[name^=is_ipo]').val(this.form.is_ipo);
                    $('input[name^=email]').val(this.form.email);
                    $('input[name^=contact]').val(this.form.contact);
                    $('input[name^=phone]').val(this.form.phone);
                    $('input[name^=cellPhone]').val(this.form.cellPhone);
                    $('input[name^=position]').val(this.form.position);
                    // let text = $('textarea[name^=comTextArea]').val();
                    $('textarea[name^=com_intro]').val(this.comTextArea);
                    document.forms['submitForm'].submit();
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
                this.previewQrCodeList[0] = this.form.qr_code;
                if(this.form.com_intro)
                {
                    this.comTextArea = this.form.com_intro.replace(new RegExp('<br>','g'),'\r\n');
                }
            },
        });
    </script>
@endsection