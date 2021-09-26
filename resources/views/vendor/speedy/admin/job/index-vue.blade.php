@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="jobIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header style="height: auto;">
                            <div class="search-input">
                                <el-button
                                        size="medium"
                                        type="primary"
                                        style="margin-right: 20px;"
                                        @click="handleCreate">
                                    创建
                                    <i class="el-icon-upload el-icon--right"></i></el-button>
                                <el-divider direction="vertical"></el-divider>
                                <form id="search_form" action="{{route('admin.job.index')}}" style="display: inline-block;">
                                    <el-input
                                            size="medium"
                                            style="margin-left: 20px;"
                                            name="job_name"
                                            placeholder="请输入职位或企业名称..."
                                            v-model="searchName">
                                    </el-input>
                                    <el-button size="medium" type="primary" @click="handleSearch"
                                               style="margin-right: 20px;">搜索<i
                                                class="el-icon-search el-icon--right"></i></el-button>
                                </form>
                                <el-divider direction="vertical"></el-divider>
                                <form id="refresh_form" action="{{route('admin.job.index')}}" style="display: inline-block;">
                                    <input id="refresh_job_order_id" class="form-control"
                                           name="refresh_job_order_id"
                                           value="true" type="hidden">
                                    <el-button size="medium" type="primary" @click="handleRefresh"
                                               style="margin-left: 20px;">刷新职位排序<i
                                                class="el-icon-refresh-right el-icon--right"></i></el-button>
                                </form>
                            </div>

                            <div class="topWrapper">
                                <div style="font-weight: 600">数据下载</div>
                                <div class="downloadWrapper">
                                    <el-date-picker
                                            v-model="timeLimit"
                                            type="datetimerange"
                                            range-separator="至"
                                            start-placeholder="开始日期"
                                            end-placeholder="结束日期">
                                    </el-date-picker>
                                    <el-button
                                            style="margin-left: 30px"
                                            type="primary"
                                            @click="downloadData">导出
                                        <i class="el-icon-download el-icon--right"></i>
                                    </el-button>
                                </div>
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
                                    :data="tableData">
                                {{--:data="tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))--}}
                                {{--.slice((currentPage-1)*pagesize,currentPage*pagesize)">--}}
                                {{--展开菜单部分--}}
                                <el-table-column type="expand">
                                    <template slot-scope="props">
                                        <el-form
                                                label-position="left"
                                                inline
                                                class="table-expand"
                                                style="background-color: rgba(237,242,252,0.4);padding: 10px;">
                                            {{--<el-form-item label="推荐奖金">--}}
                                            {{--<el-tag v-if="props.row.reward > 0">@{{ props.row.reward}}--}}
                                            {{--</el-tag>--}}
                                            {{--<el-tag v-else type="info">无</el-tag>--}}
                                            {{--</el-form-item>--}}
                                            <el-form-item label="薪资">
                                                <el-tag type="warning" v-if="props.row.salary">@{{ props.row.salary}}
                                                </el-tag>
                                                <el-tag v-else type="info">无</el-tag>
                                            </el-form-item>
                                            <el-form-item label="平台审批">
                                                <el-tag v-if="props.row.sp_jg == '1'" type="success">通过</el-tag>
                                                <el-tag v-else-if="props.row.sp_jg == '0'" type="danger">拒绝</el-tag>
                                                <el-tag v-else-if="props.row.sp_jg == null" type="info">未审批</el-tag>
                                            </el-form-item>
                                            <el-form-item label="专业要求">
                                                <el-tag type="info">
                                                    @{{ props.row.type}}
                                                </el-tag>
                                            </el-form-item>
                                            <el-form-item label="创建时间">
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
                                        prop="title"
                                        align="left"
                                        label="职位名"
                                        width="450">
                                    <template slot-scope="scope">
                                        <span class="mainItem">@{{ scope.row.title }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="企业">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-office-building"></i>--}}
                                        <span>@{{ scope.row.belongs_to_company.name }}</span>
                                    </template>
                                </el-table-column>

                                {{--<el-table-column--}}
                                {{--sortable--}}
                                {{--label="薪资"--}}
                                {{--prop="salary"--}}
                                {{--width="250">--}}
                                {{--<template slot-scope="scope">--}}
                                {{--<el-tag type="primary">@{{ scope.row.salary }}</el-tag>--}}
                                {{--</template>--}}
                                {{--</el-table-column>--}}

                                <el-table-column
                                        label="行业">
                                    <template slot-scope="scope">
                                        <el-tag type="primary">@{{ scope.row.belongs_to_industry.label }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        sortable
                                        label="招聘人数"
                                        prop="hire_count">
                                    <template slot-scope="scope">
                                        <el-tag type="danger">@{{ scope.row.hire_count }}</el-tag>
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
            height: auto;
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
        .mainItem
        {
            font-size: 14px;
            font-weight: 600;
        }

        .topWrapper{
            height: auto;
            border: 1px solid #ededed;
            padding: 30px;
            margin: 10px auto;
            background-color: white;
            border-radius: 5px;
        }

        .downloadWrapper
        {
            margin: 20px auto;
            display: flex;
            justify-items: center;
        }
    </style>

    <script>
        let jobIndex = new Vue({
            el: '#jobIndex',
            data: {
                searchName: '{{$job_name}}',
                loading: true,
                total: {!! $total !!},
                currentPage: '{!! $page !!}',
                pagesize: 10,
                tableData: [],
                timeLimit:[new Date(2020, 1, 1, 0, 0), new Date(2020, 1, 1, 0,0)],
            },
            compute: {
                //
            },
            methods: {
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                    window.location.href = '{{route('admin.job.index')}}' + '?' + 'job_name=' + this.searchName + '&'
                        + 'page=' + currentPage;
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.job.index')}}' + '/' + row.ids +
                        '/edit' + '?searchName=' + this.searchName;
                },
                //创建按钮
                handleCreate() {
                    this.loading = true;
                    window.location.href = '{{ route('admin.job.create') }}';
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
                        document.getElementById('delete-form').action = '{{ route('admin.job.index') . "/" }}' + row.ids;
                        document.getElementById('delete-form').submit();
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消删除'
                        });
                    });
                },
                //搜索按钮
                handleSearch: function () {
                    document.getElementById('search_form').submit();
                },
                //刷新职位排序按钮
                handleRefresh: function () {
                    document.getElementById('refresh_form').submit();
                },
                downloadData()
                {
                    let start =this.timeLimit[0].getFullYear() + '-' + (this.timeLimit[0].getMonth()+1) + '-' + this
                        .timeLimit[0].getDate() + ' ' + this
                        .timeLimit[0].toTimeString().substring(0,8);
                    let end = this.timeLimit[1].getFullYear() + '-' + (this.timeLimit[1].getMonth()+1) + '-' + this
                        .timeLimit[1].getDate() + ' ' + this
                        .timeLimit[1].toTimeString().substring(0,8);

                    {{--window.location.href =("{{ route('admin.recommend.download')}}" + '?' + 'start=' + start +--}}
                    {{--'&end=' +end);--}}
                    window.open('{{ route('admin.job.download')}}' + '?' + 'start=' + start + '&end=' +end,
                        '_blank');
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
                let jobs = {!! $jobs !!};
                for(var i in jobs){
                    this.tableData.push(jobs[i]);
                }
            },
        });
    </script>
@endsection