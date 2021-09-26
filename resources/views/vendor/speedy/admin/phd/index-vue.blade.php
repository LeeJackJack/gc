@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="phdIndex">
        <template>
            <el-row :gutter="0" v-loading="loading">
                <el-col :span="22" :offset=1>
                    <div style="margin: 30px 0;">
                        <div style="font-size:16px;font-weight: 600;">平台共计收录<span
                                    style="color: rgb(60,207,207)"> 30014 </span>名在读博士信息
                        </div>
                        <div>
                            <div style="color: #333;margin: 20px 0;">--请先选择地区，查看地区高校分布</div>
                            <div style="display: flex">
                                <el-select
                                        v-model="selectValue"
                                        placeholder="请选择区域"
                                        clearable>
                                    <el-option
                                            v-for="item in labels"
                                            :key="item.code"
                                            :label="item.label"
                                            :value="item.code">
                                    </el-option>
                                </el-select>
                                <div style="margin: 0 20px;width:100%;">
                                    <el-button type="primary"
                                               @click="searchSchool">查询
                                    </el-button>
                                    <el-button type="primary" circle
                                               icon="el-icon-plus"
                                               style="float: right;"
                                               @click="addPhd">
                                    </el-button>
                                </div>
                            </div>
                        </div>
                        <div class="province-group" v-show="cityData.length > 0">
                            <el-button type="primary" plain size="small" v-for="(value,index) in cityData"
                                       @click="selectCity(index)"
                                       v-if="Object.keys(value.school).length >0">
                                @{{ value.label }} @{{ Object.keys(value.school).length }}
                            </el-button>
                        </div>
                        <div v-loading="schoolLoading"
                             style="display: flex;justify-content: flex-start;flex-flow:row wrap;">
                            <div style="margin: 20px 0;width: 100%;text-align: center;color: #ccc;"
                                 v-if="Object.keys(tableData).length == 0">
                            </div>
                            <div v-else>
                                <div>--请选择高校，查看博士信息</div>
                                <el-button
                                        @click="searchSchoolPhd(key)"
                                        class="school-btn"
                                        v-for="(value,key,index) in tableData"
                                        type="primary"
                                        plain
                                        size="small"
                                        icon="el-icon-school">@{{ key }} @{{ value.length }}
                                </el-button>
                            </div>
                        </div>
                        <el-divider></el-divider>
                        <div class="student-table" v-if="studentData.length > 0" v-loading="phdLoading">
                            <div style="margin: 20px 0;">
                                <div style="font-size:16px;font-weight: 600;">@{{ selectSchool }} 共有在统计专业
                                    <span style="color: rgb(60,207,207)">@{{ major.length }} </span>个</div>
                                <div style="margin: 20px 0;">
                                    <span v-for="(value,index) in major">@{{ String(Object.keys(value)) }}@{{ index
                                        == major.length - 1 ? '':'，'  }}</span>
                                </div>
                            </div>
                            <div>
                                <div style="margin: 30px 0;font-size:16px;font-weight: 600;">录入博士信息</div>

                                <div style="margin: 10px 0;">
                                    <el-select
                                            @change="filterTime"
                                            v-model="enterTime"
                                            placeholder="录取时间"
                                            clearable>
                                        <el-option
                                                key="2018"
                                                label="2018年"
                                                value="2018年">
                                        </el-option>
                                        <el-option
                                                key="2019"
                                                label="2019年"
                                                value="2019年">
                                        </el-option>
                                        <el-option
                                                key="2020"
                                                label="2020年"
                                                value="2020年">
                                        </el-option>
                                        <el-option
                                                key="2021"
                                                label="2021年"
                                                value="2021年">
                                        </el-option>
                                    </el-select>
                                </div>

                                <el-table
                                        size="small"
                                        border
                                    :data="filterStudentData.slice((currentPage-1)*pagesize,currentPage*pagesize)">

                                    {{--列表项目--}}
                                    <el-table-column
                                            prop="name"
                                            label="姓名">
                                        <template slot-scope="scope">
                                            <span class="mainItem">@{{ scope.row.name }}</span>
                                        </template>
                                    </el-table-column>

                                    <el-table-column
                                            prop="now_institution"
                                            label="在读院校/科研机构">
                                    </el-table-column>

                                    <el-table-column
                                            prop="department"
                                            label="院系">
                                    </el-table-column>

                                    <el-table-column
                                            prop="major"
                                            label="专业">
                                    </el-table-column>

                                    <el-table-column
                                            prop="enter_time"
                                            label="录取时间">
                                    </el-table-column>

                                    <el-table-column
                                            prop="department_contact_link"
                                            label="所在院系链接">
                                    </el-table-column>

                                    <el-table-column label="操作">
                                        <template slot-scope="scope">
                                            <el-button
                                                    size="mini"
                                                    type="primary"
                                                    circle
                                                    @click="handleEdit(scope.$index, scope.row)" icon="el-icon-edit">
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>

                            <div style="margin: 30px 0;">
                                {{--分页--}}
                                <el-pagination
                                        layout="total,prev, pager, next"
                                        :total="total"
                                        :current-page = "parseInt(currentPage)"
                                        @current-change="current_change">
                                </el-pagination>
                            </div>
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </template>
    </div>

    <style scoped>
        .province-group {
            display: flex;
            justify-content: flex-start;
            flex-flow: row wrap;
            margin: 30px 0;
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

        .school-card {
            width: 300px;
            margin: 10px;
        }

        .mainItem {
            font-size: 14px;
            font-weight: 600;
        }

        .school-btn {
            margin: 10px;
        }
    </style>

    <script>
        let phdIndex = new Vue({
            el: '#phdIndex',
            data: {
                loading: true,
                total: 1000,
                currentPage: 1,
                pagesize: 10,
                tableData: {},
                cityData: [],
                labels: {!! $labels !!} ,
                selectValue: '',
                schoolLoading: false,
                phdLoading:false,
                studentData:[],
                filterStudentData:[],
                major:[],
                selectSchool:'',
                enterTime:'',
            },
            compute: {
                //
            },
            methods: {
                //搜索地区高校数据
                searchSchool() {
                    let value = this.selectValue;
                    let __this = this;
                    if (!value) {
                        __this.$message.error('请先选择区域再进行搜索');
                    } else {
                        __this.loading = true;
                        __this.tableData = [];
                        __this.cityData = [];
                        __this.studentData = [];
                        __this.filterStudentData = [];
                        axios.get("/api/searchSchool", {
                            params: {
                                code: value,
                            },
                        }).then(res => {
                            // console.log(res);
                            let response = res.data;
                            if (response.result == 'success') {
                                __this.cityData = response.data;
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
                    }
                },
                searchSchoolPhd(school) {
                    let __this = this;
                    __this.selectSchool = school;
                    __this.phdLoading = true;
                    axios.get("/api/searchSchoolPhd", {
                        params: {
                            school: school,
                        },
                    }).then(res => {
                        // console.log(res);
                        let response = res.data;
                        if (response.result == 'success') {
                            __this.studentData = response.data;
                            __this.filterStudentData = response.data;
                            __this.major = response.major;
                            __this.total = response.data.length;
                        }
                        __this.phdLoading = false;
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
                selectCity(index) {
                    let __this = this;
                    __this.schoolLoading = true;
                    // console.log(__this.tableData);
                    setTimeout(function () {
                        __this.tableData = __this.cityData[index].school;
                        __this.schoolLoading = false;
                    }, 500)
                },
                filterTime(value)
                {
                    let data = this.studentData;
                    let filter = [];
                    for (let i = 0; i < data.length ; i++) {
                        if (data[i].enter_time == value)
                        {
                            filter.push(data[i]);
                        }
                    }
                    this.filterStudentData = filter;
                    this.total = filter.length
                    // console.log(filter);
                },
                //分页
                current_change(currentPage) {
                    this.currentPage = currentPage;
                },
                //编辑按钮
                handleEdit(index, row) {
                    this.loading = true;
                    window.location.href = '{{route('admin.phd.index')}}' + '/' + row.id + '/edit';
                },
                addPhd()
                {
                    window.location.href = '{{ route('admin.phd.create') }}';
                },
            },
            created: function () {
                // this.total = this.tableData.length;
            },
            mounted: function () {
                this.loading = false;
            },
        });
    </script>
@endsection