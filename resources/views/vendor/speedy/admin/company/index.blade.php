@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">搜索栏</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <form id="search_form" action="{{ route('admin.company.index')}}">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <!-- 公司关键字 -->
                                        <span for="" class="input-group-addon">请输入公司关键字：</span>
                                        <input id="com_name" class="form-control" name="com_name"
                                               placeholder="名称..." value="{{isset($com_name) ? $com_name : ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-success" type="button" onclick="event.preventDefault();
                    document.getElementById('search_form').submit();">搜索
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ route('admin.company.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.company.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.company.name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.company.property') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.company.scale') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.company.type') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.company.is_ipo') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.company.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.company.updated_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td style="vertical-align: middle;">{{ $company->name }}</td>
                                <td style="vertical-align: middle;">{{ $company->property}}</td>
                                <td style="vertical-align: middle;">{{ $company->scale}}</td>
                                <td style="vertical-align: middle;">{{ $company->type}}</td>
                                <td style="vertical-align: middle;">{{ $company->is_ipo ? '已上市' : '未上市'}}</td>
                                <td style="vertical-align: middle;">{{ $company->created_at}}</td>
                                <td style="vertical-align: middle;">{{ $company->updated_at}}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('admin.company.show', ['id' => $company->ids ]) }}">{{ trans('view.admin.public.show') }}</a>
                                    <a class="btn btn-warning btn-sm"
                                       href="{{ route('admin.company.edit', ['id' => $company->ids ]) }}">{{ trans('view.admin.public.edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $companies->appends([
                        'com_name' => $com_name,
                    ])->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.company.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.company.sure_to_delete') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('view.admin.public.close') }}</button>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                    document.getElementById('delete-form').submit();">{{ trans('view.admin.public.destroy') }}</button>
                    <form id="delete-form" action="" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection