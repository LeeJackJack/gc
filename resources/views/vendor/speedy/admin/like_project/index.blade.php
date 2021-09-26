@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="btn btn-info btn-sm">{{ trans('view.admin.like_project.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.like_project.name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.like_project.company') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.like_project.job') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.like_project.user_name') }}
                            <th style="text-align: center">{{ trans('view.admin.like_project.phone') }}
                            <th style="text-align: center">{{ trans('view.admin.like_project.project_name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.like_project.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.like_project.is_handle') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($likes as $like)
                            <tr>
                                <td style="vertical-align: middle;">{{ $like->name }}</td>
                                <td style="vertical-align: middle;">{{ $like->company}}</td>
                                <td style="vertical-align: middle;">{{ $like->job}}</td>
                                <td style="vertical-align: middle;">{{ $like->belongsToUser->name}}</td>
                                <td style="vertical-align: middle;">{{ $like->belongsToUser->phone}}</td>
                                <td style="vertical-align: middle;">{{ $like->belongsToProject->title}}</td>
                                <td style="vertical-align: middle;">{{ $like->created_at }}</td>
                                <td style="vertical-align: middle;">
                                    <form method="post" action="{{ route('admin.like_project.update',['id' => $like->id]) }}">
                                        {{ csrf_field() }}
                                        {{ isset($like) ? method_field('PUT') : '' }}
                                        <button class="{{ $like->is_handle ? 'btn btn-default' : 'btn btn-danger'}}" {{ $like->is_handle ? 'disabled':''}}
                                        type="submit">
                                            {{$like->is_handle ? '已联系' : '未联系'}}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $likes->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection