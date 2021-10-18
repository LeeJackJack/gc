@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="mapContainer" class="container">
        <template>
            <el-tabs v-model="tab" type="card" closable @tab-click="changeTab" editable @edit="handleTabsEdit" v-loading.fullscreen.lock="loading">
                <el-tab-pane
                    v-for="(item, index) in data"
                    :key="item.id"
                    :label="item.name"
                    :name="String(item.id)">
                    <el-form ref="tour" :model="item" label-width="160px" label-position="left">
                        <el-form-item label="路线名称">
                            <el-input v-model="item.name" style="width: 300px"></el-input>
                        </el-form-item>
                        <el-form-item label="所需时间">
                            <el-input v-model="item.hour" style="width: 300px"></el-input>
                        </el-form-item>
                        <el-form-item label="路线距离">
                            <el-input v-model="item.distance" style="width: 300px"></el-input>
                        </el-form-item>
                        <el-form-item label="途径景点数">
                            <el-input v-model="item.spots" style="width: 300px"></el-input>
                        </el-form-item>
                        <el-form-item label="途径景点">
                            <el-checkbox-group v-model="item.route" @change="updateTag">
                                <el-checkbox v-for="p in places" :label="p.id" :key="p.id">@{{ p.name }}</el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                        <el-form-item label="途径景点顺序" scope="spotNames">
                            <el-tag v-for="s in spotNames" class="tagSpace">@{{ s.name }}</el-tag>
                        </el-form-item>
                        <el-form-item label="是否编辑路线(编辑路线将清空当前点位)">
                            <el-switch v-model="ifEditPolyline" @change="polylineChange">
                            </el-switch>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
            </el-tabs>
            <div id="mapIndex" class="map"></div>
            <div class="buttonGroup">
{{--                <el-button class="clearBtn" type="primary" @click="clearPolyline()">清除地图点</el-button>--}}
                <el-button class="saveBtn" icon="el-icon-upload" type="primary" @click="saveTour()">保存信息</el-button>
{{--                <el-button class="saveBtn" icon="el-icon-circle-plus" type="primary" >新增点位</el-button>--}}
            </div>
        </template>
    </div>
    <style>
        .el-header {
            background-color: rgb(247, 247, 247);
            color: #333;
            text-align: left;
            line-height: 60px;
        }

        .container
        {
            /*display: flex;*/
        }

        .map{
            margin: auto;
            width: 100%;
            height: 100%;
            padding: 0;
        }

        .buttonGroup
        {
            width: 20%;
            margin: 30px 0;
        }

        .clearBtn,.saveBtn{
            /*margin: 20px 0;*/
        }

        .tagSpace
        {
            margin: 0 5px;
        }
    </style>
    {{--  引入腾讯地图  --}}
    <script src="https://map.qq.com/api/gljs?v=1.exp&key=	VLIBZ-KLFCV-PD3PJ-USOHR-O6T3V-RDBIW"></script>
    <script>
        let mapIndex = new Vue({
            el: '#mapContainer',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                data:{!! $tours !!},
                places:{!! $places !!},
                loading: true,
                pl:[],
                markerLayer:{},
                map:{},
                tab:'1',
                selectTab:0,
                ifEditPolyline:false,
                markers:[],
                spotNames:[],
            },
            compute: {
                //
            },
            methods: {
                handleTabsEdit(targetName, action) {
                    let _this = this;
                    _this.loading = true;
                    if (action === 'add') {
                        let name = 'new'+_this.data.length;
                        _this.data.push({
                            distance: '',
                            hour: '',
                            name: name,
                            place: [],
                            polyline: [],
                            route: [],
                            spots: '',
                        });
                        _this.tab = name;
                        _this.selectTab = _this.data.length-1;
                        _this.loading = false;
                        // console.log(_this.data);
                    }
                    if (action === 'remove') {
                        if (this.data.length <= 1) {
                            this.$message.error('无法删除最后一条线路');
                        } else {
                            let data = _this.data;
                            for (let i = 0; i < data.length; i++) {
                                if (data[i].id == targetName)
                                {
                                    let id = data[i].id;
                                    axios.get("/api/deleteTour", {
                                        params: {
                                            id:id,
                                        }
                                    }).then(res => {
                                        _this.data = res.data.return;
                                        // console.log(res);
                                        _this.$notify({
                                            title: response.result,
                                            message: response.msg,
                                            type: response.result
                                        });
                                    }).catch(function (err) {
                                        //console.log(err);
                                    });
                                }
                            }
                        }
                        _this.loading = false;
                    }
                },
                changeTab:function (e)
                {
                    let _this = this;
                    _this.selectTab = e.index;
                    _this.setMarkers();
                    _this.updateTag(_this.data[_this.selectTab].route);

                },
                updateTag:function (e)
                {
                    let data = this.places;
                    let arr = [];
                    for (let i = 0; i < e.length; i++) {
                        for (let j = 0; j < data.length; j++) {
                            if (e[i] === data[j].id)
                            {
                                arr.push({
                                   id:e[i],
                                   name:data[j].name,
                                });
                            }
                        }
                    }
                    // console.log(e);
                    // console.log(arr);
                    this.spotNames = arr;
                },
                polylineChange:function ()
                {
                    let _this = this;
                    if (_this.ifEditPolyline)
                    {
                        _this.clearPolyline();
                    }else
                    {
                        _this.setMarkers();
                    }
                },
                clearPolyline:function(){
                    this.markerLayer.setGeometries([]);
                    this.pl = [];
                },
                saveTour:function (){
                    let _this = this;
                    _this.loading = true;
                    let form = _this.data[_this.selectTab];
                    let params = {};
                    let arr = [];

                    params.id = form.id;
                    params.name = form.name;
                    params.hour = form.hour;
                    params.spots = form.spots;
                    params.distance = form.distance;
                    params.route = JSON.stringify(form.route);

                    for (let i = 0; i < _this.markers.length; i++) {
                        arr.push({
                            lat:_this.markers[i].position.lat,
                            lng:_this.markers[i].position.lng,
                        })
                    };

                    params.polyline = JSON.stringify(arr);
                    // console.log(params);

                    axios.get("/api/saveTour", {
                        params: {
                            data:params,
                        }
                    }).then(res => {
                        _this.data = res.data.return;
                        let response = res.data;
                        _this.loading = false;
                        _this.$notify({
                            title: response.result,
                            message: response.msg,
                            type: response.result
                        });
                    }).catch(function (err) {
                        //console.log(err);
                    });
                },
                initMap:function (){
                    let _this = this;
                    //地图初始化函数，本例取名为init，开发者可根据实际情况定义
                    //定义地图中心点坐标
                    let center = new TMap.LatLng(24.913156, 118.585448)
                    //定义map变量，调用 TMap.Map() 构造函数创建地图
                    let map = new TMap.Map(document.getElementById('mapIndex'), {
                        center: center,//设置地图中心点坐标
                        zoom: 16,   //设置地图缩放级别
                        pitch: 0,  //设置俯仰角
                        rotation: 0 ,   //设置地图旋转角度
                        viewMode:'2D', //设置2D、3D
                        mapStyleId: 'style 1 map',
                    });

                    //初始化marker数据
                    _this.tab = String(_this.data[0].id);
                    let index = _this.selectTab;
                    let pl = _this.data[index].polyline;
                    let markers = [];
                    for (let i = 0; i < pl.length; i++) {
                        markers.push({
                            "id": i,
                            "styleId": "marker",
                            "position": new TMap.LatLng(pl[i].lat, pl[i].lng),
                        })
                    }
                    _this.markers = markers;

                    //初始化marker图层
                    let markerLayer = new TMap.MultiMarker({
                        id: 'marker-layer',
                        map: map,
                        styles: {
                            "marker": new TMap.MarkerStyle({
                                "width": 15,
                                "height": 15,
                                "opacity": 0.5,
                                "anchor": { x: 6, y: 6 },
                                "src": "https://guchenglvyou.oss-cn-shenzhen.aliyuncs.com/icon/circle%402x.png"
                            })},
                        geometries:markers,
                    });
                    _this.markerLayer = markerLayer;
                    //拾取鼠标点击经纬度
                    //绑定点击事件
                    map.on("click",function(evt){
                        _this.addMarkers(evt);
                    });
                    _this.map = map;
                    _this.loading = false;
                },
                setMarkers:function()
                {
                    let _this = this;
                    //初始化marker数据
                    _this.tab = String(_this.data[0].id);
                    let index = _this.selectTab;
                    let pl = _this.data[index].polyline;
                    let markers = [];
                    for (let i = 0; i < pl.length; i++) {
                        markers.push({
                            "id": i,
                            "styleId": "marker",
                            "position": new TMap.LatLng(pl[i].lat, pl[i].lng),
                        })
                    }
                    //更新marker图层
                    _this.markerLayer.setGeometries(markers);
                    _this.markers = markers;
                },
                addMarkers:function (evt)
                {
                    if(this.ifEditPolyline)
                    {
                        let lat = evt.latLng.getLat().toFixed(6);
                        let lng = evt.latLng.getLng().toFixed(6);
                        this.markerLayer.add({
                            position: evt.latLng,
                            styleId: "marker",
                        });
                        this.markers = this.markerLayer.getGeometries();
                        // console.log(this.markers);
                    }else
                    {
                        this.$message.error('如需编辑路线，请先开启路线编辑开关');
                    }
                },
                setPolyline:function (){
                    let _this = this;
                    //创建 MultiPolyline显示折线
                    let polylineLayer = new TMap.MultiPolyline({
                        id: 'polyline-layer', //图层唯一标识
                        map: _this.map,//绘制到目标地图
                        //折线样式定义
                        styles: {
                            'style_blue': new TMap.PolylineStyle({
                                'color': '#679E81', //线填充色
                                'width': 6, //折线宽度
                                'borderWidth': 2, //边线宽度
                                'borderColor': '#FFF', //边线颜色
                                'lineCap': 'round', //线端头方式
                            })
                        },
                        //折线数据定义
                        geometries: [
                            {
                                'id': 'pl_1',//折线唯一标识，删除时使用
                                'styleId': 'style_blue',//绑定样式名
                                'paths': _this.pl,
                            }
                        ]
                    });
                },
            },
            created: function () {
                //
            },
            mounted: function () {
                let _this = this;
                _this.initMap();
                _this.updateTag(_this.data[_this.selectTab].route);
                // console.log(_this.data);
            },
        });
    </script>
@endsection
