@extends('vendor.speedy.layouts.app')

@section('content')
    @include('flash::message')
    <div id="placeEdit">
        <template>
            <el-row v-loading="loading" :gutter="0">
                <el-col :span="16" :offset="4">
                            <el-container>
                                <el-header>
                                    <el-alert
                                            title="您正在编辑景点内容，请完整填写下列表单内容"
                                            type="info"
                                            center
                                            show-icon
                                            :closable="false">
                                    </el-alert>
                                </el-header>
                                <el-main>
                                    <el-col :span="20" :offset="2">
                                        <el-form ref="form" :model="form" label-width="170px" label-position="left"
                                                 name="edit"
                                                 size="medium">
                                            <el-form-item
                                                    label="景点名称"
                                                    prop="name"
                                                    :rules="[{ required: true, message: '请输入景点名称' },]">
                                                <el-input v-model="form.name" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                    label="景点封面"
                                                    :rules="[{ required: true, message: '' },]">
                                                <el-upload
                                                        class="pic-uploader"
                                                        action="/api/upLoadPlacePic/"
                                                        :show-file-list="false"
                                                        :on-success="upLoadPlacePic"
                                                        :headers="{'X-CSRF-TOKEN':csrfToken}">
                                                    <img :src="pic" class="pic" v-show="pic">
                                                    <i v-if="!pic" class="el-icon-plus avatar-uploader-icon"></i>
                                                </el-upload>
                                            </el-form-item>

                                            <el-form-item
                                                label="正常状态icon"
                                                :rules="[{ required: true, message: '' },]">
                                                <el-upload
                                                    class="avatar-uploader"
                                                    action="/api/upLoadPlaceIcon/"
                                                    :show-file-list="false"
                                                    :on-success="upLoadPlaceIcon"
                                                    :headers="{'X-CSRF-TOKEN':csrfToken}">
                                                    <img :src="icon" class="avatar" v-show="icon">
                                                    <i v-if="!icon" class="el-icon-plus avatar-uploader-icon"></i>
                                                </el-upload>
                                            </el-form-item>

                                            <el-form-item
                                                label="选中状态icon"
                                                :rules="[{ required: true, message: '' },]">
                                                <el-upload
                                                    class="avatar-uploader"
                                                    action="/api/upLoadPlaceIconSelect/"
                                                    :show-file-list="false"
                                                    :on-success="upLoadPlaceIconSelect"
                                                    :headers="{'X-CSRF-TOKEN':csrfToken}">
                                                    <img :src="icon_select" class="avatar" v-show="icon_select">
                                                    <i v-if="!icon_select" class="el-icon-plus avatar-uploader-icon"></i>
                                                </el-upload>
                                            </el-form-item>

                                            <el-form-item
                                                label="路线icon"
                                                :rules="[{ required: true, message: '' },]">
                                                <el-upload
                                                    class="avatar-uploader"
                                                    action="/api/upLoadPlaceIllustrator/"
                                                    :show-file-list="false"
                                                    :on-success="upLoadPlaceIllustrator"
                                                    :headers="{'X-CSRF-TOKEN':csrfToken}">
                                                    <img :src="illustrator" class="avatar" v-show="illustrator">
                                                    <i v-if="!illustrator" class="el-icon-plus avatar-uploader-icon"></i>
                                                </el-upload>
                                            </el-form-item>

                                            <el-form-item
                                                label="景点门票"
                                                prop="ticket"
                                                :rules="[{ required: true, message: '请输入景点门票' },]">
                                                <el-input v-model="form.ticket" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                label="景点级别"
                                                prop="level"
                                                :rules="[{ required: true, message: '请输入景点级别' },]">
                                                <el-input v-model="form.level" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                label="标签1"
                                                prop="tag_first"
                                                :rules="[{ required: true, message: '请输入景点标签' },]">
                                                <el-input v-model="form.tag_first" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                label="标签2"
                                                prop="tag_second"
                                                :rules="[{ required: true, message: '请输入景点标签' },]">
                                                <el-input v-model="form.tag_second" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                label="开放时间"
                                                prop="business_hour"
                                                :rules="[{ required: true, message: '请输入景点开放时间' },]">
                                                <el-input v-model="form.business_hour" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                label="景点地址"
                                                prop="address"
                                                :rules="[{ required: true, message: '请输入景点地址' },]">
                                                <el-input v-model="form.address" class="el-input"></el-input>
                                            </el-form-item>

                                            <el-form-item
                                                label="介绍"
                                                prop="introduction"
                                                :rules="[{ required: true, message: '如：景点介绍等...' },]">
                                                <el-input v-model="form.introduction" rows="18"
                                                          type="textarea"
                                                          class="el-input"
                                                          placeholder="景点介绍等..."></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                label="标记经度"
                                                :rules="[{ required: true, message: '请在地图选择点位' },]">
                                                <el-input v-model="latitude" class="el-input"></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                label="标记纬度"
                                                :rules="[{ required: true, message: '请在地图选择点位' },]">
                                                <el-input v-model="longitude" class="el-input"></el-input>
                                            </el-form-item>
                                        </el-form>
                                        <div id="mapIndex" class="map"></div>
                                    </el-col>
                                </el-main>
                                <el-footer style="text-align: right;">
                                    <el-button
                                            plain
                                            type="primary"
                                            @click="onSubmit"
                                            size="small">保存
                                    </el-button>
                                </el-footer>
                            </el-container>
                </el-col>
            </el-row>
        </template>
        <form name="submitForm"
              action="{{ isset($place) && $place ? route('admin.place.update', ['id' => $place->id]) :  route('admin.place.store') }}"
              style="display: none"
              method="post">
            {{ csrf_field() }}
            {{ isset($place) ? method_field('PUT') : method_field('POST') }}
            <input type="text" name="name">
            <input type="text" name="ticket">
            <input type="text" name="level">
            <input type="text" name="tag_first">
            <input type="text" name="tag_second">
            <input type="text" name="pic">
            <input type="text" name="icon">
            <input type="text" name="icon_select">
            <input type="text" name="illustrator">
            <input type="text" name="longitude">
            <input type="text" name="latitude">
            <input type="text" name="business_hour">
            <input type="text" name="introduction">
            <input type="text" name="address">
        </form>
    </div>
    <style>
        .el-header {
            height: 80px;
        }

        .el-footer {
            background-color: rgb(247, 247, 247);
            line-height: 60px;
        }

        .avatar-uploader .el-upload {
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 80px;
            height: 80px;
        }

        .pic-uploader {
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 312px;
            height: 178px;
        }

        .pic{
            width: 312px;
            height: 178px;
            display: block;
        }

        .avatar-uploader .el-upload:hover {
            border-color: #409EFF;
        }

        .avatar-uploader-icon {
            font-size: 28px;
            color: #8c939d;
            width: 80px;
            height: 80px;
            line-height: 80px;
            text-align: center;
        }

        .avatar {
            width: 80px;
            height: 80px;
            display: block;
        }

    </style>
    {{--  引入腾讯地图  --}}
    <script src="https://map.qq.com/api/gljs?v=1.exp&key=	VLIBZ-KLFCV-PD3PJ-USOHR-O6T3V-RDBIW"></script>
    <script>
        let placeEdit = new Vue({
            el: '#placeEdit',
            data: {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                form: {!! isset($place)? $place:'{}' !!},
                loading: true,
                markerLayer:{},
                map:{},
                pic: '',
                icon:'',
                icon_select:'',
                illustrator:'',
                marker:[],
                latitude:0,
                longitude:0,
            },
            compute: {
                //
            },
            methods: {
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
                    let marker = [];
                    if (this.form.latitude)
                    {
                        marker.push({
                            "id": 'marker',
                            "styleId": "marker",
                            "position": new TMap.LatLng(_this.form.latitude, _this.form.longitude),
                        })
                    }

                    _this.marker = marker;

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
                        geometries:marker,
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
                addMarkers:function (evt)
                {
                    let lat = evt.latLng.getLat().toFixed(6);
                    let lng = evt.latLng.getLng().toFixed(6);
                    this.markerLayer.updateGeometries({
                        position: evt.latLng,
                        styleId: "marker",
                        id:'marker'
                    });
                    this.markers = this.markerLayer.getGeometries();
                    this.latitude = lat;
                    this.longitude = lng;
                    this.form.latitude = lat;
                    this.form.longitude = lng;
                    console.log(this.form);
                },
                // 上传pic回调
                upLoadPlacePic(res, file) {
                    this.pic = res.result;
                },
                // 上传icon回调
                upLoadPlaceIcon(res, file) {
                    this.icon = res.result;
                },
                // 上传icon_select回调
                upLoadPlaceIconSelect(res, file) {
                    this.icon_select = res.result;
                },
                // 上传illustrator回调
                upLoadPlaceIllustrator(res, file) {
                    this.illustrator = res.result;
                },
                //提交资料
                onSubmit() {
                    let _this = this;
                    _this.$refs['form'].validate((valid) => {
                        if (valid) {
                            this.loading = true;
                            $('input[name^=name]').val(this.form.name);
                            $('input[name^=ticket]').val(this.form.ticket);
                            $('input[name^=level]').val(this.form.level);
                            $('input[name^=tag_first]').val(this.form.tag_first);
                            $('input[name^=tag_second]').val(this.form.tag_second);
                            $('input[name^=pic]').val(this.pic);
                            $('input[name^=illustrator]').val(this.illustrator);
                            $('input[name^=icon]').val(this.icon);
                            $('input[name^=icon_select]').val(this.icon_select);
                            $('input[name^=longitude]').val(this.form.longitude);
                            $('input[name^=latitude]').val(this.form.latitude);
                            $('input[name^=business_hour]').val(this.form.business_hour);
                            $('input[name^=introduction]').val(this.form.introduction);
                            $('input[name^=address]').val(this.form.address);
                            document.forms['submitForm'].submit();
                        } else {
                            _this.$notify({
                                title: '错误',
                                message: '请填写完成表单',
                                type: 'danger'
                            });
                            return false;
                        }
                    });

                },
            },
            created: function () {
                //
            },
            mounted: function () {
                this.initMap();
                this.loading = false;
                this.pic = this.form.pic;
                this.icon = this.form.icon;
                this.icon_select = this.form.icon_select;
                this.illustrator = this.form.illustrator;
                this.longitude = this.form.longitude;
                this.latitude = this.form.latitude;
                // console.log();
            },
            destroy: function () {
                //
            }
        });
    </script>
@endsection
