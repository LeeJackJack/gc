@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="likeProjectIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>
                            {{----}}
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
                                            <el-form-item label="微信">
                                                <el-tag type="success">@{{ props.row.belongs_to_user.name }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="联系方式">
                                                <el-tag type="success">@{{ props.row.belongs_to_user.phone }}</el-tag>
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
                                        align="left"
                                        label="姓名"
                                        prop="name">
                                </el-table-column>

                                <el-table-column
                                        label="企业">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-s-custom"></i>--}}
                                        <span>@{{ scope.row.company }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="职位">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-s-custom"></i>--}}
                                        <span>@{{ scope.row.job }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="感兴趣项目">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-s-custom"></i>--}}
                                        <span>@{{ scope.row.belongs_to_project.title }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column label="联系">
                                    <template slot-scope="scope">
                                        <form id="contact_form" method="post" v-if="scope.row.is_handle == '0'">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <el-button
                                                    size="mini"
                                                    type="danger"
                                                    plain
                                                    icon="el-icon-phone-outline"
                                                    @click="handleEdit(scope.$index, scope.row)">未联系
                                            </el-button>
                                        </form>
                                        <el-button
                                                v-else
                                                size="mini"
                                                type="success"
                                                plain
                                                icon="el-icon-phone-outline"
                                                :disabled="true">已联系
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

        .mainItem
        {
            font-size: 14px;
            font-weight: 600;
        }
    </style>

    <script>
        let likeProjectIndex = new Vue({
            el: '#likeProjectIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $likes !!},
            },
            compute: {
                //
            },
            methods: {
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //联系按钮
                handleEdit:function (index,row) {
                    document.getElementById('contact_form').action = '{{ route('admin.like_project.index') . "/" }}' + row.id;
                    document.getElementById('contact_form').submit();
                }
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