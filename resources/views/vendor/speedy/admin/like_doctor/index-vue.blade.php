@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="likeDoctorIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>

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

                                <el-table-column type="expand">
                                    <template slot-scope="props">
                                        <el-form
                                                label-position="left"
                                                inline
                                                class="table-expand"
                                                style="background-color: rgba(237,242,252,0.4);padding: 10px;">
                                            <el-form-item label="感兴趣博士姓名">
                                                <el-tag type="info">@{{ props.row.belongs_to_doctor.name}}
                                                </el-tag>
                                            </el-form-item>
                                            <el-form-item label="博士联系方式">
                                                <el-tag v-if="props.row.belongs_to_doctor.phone" type="success">@{{ props.row.belongs_to_doctor .phone}}</el-tag>
                                                <el-tag v-else type="info">无</el-tag>
                                            </el-form-item>
                                            <el-form-item label="博士联系邮箱">
                                                <el-tag v-if="props.row.belongs_to_doctor.email" type="success">@{{
                                                    props.row.belongs_to_doctor.email}}</el-tag>
                                                <el-tag v-else type="info">无</el-tag>
                                            </el-form-item>
                                            <el-form-item label="博士毕业学校">
                                                <el-tag type="info">@{{ props.row.belongs_to_doctor.school}}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="博士专业">
                                                <el-tag type="info">@{{ props.row.belongs_to_doctor.major}}</el-tag>
                                            </el-form-item>
                                        </el-form>
                                    </template>
                                </el-table-column>

                                {{--列表项目--}}
                                <el-table-column
                                        align="left"
                                        label="姓名">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-s-flag"></i>
                                        <span>@{{ scope.row.name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        align="left"
                                        label="单位">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-s-flag"></i>
                                        <span>@{{ scope.row.company }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="联系电话">
                                    <template slot-scope="scope">
                                        <el-tag type="success">@{{ scope.row.phone }}</el-tag>
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
                            </el-table>
                        </el-main>
                        <el-footer>
                            {{--分页--}}
                            <el-pagination
                                    layout="total,prev, pager, next"
                                    :total="total"
                                    background
                                    :current-page = "parseInt(currentPage)"
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

        .table-expand {
            font-size: 0;
        }

        .table-expand label {
            width: 200px;
            color: #99a9bf;
        }

        .table-expand .el-form-item {
            margin-right: 0;
            margin-bottom: 0;
            height: 50px;
            line-height: 50px;
            width: 90%;
        }

        .search-input .el-input {
            vertical-align: top;
            margin: 0 10px 10px 0;
        }

        .search-input .el-input {
            width: 160px;
            position: relative;
            font-size: 13px;
        }
    </style>

    <script>
        let likeDoctorIndex = new Vue({
            el: '#likeDoctorIndex',
            data: {
                loading: true,
                total: 0,
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
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
                this.total = this.tableData.length;
                // console.log(this.tableData);
            },
        });
    </script>
@endsection