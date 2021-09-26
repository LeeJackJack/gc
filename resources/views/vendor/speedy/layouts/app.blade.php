<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lindell') }}</title>

    <!-- Styles -->
    <link href="{{asset('bch_logo.ico')}}" rel="SHORTCUT ICON"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"--}}
    {{--integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"--}}
    {{--crossorigin="anonymous"></script>--}}
{{--    <script src="https://webapi.amap.com/loader.js"></script>--}}
    <script src="{{mix('/js/app.js')}}"></script>
</head>
<style>
    body {
        font-family: "PingFang SC", "Helvetica Neue", Helvetica, "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
        /*background-color: rgb(240,242,245);*/
        background-color: white;
    }

    .item {
        margin-top: 13px;
        margin-right: 30px;
        font-size: 10px;
    }

    .content-footer {
        margin-top: 50px;
    }

    .copy-right {
        text-align: center;
        color: rgba(0, 0, 0, 0.45);
        font-size: 14px;
    }

    .moving-line {
        -webkit-animation: page1TitleLine 3s ease-in-out 1.5s infinite;
        animation: page1TitleLine 3s ease-in-out 1.5s infinite;
        height: 100%;
        width: 64px;
        -webkit-transform: translateX(-64px);
        transform: translateX(-64px);
        background: -webkit-gradient(linear, left top, right top, from(rgba(24, 144, 255, 0)), to(#1890ff));
        background: linear-gradient(90deg, rgba(24, 144, 255, 0) 0, #1890ff);
    }

    @keyframes page1TitleLine {
        0%, 25% {
            -webkit-transform: translateX(-64px);
            transform: translateX(-64px);
        }
        75%, 100% {
            -webkit-transform: translateX(376px);
            transform: translateX(376px);
        }
    }

    .lineWrapper {
        height: 2px;
        width: 312px;
        margin: 24px auto 44px;
        overflow: hidden;
    }
</style>
<body>
@include('ueditor::head')
@include('vendor.speedy.layouts.loading')
<div id="app" style="display: flex;justify-content: flex-start;">
    <div style="width: auto;position: fixed;z-index: 999;">
        @include('vendor.speedy.partials.sidebar-vue')
    </div>
    <div id="mainContent" style="width: 100%;padding-left: 205px;">
        <div class="content-wrapper">
            <nav class="navbar navbar-default navbar-static-top" style="border-color: #ededed;">
                <div class="container">

                    <div class="collapse navbar-collapse" id="app-navbar-collapse" style="height: 53px !important;">
                        {{--面包屑--}}
                        <ul class="nav navbar-nav">
                            <div id="breadCrumb"
                                 style="height: 53px;font-size: 13px;padding-top: 13px;">
                                <div style="display: inline-block;margin-right: 20px;">
                                    {{--<i @click="toggleDraw" :class=" menuHide ? 'el-icon-s-unfold' : 'el-icon-s-fold'"></i>--}}
                                    <el-tooltip effect="dark" content="伸缩/折叠菜单栏" placement="bottom">
                                        <el-button type="primary" :icon="menuHide ? 'el-icon-s-unfold' :
                                    'el-icon-s-fold'" size="mini" circle
                                                   @click="toggleDraw">
                                        </el-button>
                                    </el-tooltip>
                                </div>
                                {{--<div style="float: right;margin-left: 5px;padding-top: 6px">--}}
                                {{--<el-breadcrumb separator-class="el-icon-arrow-right">--}}
                                {{--<el-breadcrumb-item v-for="(value,index) in curMenu" :key="index">--}}
                                {{--<el-link v-if="index + 1 < curMenu.length" :underline="false" type="primary"--}}
                                {{--@click="goToUrl(value.url)">--}}
                                {{--<i class="el-icon-s-promotion"></i> @{{ value.title }}--}}
                                {{--</el-link>--}}
                                {{--<el-link v-else :underline="false" type="info">@{{ value.title }}</el-link>--}}
                                {{--</el-breadcrumb-item>--}}
                                {{--</el-breadcrumb>--}}
                                {{--</div>--}}
                            </div>
                        </ul>

                        {{--<ul class="nav navbar-nav" style="line-height: 53px;color: #DDDDDD">|</ul>--}}

                        {{--<ul class="nav navbar-nav">--}}
                        {{--<div style="display: flex;">--}}
                        {{--<img src="{{asset('bch_logo.png')}}" alt=""--}}
                        {{--style="width: 36px;height: 36px;border-radius: 50%;margin-top: 10px;">--}}
                        {{--<div style="line-height: 53px;margin: 0 15px 0 15px;font-size: 17px;font-weight: 500;">--}}
                        {{--博士博士后发展促进会--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</ul>--}}

                        <div class="nav navbar-nav navbar-right">
                            <div id="logout">
                                <template>
                                    <el-dropdown size="small" @command="handleCommand"><span class="el-dropdown-link">
                                        <img src="https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80"
                                             style="width: 40px;height: 40px;border-radius: 50%;margin-top: 5px;"></span>
                                        <el-dropdown-menu slot="dropdown">
                                            <el-dropdown-item command="logout">退出</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                </template>
                            </div>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        {{--未读提示模块--}}
                        <ul class="nav navbar-nav navbar-right" style="margin-right: 3%;">
                            <div id="badgeGroup">
                                <template>
                                    <el-badge :value="recommends" class="item">
                                        <el-button size="small" @click="goToRecommend" type="primary" plain>
                                            <i class="el-icon-message-solid"></i> 推荐
                                        </el-button>
                                    </el-badge>
                                    <el-badge :value="project" class="item">
                                        <el-button size="small" @click="goToProject" type="primary" plain>
                                            <i class="el-icon-message-solid"></i> 项目感兴趣
                                        </el-button>
                                    </el-badge>
                                </template>
                            </div>
                        </ul>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
        <div class="content-footer">
            <div class="copy-right">
                Copyright © 2020 人才优服技术部出品
            </div>
            <div class="lineWrapper">
                <div class="moving-line"></div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script>
    $(document).ready(function () {
        $('#app').fadeIn(200);
        $('.spinner').fadeOut(300);
    })

    window.onbeforeunload = function (event) {
        $('#app').fadeOut(50);
        $('.spinner').fadeIn(100);
    };

    window.onunload = function () {
        $('#app').fadeOut(50);
        $('.spinner').fadeIn(100);
    };

    let bus = new Vue();
    Vue.prototype.bus = bus;

    //面包屑
    let breadCrumb = new Vue({
        el: '#breadCrumb',
        data: {
            domain: '',
            menus: [],
            urlArr: [],
            curMenu: [],
            draw: false,
            menuHide: false,
        },
        methods: {
            toggleDraw: function () {
                this.menuHide = !this.menuHide;
                this.bus.$emit('menuHide', this.menuHide);
                if(this.menuHide)
                {
                    setTimeout(function () {
                        document.getElementById('mainContent').style.paddingLeft = '64px';
                    },400)
                }else
                {
                    document.getElementById('mainContent').style.paddingLeft = '210px';
                    setTimeout(function () {
                        let height = document.getElementById('mainContent').offsetHeight;
                        let sHeight = document.documentElement.clientHeight;
                        if (height < sHeight)
                        {
                            $('#sidebar>ul').height(sHeight);
                        }else
                        {
                            $('#sidebar>ul').height(height);
                        }
                    },500)
                }
                //console.log(this.draw);
            },
            //跳转到指定页面
            goToUrl: function (url) {
                this.loading = true;
                window.location.href = 'http://' + this.domain + url;
            },
            setCurMenu: function () {
                let tempArr = [];
                for (let i = 0; i < this.urlArr.length; i++) {
                    if (this.urlArr[i] == 'admin') {
                        tempArr.push({'title': '首页', 'url': '/admin'});
                        if (this.urlArr[i + 1]) {
                            for (let j in this.menus) {
                                if (this.urlArr[i + 1] == j) {
                                    tempArr.push({'title': this.menus[j].display, 'url': this.menus[j].url});
                                }
                            }
                            if (this.urlArr[i + 3] && this.urlArr[i + 3] == 'edit') {
                                tempArr.push({'title': '编辑', 'url': ''});
                            }
                            if (this.urlArr[i + 2] && !this.urlArr[i + 3]) {
                                if (this.urlArr[i + 2] == 'create') {
                                    tempArr.push({'title': '创建', 'url': ''});
                                } else {
                                    tempArr.push({'title': '详情', 'url': ''});
                                }
                            }
                        }
                    }
                }
                this.curMenu = tempArr;
            },
        },
        beforeCreate: function () {
            //
        },
        created: function () {
            //获取权限菜单
            this.menus = JSON.parse('{!! Speedy::getMenus(true) !!}');
            this.urlArr = window.location.href.split('/');
            this.domain = window.location.host;
            //设置面包屑
            //this.setCurMenu();
        },
        mounted: function () {
            let that = this;
            this.bus.$on('menuHide', function (draw) {
                that.menuHide = draw;
            });
        }
    });

    let logout = new Vue({
        el: '#logout',
        data: {
            //
        },
        methods: {
            handleCommand(command) {
                if (command = 'logout') {
                    document.getElementById('logout-form').submit();
                }
            },
        },
        created: function () {
            //
        }
    });

    //未读提示
    {{--let badgeGroup = new Vue({--}}
    {{--    el: '#badgeGroup',--}}
    {{--    data: {--}}
    {{--        badges: [],--}}
    {{--        recommends: '',--}}
    {{--        project: '',--}}
    {{--    },--}}
    {{--    methods: {--}}
    {{--        setBadges: function (badges) {--}}
    {{--            this.badges = JSON.parse(badges);--}}
    {{--        },--}}
    {{--        countOfBadge: function () {--}}
    {{--            for (let i = 0; i < this.badges.length; i++) {--}}
    {{--                if (this.badges[i].name == '推荐博士') {--}}
    {{--                    this.recommends = this.badges[i].count;--}}
    {{--                } else if (this.badges[i].name == '项目感兴趣者') {--}}
    {{--                    this.project = this.badges[i].count;--}}
    {{--                } else {--}}
    {{--                    //--}}
    {{--                }--}}
    {{--            }--}}
    {{--        },--}}
    {{--        goToRecommend: function () {--}}
    {{--            this.loading = true;--}}
    {{--            window.location.href = '{{ route('admin.recommend.index') }}';--}}
    {{--        },--}}
    {{--        goToProject: function () {--}}
    {{--            this.loading = true;--}}
    {{--            window.location.href = '{{ route('admin.like_project.index') }}';--}}
    {{--        }--}}
    {{--    },--}}
    {{--    created: function () {--}}
    {{--        this.setBadges('{!! Badge::getBadge() !!}');--}}
    {{--        this.countOfBadge();--}}
    {{--    }--}}
    {{--});--}}

    //侧边栏
    let sidebar = new Vue({
        el: '#sidebar',
        data: {
            menus: [],
            active: '',
            direction: 'ltr',
            badges: [],
            drawer: false,
            icon: {!! json_encode(config('speedy.menu-icons')) !!} ,
            curMenu: '',
            domain: '',
            menuHide: false,
        },
        methods: {
            //获取当前路径
            getCurMenu: function () {
                let urlArr = document.URL.split('/');
                for (let i = 0; i < urlArr.length; i++) {
                    if (urlArr[i] == 'admin') {
                        this.curMenu = '/admin/' + urlArr[i + 1];
                    }
                }
                //console.log(this.curMenu);
            },
            //菜单栏选择
            clickMenu: function (index, indexPath) {
                window.location.href = 'http://' + this.domain + index;
            },
            //抽屉关闭前事件回调
            handleBeforeClose: function (done) {
                this.bus.$emit('menuHide', !this.menuHide);
                done();
            },
            //历史方法
            toggleMenu: function (id) {
                this.active = this.active == id ? '' : id;
            },
            setMenus: function (menus) {
                this.menus = menus;
            },
            //历史方法
            isCurrentUrl: function (url, key) {
                var parser = document.createElement('a');
                parser.href = url;

                if (parser.pathname === window.location.pathname) {
                    this.active = key ? key : this.active;
                    return true;
                }
                return false;
            },
            //设置一级菜单icon
            setMenuIcon: function () {
                let menus = this.menus;
                let icon = this.icon;
                for (let p in menus) {
                    for (let c in icon) {
                        if (p == c) {
                            menus[p]['icon'] = icon[c];
                        }
                    }
                }
                this.menus = menus;
            },
            setSubMenu: function () {
                let menus = this.menus;
                for (let m in menus) {
                    if (menus[m].sub) {
                        let sub = menus[m].sub;
                        let newArr = [];
                        let tempArr = [];
                        let title = '';
                        for (let s in sub) {
                            if (sub[s].type == title) {
                                tempArr.push(sub[s]);
                            } else {
                                if (title != '') {
                                    newArr.push({'title': title, 'sub': tempArr});
                                    title = sub[s].type;
                                    tempArr = [];
                                    tempArr.push(sub[s]);
                                } else {
                                    title = sub[s].type;
                                    tempArr.push(sub[s]);
                                }
                            }
                        }
                        newArr.push({'title': title, 'sub': tempArr});
                        menus[m].sub = newArr;
                    }
                }
                this.menus = menus;
            },
        },
        created: function () {
            this.setMenus(JSON.parse('{!! Speedy::getMenus(true) !!}'));
            //设置一级菜单icon
            this.setMenuIcon();
            //获取域名
            this.domain = window.location.host;
            //获取当前选中菜单
            this.getCurMenu();
            //设置二级菜单分组
            this.setSubMenu();
        },
        mounted: function () {
            let that = this;
            //更新总线抽屉状态
            this.bus.$on('menuHide', function (draw) {
                that.menuHide = draw;
            });
            //console.log(this.menus);
            let height = document.getElementById('mainContent').offsetHeight;
            let sHeight = document.documentElement.clientHeight;
            if (height < sHeight)
            {
                $('#sidebar>ul').height(sHeight);
            }else
            {
                $('#sidebar>ul').height(height);
            }
            // console.log(sHeight);
        },
    });
</script>
</body>
</html>
