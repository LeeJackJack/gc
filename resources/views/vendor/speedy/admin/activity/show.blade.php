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
                        <ul class="nav nav-pills" role="tablist">
                            <li id="activity_basic_nav" role="presentation" ><a
                                        href="#activity_basic_nav">{{trans('view.admin.activity.activity_basic')}}</a></li>
                            <li id="form_field_nav" role="presentation" class=""><a
                                        href="#form_field_nav">{{trans('view.admin.activity.form_field')}}</a></li>
                            <li id="activity_sign_up_nav" role="presentation" class="active"><a
                            href="#activity_sign_up_nav">{{trans('view.admin.activity.activity_sign_up')}}<span class="badge">
                                        {{count($sign_ups)}}
                                    </span></a></li>
                        </ul>
                    </div>
                        <div class="panel-body">
                            @include('vendor.speedy.admin.activity.show_sub_pages.activity_basic')
                            @include('vendor.speedy.admin.activity.show_sub_pages.form_field')
                            @include('vendor.speedy.admin.activity.show_sub_pages.activity_sign_up')
                        </div>
                        <div class="panel-footer">
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection