@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="recommendIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
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
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-user"></i> 应聘记录</span>
                            <el-table
                                    size="medium"
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
                                            <el-form-item label="是否领奖金">
                                                <el-tag v-if="props.row.is_pay==1" type="success">@{{ props.row.is_pay
                                                    }}
                                                </el-tag>
                                                <el-tag v-else type="info">未领取</el-tag>
                                            </el-form-item>
                                            <el-form-item label="联系电话">
                                                <el-tag type="success">@{{ props.row.phone }}
                                                </el-tag>
                                            </el-form-item>
                                            <el-form-item label="联系邮箱">
                                                <el-tag type="success">@{{ props.row.email }}
                                                </el-tag>
                                            </el-form-item>
                                            {{--<el-form-item label="投递时间">--}}
                                            {{--<el-tag type="info">@{{ props.row.created_at }}</el-tag>--}}
                                            {{--</el-form-item>--}}
                                            {{--<el-form-item label="更新时间">--}}
                                            {{--<el-tag type="info">@{{ props.row.updated_at }}</el-tag>--}}
                                            {{--</el-form-item>--}}
                                        </el-form>
                                    </template>
                                </el-table-column>

                                {{--列表项目--}}
                                <el-table-column
                                        align="left"
                                        label="姓名"
                                        width="120px">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.is_handle=='0'">
                                            <el-badge is-dot style="margin-top: 5px;">
                                                {{--<i style="color: #409EFF" class="el-icon-user"></i>--}}
                                                <span class="mainItem">@{{ scope.row.name }}</span>
                                            </el-badge>
                                        </div>
                                        <div v-else>
                                            {{--<i style="color: #409EFF" class="el-icon-user"></i>--}}
                                            <span>@{{ scope.row.name }}</span>
                                        </div>
                                    </template>
                                </el-table-column>

                                {{--<el-table-column--}}
                                {{--sortable--}}
                                {{--label="专业"--}}
                                {{--prop="major">--}}
                                {{--<template slot-scope="scope">--}}
                                {{--<i style="color: #409EFF" class="el-icon-s-opportunity"></i>--}}
                                {{--<span style="margin-left: 10px">@{{ scope.row.major }}</span>--}}
                                {{--</template>--}}
                                {{--</el-table-column>--}}

                                {{--<el-table-column--}}
                                {{--sortable--}}
                                {{--label="毕业学校"--}}
                                {{--prop="school">--}}
                                {{--<template slot-scope="scope">--}}
                                {{--<i style="color: #409EFF" class="el-icon-school"></i>--}}
                                {{--<span style="margin-left: 10px">@{{ scope.row.school }}</span>--}}
                                {{--</template>--}}
                                {{--</el-table-column>--}}

                                <el-table-column label="应聘岗位">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-news"></i>--}}
                                        <span style="margin-left: 10px">@{{ scope.row.belongs_to_job.title }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column label="应聘企业">
                                    <template slot-scope="scope">
                                        {{--<i style="color: #409EFF" class="el-icon-school"></i>--}}
                                        <span style="margin-left: 10px">@{{ scope.row.belongs_to_job.belongs_to_company.name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        sortable
                                        label="投递时间"
                                        prop="created_at">
                                    <template slot-scope="scope">
                                        <i style="color: #409EFF" class="el-icon-time"></i>
                                        <span style="margin-left: 10px">@{{ scope.row.created_at }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="推荐类型"
                                        prop="type"
                                        :filters="[{ text: '自荐', value: '0' },{text: '推荐他人', value: '1'}]"
                                        :filter-method="typeFilterTag"
                                        filter-placement="bottom-end"
                                        width="120px">
                                    <template slot-scope="scope">
                                        <el-tag size="medium" v-if="scope.row.type=='1'" type="warning">推荐他人</el-tag>
                                        <el-tag size="medium" v-else type="primary">自荐</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="推荐状态"
                                        prop="status"
                                        :filters="[{ text: '入职成功', value: '4' }, { text: '入职中', value: '3' },{text: '不匹配', value: '2'},{text: '面试中', value: '1'}
                                        ,{text: '已接收', value: '0'}]"
                                        :filter-method="statusFilterTag"
                                        filter-placement="bottom-end"
                                        width="120px">
                                    <template slot-scope="scope">
                                        <el-tag size="medium" v-if="scope.row.status=='4'" type="success">入职成功</el-tag>
                                        <el-tag size="medium" v-if="scope.row.status=='3'" type="success">入职中</el-tag>
                                        <el-tag size="medium" v-if="scope.row.status=='2'" type="danger">不匹配</el-tag>
                                        <el-tag size="medium" v-if="scope.row.status=='1'" type="warning">面试中</el-tag>
                                        <el-tag size="medium" v-if="scope.row.status=='0'" type="info">已接收</el-tag>
                                    </template>
                                </el-table-column>

                                <el-table-column label="操作">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.email_handle > 0">
                                            <el-badge is-dot style="margin-top: 5px;">
                                                <el-button
                                                        size="mini"
                                                        type="primary"
                                                        circle
                                                        @click="handleEdit(scope.$index, scope.row)"
                                                        icon="el-icon-edit">
                                                </el-button>
                                            </el-badge>
                                        </div>
                                        <div v-else>
                                            <el-button
                                                    size="mini"
                                                    type="warning"
                                                    plain
                                                    @click="handleEdit(scope.$index, scope.row)" icon="el-icon-edit">
                                            </el-button>
                                        </div>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <div style="margin: 30px 0;">
                                {{--分页--}}
                                <el-pagination
                                        layout="total,prev, pager, next"
                                        :total="total"
                                        background
                                        @current-change="current_change">
                                </el-pagination>
                            </div>
                        </el-tab-pane>

                        <el-tab-pane name="1">
                            <span slot="label"><i class="el-icon-medal-1"></i>热门企业</span>
                            <div style="margin: 10px auto 30px auto;text-align: center">
                                <div style="color: #333;margin: 20px 0;">点击下方获取数据按钮，获取平台热门应聘企业排行</div>
                                <el-button icon="el-icon-info" @click="getCompanyData">获取数据</el-button>
                            </div>
                            <div v-if="comTableData.length > 0">
                                <el-table
                                        size="medium"
                                        {{--分页--}}
                                        :data="comTableData.slice((comCurrentPage-1)*pagesize,comCurrentPage*pagesize)">
                                    {{--列表项目--}}
                                    <el-table-column
                                            label="企业"
                                            prop="name">
                                    </el-table-column>

                                    <el-table-column
                                            align="center"
                                            label="应聘数量">
                                        <template slot-scope="scope">
                                            <el-popover trigger="hover" placement="top">
                                                <p v-for="(value,index) in scope.row.job">
                                                    <span style="color: rgb(66,87,178);">@{{  value.title}}</span>
                                                    @{{value.count }} 次</p>
                                                <div slot="reference">
                                                    <el-tag size="medium" type="success">@{{scope.row.count}}</el-tag>
                                                </div>
                                            </el-popover>
                                        </template>
                                    </el-table-column>

                                    <el-table-column
                                            label="单位属性"
                                            prop="property">
                                    </el-table-column>

                                    <el-table-column
                                            label="单位资质"
                                            prop="scale">
                                    </el-table-column>

                                    <el-table-column
                                            label="所属行业"
                                            prop="type">
                                    </el-table-column>
                                </el-table>
                                <div style="margin: 30px 0;">
                                    {{--分页--}}
                                    <el-pagination
                                            layout="total,prev, pager, next"
                                            :total="comTotal"
                                            background
                                            @current-change="com_current_change">
                                    </el-pagination>
                                </div>
                            </div>
                        </el-tab-pane>

                        <el-tab-pane name="2">
                            <span slot="label"><i class="el-icon-trophy"></i>热门职位</span>
                            <div style="margin: 10px auto 30px auto;text-align: center">
                                <div style="color: #333;margin: 20px 0;">点击下方获取数据按钮，获取平台热门职位排行</div>
                                <el-button icon="el-icon-info" @click="getJobData">获取数据</el-button>
                            </div>
                            <div v-if="jobTableData.length > 0">
                                <el-table
                                        size="medium"
                                        {{--分页--}}
                                        :data="jobTableData.slice((jobCurrentPage-1)*pagesize,jobCurrentPage*pagesize)">
                                    {{--列表项目--}}
                                    <el-table-column
                                            label="职位"
                                            prop="title">
                                    </el-table-column>

                                    <el-table-column
                                            align="center"
                                            label="应聘人数"
                                            prop="count">
                                        <template slot-scope="scope">
                                            <el-popover trigger="hover" placement="top">
                                                <p v-for="(value,index) in scope.row.recommend">
                                                    <span style="color: rgb(66,87,178);">@{{ value.name }}</span></p>
                                                <div slot="reference">
                                                    <el-tag size="medium" type="success">@{{scope.row.count}}</el-tag>
                                                </div>
                                            </el-popover>
                                        </template>
                                    </el-table-column>

                                    <el-table-column
                                            label="发布企业">
                                        <template slot-scope="scope">
                                            <span style="margin-left: 10px">@{{ scope.row.belongs_to_company.name
                                                }}</span>
                                        </template>
                                    </el-table-column>

                                    <el-table-column
                                            label="薪资"
                                            prop="salary">
                                    </el-table-column>

                                    <el-table-column
                                            label="专业"
                                            prop="type">
                                    </el-table-column>
                                </el-table>
                                <div style="margin: 30px 0;">
                                    {{--分页--}}
                                    <el-pagination
                                            layout="total,prev, pager, next"
                                            :total="jobTotal"
                                            background
                                            @current-change="job_current_change">
                                    </el-pagination>
                                </div>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>
        </template>
    </div>

    <style>
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

        .mainItem {
            font-size: 14px;
            font-weight: 600;
        }

        .topWrapper{
            height: 155px;
            border: 1px solid #ededed;
            padding: 30px;
            margin: 30px auto;
            background-color: rgb(250,250,250);
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
        let recommendIndex = new Vue({
            el: '#recommendIndex',
            data: {
                search: '',
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {!! $recommends !!},
                active: '0',
                comTableData: {},
                comTotal: 0,
                comCurrentPage: 1,
                jobTableData: {},
                jobTotal: 0,
                jobCurrentPage: 1,
                timeLimit:[new Date(2020, 1, 1, 0, 0), new Date(2020, 1, 1, 0,0)],
            },
            compute: {
                //
            },
            methods: {
                //推荐类型筛选
                typeFilterTag(value, row) {
                    return row.type === value;
                },
                //应聘状态筛选
                statusFilterTag(value, row) {
                    return row.status === value;
                },
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //企业数据分页
                com_current_change(comCurrentPage) {
                    this.comCurrentPage = comCurrentPage;
                },
                //职位数据分页
                job_current_change(jobCurrentPage) {
                    this.jobCurrentPage = jobCurrentPage;
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.recommend.index')}}' + '/' + row.ids + '/edit';
                },
                getJobData() {
                    let __this = this;
                    __this.loading = true;
                    axios.get("/api/getJobData", {
                        params: {
                            //
                        },
                    }).then(res => {
                        // console.log(res);
                        let response = res.data;
                        if (response.result == 'success') {
                            __this.jobTableData = response.data;
                            __this.jobTotal = response.data.length;
                        }
                        __this.loading = false;
                        this.$notify({
                            title: response.result,
                            message: response.msg,
                            type: response.result
                        });
                        __this.loading = false;
                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                getCompanyData() {
                    let __this = this;
                    __this.loading = true;
                    axios.get("/api/getCompanyData", {
                        params: {
                            //
                        },
                    }).then(res => {
                        // console.log(res);
                        let response = res.data;
                        if (response.result == 'success') {
                            __this.comTableData = response.data;
                            __this.comTotal = response.data.length;
                        }
                        __this.loading = false;
                        this.$notify({
                            title: response.result,
                            message: response.msg,
                            type: response.result
                        });
                        __this.loading = false;
                    }).catch(function (err) {
                        //console.log(err);
                    });
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
                    window.open('{{ route('admin.recommend.download')}}' + '?' + 'start=' + start + '&end=' +end,
                        '_blank');
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