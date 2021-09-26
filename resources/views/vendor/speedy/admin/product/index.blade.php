@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ route('admin.product.create') }}"
                           class="btn btn-info btn-sm">{{ trans('view.admin.public.create') .' '. trans('view.admin.product.title') }}</a>
                    </div>
                    <table class="table table-bordered table-hover" style="text-align: center;table-layout: fixed;">
                        <thead>
                        <tr class="active">
                            <th style="text-align: center">{{ trans('view.admin.product.name') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.pic') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.detail_pic') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.type') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.cx_intro') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.reading_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.support_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.comment_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.collection_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.share_count') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.is_recommend') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.order_id') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.product.sp') }}</th>
                            <th style="text-align: center">{{ trans('view.admin.public.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td style="vertical-align: middle;">{{ $product->title }}</td>
                                @if($product->pic)
                                    <td style="vertical-align: middle;"><img src="{{$product->pic}}" style="width: 80px;height: auto;border-radius: 5px;margin: 0 auto;">
                                    </td>
                                @else
                                    <td style="vertical-align: middle;">-</td>
                                @endif
                                @if($product->detail_pic)
                                    <td style="vertical-align: middle;"><img src="{{$product->detail_pic}}" style="width: 80px;height: auto;border-radius: 5px;margin: 0 auto;">
                                    </td>
                                @else
                                    <td style="vertical-align: middle;">-</td>
                                @endif
                                <td style="vertical-align: middle;">{{ $product->type_label}}</td>
                                <td style="vertical-align: middle;">{{ $product->cx_intro}}</td>
                                <td style="vertical-align: middle;">{{ $product->reading_count}}</td>
                                <td style="vertical-align: middle;">{{ $product->support_count}}</td>
                                <td style="vertical-align: middle;">{{ $product->comment_count}}</td>
                                <td style="vertical-align: middle;">{{ $product->collection_count}}</td>
                                <td style="vertical-align: middle;">{{ $product->share_count}}</td>
                                <td style="vertical-align: middle;">{{ $product->is_recommend ? $product->is_recommend : '-' }}</td>
                                <td style="vertical-align: middle;">{{ $product->order_id}}</td>
                                <td style="vertical-align: middle;">{{ $product->sp_jg != null ? $product->sp_jg == '1' ? '通过' : '拒绝' : '未审批' }}</td>
                                <td style="vertical-align: middle;">
                                    <a class="btn btn-warning btn-sm"
                                       href="{{ route('admin.product.edit', ['id' => $product->ids ]) }}">{{ trans('view.admin.public.edit') }}</a>
                                    <a class="btn btn-danger btn-sm"
                                       href="javascript:;"
                                       onclick="document.getElementById('delete-form').action = '{{ route('admin.product.index') . "/{$product->ids}" }}'"
                                       data-toggle="modal"
                                       data-target="#deleteModal">{{ trans('view.admin.public.destroy') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="panel-footer">{{ $products->links() }}</div>
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
                    <h4 class="modal-title">{{ trans('view.admin.public.destroy') . ' ' . trans('view.admin.product.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('view.admin.product.sure_to_delete') }}</p>
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