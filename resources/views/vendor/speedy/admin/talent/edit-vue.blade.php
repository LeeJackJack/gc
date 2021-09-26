@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="talentEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-reading"></i> 基本信息</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑人才信息，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="form" :model="form" label-width="170px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="姓名"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入人才姓名...' },]">
                                                <el-input v-model="form.name" class="el-input" :disabled="show"
                                                          placeholder="姓名..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="专业"
                                                    prop="major"
                                                    :rules="[{ required: true, message: '请输入专业' },]">
                                                <el-input v-model="form.major" class="el-input" style="width: 220px;"
                                                          placeholder="如：自动化，建筑学..." :disabled="show"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="毕业学校"
                                                    prop="school"
                                                    :rules="[{ required: true, message: '请输入毕业学校' },]">
                                                <el-input v-model="form.school" class="el-input"
                                                          style="width: 220px;" placeholder="如：北京大学，清华大学..."
                                                          :disabled="show"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="简历"
                                                    prop="if_resume">
                                                <el-link
                                                        v-if="show"
                                                        :type="form.resume_url ? 'primary':'info'"
                                                        :underline="false"
                                                        :href="form.resume_url"
                                                        target="_blank"
                                                        :disabled="form.resume_url ? false:true">
                                                    <el-tag :type="form.resume_url ? 'success':'warning'">
                                                        @{{ form.resume_url ? '查看':'未上传' }}
                                                    </el-tag>
                                                </el-link>
                                                <el-upload
                                                        v-else
                                                        style="width: 360px"
                                                        :file-list="resume"
                                                        action="/api/upLoadResume/"
                                                        :on-success="upLoadResume"
                                                        :on-remove="removeFile"
                                                        :headers="{'X-CSRF-TOKEN':csrfToken}"
                                                        :on-preview="showUploadFile">
                                                    <el-button
                                                            v-if="resume.length < 1"
                                                            size="small"
                                                            type="primary">
                                                        点击上传
                                                    </el-button>
                                                    <el-button
                                                            v-else
                                                            size="small"
                                                            type="primary">
                                                        更换简历
                                                    </el-button>
                                                    <div slot="tip">
                                                        可上传PDF，Microsoft文件或图片
                                                    </div>
                                                </el-upload>
                                            </el-form-item>

                                            <el-form-item
                                                    label="联系电话"
                                                    prop="phone"
                                                    :rules="[{ required: true, message: '请输入联系电话...' },]">
                                                <el-input v-model="form.phone" class="el-input"
                                                          style="width: 220px;" placeholder="手机或固话..."
                                                          :disabled="show"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="邮箱"
                                                    prop="email"
                                                    :rules="[{ required: true, message: '请填写邮箱...' },]">
                                                <el-input v-model="form.email" class="el-input"
                                                          placeholder="邮箱地址..." :disabled="show"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="是否联系"
                                                    prop="if_contact">
                                                <el-switch
                                                        v-model="form.if_contact"
                                                        active-value="1"
                                                        inactive-value="0"
                                                        active-text="已联系"
                                                        inactive-text="未联系"
                                                        :disabled="show">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item
                                                    label="对接企业"
                                                    prop="if_contact_com">
                                                <el-switch
                                                        v-model="form.if_contact_com"
                                                        active-value="1"
                                                        inactive-value="0"
                                                        active-text="已对接"
                                                        inactive-text="未对接"
                                                        :disabled="show">
                                                </el-switch>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            plain
                                            type="primary"
                                            @click="onSubmit"
                                            :disabled="show"
                                            size="small">提交
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="1">
                            <span slot="label"><i class="el-icon-notebook-2"></i> 感兴趣岗位</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="用户曾经在平台投递过或推荐过一下岗位"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>

                                <el-main>
                                    {{--记录表格--}}
                                    <el-table
                                            border
                                            size="small"
                                            {{--分页--}}
                                            :data="wantedJob ? wantedJob.slice((jobCurrentPage-1)*pagesize,
                                            jobCurrentPage*pagesize) : []">

                                        {{--列表项目--}}
                                        <el-table-column
                                                prop="title"
                                                label="职位">
                                        </el-table-column>

                                        <el-table-column
                                                label="企业">
                                            <template slot-scope="scope">
                                                <i style="color: #409EFF" class="el-icon-office-building"></i>
                                                <span style="margin-left: 10px">@{{ scope.row.belongs_to_company ? scope.row.belongs_to_company.name : '' }}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                prop="address"
                                                label="地址">
                                        </el-table-column>

                                        <el-table-column
                                                sortable
                                                label="薪资"
                                                prop="salary">
                                            <template slot-scope="scope">
                                                <el-tag type="warning">@{{ scope.row.salary }}</el-tag>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="推荐奖金"
                                                prop="reward"
                                                align="center">
                                            <template slot-scope="scope">
                                                <el-tag v-if="scope.row.reward > 0">@{{ scope.row.reward}}
                                                </el-tag>
                                                <el-tag v-else type="info">无</el-tag>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="应聘时间"
                                                prop="reward"
                                                align="center">
                                            <template slot-scope="scope">
                                                <el-tag v-if="scope.row.reward > 0">@{{ scope.row.reward}}
                                                </el-tag>
                                                <el-tag v-else type="info">无</el-tag>
                                            </template>
                                        </el-table-column>

                                    </el-table>
                                </el-main>

                                <el-footer>
                                    {{--分页--}}
                                    <el-pagination
                                            style="display: inline-block;line-height: 30px;margin-right: 20px;"
                                            layout="total,prev, pager, next"
                                            :total="jobTotal"
                                            @current-change="jobPageChange"
                                            :current-page="jobCurrentPage"
                                            background>
                                    </el-pagination>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="2">
                            <span slot="label"><i class="el-icon-data-analysis"></i> 记录及备注</span>
                            <el-container>

                                <el-header>
                                    <el-alert
                                            title="如果您曾经联系人才获得其他信息或有其他内容需对人才进行内容备注，可在此填写。"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>

                                <el-main>
                                    {{--记录表格--}}
                                    <el-table
                                            border
                                            size="small"
                                            {{--分页--}}
                                            :data="contacts.slice((currentPage-1)*pagesize,currentPage*pagesize)">

                                        {{--列表项目--}}
                                        <el-table-column
                                                prop="name"
                                                label="操作人">
                                            <template slot-scope="scope">
                                                <el-input v-if="scope.row.created_at == null" v-model="scope.row.name"
                                                          placeholder="联系人..."></el-input>
                                                <span v-else>@{{ scope.row.name }}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="内容">
                                            <template slot-scope="scope">
                                                <el-input v-if="scope.row.created_at == null" type="textarea" :rows="2"
                                                          v-model="scope.row.content" placeholder="记录内容..."></el-input>
                                                <span v-else v-html="scope.row.content"></span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="记录时间"
                                                prop="created_at"
                                                align="center">
                                            <template slot-scope="scope">
                                                <el-input v-if="scope.row.created_at == null" :disabled="true"
                                                          placeholder="系统生成"></el-input>
                                                <span v-else>@{{ scope.row.created_at }}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column label="操作" align="center">
                                            <template slot-scope="scope">
                                                <el-button
                                                        v-if="scope.row.created_at == null"
                                                        size="mini"
                                                        type="success"
                                                        plain
                                                        :disabled="show"
                                                        @click="handleCreate(scope.$index, scope.row)">保存
                                                </el-button>
                                                <el-button
                                                        v-else
                                                        size="mini"
                                                        type="danger"
                                                        plain
                                                        :disabled="show"
                                                        @click="handleDelete(scope.$index, scope.row)"
                                                        icon="el-icon-delete">
                                                </el-button>
                                            </template>
                                        </el-table-column>

                                    </el-table>
                                </el-main>

                                <el-footer>
                                    {{--分页--}}
                                    <el-pagination
                                            style="display: inline-block;line-height: 30px;margin-right: 20px;"
                                            layout="total,prev, pager, next"
                                            :total="total"
                                            background>
                                    </el-pagination>

                                    {{--新增按钮--}}
                                    <el-button
                                            style="display: inline-block;float: right;margin-top: 14px;"
                                            type="primary"
                                            @click="createContact"
                                            :loading="btnLoading"
                                            icon="el-icon-plus"
                                            :disabled="show"
                                            size="small">新增记录或备注
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                    </el-tabs>
                </el-col>
            </el-row>
        </template>
        <form name="submitForm"
              action="{{ isset($talent) && $talent ? route('admin.talent.update', ['id' => $talent->id]) :  route('admin.talent.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($talent) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="name">
            <input type="text" name="major">
            <input type="text" name="phone">
            <input type="text" name="if_contact">
            <input type="text" name="if_resume">
            <input type="text" name="if_contact_com">
            <input type="text" name="resume_url">
            <input type="text" name="school">
            <input type="text" name="email">
        </form>
    </div>
    <style>
        .el-header {
            height: 80px;
        }

        .el-footer {
            background-color: rgb(247, 247, 247);
            line-height: 60px;
        }

        input[type=file] {
            display: none;
        }

    </style>
    <script>
        let talentEdit = new Vue({
            el: '#talentEdit',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                form: {!! isset($talent)? $talent:'{}' !!},
                loading: true,
                btnLoading: false,
                contacts: [],
                contactName: '',
                contactContent: '',
                total: 1000,
                jobTotal: 1000,
                currentPage: 1,
                jobCurrentPage: 1,
                pagesize: 10,
                resume: [],
                show: '{!! $show !!}' == '1' ? true : false,
                wantedJob : [],
            },
            compute: {
                //
            },
            methods: {
                //感兴趣职位翻页
                jobPageChange(val)
                {
                    this.jobCurrentPage = val;
                },
                //删除简历文件
                removeFile() {
                    this.resume = [];
                },
                //预览上传文件
                showUploadFile(file) {
                    window.open(this.resume[0].url);
                },
                // 上传简历回调
                upLoadResume(res, file) {
                    this.resume = [];
                    this.resume[0] = {name: '简历', url: res.result};
                },
                //创建按钮
                createContact() {
                    this.contacts.push([]);
                },
                //增加联系记录
                handleCreate(index, row) {
                    let id = this.form.id;
                    let name = row.name;
                    let content = row.content;
                    this.$confirm('确定要新增此条记录?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning',
                        center: true
                    }).then(() => {
                        this.loading = true;
                        //请求服务器
                        axios.get("/api/createContact", {
                            params: {
                                id: id,
                                name: name,
                                content: content,
                            },
                        }).then(res => {
                            this.contacts = res.data.contacts;
                            this.$notify({
                                title: res.data.result,
                                message: res.data.msg,
                                type: res.data.result
                            });
                            this.loading = false;
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
                //删除联系记录
                handleDelete(index, row) {
                    this.$confirm('确定要删除此条记录?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning',
                        center: true
                    }).then(() => {
                        this.loading = true;
                        //请求服务器
                        axios.get("/api/delContactInfo", {
                            params: {
                                id: row.id
                            },
                        }).then(res => {
                            this.contacts = res.data.contacts;
                            this.$notify({
                                title: res.data.result,
                                message: res.data.msg,
                                type: res.data.result
                            });
                            this.loading = false;
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
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    $('input[name^=name]').val(this.form.name);
                    $('input[name^=major]').val(this.form.major);
                    $('input[name^=phone]').val(this.form.phone);
                    $('input[name^=if_contact]').val(this.form.if_contact);
                    if (this.resume.length > 0) {
                        $('input[name^=resume_url]').val(this.resume[0].url);
                        $('input[name^=if_resume]').val('1');
                    } else {
                        $('input[name^=resume_url]').val(null);
                        $('input[name^=if_resume]').val('0');
                    }
                    $('input[name^=if_contact_com]').val(this.form.if_contact_com);
                    $('input[name^=school]').val(this.form.school);
                    $('input[name^=email]').val(this.form.email);
                    document.forms['submitForm'].submit();
                },
            },
            created: function () {
                this.contacts = this.form.contacts;
                this.wantedJob = this.form.wanted_job;
            },
            mounted: function () {
                this.loading = false;

                this.total = this.contacts.length;
                this.jobTotal = this.wantedJob ? this.wantedJob.length : 0 ;

                if (this.form.resume_url) {
                    this.resume.push({name: '简历文件', url: this.form.resume_url});
                };
                //console.log(this.wantedJob);
            },
            destroy: function () {
                //
            }
        })
    </script>
@endsection