@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="mapIndex">
{{--        <template>--}}
{{--            <form id="delete-form" action="" method="POST" style="display: none;">--}}
{{--                {{ csrf_field() }}--}}
{{--                {{ method_field('DELETE') }}--}}
{{--            </form>--}}
{{--        </template>--}}
    </div>

    <style>
        .el-header {
            background-color: rgb(247, 247, 247);
            color: #333;
            text-align: left;
            line-height: 60px;
        }
        #mapIndex{
            width: 80%;
            height: 500px;
        }
    </style>
    {{--  引入腾讯地图  --}}
    <script src="https://map.qq.com/api/gljs?v=1.exp&key=	VLIBZ-KLFCV-PD3PJ-USOHR-O6T3V-RDBIW"></script>
    <script>
        //地图初始化函数，本例取名为init，开发者可根据实际情况定义
        //定义地图中心点坐标
        var center = new TMap.LatLng(39.984120, 116.307484)
        //定义map变量，调用 TMap.Map() 构造函数创建地图
        var map = new TMap.Map(document.getElementById('mapIndex'), {
            center: center,//设置地图中心点坐标
            zoom: 17.2,   //设置地图缩放级别
            pitch: 43.5,  //设置俯仰角
            rotation: 45 ,   //设置地图旋转角度
            viewMode:'2D', //设置2D、3D
            mapStyleId: 'style 1 map',
        });

        //拾取鼠标点击经纬度
        //绑定点击事件
        map.on("click",function(evt){
            var lat = evt.latLng.getLat().toFixed(6);
            var lng = evt.latLng.getLng().toFixed(6);
            alert(lat + "," + lng) ;
        })
    </script>
@endsection
