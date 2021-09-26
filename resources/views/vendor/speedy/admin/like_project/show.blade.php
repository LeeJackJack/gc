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
                            <h1>职位内容</h1>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li id="job_basic_nav" role="presentation" class="active"><a
                                        href="#job_basic_nav">{{trans('view.admin.job.job_basic')}}</a></li>
                            <li id="job_qr_code_nav" role="presentation"><a
                                        href="#job_qr_code_nav">{{trans('view.admin.job.job_qr_code')}}</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        @include('vendor.speedy.admin.job.show_sub_pages.job_basic')
                        @include('vendor.speedy.admin.job.show_sub_pages.job_qr_code')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection