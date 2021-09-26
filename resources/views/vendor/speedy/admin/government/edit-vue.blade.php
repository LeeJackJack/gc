@extends('vendor.speedy.layouts.app')

@section('content')
    <div id="governmentEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-reading"></i> 基本信息</span>
                            <el-container>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="form" :model="form" label-width="170px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="姓名"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入姓名...' },]">
                                                <el-input v-model="form.name" class="el-input" style="width: 220px;"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="性别"
                                                    prop="gender">
                                                <el-select
                                                        v-model="form.gender"
                                                        placeholder="请选择性别"
                                                        clearable>
                                                    <el-option
                                                            label="男"
                                                            value="男">
                                                    </el-option>
                                                    <el-option
                                                            label="女"
                                                            value="女">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                            <el-form-item
                                                    label="政府单位"
                                                    prop="governmentName">
                                                <el-input v-model="form.governmentName" class="el-input"
                                                          placeholder="如：广州市人社局"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="区域级别"
                                                    prop="region">
                                                <el-select
                                                        v-model="form.region"
                                                        placeholder="请选择"
                                                        clearable>
                                                    <el-option
                                                            label="省级"
                                                            value="省级">
                                                    </el-option>
                                                    <el-option
                                                            label="市级"
                                                            value="市级">
                                                    </el-option>
                                                    <el-option
                                                            label="区级"
                                                            value="区级">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                            <el-form-item
                                                    label="部门"
                                                    prop="office">
                                                <el-input v-model="form.office" class="el-input" placeholder="如：人才科"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="职位"
                                                    prop="post">
                                                <el-input v-model="form.post" class="el-input"
                                                          style="width: 220px;" placeholder="如：处长"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="座机"
                                                    prop="phone">
                                                <el-input v-model="form.phone" class="el-input"
                                                          style="width: 220px;" placeholder="如：020-33388882"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="手机"
                                                    prop="cellPhone">
                                                <el-input v-model="form.cellPhone" class="el-input" style="width: 220px;"
                                                          placeholder="如：135xxxxxxxx"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="邮箱"
                                                    prop="email">
                                                <el-input v-model="form.email" class="el-input" style="width: 220px;"
                                                          placeholder="如：xxx@xxx.com"></el-input>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                    type="primary"
                                    @click="onSubmit"
                                    :loading="btnLoading"
                                    size="small">提交
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        {{--<el-tab-pane name="1">--}}
                            {{--<span slot="label"><i class="el-icon-data-analysis"></i> 职位介绍</span>--}}
                            {{--<el-container>--}}
                                {{--<el-header>--}}
                                    {{--<el-alert--}}
                                            {{--title="您正在编辑职位内容，请填写下列表单内容"--}}
                                            {{--type="info"--}}
                                            {{--center--}}
                                            {{--show-icon--}}
                                            {{--:closable="false">--}}
                                    {{--</el-alert>--}}
                                {{--</el-header>--}}
                                {{--<el-main>--}}
                                    {{--富文本编辑器--}}
                                    {{--<script id="job_ueditor" name="detail_rich_text" type="text/plain"></script>--}}
                                {{--</el-main>--}}
                                {{--<el-footer style="text-align: right;">--}}
                                    {{--<el-button--}}
                                            {{--style="display: inline-block"--}}
                                            {{--plain--}}
                                            {{--type="primary"--}}
                                            {{--@click="forward"--}}
                                            {{--size="small">上一步--}}
                                    {{--</el-button>--}}
                                    {{--<el-button--}}
                                            {{--style="display: inline-block"--}}
                                            {{--type="primary"--}}
                                            {{--@click="onSubmit"--}}
                                            {{--:loading="btnLoading"--}}
                                            {{--size="small">提交--}}
                                    {{--</el-button>--}}
                                {{--</el-footer>--}}
                            {{--</el-container>--}}
                        {{--</el-tab-pane>--}}

                    </el-tabs>
                </el-col>
            </el-row>
        </template>
    </div>
    <style>
        .el-header {
            height: 80px;
        }

        .el-footer {
            background-color: white;
            line-height: 60px;
        }

    </style>
    <script>
        let governmentEdit = new Vue({
            el: '#governmentEdit',
            data: {
                form: {!! isset($government) ? $government : '{}' !!},
                loading: true,
                btnLoading: false,
                active: '0',
                id:'{{ isset($id) ? $id : '' }}',
            },
            compute: {
                //
            },
            methods: {
                //下一步
                next() {
                    this.active = parseInt(this.active) + 1 + '';
                    if (parseInt(this.active) > 1) this.active = '0';
                },
                //上一步
                forward() {
                    this.active = parseInt(this.active) - 1 + '';
                    if (parseInt(this.active) < 0) this.active = '0';
                },
                //提交资料
                onSubmit() {
                    // console.log(this.form);
                    let __this = this;
                    __this.loading = true;
                    __this.btnLoading = true;
                    __this.$refs['form'].validate((valid) => {
                        if (valid) {
                            axios.get("/api/editGovernment", {
                                params: {
                                    id: __this.id,
                                    form: __this.form,
                                },
                            }).then(res => {
                                // console.log(res);
                                let response = res.data;
                                __this.$notify({
                                    title: response.result,
                                    message: response.msg,
                                    type: response.result
                                });
                                __this.loading = false;
                                __this.btnLoading = false;
                            }).catch(function (err) {
                                //console.log(err);
                            });
                        } else {
                            __this.$message({
                                message: '请完善带*必填项',
                                type: 'error'
                            });
                            __this.loading = false;
                            __this.btnLoading = false;
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
            destroy: function () {
                //
            }
        });
    </script>
@endsection