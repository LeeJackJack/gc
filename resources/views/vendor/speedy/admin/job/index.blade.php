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
                            <form id="search_form" action="{{ route('admin.job.index')}}">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <!-- 职位关键字 -->
                                        <span for="" class="input-group-addon">请输入职位关键字：</span>
                                        <input id="job_name" class="form-control" name="job_name"
                                               placeholder="名称..." value="{{isset($job_name) ? $job_name : ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-success" type="button" onclick="event.preventDefault();
                    document.getElementById('search_form').submit();">搜索
                                    </button>
                                </div>
                            </form>
                            <form id="refresh_job_order_id" action="{{ route('admin.job.index')}}">
                                <div class="col-sm-4" style="text-align: right;">
                                    <button type="button" class="btn btn-info" aria-label="Left Align" onclick="event.preventDefault();
                    document.getElementById('refresh_job_order_id').submit();">
                                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"> 刷新职位排序</span>
                                        <input id="refresh_job_order_id" class="form-control"
                                               name="refresh_job_order_id"
                                               value="true" type="hidden">
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
                        <a href="{{ route('admin.job.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.job.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.job.title') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.job.com') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.job.industry') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.job.salary') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.job.hire_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.job.reward') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.job.sp') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td style="vertical-align: middle;">{{ $job->title }}</td>
                                <td style="vertical-align: middle;">{{ $job->belongsToCompany->name}}</td>
                                <td style="vertical-align: middle;">{{ $job->belongsToIndustry->label}}</td>
                                <td style="vertical-align: middle;">{{ $job->salary}}</td>
                                <td style="vertical-align: middle;">{{ $job->hire_count}}</td>
                                <td style="vertical-align: middle;">{{ $job->reward}}</td>
                                <td style="vertical-align: middle;">{{ $job->sp_jg != null ? $job->sp_jg == '1' ? '通过' : '拒绝' : '未审批' }}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('admin.job.show', ['id' => $job->ids , 'job_name' => $job_name ]) }}">{{ trans('view.admin.public.show') }}</a>
                                    <a class="btn btn-warning btn-sm"
                                       href="{{ route('admin.job.edit', ['id' => $job->ids , 'job_name' => $job_name ]) }}">{{ trans('view.admin.public.edit') }}</a>
                                    <a class="btn btn-danger btn-sm"
                                       href="javascript:;"
                                       onclick="document.getElementById('delete-form').action = '{{ route('admin.job.index') . "/{$job->ids}" }}'"
                                       data-toggle="modal"
                                       data-target="#deleteModal">{{ trans('view.admin.public.destroy') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ method_exists($jobs,'appends') ? $jobs->appends([
                        'job_name' => $job_name,
                    ])->links() : '' }}</div>
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
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.job.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.job.sure_to_delete') }}</p>
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