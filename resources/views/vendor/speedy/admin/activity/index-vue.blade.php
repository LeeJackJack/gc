@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="activityIndex">
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
                                                inline
                                                class="table-expand"
                                                style="background-color: rgba(237,242,252,0.4);padding: 10px;">
                                            <el-form-item label="平台审批">
                                                <el-tag v-if="props.row.sp_jg == '1'" type="success">通过</el-tag>
                                                <el-tag v-else-if="props.row.sp_jg == '0'" type="danger">拒绝</el-tag>
                                                <el-tag v-else-if="props.row.sp_jg == null" type="info">未审批</el-tag>
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
                                        align="left"
                                        label="活动主题">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-coordinate"></i>--}}
                                        <span class="mainItem">@{{ scope.row.name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="地点">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-location-information"></i>
                                        <span>@{{ scope.row.address }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="开始时间"
                                        width="180">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-time"></i>
                                        <span>@{{ scope.row.start_time.substr(0,16) }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="结束时间"
                                        width="180">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-time"></i>
                                        <span>@{{ scope.row.end_time.substr(0,16) }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="截止报名时间"
                                        width="180">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-timer"></i>
                                        <span>@{{ scope.row.sign_up_end_time.substr(0,16) }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="价格"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.price > 0" type="warning">@{{ scope.row.price }}</el-tag>
                                        <el-tag v-if="scope.row.price = '免费'" type="success">@{{ scope.row.price }}</el-tag>
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
                                        <el-button
                                                size="mini"
                                                type="success"
                                                plain
                                                @click="exportSigns(scope.$index, scope.row)"
                                                icon="el-icon-download">导出报名
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
            display: inline-block;
        }
        .mainItem
        {
            font-size: 14px;
            font-weight: 600;
        }
    </style>

    <script>
        let activityIndex = new Vue({
            el: '#activityIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $activities !!},
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
                    window.location.href = '{{ route('admin.activity.create') }}';
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.activity.index')}}' + '/' + row.ids + '/edit';
                },
                //导出报名名单
                exportSigns(index, row)
                {
                    window.open('{{ route('admin.activity.download')}}' + '?' + 'ids=' + row.ids ,
                        '_blank');
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
                        document.getElementById('delete-form').action = '{{ route('admin.activity.index') . "/" }}' + row.ids;
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