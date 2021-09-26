@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="roleEdit">
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
                                            title="您正在编辑权限信息，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="form" :model="form" label-width="120px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="角色"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入角色' },]">
                                                <el-input v-model="form.name" class="el-input"></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                    label="角色名称"
                                                    prop="display_name"
                                                    :rules="[{ required: true, message: '请输入角色名称' },]">
                                                <el-input v-model="form.display_name" class="el-input"></el-input>
                                            </el-form-item>
                                            <el-form-item label="使用权限">
                                                <el-checkbox-group size="mini" v-model="hasPermissions" @change="handleCheckedRolesChange">
                                                    <el-checkbox v-for="permission in permissions" :label="permission.id"
                                                                 :key="permission.id">@{{permission.display_name}}
                                                    </el-checkbox>
                                                </el-checkbox-group>
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
              action="{{ isset($role) && $role ? route('admin.role.update', ['id' => $role->id]) :  route('admin.role.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($role) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="name">
            <input type="text" name="display_name">
            <input type="text" name="permission_id">
        </form>
    </div>
    <style>
        {{----}}
    </style>
    <script>
        let roleEdit = new Vue({
            el: '#roleEdit',
            data: {
                form: {!! isset($role)? $role:'{}' !!},
                permissions: {!! $permissions !!},
                hasPermissions: JSON.parse('{{ isset($role) ?  $role->permissions->pluck('id') : '[]' }}'),
                permission_id: [],
                loading: true,
                btnLoading: false,
            },
            compute: {
                //
            },
            methods: {
                //权限多选框
                handleCheckedRolesChange(value) {
                    this.permission_id = value;
                },
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    $('input[name^=name]').val(this.form.name);
                    $('input[name^=display_name]').val(this.form.display_name);
                    $('input[name^=permission_id]').val(this.permission_id);
                    document.forms['submitForm'].submit();
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