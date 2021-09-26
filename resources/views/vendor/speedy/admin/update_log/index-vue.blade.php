@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="updateLog">
        <el-row :gutter="0" v-loading="loading">
            <el-col :span="22" :offset=1>
                <el-container>
                    <el-header>
                        <el-button
                                   size="medium"
                                   type="primary"
                                   style="margin-right: 20px;"
                                   @click="handleCreate">创建
                            <i class="el-icon-upload el-icon--right"></i>
                        </el-button>
                    </el-header>
                    <el-main>
                        <el-timeline>
                            <el-timeline-item
                                    v-for="(log,index) in logs"
                                    :key="index"
                                    :timestamp="log.created_at.substring(0,10)"
                                    placement="top"
                                    color="rgb(66,87,178)"
                            >
                                <el-card>
                                    <p v-html="log.content"></p>
                                    <h5>
                                        <el-tag type="success"><i class="el-icon-user"></i> @{{ log.author }}</el-tag>
                                        提交于
                                        <el-tag type="primary"><i class="el-icon-date"></i>
                                            @{{ log.created_at }}
                                        </el-tag>
                                    </h5>
                                </el-card>
                            </el-timeline-item>
                        </el-timeline>
                    </el-main>
                    <el-footer>
                    </el-footer>
                </el-container>
            </el-col>
        </el-row>
    </div>
    <style>
        .el-header {
            background-color: rgb(247, 247, 247);
            color: #333;
            text-align: left;
            line-height: 60px;
        }

        .createBtn {
            margin: 50px;
        }

    </style>

    <script>
        let updateLog = new Vue({
            el: '#updateLog',
            data: {
                loading: true,
                logs: {!! $logs !!},
            },
            compute: {
                //
            },
            methods: {
                //创建按钮
                handleCreate() {
                    this.loading = true;
                    window.location.href = '{{ route('admin.update_log.create') }}';
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.loading = false;
            },
        });
    </script>
@endsection