@extends('vendor.speedy.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ route('admin.role.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.role.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">#</th>
                            <th style="text-align: center">{{ trans('view.admin.role.name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.role.display_name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <th scope="row" style="text-align: center;">{{ $role->id }}</th>
                                <td style="vertical-align: middle;">{{ $role->name }}</td>
                                <td style="vertical-align: middle;">{{ $role->display_name }}</td>
                                <td style="vertical-align: middle;">{{ $role->created_at }}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm"
                                       href="{{ route('admin.role.edit', ['id' => $role->id]) }}">{{ trans('view.admin.public.edit') }}</a>
                                    <a class="btn btn-danger btn-sm"
                                       href="javascript:;"
                                       onclick="document.getElementById('delete-form').action = '{{ route('admin.role.index') . "/{$role->id}" }}'"
                                       data-toggle="modal"
                                       data-target="#deleteModal">{{ trans('view.admin.public.destroy') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.role.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.role.sure_to_delete') }}</p>
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