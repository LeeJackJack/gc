@if (!Auth::guest())
    <div id="sidebar">
        <template>
            <el-menu
                    :default-active="curMenu"
                    :collapse="menuHide"
                    :unique-opened="true"
                    background-color="rgb(26,45,49)"
                    text-color="#bbbbbb"
                    @select="clickMenu">
                    {{--background-color="rgb(255,255,255)"--}}
                    {{--text-color="#595959"--}}
                    {{--class="menuClass"--}}
                    {{--active-text-color="#262626">--}}
                <template v-for="(value,key,index) in menus">
                    {{--有子菜单--}}
                    <el-submenu
                            v-if="value.sub"
                            :index="key"
                            :key="key">
                        <template slot="title">
                            <i :class="value.icon" style="color: rgb(27,154,238)"></i>
                            <span>@{{ value.display }}</span>
                        </template>
                        {{--二级菜单--}}
                        <template v-for="(sValue,sKey,sIndex) in value.sub">
                            <el-menu-item-group :title="sValue.title">
                                <el-menu-item
                                        :index="ssValue.url"
                                        v-for="(ssValue,ssKey,ssIndex) in sValue.sub"
                                        :key="ssKey"
                                        style="font-size: 13px;">
                                    @{{ ssValue.display }}
                                </el-menu-item>
                            </el-menu-item-group>
                        </template>
                    </el-submenu>
                    {{--无子菜单--}}
                    <el-menu-item
                            v-else
                            :index="value.url">
                        <i :class="value.icon" style="color: rgb(27,154,238)"></i>
                        <span>@{{ value.display }}</span>
                    </el-menu-item>
                </template>
            </el-menu>
        </template>
    </div>

    <style scoped>
        #sidebar>ul
        {
            /*height: 979px;*/
        }
        #sidebar
        {
            /*position: fixed;*/
            width: auto;
        }
        .is-active
        {
            /*background-color: rgb(255,205,31) !important;*/
            font-size: 12px;
            font-weight: 600;
        }
        .el-submenu__title:hover
        {
            /*background-color: rgb(255,205,31) !important;*/
        }
        .el-submenu__title
        {
            font-size: 12px;
            font-weight: 600;
        }
        .el-menu-item
        {
            font-size: 12px;
            font-weight: 600;
        }
        .el-menu-item:hover
        {
            /*background-color: rgb(255,205,31) !important;*/
        }
        /*.el-drawer.ltr {*/
            /*background-color: #555555;*/
        /*}*/

        .el-menu {
            /*box-shadow: 0 0.5rem 1.25rem 0 rgba(0,0,0,.28);*/
        }
        .menuClass:not(.el-menu--collapse)
        {
            width: 201px;
            min-height: 400px;
        }
    </style>
@endif
