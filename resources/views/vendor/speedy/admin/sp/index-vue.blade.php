@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="spIndex">
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

                                {{--列表项目--}}
                                <el-table-column
                                        align="left"
                                        label="内容">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-s-flag"></i>--}}
                                        <span class="mainItem">@{{ scope.row.sp_title }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="类型"
                                        prop="from_kind"
                                        :filters="[{ text: '职位', value: '1' }, { text: '活动', value: '2' }]"
                                        :filter-method="typeFilterTag"
                                        filter-placement="bottom-end">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.from_kind == '1'" type="primary">职位</el-tag>
                                        <el-tag v-else type="warning">活动</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="创建时间">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-date"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.created_at }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column label="操作" width="400">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                type="info"
                                                plain
                                                @click="handleDetail(scope.$index, scope.row)" icon="el-icon-info">
                                            查看内容
                                        </el-button>
                                        <el-button
                                                size="mini"
                                                type="success"
                                                plain
                                                @click="handlePass(scope.$index, scope.row)" icon="el-icon-success">
                                            通过
                                        </el-button>
                                        <el-button
                                                size="mini"
                                                type="danger"
                                                plain
                                                @click="handleReject(scope.$index, scope.row)" icon="el-icon-error">
                                            拒绝
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
        let spIndex = new Vue({
            el: '#spIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $sps !!},
            },
            compute: {
                //
            },
            methods: {
                //类型筛选
                typeFilterTag(value, row) {
                    return row.from_kind === value;
                },
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //查看具体内容
                handleDetail(index,row)
                {
                    if (row.from_kind == '1')
                    {
                        this.loading = true;
                        window.location.href = '{{ route('admin.job.index') }}' + '/' + row.from_id + '/edit';
                    }else
                    {
                        this.loading = true;
                        window.location.href = '{{ route('admin.activity.index') }}' + '/' + row.from_id + '/edit';
                    }
                },
                //通过按钮
                handlePass(index, row) {
                    this.loading = true;
                    this.$confirm('确定要审批通过本条内容吗?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning',
                        center: true
                    }).then(() => {
                        document.getElementById('delete-form').action = '{{ route('admin.sp.index') . "/" }}'
                            + row.ids + '.' + row.from_kind + '.' + 'pass';
                        document.getElementById('delete-form').submit();
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消审批'
                        });
                        this.loading = false;
                    });
                },
                //拒绝按钮
                handleReject(index, row) {
                    this.loading = true;
                    this.$confirm('确定要审批拒绝本条内容吗?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning',
                        center: true
                    }).then(() => {
                        document.getElementById('delete-form').action = '{{ route('admin.sp.index') . "/" }}'
                            + row.ids + '.' + row.from_kind + '.' + 'reject';
                        document.getElementById('delete-form').submit();
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消审批'
                        });
                        this.loading = false;
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