@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="jobEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-reading"></i> 基本信息</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑职位信息，请填写下列表单内容"
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
                                                    label="职位名称"
                                                    prop="title"
                                                    :rules="[{ required: true, message: '请输入职位名称...' },]">
                                                <el-input v-model="form.title" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="职位薪酬"
                                                    prop="salary"
                                                    :rules="[{ required: true, message: '请输入职位薪酬...' },]">
                                                <el-input v-model="form.salary" class="el-input" style="width: 220px;"
                                                          placeholder="如：25K/月"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="招聘人数"
                                                    prop="hire_count"
                                                    :rules="[{ required: true, message: '请输入招聘人数...' },]">
                                                <el-input v-model="form.hire_count" class="el-input"
                                                          style="width: 220px;" placeholder="如：1，2等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="伯乐奖金"
                                                    prop="reward"
                                                    :rules="[{ required: true, message: '请输入推荐成功所得奖金...' },]">
                                                <el-input v-model="form.reward" class="el-input"
                                                          style="width: 220px;" placeholder="如：10K等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="学历要求"
                                                    prop="education"
                                                    :rules="[{ required: true, message: '请输入学历...' },]">
                                                <el-input v-model="form.education" class="el-input"
                                                          style="width: 220px;" placeholder="如：本科、博士等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="职位经验"
                                                    prop="experience"
                                                    :rules="[{ required: true, message: '请输入所需工作经验...' },]">
                                                <el-input v-model="form.experience" class="el-input"
                                                          placeholder="如：有科研能力、有工作经验、不限等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="专业要求"
                                                    prop="type"
                                                    :rules="[{ required: true, message: '请输入专业要求...' },]">
                                                <el-input v-model="form.type" class="el-input"
                                                          type="textarea"
                                                          :rows="4"
                                                          placeholder="如：材料学，建筑学等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="行业"
                                                    prop="industry"
                                                    :rules="[{ required: true, message: '请选择行业' },]">
                                                <el-select
                                                        value-key="code"
                                                        v-model="form.industry"
                                                        placeholder="请选择行业"
                                                        clearable>
                                                    <el-option
                                                            v-for="item in industries"
                                                            :key="item.ids"
                                                            :label="item.label"
                                                            :value="item.code">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                            <el-form-item
                                                    label="城市"
                                                    prop="city_code"
                                                    :rules="[{ required: true, message: '如：广州市...' },]">
                                                <el-cascader
                                                        :options="provinces"
                                                        :props="{ children: 'city','value':'code','label':'label','emitPath':false }"
                                                        v-model="form.city_code">
                                                </el-cascader>
                                            </el-form-item>

                                            <el-form-item
                                                    label="地址"
                                                    prop="address"
                                                    :rules="[{ required: true, message: '请输入上班地址...' },]">
                                                <el-input v-model="form.address" class="el-input"
                                                          placeholder="如无请直接输入具体城市..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="排序号"
                                                    prop="order_id"
                                                    :rules="[{ required: true, message: '排序号越大，显示优先级越高...' },]">
                                                <el-input v-model="form.order_id" class="el-input"
                                                          placeholder="排序号越大，显示优先级越高..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="企业"
                                                    prop="com_ids"
                                                    :rules="[{ required: true, message: '请选择所属企业' },]">
                                                <el-select
                                                        v-model="form.com_ids"
                                                        filterable
                                                        reserve-keyword
                                                        placeholder="请输入企业关键词"
                                                        style="width: 50%">
                                                    <el-option
                                                            v-for="item in companies"
                                                            :key="item.ids"
                                                            :label="item.name"
                                                            :value="item.ids">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            plain
                                            type="primary"
                                            @click="next"
                                            size="small">下一步
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="1">
                            <span slot="label"><i class="el-icon-data-analysis"></i> 职位介绍</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑职位内容，请填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    {{--富文本编辑器--}}
                                    <script id="job_ueditor" name="detail_rich_text" type="text/plain">{!! isset
                                    ($job->detail_rich_text) ? $job->detail_rich_text : '输入职位内容...'!!}</script>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            style="display: inline-block"
                                            plain
                                            type="primary"
                                            @click="forward"
                                            size="small">上一步
                                    </el-button>
                                    <el-button
                                            style="display: inline-block"
                                            type="primary"
                                            @click="onSubmit"
                                            :loading="btnLoading"
                                            size="small">提交
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                    </el-tabs>
                </el-col>
            </el-row>
        </template>
        <form name="submitForm"
              action="{{ isset($job) && $job ? route('admin.job.update', ['id' => $job->ids]) :  route('admin.job.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($job) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="title">
            <input type="text" name="salary">
            <input type="text" name="hire_count">
            <input type="text" name="reward">
            <input type="text" name="education">
            <input type="text" name="experience">
            <textarea type="text" name="type"></textarea>
            <input type="text" name="city">
            <input type="text" name="industry">
            <input type="text" name="address">
            <input type="text" name="order_id">
            <input type="text" name="com_name">
            <input type="text" name="detail_rich_text">
            <input type="text" name="search_name">
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

    </style>
    <script>
        let jobEdit = new Vue({
            el: '#jobEdit',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                form: {!! isset($job)? $job: "{title:'',salary:'',hire_count:'',reward:'',education:'',experience:'',
                type:'',city_code:'',industry:'',address:'',order_id:'',com_ids:''}" !!},
                loading: true,
                btnLoading: false,
                provinces: {!! $provinces !!},
                industries: {!! $industries !!},
                searchName: '{!! isset($searchName) ? $searchName:'' !!}',
                active: '0',
                config: {
                    initialFrameHeight: 400,
                },
                companies:{!! $companies !!},
                searchLoading: false,
            },
            compute: {
                //
            },
            methods: {
                //获取富文本编辑器内容
                getUEContent() {
                    return this.editor.getContent();
                },
                //下一步
                next() {
                    this.active = parseInt(this.active) + 1 + '';
                    if (parseInt(this.active) > 1) this.active = '0';
                },
                //上一步
                forward() {
                    this.active = parseInt(this.active) - 1 + '';
                    if (parseInt(this.active) < 0) this.active = '0';
                },
                //提交资料
                onSubmit() {
                    this.loading = true;
                    this.btnLoading = true;
                    this.$refs['form'].validate((valid) => {
                        if (valid) {
                            $('input[name^=title]').val(this.form.title);
                            $('input[name^=salary]').val(this.form.salary);
                            $('input[name^=hire_count]').val(this.form.hire_count);
                            $('input[name^=reward]').val(this.form.reward);
                            $('input[name^=education]').val(this.form.education);
                            $('input[name^=experience]').val(this.form.experience);
                            $('textarea[name^=type]').val(this.form.type);
                            $('input[name^=city]').val(this.form.city_code);
                            $('input[name^=industry]').val(this.form.industry);
                            $('input[name^=address]').val(this.form.address);
                            $('input[name^=order_id]').val(this.form.order_id);
                            $('input[name^=com_name]').val(this.form.com_ids);
                            $('input[name^=detail_rich_text]').val(this.getUEContent());
                            $('input[name^=search_name]').val(this.searchName);
                            document.forms['submitForm'].submit();
                        } else {
                            this.$message.error('请填写完整必填信息');
                            this.loading = false;
                            this.btnLoading = false;
                            return false;
                        }
                    });
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;

                //实例化富文本编辑器
                const _this = this;
                let content=$("#job_ueditor").html();
                _this.editor = UE.getEditor('job_ueditor', _this.config);

                this.editor.addListener("ready", function () {
                    _this.editor.setContent(content);
                    {{--_this.editor.setContent('{!! $job->detail_rich_text !!}');--}}
                    _this.editor.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                });
            },
            destroy: function () {
                this.editor.destroy();
            }
        });
    </script>
@endsection