@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="OverseasIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <el-container>
                        <el-header>
                            <el-link
                                    :underline="false"
                                    type="primary"
                                    target="_blank"
                                    href="{{ route('admin.oversea_activity.download') }}">导出报名名单
                                <i class="el-icon-download el-icon--right"></i>
                            </el-link>
                        </el-header>
                        <el-main>
                            <el-table
                                    {{--表格边框属性--}}
                                    {{--border--}}
                                    size="small"
                                    {{--分页--}}
                                    {{--:data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"--}}
                                    :data="tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))
                                    .slice((currentPage-1)*pagesize,currentPage*pagesize)">
                                {{--展开菜单部分--}}
                                <el-table-column type="expand">
                                    <template slot-scope="props">
                                        <el-form
                                                label-position="left"
                                                inline
                                                class="table-expand"
                                                style="background-color: rgba(237,242,252,0.4);padding: 20px;">
                                            <el-form-item label="居住国家">
                                                <span>@{{ props.row.settleCountry }}</span>
                                            </el-form-item>
                                            <el-form-item label="居住城市">
                                                <span>@{{ props.row.settleCity }}</span>
                                            </el-form-item>
                                            <el-form-item label="证件类型">
                                                <el-tag v-if="props.row.idCard == '1'" type="primary"
                                                        icon="el-icon-search">身份证
                                                </el-tag>
                                                <el-tag v-else type="primary" icon="el-icon-search">护照</el-tag>
                                            </el-form-item>
                                            <el-form-item label="证件号码">
                                                <el-tag type="primary">@{{ props.row.idCardNum }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="参加社团及职务">
                                                <span>@{{ props.row.corporation }}</span>
                                            </el-form-item>
                                            <el-form-item label="现任职单位及职务">
                                                <span>@{{ props.row.job }}</span>
                                            </el-form-item>
                                            <el-form-item label="国内电话">
                                                <el-tag type="success">@{{ props.row.phone }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="国外电话">
                                                <el-tag type="success">@{{ props.row.foreignPhone }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="E-mail">
                                                <el-tag type="success">@{{ props.row.email }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="wechat">
                                                <el-tag type="success">@{{ props.row.wechat }}</el-tag>
                                            </el-form-item>
                                            <el-form-item label="项目合作">
                                                <span>@{{ props.row.project }}</span>
                                            </el-form-item>
                                        </el-form>
                                    </template>
                                </el-table-column>

                                {{--列表项目--}}
                                <el-table-column
                                        prop="name"
                                        align="left"
                                        label="姓名">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-user"></i>
                                        <span>@{{ scope.row.name }}</span>
                                    </template>
                                    <template slot="header" slot-scope="scope">
                                        <el-input size="medium" v-model="search" placeholder="输入名字搜索">
                                            <i slot="prefix" class="el-input__icon el-icon-search"
                                               style="padding-left: 15px;"></i></el-input>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="推荐机构"
                                        prop="organization"
                                        width="220px">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-office-building"></i>
                                        <span>@{{ scope.row.organization }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="学历"
                                        prop="edu"
                                        :filters="[{ text: '已获博士学位', value: '已获博士学位' }, { text: '在读博士', value: '在读博士' }]"
                                        :filter-method="eduFilterTag"
                                        filter-placement="bottom-end">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-medal"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.edu }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        sortable
                                        label="专业"
                                        prop="major">
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
                                        label="性别"
                                        prop="gender"
                                        :filters="[{ text: '男', value: '0' }, { text: '女', value: '1' }]"
                                        :filter-method="filterTag"
                                        filter-placement="bottom-end"
                                        width="90px">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.gender == '0'"
                                                type="success"
                                                close-transition>男
                                        </el-tag>
                                        <el-tag v-if="scope.row.gender == '1'"
                                                type="primary"
                                                close-transition>女
                                        </el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="生日">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-date"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.birthday ? scope.row.birthday.substr(0,10) : '' }}</span>
                                    </template>
                                </el-table-column>
                                <el-table-column
                                        label="国籍"
                                        prop="region"
                                        :filters="[{ text: '中国', value: '0' }, { text: '国外', value: '1' }]"
                                        :filter-method="countyFilterTag"
                                        filter-placement="bottom-end"
                                        width="90px">
                                    <template slot-scope="scope">
                                        <el-tag v-if="scope.row.region == '0'"
                                                type="success"
                                                close-transition>中国
                                        </el-tag>
                                        <el-tag v-else
                                                type="primary"
                                                close-transition>国外
                                        </el-tag>
                                    </template>
                                </el-table-column>

                            </el-table>
                        </el-main>
                        <el-footer>
                            {{--分页--}}
                            <el-pagination
                                    layout="total,prev, pager, next"
                                    :total="total"
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
            background-color: rgb(247,247,247);
            color: #333;
            text-align: center;
            line-height: 60px;
        }

        .table-expand {
            font-size: 0;
        }

        .table-expand label {
            width: 30%;
            color: #99a9bf;
        }

        .table-expand .el-form-item {
            margin-right: 0;
            margin-bottom: 0;
            width: 50%;
        }
    </style>

    <script>
        let OverseasIndex = new Vue({
            el: '#OverseasIndex',
            data: {
                search: '',
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $signUps !!},
            },
            compute: {
                //
            },
            methods: {
                filterTag(value, row) {
                    return row.gender === value;
                },
                countyFilterTag(value, row) {
                    return row.region === value;
                },
                eduFilterTag(value, row) {
                    return row.edu === value;
                },
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