@extends('vendor.speedy.layouts.app')

@section('content')
    <div id="studentEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="22" :offset="1">
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-edit"></i> 个人信息</span>
                            <el-container>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="form" :model="form" label-width="170px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="姓名"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '博士姓名' },]">
                                                <el-input v-model="form.name" class="el-input"
                                                          placeholder="请输入博士姓名..."
                                                ></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="城市"
                                                    prop="city_code"
                                                    :rules="[{ required: true, message: '如：广州市...' },]">
                                                <el-cascader
                                                        :options="provinces"
                                                        :props="{ children: 'city','value':'code','label':'label','emitPath':false }"
                                                        v-model="form.city_code">
                                                </el-cascader>
                                            </el-form-item>

                                            <el-form-item label="性别">
                                                <el-select
                                                        v-model="form.gender"
                                                        placeholder="性别"
                                                        clearable>
                                                    <el-option
                                                            key="0"
                                                            label="男"
                                                            value="0">
                                                    </el-option>
                                                    <el-option
                                                            key="1"
                                                            label="女"
                                                            value="1">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                            <el-form-item
                                                    label="录取前所在单位"
                                                    prop="fore_institution">
                                                <el-input v-model="form.fore_institution" class="el-input"
                                                          placeholder=""
                                                ></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="在读院校/科研机构"
                                                    prop="now_institution">
                                                <el-input v-model="form.now_institution" class="el-input"
                                                          placeholder=""
                                                ></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="录入院系"
                                                    prop="department">
                                                <el-input v-model="form.department" class="el-input"
                                                          placeholder=""
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="专业"
                                                    prop="major">
                                                <el-input v-model="form.major" class="el-input"
                                                          placeholder=""
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="录取时间"
                                                    prop="enter_time">
                                                <el-input v-model="form.enter_time" class="el-input"
                                                          placeholder=""
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="学制"
                                                    prop="educational_system">
                                                <el-input v-model="form.educational_system" class="el-input"
                                                          placeholder=""
                                                ></el-input>
                                            </el-form-item>
                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            type="primary"
                                            @click="nextPage"
                                            :loading="btnLoading"
                                            size="small">下一页
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>
                        <el-tab-pane name="1">
                            <span slot="label"><i class="el-icon-share"></i>联系人信息</span>
                            <el-container>
                                <el-main>
                                    <el-col :span="20" :offset="2" style="text-align: center">
                                        <el-form ref="form" :model="form" label-width="170px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                        <el-form-item
                                                label="所在院系联系人"
                                                prop="department_contact">
                                            <el-input v-model="form.department_contact" class="el-input"
                                                      placeholder=""
                                            ></el-input>
                                        </el-form-item>

                                        <el-form-item
                                                label="所在院系联系人职务"
                                                prop="department_contact_position">
                                            <el-input v-model="form.department_contact_position" class="el-input"
                                                      placeholder=""
                                            ></el-input>
                                        </el-form-item>

                                        <el-form-item
                                                label="所在院系联系电话"
                                                prop="department_contact_phone">
                                            <el-input v-model="form.department_contact_phone" class="el-input"
                                                      placeholder=""
                                            ></el-input>
                                        </el-form-item>

                                        <el-form-item
                                                label="所在院系Email"
                                                prop="department_contact_email">
                                            <el-input v-model="form.department_contact_email" class="el-input"
                                                      placeholder=""
                                            ></el-input>
                                        </el-form-item>

                                        <el-form-item
                                                label="所在院系链接"
                                                prop="department_contact_link">
                                            <el-input v-model="form.department_contact_link" class="el-input"
                                                      placeholder=""
                                            ></el-input>
                                        </el-form-item>

                                        <el-form-item
                                                label="备注"
                                                prop="remark">
                                            <el-input v-model="form.remark" class="el-input"
                                                      placeholder=""
                                            ></el-input>
                                        </el-form-item>

                                        <el-form-item
                                                label="信息来源"
                                                prop="information_from">
                                            <el-input v-model="form.information_from" class="el-input"
                                                      placeholder=""
                                            ></el-input>
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
                    </el-tabs>
                </el-col>
            </el-row>
        </template>
    </div>
    <style>
        .el-table .cell.el-tooltip {
            white-space: pre-wrap;
        }
    </style>
    <script>
        let studentEdit = new Vue({
            el: '#studentEdit',
            data: {
                form: {!! isset($student)? $student:'{}' !!},
                provinces: {!! $provinces !!},
                loading: true,
                btnLoading: false,
                active:'0',
            },
            compute: {
                //
            },
            methods: {
                nextPage()
                {
                    this.active = '1';
                },
                //提交资料
                onSubmit() {
                    let __this = this;
                    __this.loading = true;
                    __this.btnLoading = true;
                    __this.$refs['form'].validate((valid) => {
                        if (valid) {
                            axios.get("/api/editPhd", {
                                params: {
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
        });
    </script>
@endsection