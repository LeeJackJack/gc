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
                @include('vendor.speedy.partials.alert')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="page-header">
                            <h1>{{isset($service) ? trans('view.admin.public.edit') : trans('view.admin.public.create')}}
                                活动内容
                                <small>请填写以下内容，带<span style="color: red;">*</span>号项目为必填项...</small>
                            </h1>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li id="activity_basic_nav" role="presentation" class="active"><a
                                        href="#activity_basic_nav">{{trans('view.admin.activity.activity_basic')}}</a></li>
                            <li id="form_field_nav" role="presentation"><a
                                        href="#form_field_nav">{{trans('view.admin.activity.form_field')}}</a></li>
                        </ul>
                    </div>
                    <form method="post" enctype="multipart/form-data"
                          action="{{ isset($activity) ? route('admin.activity.update',['id' => $activity->ids]) :  route('admin.activity.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($activity) ? method_field('PUT') : '' }}
                            @include('vendor.speedy.admin.activity.sub_pages.activity_basic')
                            @include('vendor.speedy.admin.activity.sub_pages.form_field')
                        </div>
                        <div class="panel-footer">
                            <button type="submit"
                                    class="btn btn-success">{{ trans('view.admin.public.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection