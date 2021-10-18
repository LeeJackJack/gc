@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="placeIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>
                            <el-button
                                size="medium"
                                type="primary"
                                style="margin-right: 20px;"
                                @click="handleCreate">
                                创建
                                <i class="el-icon-upload el-icon--right"></i></el-button>
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
                                    label="景点名称">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-office-building"></i>--}}
                                        <span class="mainItem">@{{ scope.row.name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                    label="门票价格">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-s-flag"></i>--}}
                                        <span>@{{ scope.row.ticket }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                    label="景区级别">
                                    <template slot-scope="scope">
                                        <el-tag type="primary">@{{ scope.row.level }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                    label="标签1">
                                    <template slot-scope="scope">
                                        <el-tag type="success">@{{ scope.row.tag_first }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                    label="标签2">
                                    <template slot-scope="scope">
                                        <el-tag type="success">@{{ scope.row.tag_second }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                    label="创建时间">
                                    <template slot-scope="scope">
                                        <i class="el-icon-time"></i>
                                        <span> @{{ scope.row.created_at }}</span>
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
        let placeIndex = new Vue({
            el: '#placeIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $places !!},
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
                    window.location.href = '{{ route('admin.place.create') }}';
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.place.index')}}' + '/' + row.id + '/edit';
                },
                //删除按钮
                handleDelete(index, row)
                {
                    this.$confirm('删除景点可能会影响线路展示，是否继续？', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        document.getElementById('delete-form').action = '{{ route('admin.place.index') . "/" }}' + row.id;
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
