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
                            <h1>企业信息</h1>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li id="company_basic_nav" role="presentation" class="active"><a
                                        href="#company_basic_nav">{{trans('view.admin.company.company_basic')}}</a></li>
                            <li id="company_qr_code_nav" role="presentation"><a
                            href="#company_qr_code_nav">{{trans('view.admin.company.company_qr_code')}}</a></li>
                        </ul>
                    </div>
                        <div class="panel-body">
                            @include('vendor.speedy.admin.company.show_sub_pages.company_basic')
                            @include('vendor.speedy.admin.company.show_sub_pages.company_qr_code')
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection