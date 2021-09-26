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
                            <h1>{{isset($company) ? trans('view.admin.public.edit') : trans('view.admin.public.create')}}
                                企业信息
                                <small>请填写以下内容，带<span style="color: red;">*</span>号项目为必填项...</small>
                            </h1>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li id="company_basic_nav" role="presentation" class="active"><a
                                        href="#company_basic_nav">{{trans('view.admin.company.company_basic')}}</a></li>
                            {{--<li id="cx_people_nav" role="presentation"><a--}}
                                        {{--href="#cx_people_nav">{{trans('view.admin.product.cx_people')}}</a></li>--}}
                            {{--<li id="cx_story_nav" role="presentation"><a--}}
                                        {{--href="#cx_story_nav">{{trans('view.admin.product.cx_story')}}</a></li>--}}
                            {{--<li id="cx_principle_nav" role="presentation"><a--}}
                                        {{--href="#cx_principle_nav">{{trans('view.admin.product.cx_principle')}}</a></li>--}}
                            {{--<li id="cx_tech_nav" role="presentation"><a--}}
                                        {{--href="#cx_tech_nav">{{trans('view.admin.product.cx_tech')}}</a></li>--}}
                        </ul>
                    </div>
                    <form method="post" enctype="multipart/form-data"
                          action="{{ isset($company) ? route('admin.company.update',['id' => $company->ids]) :  route('admin.company.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($company) ? method_field('PUT') : '' }}
                            @include('vendor.speedy.admin.company.sub_pages.company_basic')
                            {{--@include('vendor.speedy.admin.product.sub_pages.cx_people')--}}
                            {{--@include('vendor.speedy.admin.product.sub_pages.cx_story')--}}
                            {{--@include('vendor.speedy.admin.product.sub_pages.cx_principle')--}}
                            {{--@include('vendor.speedy.admin.product.sub_pages.cx_tech')--}}
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