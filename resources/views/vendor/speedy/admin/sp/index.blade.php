@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(count($sps) > 0)
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <a class="btn btn-info btn-sm">{{  trans('view.admin.sp.title') }}</a>
                        </div>
                        <table class="table table-bordered table-hover" style="text-align: center">
                            <thead>
                            <tr class="active">
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">{{ trans('view.admin.sp.name') }}</th>
                                <th style="text-align: center">{{ trans('view.admin.sp.create_time') }}</th>
                                <th style="text-align: center">{{ trans('view.admin.sp.type') }}</th>
                                <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sps as $sp)
                                <tr>
                                    <th scope="row" style="text-align: center;">#</th>
                                    <td style="vertical-align: middle;">{{ $sp->sp_title }}</td>
                                    <td style="vertical-align: middle;">{{ $sp->created_at }}</td>
                                    <td style="vertical-align: middle;">{{ $sp->from_kind == '1' ? '产品' : '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger"
                                                href="javascript:;"
                                                onclick="document.getElementById('delete-form').action = '{{ route('admin.sp.index') . "/{$sp->ids}.{$sp->from_kind}.reject" }}'"
                                                data-toggle="modal"
                                                data-target="#deleteModal">{{ trans('view.admin.public.sp_reject') }}</button>
                                        <a class="btn btn-success btn-sm"
                                           href="javascript:;"
                                           onclick="document.getElementById('delete-form').action = '{{ route('admin.sp.index') . "/{$sp->ids}.{$sp->from_kind}.pass" }}'"
                                           data-toggle="modal"
                                           data-target="#deleteModal">{{ trans('view.admin.public.sp_pass') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="panel-footer">{{ $sps->links() }}</div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div style="text-align: center;">
                        <img src="{{asset('pic/null_page.png')}}" alt=""
                             style="width: 40%;margin:  0 auto;">
                        </div>
                        <div style="text-align: center;">暂无内容...</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('view.admin.public.sp') . ' ' . trans('view.admin.sp.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.sp.sure_to_sp') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger"
                            data-dismiss="modal">{{ trans('view.admin.public.close') }}</button>
                    <button type="button" class="btn btn-info" onclick="event.preventDefault();
                    document.getElementById('delete-form').submit();">{{ trans('view.admin.public.submit') }}</button>
                    <form id="delete-form" action="" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection