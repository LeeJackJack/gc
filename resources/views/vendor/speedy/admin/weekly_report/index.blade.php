@extends('vendor.speedy.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1>请选择生成报告日期</h1>
                    <form action="{{ route('admin.weekly_report.index')}}">
                        <p style="width: 40%;height: 40px;margin-top: 40px;">
                            <input id="date" class="form-control" name="date"
                                   placeholder="" value="{{isset($date) ? $date : ''}}" type="date" required="required">
                        </p>
                        <p style="color: grey;font-size: 16px;">如选择日期2019-04-19生成报告，则统计数据一周为2019-04-12至2019-04-18</p>
                        <p><button class="btn btn-primary btn-lg" type="submit">生成报告</button></p>
                    </form>
                </div>
                @if(isset($date))
                    @include('vendor.speedy.admin.weekly_report.sub_pages.user_data')
                    @include('vendor.speedy.admin.weekly_report.sub_pages.register_user_data')
                    @include('vendor.speedy.admin.weekly_report.sub_pages.jobs_data')
                    @include('vendor.speedy.admin.weekly_report.sub_pages.activity_data')
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
@endsection