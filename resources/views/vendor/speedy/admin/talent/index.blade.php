@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">搜索栏</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <form id="search_form" action="{{ route('admin.talent.index')}}">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <!-- 博士名称 -->
                                        <span for="" class="input-group-addon">请输入博士名称：</span>
                                        <input id="name" class="form-control" name="name"
                                               placeholder="名称..." value="{{isset($name) ? $name : ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <!-- 专业 -->
                                        <span for="" class="input-group-addon">请输入专业：</span>
                                        <input id="major" class="form-control" name="major"
                                               placeholder="专业..." value="{{isset($major) ? $major : ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <!-- 毕业学校 -->
                                        <span for="" class="input-group-addon">请输入毕业学校：</span>
                                        <input id="school" class="form-control" name="school"
                                               placeholder="毕业学校..." value="{{isset($school) ? $school : ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-info" type="button" onclick="event.preventDefault();
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
                        <a href="{{ route('admin.talent.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.talent.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center" width="8%">{{ trans('view.admin.talent.name') }}</th>
                            <th style="text-align: center" width="8%">{{ trans('view.admin.talent.major') }}
                            <th style="text-align: center" width="8%">{{ trans('view.admin.talent.school') }}</th>
                            <th style="text-align: center" width="8%">{{ trans('view.admin.talent.job_count') }}</th>
                            <th style="text-align: center" width="8%">{{ trans('view.admin.talent.is_contact') }}</th>
                            <th style="text-align: center" width="8%">{{ trans('view.admin.talent.is_resume') }}</th>
                            <th style="text-align: center"
                                width="8%">{{ trans('view.admin.talent.is_contact_com') }}</th>
                            <th style="text-align: center"
                                width="8%">{{ trans('view.admin.talent.contact_count') }}</th>
                            <th style="text-align: center"
                                width="8%">{{ trans('view.admin.talent.last_contact_user') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.talent.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($talents as $talent)
                            <tr>
                                <td style="vertical-align: middle;">{{ $talent->name }}</td>
                                <td style="vertical-align: middle;">{{ $talent->major}}</td>
                                <td style="vertical-align: middle;">{{ $talent->school}}</td>
                                <td style="vertical-align: middle;">{{ $talent->job_count}}</td>
                                <td style="vertical-align: middle;"><span
                                            class="{{ $talent->if_contact == 1 ? 'label label-success':'label label-light-gray'}}">{{ $talent->if_contact == 1 ? '已联系':'未联系'}}</span>
                                </td>
                                <td style="vertical-align: middle;"><span
                                            class="{{ $talent->if_resume == 1 ? 'label label-success':'label label-light-gray'}}">{{ $talent->if_resume == 1 ? '有简历':'无简历'}}</span>
                                </td>
                                <td style="vertical-align: middle;"><span
                                            class="{{ $talent->if_contact_com == 1 ? 'label label-success':'label label-light-gray'}}">{{ $talent->if_contact_com == 1 ? '已对接':'未对接'}}</span>
                                </td>
                                <td style="vertical-align: middle;">{{ $talent->hasManyContacts->count() }}</td>
                                <td style="vertical-align: middle;">{{ $talent->last_contact ? $talent->last_contact->name:'-' }}</td>
                                <td style="vertical-align: middle;">{{ $talent->created_at }}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('admin.talent.show', ['id' => $talent->id , 'name' => $name , 'major' => $major , 'school' => $school ]) }}">{{ trans('view.admin.public.show') }}</a>
                                    <a class="btn btn-warning btn-sm"
                                       href="{{ route('admin.talent.edit', ['id' => $talent->id , 'name' => $name , 'major' => $major , 'school' => $school ]) }}">{{ trans('view.admin.public.edit') }}</a>
                                    <a class="btn btn-danger btn-sm"
                                       href="javascript:;"
                                       onclick="document.getElementById('delete-form').action = '{{ route('admin.talent.index') . "/{$talent->id}" }}'"
                                       data-toggle="modal"
                                       data-target="#deleteModal">{{ trans('view.admin.public.destroy') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ method_exists($talents,'appends') ? $talents->appends([
                        'name' => $name ,
                        'major' => $major ,
                        'school' => $school
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
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.talent.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.talent.sure_to_delete') }}</p>
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