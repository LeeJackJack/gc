@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="userIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>
                            <el-button v-if="nowUser.role_id == '1'"
                                       size="medium"
                                       type="primary"
                                       style="margin-right: 20px;"
                                       @click="handleCreate">创建
                                <i class="el-icon-upload el-icon--right"></i>
                            </el-button>
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

                                {{--列表项目--}}
                                <el-table-column
                                        align="left"
                                        label="账号">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-user"></i>
                                        <span class="mainItem">@{{ scope.row.name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="邮箱"
                                        prop="email">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-message"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.email }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="角色">
                                    <template slot-scope="scope">
                                        <el-tag type="success">@{{ scope.row.role.display_name }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="创建时间">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-date"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.created_at }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column label="更新时间">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-date"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.updated_at }}</span>
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
            <form id="delete-form" action="" method="POST" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </template>
    </div>

    <style>
        .el-header {
            background-color: rgb(247, 247, 247);
            color: #333;
            text-align: left;
            line-height: 60px;
        }
        .mainItem
        {
            font-size: 14px;
            font-weight: 600;
        }
    </style>

    <script>
        let userIndex = new Vue({
            el: '#userIndex',
            data: {
                search: '',
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $users !!},
                nowUser: {!! $nowUser !!},
            },
            compute: {
                //
            },
            methods: {
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //创建按钮
                handleCreate() {
                    this.loading = true;
                    window.location.href = '{{ route('admin.user.create') }}';
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.user.index')}}' + '/' + row.id + '/edit';
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
                        document.getElementById('delete-form').action = '{{ route('admin.user.index') . "/" }}' + row.id;
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