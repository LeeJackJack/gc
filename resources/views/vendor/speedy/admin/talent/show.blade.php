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
                            <h1>人才信息</h1>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li id="talent_basic_nav" role="presentation" class="active"><a
                                        href="#talent_basic_nav">{{trans('view.admin.talent.talent_basic')}}</a></li>
                            <li id="upload_resume_nav" role="presentation" class=""><a
                                        href="#upload_resume_nav">{{trans('view.admin.talent.upload_resume')}}</a></li>
                            <li id="talent_wanted_job_nav" role="presentation" class=""><a
                                        href="#talent_wanted_job_nav">{{trans('view.admin.talent.talent_wanted_job')}}
                                    <span class="badge">
                                        {{ !isset($talent->wanted_job) ? '0' : count($talent->wanted_job)}}
                                    </span></a>
                            </li>
                            <li id="talent_contact_nav" role="presentation" class=""><a
                                        href="#talent_contact_nav">{{trans('view.admin.talent.talent_contact_history')}}
                                    <span class="badge">
                                        {{ $talent->contacts == null ? '0':count($talent->contacts) }}
                                    </span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        @include('vendor.speedy.admin.talent.show_sub_pages.talent_basic')
                        @include('vendor.speedy.admin.talent.show_sub_pages.upload_resume')
                        @include('vendor.speedy.admin.talent.show_sub_pages.talent_wanted_job')
                        @include('vendor.speedy.admin.talent.show_sub_pages.talent_contact_history')
                    </div>
                    <div class="panel-footer" style="height:55px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection