@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <button class="btn btn-info btn-sm">{{ trans('view.admin.recommend.title') }}</button>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.recommend.name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.major') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.school') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.job') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.company') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.user_name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.status') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.type') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.updated_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.recommend.is_pay') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recommends as $recommend)
                            <tr>
                                <td style="vertical-align: middle;">{{ $recommend->name }} <span
                                            class="label label-danger">{{ $recommend->is_handle == 0 ? 'new':'' }}</span>
                                </td>
                                <td style="vertical-align: middle;">{{ $recommend->major}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->school}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->belongsToJob->title}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->belongsToJob->belongsToCompany->name}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->belongsToUser->name}}</td>
                                @switch($recommend->status)
                                    @case('0')
                                    <td style="vertical-align: middle;">已接收</td>
                                    @break
                                    @case('1')
                                    <td style="vertical-align: middle;">面试中</td>
                                    @break
                                    @case('2')
                                    <td style="vertical-align: middle;">不匹配</td>
                                    @break
                                    @case('3')
                                    <td style="vertical-align: middle;">入职中</td>
                                    @break
                                    @case('4')
                                    <td style="vertical-align: middle;">入职成功</td>
                                    @break
                                @endswitch
                                <td style="vertical-align: middle;">{{ $recommend->type == 0 ? '自荐' : '推荐他人'}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->created_at}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->updated_at}}</td>
                                <td style="vertical-align: middle;">{{ $recommend->is_pay ? '已领取':'未领取'}}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-info"
                                       href="{{ route('admin.recommend.edit', ['id' => $recommend->ids ]) }}">
                                        操作
                                        @if($recommend->email_handle > 0)
                                            <span class="badge">{{$recommend->email_handle}}</span>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $recommends->links() }}</div>
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
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.recommend.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.recommend.sure_to_delete') }}</p>
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