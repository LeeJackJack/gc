@extends('vendor.speedy.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ route('admin.update_log.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.update_log.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center" width="20%" >{{ trans('view.admin.update_log.author') }}</th>
                            <th style="text-align: center" width="60%">{{ trans('view.admin.update_log.content') }}</th>
                            <th style="text-align: center" width="20%">{{ trans('view.admin.update_log.created_at') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td style="vertical-align: middle;">{{ $log->author }}</td>
                                <td style="vertical-align: middle;text-align: left;">{!! $log->content !!}</td>
                                <td style="vertical-align: middle;">{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $logs->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection