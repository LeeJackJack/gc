@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="btn btn-info btn-sm">{{ trans('view.admin.project.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.project.title') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.user') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.industry') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.maturity') }}
                            <th style="text-align: center">{{ trans('view.admin.project.cooperation') }}
                            <th style="text-align: center">{{ trans('view.admin.project.phone') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.view_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.like_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.created_at') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.project.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td style="vertical-align: middle;">{{ $project->title }}</td>
                                <td style="vertical-align: middle;">{{ $project->belongsToUser->name}}</td>
                                <td style="vertical-align: middle;">{{ $project->industry_label}}</td>
                                <td style="vertical-align: middle;">{{ $project->maturity_label}}</td>
                                <td style="vertical-align: middle;">{{ $project->cooperation_label}}</td>
                                <td style="vertical-align: middle;">{{ $project->belongsToUser->phone}}</td>
                                <td style="vertical-align: middle;">{{ $project->view_count}}</td>
                                <td style="vertical-align: middle;">{{ $project->like_count}}</td>
                                <td style="vertical-align: middle;">{{ $project->created_at }}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('admin.project.show', ['id' => $project->ids ]) }}">{{ trans('view.admin.public.show') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $projects->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection