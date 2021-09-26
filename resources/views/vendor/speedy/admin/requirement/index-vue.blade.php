@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="requirementIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>
                            <div class="search-input">
                                <el-button
                                        size="medium"
                                        type="primary"
                                        style="margin-right: 20px;"
                                        @click="handleCreate">
                                    创建
                                    <i class="el-icon-upload el-icon--right"></i></el-button>
                            </div>
                        </el-header>
                        <el-main>
                            <el-table
                                    {{--表格边框属性--}}
                                    {{--border--}}
                                    {{-- 高度 --}}
                                    {{--:stripe="true"--}}
                                    size="small"
                                    {{--分页--}}
                                    :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)">

                                {{--展开菜单部分--}}
                                <el-table-column type="expand">
                                    <template slot-scope="props">
                                        <el-form
                                                label-position="left"
                                                class="table-expand"
                                                style="background-color: rgba(237,242,252,0.4);padding: 10px;">
                                            <el-form-item label="联系人">
                                                <el-tag type="primary">@{{ props.row.contact }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="电话">
                                                <el-tag type="primary">@{{ props.row.phone }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="邮箱">
                                                <el-tag type="primary">@{{ props.row.email }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="需求项目描述">
                                                <el-row :gutter="0">
                                                    <el-col :span="20"><span v-if="props.row.detail"
                                                                             style="white-space: pre-wrap">@{{ props
                                                            .row.detail }}</span>
                                                        <span v-else
                                                              style="white-space: pre-wrap">无</span>
                                                    </el-col>
                                                </el-row>
                                            </el-form-item>
                                            <el-form-item label="其他要求">
                                                <el-row :gutter="0">
                                                    <el-col :span="20">
                                                        <span v-if="props.row.more" style="white-space: pre-wrap">@{{ props.row.more}}</span>
                                                        <span v-else
                                                              style="white-space: pre-wrap">无</span>
                                                    </el-col>
                                                </el-row>
                                            </el-form-item>
                                            <el-form-item label="提交时间">
                                                <el-tag type="info">@{{ props.row.created_at }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="更新时间">
                                                <el-tag type="info">@{{ props.row.updated_at }}</el-tag>
                                            </el-form-item>
                                        </el-form>
                                    </template>
                                </el-table-column>

                                {{--列表项目--}}
                                <el-table-column
                                        prop="company_name"
                                        align="left"
                                        label="企业"
                                        width="250">
                                </el-table-column>

                                <el-table-column
                                        label="自主投入经费"
                                        prop="budget"
                                        width="250">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.budget" type="primary">@{{ scope.row.budget }}</el-tag>
                                        <el-tag v-else type="info">无</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="行业"
                                        width="150">
                                    <template slot-scope="scope">
                                        <el-tag type="primary">@{{ scope.row.industry }}</el-tag>
                                    </template>
                                </el-table-column>

                                {{--<el-table-column--}}
                                        {{--label="性质"--}}
                                        {{--width="150">--}}
                                    {{--<template slot-scope="scope">--}}
                                        {{--<el-tag v-if="scope.row.property" type="primary">@{{ scope.row.property }}--}}
                                        {{--</el-tag>--}}
                                        {{--<el-tag v-else type="info">无</el-tag>--}}
                                    {{--</template>--}}
                                {{--</el-table-column>--}}

                                <el-table-column label="引进成果">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.introduce == '1'" type="success">是</el-tag>
                                        <el-tag v-else-if="scope.row.introduce == '0'" type="danger">否</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="合作开发">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.cooperate == '1'" type="success">是</el-tag>
                                        <el-tag v-else-if="scope.row.cooperate == '0'" type="danger">否</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="委托开发">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.entrust == '1'" type="success">是</el-tag>
                                        <el-tag v-else-if="scope.row.entrust == '0'" type="danger">否</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                type="primary"
                                                circle
                                                @click="handleEdit(scope.$index, scope.row)" icon="el-icon-edit">
                                        </el-button>
                                        <el-button
                                                size="mini"
                                                type="danger"
                                                circle
                                                @click="handleDelete(scope.$index, scope.row)" icon="el-icon-delete">
                                        </el-button>
                                    </template>
                                </el-table-column>

                            </el-table>
                        </el-main>
                        <el-footer>
                            {{--分页--}}
                            <el-pagination
                                    layout="total,prev, pager, next"
                                    :total="total"
                                    background
                                    @current-change="current_change">
                            </el-pagination>
                        </el-footer>
                    </el-container>
                </el-col>
            </el-row>
        </template>
    </div>

    <style>
        .el-header {
            background-color: rgb(247, 247, 247);
            color: #333;
            text-align: left;
            line-height: 60px;
        }

        .table-expand {
            font-size: 0;
        }

        .table-expand label {
            width: 90px;
            color: #99a9bf;
        }

        .table-expand .el-form-item {
            margin-right: 0;
            margin-bottom: 0;
        }
    </style>

    <script>
        let requirementIndex = new Vue({
            el: '#requirementIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $requirements !!},
            },
            compute: {
                //
            },
            methods: {
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.requirement.index')}}' + '/' + row.id + '/edit';
                },
                //创建按钮
                handleCreate() {
                    this.loading = true;
                    window.location.href = '{{ route('admin.requirement.create') }}';
                },
                //删除按钮
                handleDelete(index, row) {
                    this.$confirm('此操作将永久删除该内容, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning',
                        center: true
                    }).then(() => {
                        this.loading = true;
                        document.getElementById('delete-form').action = '{{ route('admin.requirement.index') . "/" }}' + row.id;
                        document.getElementById('delete-form').submit();
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消删除'
                        });
                    });
                },
            },
            created: function () {
                this.total = this.tableData.length;
            },
            mounted: function () {
                this.loading = false;
            },
        });
    </script>
@endsection