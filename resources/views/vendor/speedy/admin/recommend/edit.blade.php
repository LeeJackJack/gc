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
                            <li id="recommend_basic_nav" role="presentation" class="active"><a
                                        href="#recommend_basic_nav">{{trans('view.admin.recommend.recommend_basic')}}</a></li>
                            <li id="send_email_nav" role="presentation" class=""><a
                                        href="#send_email_nav">{{trans('view.admin.recommend.send_email')}}
                                    <span class="badge">{{$recommend->email_handle}}</span>
                                </a></li>
                            <li id="hint_control_nav" role="presentation" class=""><a
                                        href="#hint_control_nav">{{trans('view.admin.recommend.hint_control')}}</a></li>
                        </ul>
                    </div>
                    <form method="post" enctype="multipart/form-data"
                          action="{{ isset($recommend) ? route('admin.recommend.update',['id' => $recommend->ids]) :  route('admin.recommend.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($recommend) ? method_field('PUT') : '' }}
                            @include('vendor.speedy.admin.recommend.sub_pages.recommend_basic')
                            @include('vendor.speedy.admin.recommend.sub_pages.send_email')
                            @include('vendor.speedy.admin.recommend.sub_pages.hint_control')
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