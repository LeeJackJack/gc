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
                            <h1>{{isset($talent) ? trans('view.admin.public.edit') : trans('view.admin.public.create')}}
                                人才信息
                                <small>请填写以下内容，带<span style="color: red;">*</span>号项目为必填项...</small>
                            </h1>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li id="talent_basic_nav" role="presentation" class="active"><a
                                        href="#talent_basic_nav">{{trans('view.admin.talent.talent_basic')}}</a></li>
                            <li id="upload_resume_nav" role="presentation" class=""><a
                                        href="#upload_resume_nav">{{trans('view.admin.talent.upload_resume')}}</a>
                            </li>
                            @if(isset($talent))
                                <li id="talent_contact_nav" role="presentation" class=""><a
                                            href="#talent_contact_nav">{{trans('view.admin.talent.talent_contact_history')}}
                                        <span class="badge">
                                        {{ $talent->contacts == null ? '0':count($talent->contacts) }}
                                    </span></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <form method="post" enctype="multipart/form-data"
                          action="{{ isset($talent) ? route('admin.talent.update',['id' => $talent->id]) :  route('admin.talent.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($talent) ? method_field('PUT') : '' }}
                            @include('vendor.speedy.admin.talent.sub_pages.talent_basic')
                            @include('vendor.speedy.admin.talent.sub_pages.upload_resume')
                            @if(isset($talent))
                                @include('vendor.speedy.admin.talent.sub_pages.talent_contact_history')
                            @endif
                        </div>
                        <div class="panel-footer" style="height:55px;">
                            <button type="submit"
                                    class="btn btn-info"
                                    style="float: right;">{{ trans('view.admin.public.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection