@extends('vendor.speedy.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.speedy.partials.alert')
                <div class="panel panel-info">
                    <div class="panel-heading">{{ trans('view.admin.public.create') . ' ' . trans('view.admin.update_log.title') }}</div>
                    <form method="post" action="{{ route('admin.update_log.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($update_log) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label>{{ trans('view.admin.update_log.author') }}</label>
                                <input type="text" name="author" class="form-control" placeholder="{{ trans('view.admin.update_log.author') }}" value="">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('view.admin.update_log.content') }}</label>
                                <textarea type="text" name="content" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="panel-footer"><button type="submit" class="btn btn-success">{{ trans('view.admin.public.submit') }}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection