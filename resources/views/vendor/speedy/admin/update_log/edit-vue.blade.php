@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="updateLogEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card">
                        <el-tab-pane>
                            <span v-if="form.id" slot="label"><i class="el-icon-edit"></i> 修改</span>
                            <span v-else slot="label"><i class="el-icon-plus"></i> 创建</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在创建更新日志，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="16" :offset="4">
                                        <el-form ref="form" :model="form" label-width="120px" label-position="left"
                                                 action="{{ route('admin.update_log.store') }}"
                                                 method="post"
                                                 name="submitForm"
                                                 size="medium">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}
                                            <el-form-item
                                                    label="作者"
                                                    prop="author"
                                                    :rules="[{ required: true, message: '请输入作者' },]">
                                                <el-input v-model="form.author" class="el-input"
                                                          name="author"
                                                          placeholder="请输入作者..."></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="更新内容"
                                                    prop="content">
                                                <el-input
                                                        name="content"
                                                        type="textarea" :rows="8" v-model="form.content"
                                                        class="el-input"
                                                        placeholder="请输入更新内容..."></el-input>
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
        {{----}}
    </style>
    <script>
        let updateLogEdit = new Vue({
            el: '#updateLogEdit',
            data: {
                form: {},
                loading: true,
                btnLoading: false,
            },
            compute: {
                //
            },
            methods: {
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    //$('input[name^=author]').val(this.form.author);
                    //$('input[name^=content]').val(this.form.content);
                    document.forms['submitForm'].submit();
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
                //console.log(this.form);
            },
        });
    </script>
@endsection