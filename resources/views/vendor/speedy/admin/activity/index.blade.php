@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ route('admin.activity.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.activity.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.activity.name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.start_time') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.end_time') }}
                            <th style="text-align: center">{{ trans('view.admin.activity.sign_up_end_time') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.price') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.address') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.activity.sp') }}</th>
                            <th style="text-align: center" width="18%">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td style="vertical-align: middle;">{{ $activity->name }}</td>
                                <td style="vertical-align: middle;">{{ $activity->start_time}}</td>
                                <td style="vertical-align: middle;">{{ $activity->end_time}}</td>
                                <td style="vertical-align: middle;">{{ $activity->sign_up_end_time ? $activity->sign_up_end_time : '-' }}</td>
                                <td style="vertical-align: middle;">{{ $activity->price == 0 ? '免费':$activity->price . '元' }}</td>
                                <td style="vertical-align: middle;">{{ $activity->address}}</td>
                                <td style="vertical-align: middle;">{{ $activity->sp_jg != null ? $activity->sp_jg == '1' ? '通过' : '拒绝' : '未审批' }}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('admin.activity.show', ['id' => $activity->ids ]) }}">
                                        查看信息
                                        @if($activity->handle_count > 0)
                                            <span class="badge">{{$activity->handle_count}}</span>
                                        @endif
                                    </a>
                                    <a class="btn btn-warning btn-sm"
                                       href="{{ route('admin.activity.edit', ['id' => $activity->ids ]) }}">{{ trans('view.admin.public.edit') }}</a>
                                    <a class="btn btn-danger btn-sm"
                                       href="javascript:;"
                                       onclick="document.getElementById('delete-form').action = '{{ route('admin.activity.index') . "/{$activity->ids}" }}'"
                                       data-toggle="modal"
                                       data-target="#deleteModal">{{ trans('view.admin.public.destroy') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $activities->links() }}</div>
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
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.activity.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.activity.sure_to_delete') }}</p>
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