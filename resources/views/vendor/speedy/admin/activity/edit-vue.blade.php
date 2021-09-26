@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="activityEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-reading"></i> 基本信息</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑活动内容，请填写下列表单内容"
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
                                                    label="活动名称"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入企业名称' },]">
                                                <el-input v-model="form.name" class="el-input"></el-input>
                                            </el-form-item>

                                            {{--封面--}}
                                            <el-form-item
                                                    label="封面"
                                                    :rules="[{ required: true, message: '' },]">
                                                <el-upload
                                                        class="avatar-uploader"
                                                        action="/api/upLoadCoverPic/"
                                                        :show-file-list="false"
                                                        :on-success="upLoadCoverPic"
                                                        :headers="{'X-CSRF-TOKEN':csrfToken}">
                                                    <img :src="pic" class="avatar" v-show="pic">
                                                    <i v-if="!pic" class="el-icon-plus avatar-uploader-icon"></i>
                                                </el-upload>
                                            </el-form-item>

                                            <el-form-item
                                                    label="活动时间"
                                                    :rules="[{ required: true, message: '请输入活动时间...' },]">
                                                <el-tooltip effect="dark" content="活动开始时间" placement="top">
                                                    <el-date-picker
                                                            v-model="form.start_time"
                                                            type="datetime"
                                                            placeholder="开始时间"
                                                            value-format="yyyy-MM-dd HH:mm:ss">
                                                    </el-date-picker>
                                                </el-tooltip>

                                                <el-tooltip effect="dark" content="活动结束时间" placement="top">
                                                    <el-date-picker
                                                            v-model="form.end_time"
                                                            type="datetime"
                                                            placeholder="结束时间"
                                                            value-format="yyyy-MM-dd HH:mm:ss">
                                                    </el-date-picker>
                                                </el-tooltip>

                                            </el-form-item>

                                            <el-form-item
                                                    label="截止报名时间"
                                                    :rules="[{ required: true, message: '请选择截止报名时间' },]">
                                                <el-date-picker
                                                        v-model="form.sign_up_end_time"
                                                        type="datetime"
                                                        placeholder="选择报名截止时间"
                                                        value-format="yyyy-MM-dd HH:mm:ss">
                                                </el-date-picker>
                                            </el-form-item>

                                            <el-form-item
                                                    label="活动城市"
                                                    prop="city_code"
                                                    :rules="[{ required: true, message: '如：广州市...' },]">
                                                <el-cascader
                                                        :options="provinces"
                                                        :props="{ children: 'city','value':'code','label':'label','emitPath':false }"
                                                        v-model="form.city_code">
                                                </el-cascader>
                                            </el-form-item>

                                            <el-form-item
                                                    label="费用"
                                                    prop="price"
                                                    :rules="[{ required: true, message: '请输入活动费用...' },]">
                                                <el-input v-model="form.price" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="活动地址"
                                                    prop="address"
                                                    :rules="[{ required: true, message: '请输入活动地址...' },]">
                                                <el-input v-model="form.address" class="el-input"></el-input>
                                            </el-form-item>
                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            plain
                                            type="primary"
                                            @click="next"
                                            size="small">下一步
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="1">
                            <span slot="label"><i class="el-icon-data-analysis"></i> 活动介绍</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑活动内容，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    {{--富文本编辑器--}}
                                    <script id="activity_ueditor" name="detail_rich_text" type="text/plain"></script>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            style="display: inline-block"
                                            plain
                                            type="primary"
                                            @click="forward"
                                            size="small">上一步
                                    </el-button>
                                    <el-button
                                            style="display: inline-block"
                                            plain
                                            type="primary"
                                            @click="next"
                                            size="small">下一步
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="2">
                            <span slot="label"><i class="el-icon-tickets"></i> 报名表格</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑报名表格，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="signForm" :model="form" label-position="left"
                                                 name="edit"
                                                 size="medium"
                                                 style="margin-left: 11%">
                                            <el-form-item
                                                    v-for="(form, index) in signForm"
                                                    :key="index">
                                                <el-col :span="4" :offset="1">
                                                    <el-tooltip effect="dark" content="报名项名称"
                                                                placement="top-start">
                                                        <el-input v-model="form.formTitle"></el-input>
                                                    </el-tooltip>
                                                </el-col>
                                                <el-col :span="4" :offset="1">
                                                    <el-tooltip effect="dark" content="报名项名称（英文）"
                                                                placement="top-start">
                                                        <el-input v-model="form.formTitleEn"></el-input>
                                                    </el-tooltip>
                                                </el-col>
                                                <el-col :span="4" :offset="1">
                                                    <el-tooltip effect="dark" content="报名项类型"
                                                                placement="top-start">
                                                        <el-select v-model="form.formType" placeholder="请选择">
                                                            <el-option
                                                                    v-for="item in formType"
                                                                    :key="item.value"
                                                                    :label="item.label"
                                                                    :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </el-tooltip>
                                                </el-col>
                                                <el-col :span="4" :offset="1">
                                                    <el-button type="danger" @click.prevent="removeSignForm(form)"
                                                               icon="el-icon-close" plain></el-button>
                                                </el-col>
                                            </el-form-item>
                                            <el-form-item v-if="signForm.length < 1">
                                                <el-col :span="14" :offset="5">
                                                    <el-alert
                                                            title="未填写所需的报名项"
                                                            description="请点击‘+’按钮增加报名项"
                                                            type="error"
                                                            :closable="false"
                                                            show-icon>
                                                    </el-alert>
                                                </el-col>
                                            </el-form-item>
                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-tooltip effect="dark" content="增加报名项"
                                                placement="top-start">
                                        <el-button plain type="primary" @click="addSignForm(form)"
                                                   icon="el-icon-plus" size="small"></el-button>
                                    </el-tooltip>
                                    <el-divider direction="vertical"></el-divider>
                                    <el-button
                                            style="display: inline-block"
                                            type="primary"
                                            plain
                                            @click="forward"
                                            size="small">上一步
                                    </el-button>
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

                        <el-tab-pane name="3">
                            <span slot="label"><i class="el-icon-tickets"></i> 报名人员</span>
                            <el-container>
                                <el-header>

                                </el-header>
                                <el-main>
                                    <el-table
                                            size="small"
                                            :data="signs.slice((currentPage-1)*pagesize,currentPage*pagesize)">
                                        <el-table-column
                                                label="微信昵称">
                                            <template slot-scope="scope">
                                                <img class="sign-avatar" :src="scope.row.belongs_to_user.icon">
                                                <span class="mainItem">@{{ scope.row.belongs_to_user.name }}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="报名时间">
                                            <template slot-scope="scope">
                                                <i style="color: #409EFF" class="el-icon-time"></i>
                                                <span>@{{ scope.row.created_at }}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="电话">
                                            <template slot-scope="scope">
                                                <i style="color: #409EFF" class="el-icon-mobile-phone"></i>
                                                <span>@{{ scope.row.phone }}</span>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                </el-main>
                                <el-pagination
                                        layout="total,prev, pager, next"
                                        :total="signTotal"
                                        background
                                        @current-change="current_change">
                                </el-pagination>
                            </el-container>
                        </el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>
        </template>
        <form name="submitForm"
              action="{{ isset($activity) && $activity ? route('admin.activity.update', ['id' => $activity->ids]) :  route('admin.activity.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($activity) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="name">
            <input type="text" name="start_time">
            <input type="text" name="end_time">
            <input type="text" name="sign_up_end_time">
            <input type="text" name="price">
            <input type="text" name="address">
            <input type="text" name="province">
            <input type="text" name="city">
            <input type="text" name="pic">
            <input type="text" name="forms">
            <input type="text" name="detail_rich_text">
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

        .avatar-uploader .el-upload {
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 178px;
            height: 178px;
        }

        .avatar-uploader .el-upload:hover {
            border-color: #409EFF;
        }

        .avatar-uploader-icon {
            font-size: 28px;
            color: #8c939d;
            width: 178px;
            height: 178px;
            line-height: 178px;
            text-align: center;
        }

        .avatar {
            width: 178px;
            height: 178px;
            display: block;
        }

        .sign-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 10px;
        }

        .el-date-editor--datetimerange.el-input__inner {
            width: 80%;
        }

    </style>
    <script>
        let activityEdit = new Vue({
            el: '#activityEdit',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                form: {!! isset($activity)? $activity:'{}' !!},
                loading: true,
                btnLoading: false,
                previewQrCodeList: [''],
                provinces: {!! $provinces !!},
                signs: {!! $signs !!},
                pic: '',
                active: '0',
                activity_ue: '',
                config: {
                    initialFrameHeight: 400,
                },
                signForm: [],
                formType: [
                    {value: 'text', label: '文本'},
                    {value: 'number', label: '数值'},
                    {value: 'email', label: '邮箱'}
                ],
                currentPage: 1,
                signTotal: 0,
                pagesize: 10,
            },
            compute: {
                //
            },
            methods: {
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //获取富文本编辑器内容
                getUEContent() {
                    return this.editor.getContent();
                },
                //下一步
                next() {
                    this.active = parseInt(this.active) + 1 + '';
                    if (parseInt(this.active) > 2) this.active = '0';
                },
                //上一步
                forward() {
                    this.active = parseInt(this.active) - 1 + '';
                    if (parseInt(this.active) < 0) this.active = '0';
                },
                // 上传封面回调
                upLoadCoverPic(res, file) {
                    this.pic = res.result;
                },
                //删除报名项
                removeSignForm(item) {
                    let index = this.signForm.indexOf(item);
                    if (index !== -1) {
                        this.signForm.splice(index, 1)
                    }
                },
                //增加报名项
                addSignForm() {
                    this.signForm.push({
                        formTitle: '',
                        formTitleEn: '',
                        formType: '',
                    });
                },
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    $('input[name^=name]').val(this.form.name);
                    $('input[name^=start_time]').val(this.form.start_time);
                    $('input[name^=end_time]').val(this.form.end_time);
                    $('input[name^=sign_up_end_time]').val(this.form.sign_up_end_time);
                    $('input[name^=address]').val(this.form.address);
                    $('input[name^=price]').val(this.form.price);
                    $('input[name^=city]').val(this.form.city_code);
                    $('input[name^=pic]').val(this.pic);
                    $('input[name^=forms]').val(JSON.stringify(this.signForm));
                    $('input[name^=detail_rich_text]').val(this.getUEContent());
                    document.forms['submitForm'].submit();
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
                this.pic = this.form.pic;

                //实例化富文本编辑器
                const _this = this;
                _this.editor = UE.getEditor('activity_ueditor', _this.config);
                this.editor.addListener("ready", function () {
                    _this.editor.setContent('{!! isset($activity->detail_rich_text) ? $activity->detail_rich_text : '输入活动内容...' !!}');
                    _this.editor.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                });

                //获取报名表单
                this.signForm = this.form.ids ? JSON.parse(this.form.form_field) : [];

                this.signTotal = this.signs.length;

            },
            destroy: function () {
                this.editor.destroy();
            }
        });
    </script>
@endsection