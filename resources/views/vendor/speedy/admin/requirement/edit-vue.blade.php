@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="requirementEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                    <el-tabs type="card" v-model="active">
                        <el-tab-pane name="0">
                            <span slot="label"><i class="el-icon-reading"></i> 企业信息</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑项目需求信息，请填写下列表单内容"
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
                                                    label="企业名称"
                                                    prop="company_name"
                                                    :rules="[{ required: true, message: '请输入企业名称...' },]">
                                                <el-input v-model="form.company_name" class="el-input"
                                                          placeholder="企业名称..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="所属行业"
                                                    prop="industry"
                                                    :rules="[{ required: true, message: '请输入所属行业...' },]">
                                                <el-input v-model="form.industry" class="el-input" style="width: 220px;"
                                                          placeholder="如：生物医药，智能制造等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="所在地"
                                                    prop="location"
                                                    :rules="[{ required: true, message: '请输入所在地...' },]">
                                                <el-input v-model="form.location" class="el-input"
                                                          style="width: 220px;" placeholder="如：广州，佛山等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="性质"
                                                    prop="property"
                                                    :rules="[{ required: true, message: '请输入性质...' },]">
                                                <el-input v-model="form.property" class="el-input"
                                                          style="width: 220px;" placeholder="如：事业单位，民营等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="类别"
                                                    prop="classification"
                                                    :rules="[{ required: true, message: '请输入类别...' },]">
                                                <el-input v-model="form.classification" class="el-input"
                                                          style="width: 220px;"
                                                          placeholder="如：康复治疗、网络安全等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="需求类型"
                                                    prop="type"
                                                    :rules="[{ required: true, message: '请选择需求类型' },]">
                                                <el-select
                                                        value-key="value"
                                                        v-model="form.type"
                                                        placeholder="请选择需求类型"
                                                        clearable>
                                                    <el-option
                                                            v-for="item in typeOptions"
                                                            :key="item.value"
                                                            :label="item.text"
                                                            :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                            <el-form-item
                                                    label="预计投入经费"
                                                    prop="budget"
                                                    :rules="[{ required: true, message: '请填写经费...' },]">
                                                <el-input v-model="form.budget" class="el-input"
                                                          placeholder="如：500万等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="科技项目需求（项）"
                                                    prop="requirement_number"
                                                    :rules="[{ required: true, message: '请填写需求量...' },]">
                                                <el-input v-model="form.requirement_number" class="el-input"
                                                          style="width: 220px;" placeholder="如：3、5等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="技术难题（项）"
                                                    prop="problem_number"
                                                    :rules="[{ required: true, message: '请填写难题量...' },]">
                                                <el-input v-model="form.problem_number" class="el-input"
                                                          style="width: 220px;" placeholder="如：3、5等..."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="介绍"
                                                    prop="com_intro"
                                                    :rules="[{ required: true, message: '如：企业介绍等...' },]">
                                                <el-input v-model="form.com_intro" rows="18" type="textarea"
                                                          name="introTextArea"
                                                          class="el-input" placeholder="企业介绍等..."></el-input>
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
                            <span slot="label"><i class="el-icon-user-solid"></i> 技术团队</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑团队内容，请填写下列表单内容"
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
                                                    label="企业人数"
                                                    prop="employee_number"
                                                    :rules="[{ required: true, message: '请输入企业人数...' },]">
                                                <el-input v-model="form.employee_number" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="管理人员人数"
                                                    prop="manager_number"
                                                    :rules="[{ required: true, message: '请输入管理人员人数...' },]">
                                                <el-input v-model="form.manager_number" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="高级职称人员人数"
                                                    prop="higher_class_number"
                                                    :rules="[{ required: true, message: '请输入高级职称人员人数...' },]">
                                                <el-input v-model="form.higher_class_number"
                                                          class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="中级职称人员人数"
                                                    prop="middle_class_number"
                                                    :rules="[{ required: true, message: '请输入中级职称人员人数...' },]">
                                                <el-input v-model="form.middle_class_number"
                                                          class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="初级职称及其他技术人员人数"
                                                    prop="junior_class_number"
                                                    :rules="[{ required: true, message: '请输入初级职称及其他技术人员人数...' },]">
                                                <el-input v-model="form.junior_class_number"
                                                          class="el-input"></el-input>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
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
                                            plain
                                            type="primary"
                                            @click="next"
                                            size="small">下一步
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="2">
                            <span slot="label"><i class="el-icon-bangzhu"></i> 合作方式及专利鉴定</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑合作方式，请填写下列表单内容"
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

                                            <el-form-item label="是否要求专利">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.patent"
                                                        active-text="是"
                                                        inactive-text="否">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item label="是否要求鉴定">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.appraise"
                                                        active-text="是"
                                                        inactive-text="否">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item label="是否引进成果">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.introduce"
                                                        active-text="是"
                                                        inactive-text="否">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item label="是否合作开发">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.cooperate"
                                                        active-text="是"
                                                        inactive-text="否">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item label="是否委托开发">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.entrust"
                                                        active-text="是"
                                                        inactive-text="否">
                                                </el-switch>
                                            </el-form-item>

                                            <el-form-item label="是否其他方式方式">
                                                <el-switch
                                                        active-value="1"
                                                        inactive-value="0"
                                                        v-model="form.other"
                                                        active-text="是"
                                                        inactive-text="否">
                                                </el-switch>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
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
                                            plain
                                            type="primary"
                                            @click="next"
                                            size="small">下一步
                                    </el-button>
                                </el-footer>
                            </el-container>
                        </el-tab-pane>

                        <el-tab-pane name="3">
                            <span slot="label"><i class="el-icon-tickets"></i> 需求项目名称、内容及要求达到技术指标</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑需求内容，请填写下列表单内容"
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
                                                    label="需求项目名称、内容及要求达到技术指标"
                                                    prop="detail"
                                                    :rules="[{ required: true, message: '如：需求详情内容等...' },]">
                                                <el-input v-model="form.detail" rows="18" type="textarea"
                                                          name="detailTextArea"
                                                          class="el-input" placeholder="需求详细内容..
                                                          ."></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="其他要求"
                                                    prop="more">
                                                <el-input v-model="form.more" rows="18" type="textarea"
                                                          name="moreTextArea"
                                                          class="el-input" placeholder="其他额外内容..
                                                          ."></el-input>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
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
                                            plain
                                            type="primary"
                                            @click="next"
                                            size="small">下一步
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

                        <el-tab-pane name="4">
                            <span slot="label"><i class="el-icon-phone"></i> 联系方式</span>
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑联系方式，请填写下列表单内容"
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
                                                    label="联系人"
                                                    prop="contact"
                                                    :rules="[{ required: true, message: '请输入联系人...' },]">
                                                <el-input v-model="form.contact"
                                                          class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="联系电话"
                                                    prop="phone"
                                                    :rules="[{ required: true, message: '请输入联系电话...' },]">
                                                <el-input v-model="form.phone"
                                                          class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="邮箱"
                                                    prop="email">
                                                <el-input v-model="form.email"
                                                          class="el-input" placeholder="请输入邮箱..."></el-input>
                                            </el-form-item>

                                        </el-form>
                                    </el-col>
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
              action="{{ isset($requirement) && $requirement ? route('admin.requirement.update', ['id' => $requirement->id]) :  route('admin.requirement.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($requirement) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="company_name">
            <input type="text" name="industry">
            <input type="text" name="location">
            <input type="text" name="property">
            <input type="text" name="employee_number">
            <input type="text" name="manager_number">
            <input type="text" name="higher_class_number">
            <input type="text" name="middle_class_number">
            <input type="text" name="junior_class_number">
            <input type="text" name="type">
            <input type="text" name="classification">
            <input type="text" name="patent">
            <input type="text" name="appraise">
            <input type="text" name="introduce">
            <input type="text" name="cooperate">
            <input type="text" name="entrust">
            <input type="text" name="other">
            <input type="text" name="budget">
            <textarea type="text" name="more"></textarea>
            <textarea type="text" name="detail"></textarea>
            <input type="text" name="contact">
            <input type="text" name="phone">
            <input type="text" name="email">
            <textarea type="text" name="com_intro"></textarea>
            <input type="text" name="requirement_number">
            <input type="text" name="problem_number">
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
        let requirementEdit = new Vue({
            el: '#requirementEdit',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                form: {!! isset($requirement)? $requirement:'{}' !!},
                loading: true,
                btnLoading: false,
                active: '0',
                typeOptions: [{value: '1', text: '技术难题'}, {value: '0', text: '科技项目需求'}],
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
                    if (parseInt(this.active) > 4) this.active = '0';
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
                    $('input[name^=company_name]').val(this.form.company_name);
                    $('input[name^=industry]').val(this.form.industry);
                    $('input[name^=location]').val(this.form.location);
                    $('input[name^=property]').val(this.form.property);
                    $('input[name^=employee_number]').val(this.form.employee_number);
                    $('input[name^=manager_number]').val(this.form.manager_number);
                    $('input[name^=higher_class_number]').val(this.form.higher_class_number);
                    $('input[name^=middle_class_number]').val(this.form.middle_class_number);
                    $('input[name^=junior_class_number]').val(this.form.junior_class_number);
                    $('input[name^=type]').val(this.form.type);
                    $('input[name^=classification]').val(this.form.classification);
                    $('input[name^=patent]').val(this.form.patent);
                    $('input[name^=appraise]').val(this.form.appraise);
                    $('input[name^=introduce]').val(this.form.introduce);
                    $('input[name^=cooperate]').val(this.form.cooperate);
                    $('input[name^=entrust]').val(this.form.entrust);
                    $('input[name^=other]').val(this.form.other);
                    $('input[name^=budget]').val(this.form.budget);

                    let more = $('textarea[name^=moreTextArea]').val();
                    $('textarea[name^=more]').val(more);

                    let detail = $('textarea[name^=detailTextArea]').val();
                    $('textarea[name^=detail]').val(detail);

                    $('input[name^=contact]').val(this.form.contact);
                    $('input[name^=phone]').val(this.form.phone);
                    $('input[name^=email]').val(this.form.email);

                    let intro = $('textarea[name^=introTextArea]').val();
                    $('textarea[name^=com_intro]').val(intro);

                    $('input[name^=requirement_number]').val(this.form.requirement_number);
                    $('input[name^=problem_number]').val(this.form.problem_number);
                    document.forms['submitForm'].submit();
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
            },
            destroy: function () {
                //this.editor.destroy();
            }
        });
    </script>
@endsection