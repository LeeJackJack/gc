@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="governmentIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <div class="header-btn-group">
                        <div style="display: flex;">
                            <div class="office-input">
                                <el-input
                                        placeholder="请输入办公室关键字查询..."
                                        prefix-icon="el-icon-search"
                                        v-model="office">
                                </el-input>
                            </div>
                            <el-button type="success" @click="searchData" :loading="searchLoading"><i
                                        class="el-icon-search"> 查询</i>
                            </el-button>
                        </div>
                        <div>
                            <el-tooltip effect="dark" content="增加联系人信息" placement="bottom">
                                <el-button type="primary" circle @click="createData"><i
                                            class="el-icon-plus"></i></el-button>
                            </el-tooltip>
                        </div>
                    </div>
                    <div class="main-content">
                        <div class="data-show"><i class="el-icon-user-solid"></i> 累计收录政府联系人
                            <span style="color: #ff725B">@{{ g }}</span> 位
                        </div>
                        <div class="data-show"><i class="el-icon-s-promotion"></i> 省级部门联系人
                            <span style="color: #ff725B">@{{ p }}</span> 个，市级部门联系人
                            <span style="color: #ff725B">@{{ c }}</span> 个，区级部门联系人
                            <span style="color: #ff725B">@{{ d }}</span> 个
                        </div>
                        <transition name="el-fade-in-linear">
                            <div class="table-wrapper" v-show="tableData.length > 0">
                                <el-table
                                        {{--:data="tableData"--}}
                                        :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
                                        style="width: 100%">
                                    <el-table-column
                                            prop="name"
                                            label="姓名">
                                    </el-table-column>
                                    <el-table-column
                                            prop="gender"
                                            label="性别">
                                        <template slot-scope="scope"><span :class="scope.row.gender ? 'has-data' :
                                        'has-no-data'" >
                                            @{{ scope.row.gender ? scope.row.gender : '未填写' }}</span>
                                        </template>
                                    </el-table-column>
                                    <el-table-column
                                            prop="governmentName"
                                            label="政府单位">
                                        <template slot-scope="scope"><span :class="scope.row.governmentName ? 'has-data' :
                                        'has-no-data'">
                                            @{{ scope.row.governmentName ? scope.row.governmentName : '未填写' }}</span>
                                        </template>
                                    </el-table-column>
                                    <el-table-column
                                            prop="office"
                                            label="政府部门">
                                    </el-table-column>
                                    <el-table-column
                                            prop="region"
                                            label="地区级别">
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
                                                    @click="handleDelete(scope.$index, scope.row)"
                                                    icon="el-icon-delete">
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                                <div style="margin: 30px 0;">
                                    {{--分页--}}
                                    <el-pagination
                                            layout="total,prev, pager, next"
                                            :total="total"
                                            background
                                            :current-page = "parseInt(currentPage)"
                                            @current-change="current_change">
                                    </el-pagination>
                                </div>
                            </div>
                        </transition>
                        <transition name="el-fade-in-linear">
                            <div class="table-wrapper-null" v-show="tableData.length == 0"><i
                                        class="el-icon-info"></i>暂无记录，请点击查询获取信息
                            </div>
                        </transition>
                    </div>
                </el-col>
            </el-row>
        </template>
    </div>

    <style>
        .header-btn-group {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .office-input {
            width: 300px;
            margin-right: 10px;
        }

        .main-content {

        }

        .data-show {
            color: #666;
            font-size: 14px;
            font-weight: 600;
            margin: 5px 0;
        }

        .table-wrapper-null {
            border-radius: 2px;
            background-color: rgb(240, 242, 245);
            height: 250px;
            text-align: center;
            color: #999999;
            line-height: 250px;
            font-weight: 600;
            margin: 30px 0;
        }

        .table-wrapper {
            border-radius: 2px;
            margin: 30px 0;
        }

        .has-data{
            color: #333;
        }
        .has-no-data
        {
            color: #ccc;
        }
    </style>

    <script>
        let governmentIndex = new Vue({
            el: '#governmentIndex',
            data: {
                office: '',
                loading: true,
                total: 0,
                currentPage: 1,
                pagesize: 10,
                tableData: [],
                searchLoading: false,
                g: '{{ $g }}',
                p: '{{ $p }}',
                d: '{{ $d }}',
                c: '{{ $c }}',

            },
            compute: {
                //
            },
            methods: {
                searchData() {
                    let __this = this;
                    __this.searchLoading = true;
                    axios.get("/api/searchGovernment", {
                        params: {
                            office: __this.office,
                        },
                    }).then(res => {
                        // console.log(res);
                        let response = res.data;
                        if (response.result == 'success') {
                            __this.tableData = response.data;
                        }
                        __this.total = __this.tableData.length;
                        __this.loading = false;
                        this.$notify({
                            title: response.result,
                            message: response.msg,
                            type: response.result
                        });
                        __this.searchLoading = false;
                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //创建信息
                createData()
                {
                    this.loading = true;
                    window.location.href = '{{route('admin.government.index')}}' + '/create';
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.government.index')}}' + '/' + row.id + '/edit';
                },
                //删除按钮
                handleDelete(index, row) {
                    this.$confirm('此操作将永久删除该内容, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning',
                        center: true
                    }).then(() => {
                        let __this = this;
                        __this.loading = true;
                        axios.get("/api/delGovernment", {
                            params: {
                                id: row.id,
                                office: __this.office,
                            },
                        }).then(res => {
                            // console.log(res);
                            let response = res.data;
                            if (response.result == 'success') {
                                __this.tableData = response.data;
                                __this.total = response.data;
                            }
                            __this.loading = false;
                            this.$notify({
                                title: response.result,
                                message: response.msg,
                                type: response.result
                            });
                            __this.searchLoading = false;
                        }).catch(function (err) {
                            //console.log(err);
                        });
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