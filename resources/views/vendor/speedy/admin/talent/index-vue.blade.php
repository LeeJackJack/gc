@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="talentIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>
                            <form action="{{route('admin.talent.index')}}">
                                <div class="search-input">

                                    <el-button
                                            size="medium"
                                            type="primary"
                                            style="margin-right: 20px;"
                                            @click="handleCreate">
                                        创建
                                        <i class="el-icon-upload el-icon--right"></i></el-button>
                                    <el-divider direction="vertical"></el-divider>
                                    <el-input
                                            size="medium"
                                            style="margin-left: 20px;"
                                            name="name"
                                            placeholder="博士名称..."
                                            v-model="searchName">
                                    </el-input>
                                    <el-input
                                            size="medium"
                                            name="major"
                                            placeholder="如：生物医药..."
                                            v-model="searchMajor">
                                    </el-input>
                                    <el-input
                                            size="medium"
                                            name="school"
                                            placeholder="如：北京大学..."
                                            v-model="searchSchool">
                                    </el-input>
                                    <el-button size="medium" type="primary" native-type="submit">搜索<i
                                                class="el-icon-search el-icon--right"></i></el-button>
                                </div>
                            </form>
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
                                            <el-form-item label="最后跟进人">
                                                <el-tag v-if="props.row.last_contact">@{{ props.row.last_contact.name
                                                    }}
                                                </el-tag>
                                                <el-tag v-else type="info">无</el-tag>
                                            </el-form-item>
                                            <el-form-item label="联系电话">
                                                <el-tag type="success">@{{ props.row.phone }}
                                                </el-tag>
                                            </el-form-item>
                                            <el-form-item label="联系邮箱">
                                                <el-tag type="success">@{{ props.row.email }}
                                                </el-tag>
                                            </el-form-item>
                                            <el-form-item label="简历地址">
                                                <el-link
                                                        v-if="props.row.resume_url"
                                                        icon="el-icon-link"
                                                        :underline="false"
                                                        type="success"
                                                        :href="props.row.resume_url"
                                                        target="_blank">@{{ props.row.resume_url }}
                                                </el-link>
                                                <el-tag v-else type="info">无</el-tag>
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
                                        prop="name"
                                        align="left"
                                        label="姓名"
                                        width="120px">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-user"></i>--}}
                                        <span class="mainItem">@{{ scope.row.name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        sortable
                                        label="专业"
                                        prop="major"
                                        width="200px">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-s-opportunity"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.major }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        sortable
                                        label="毕业学校"
                                        prop="school">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-school"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.school }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="应聘岗位"
                                        width="120px">
                                    <template slot-scope="scope">
                                        <el-tag type="danger">@{{ scope.row.job_count }}</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="简历"
                                        prop="if_resume"
                                        :filters="[{ text: '有简历', value: '1' }, { text: '无简历', value: '0' }]"
                                        :filter-method="resumeFilterTag"
                                        filter-placement="bottom-end"
                                        width="120px">
                                    <template slot-scope="scope">
                                        <el-tag size="medium" v-if="scope.row.if_resume=='1'" type="success">有简历
                                        </el-tag>
                                        <el-tag size="medium" v-else type="info">没简历</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="是否联系"
                                        prop="if_contact"
                                        :filters="[{ text: '已联系', value: '1' }, { text: '未联系', value: '0' }]"
                                        :filter-method="contactFilterTag"
                                        filter-placement="bottom-end"
                                        width="120px">
                                    <template slot-scope="scope">
                                        <el-tag size="medium" v-if="scope.row.if_contact=='1'" type="success">已联系
                                        </el-tag>
                                        <el-tag size="medium" v-else type="info">未联系</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="是否对接企业"
                                        prop="if_contact_com"
                                        :filters="[{ text: '已对接', value: '1' }, { text: '未对接', value: '0' }]"
                                        :filter-method="contactComFilterTag"
                                        filter-placement="bottom-end"
                                        width="150px">
                                    <template slot-scope="scope">
                                        <el-tag size="medium" v-if="scope.row.if_contact_com=='1'" type="success">已对接
                                        </el-tag>
                                        <el-tag size="medium" v-else type="info">未对接</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                circle
                                                @click="handleInfo(scope.$index, scope.row)" icon="el-icon-info">
                                        </el-button>
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
            background-color: rgb(247,247,247);
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
        let talentIndex = new Vue({
            el: '#talentIndex',
            data: {
                search: '',
                searchName: '',
                searchMajor: '',
                searchSchool: '',
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $talents !!},
            },
            compute: {
                //
            },
            methods: {
                //是否有简历筛选
                resumeFilterTag(value, row) {
                    return row.if_resume === value;
                },
                //是否联系筛选
                contactFilterTag(value, row) {
                    return row.if_contact === value;
                },
                //是否对接企业筛选
                contactComFilterTag(value, row) {
                    return row.if_contact_com === value;
                },
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //详情按钮
                handleInfo(index, row) {
                    this.loading = true;
                    window.location.href = '{{ route('admin.talent.index') }}' + '/' + row.id + '?';
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.talent.index')}}' + '/' + row.id + '/edit';
                },
                //创建按钮
                handleCreate() {
                    this.loading = true;
                    window.location.href = '{{ route('admin.talent.create') }}';
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
                        document.getElementById('delete-form').action = '{{ route('admin.talent.index') . "/" }}' + row.id;
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
                this.searchName = '{{$name}}';
                this.searchMajor = '{{$major}}';
                this.searchSchool = '{{$school}}';
            },
        });
    </script>
@endsection