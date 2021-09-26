@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="projectIndex">
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
                                            <el-form-item label="联系方式">
                                                <el-tag type="primary">@{{ props.row.belongs_to_user.phone }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="项目描述">
                                                <el-row :gutter="0">
                                                    <el-col :span="20"><span style="white-space: pre-wrap">@{{ props.row.description }}</span>
                                                    </el-col>
                                                </el-row>
                                            </el-form-item>
                                            <el-form-item label="服务需求">
                                                <el-row :gutter="0">
                                                    <el-col :span="20"><span style="white-space: pre-wrap">@{{ props.row.requirement }}</span>
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
                                        align="left"
                                        label="课题"
                                        prop="title">
                                </el-table-column>

                                <el-table-column
                                        label="用户"
                                        width="150">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-s-custom"></i>
                                        <span>@{{ scope.row.belongs_to_user ? scope.row.belongs_to_user.name : ''
                                            }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="技术领域"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-tag type="primary">@{{ scope.row.industry_label }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="技术成熟度"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-tag type="primary">@{{ scope.row.maturity_label }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="合作方式"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-tag type="primary">@{{ scope.row.cooperation_label }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="浏览数"
                                        width="120">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-view"></i>
                                        <span>@{{ scope.row.view_count }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="感兴趣数"
                                        width="120">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-star-on"></i>
                                        <span>@{{ scope.row.like_count }}</span>
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
        let projectIndex = new Vue({
            el: '#projectIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $projects !!},
            },
            compute: {
                //
            },
            methods: {
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
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