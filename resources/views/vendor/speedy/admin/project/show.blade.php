@extends('vendor.speedy.layouts.app')

@section('content')
    <style>
        .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
            background-color: #00a0e8;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">项目内容</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-sm-6">
                                <!-- 标题 -->
                                <div class="input-group">
                                    <span for="" class="input-group-addon" style="text-align: left;">项目标题：</span>
                                    <input value="{{$project->title}}" name="title" type="text"
                                           class="form-control" id="title" placeholder="项目标题..." disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <!-- 分隔线 -->
                        <div class="col-sm-12" style="padding: 10px 0 ;">
                            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
                        </div>
                        <div class="col-md-12">
                            <!-- 用户 -->
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span for="" class="input-group-addon">用户：</span>
                                    <input value="{{ $project->belongsToUser->name }}" name="user" type="text"
                                           class="form-control" id="user" placeholder="用户..." disabled="disabled">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- 浏览数 -->
                                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">浏览数：</span>
                                    <input value="{{ $project->view_count }}" name="view_count"
                                           type="text"
                                           class="form-control" id="view_count" placeholder="浏览数..."
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- 感兴趣数 -->
                                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">感兴趣数：</span>
                                    <input value="{{ $project->like_count }}" name="like_count"
                                           type="text"
                                           class="form-control" id="like_count" placeholder="感兴趣数..."
                                           disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <!-- 分隔线 -->
                        <div class="col-sm-12" style="padding: 10px 0;">
                            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
                        </div>
                        <div class="col-md-12">
                            <!-- 技术领域 -->
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span for="" class="input-group-addon">技术领域：</span>
                                    <input value="{{ $project->industry_label }}" name="industry_label" type="text"
                                           class="form-control" id="industry_label" placeholder="技术领域..."
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- 技术成熟度 -->
                                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">技术成熟度：</span>
                                    <input value="{{ $project->maturity_label }}" name="maturity_label"
                                           type="text"
                                           class="form-control" id="maturity_label" placeholder="技术成熟度..."
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- 合作方式 -->
                                <div class="input-group">
            <span for="" class="input-group-addon"
                  style="text-align: left;">合作方式：</span>
                                    <input value="{{$project->cooperation_label}}" name="cooperation_label"
                                           type="text"
                                           class="form-control" id="cooperation_label" placeholder="合作方式..."
                                           disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <!-- 分隔线 -->
                        <div class="col-sm-12" style="padding: 10px 0;">
                            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <!-- 联系方式-->
                                    <span for="" class="input-group-addon">联系方式：</span>
                                    <input value="{{$project->belongsToUser->phone}}" name="phone"
                                           type="text"
                                           class="form-control" id="phone" placeholder="联系方式..." disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <!-- 分隔线 -->
                        <div class="col-sm-12" style="padding: 10px 0;">
                            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
                        </div>
                        <div class="col-md-12">
                            <!-- 描述 -->
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span for="" class="input-group-addon" style="text-align: left;">描述：</span>
                                    <textarea value="" name="description" type="text" rows="10"
                                              class="form-control" id="description" placeholder="描述..."
                                              disabled="disabled">{{ $project->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- 分隔线 -->
                        <div class="col-sm-12" style="padding: 10px 0;">
                            <hr style=" height:1px;border:none;border-top:1px solid #EDEDED;"/>
                        </div>
                        <div class="col-md-12">
                            <!-- 服务需求 -->
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span for="" class="input-group-addon" style="text-align: left;">服务需求：</span>
                                    <textarea value="" name="requirement" type="text" rows="10"
                                              class="form-control" id="requirement" placeholder="服务需求..."
                                              disabled="disabled">{{ $project->requirement }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection