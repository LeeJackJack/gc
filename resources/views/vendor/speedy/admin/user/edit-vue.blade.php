@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="userEdit">
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
                                            title="您正在编辑管理员信息，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="16" :offset="4">
                                        <el-form ref="form" :model="form" label-width="120px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="账号"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入账号' },]">
                                                <el-input v-model="form.name" class="el-input"></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="邮箱"
                                                    prop="email">
                                                <el-input v-model="form.email" class="el-input"></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="密码"
                                                    prop="password"
                                                    :rules="[{ required: true, message: '请输入密码' },]">
                                                <el-input v-model="form.password" class="el-input"
                                                          show-password></el-input>
                                            </el-form-item>
                                            <el-form-item label="权限" prop="role_id" :rules="[{ required: true, message: '请选择权限' },]">
                                                <el-select
                                                        value-key="id"
                                                        v-model="form.role_id"
                                                        placeholder="请选择权限"
                                                        class="el-input"
                                                        clearable>
                                                    <el-option
                                                            v-for="item in roles"
                                                            :key="item.id"
                                                            :label="item.display_name"
                                                            :value="item.id">
                                                    </el-option>
                                                </el-select>
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
        <form name="submitForm"
              action="{{ isset($user) && $user ? route('admin.user.update', ['id' => $user->id]) :  route('admin.user.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($user) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="name">
            <input type="text" name="email">
            <input type="password" name="password">
            <input type="text" name="role_id">
        </form>
    </div>
    <style>
        {{----}}
    </style>
    <script>
        let userEdit = new Vue({
            el: '#userEdit',
            data: {
                form: {!! isset($user)? $user:'{}' !!},
                roles: {!! $roles !!},
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
                    $('input[name^=name]').val(this.form.name);
                    $('input[name^=email]').val(this.form.email);
                    $('input[name^=password]').val(this.form.password);
                    $('input[name^=role_id]').val(this.form.role_id);
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