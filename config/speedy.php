<?php

    return [

        /**
         * -----------------------------------------------------------------------------------------------------------------
         *  Models config
         * -----------------------------------------------------------------------------------------------------------------
         *
         * config your namespace and model's Class name
         *
         */

        'class' => [
            'namespace' => 'App\\Models\\' ,
            'model'     => [
                'role'                     => 'Role' ,
                'user'                     => 'AdminUser' ,
                'permission'               => 'Permission' ,
                'permission_role'          => 'PermissionRole' ,
                'mini_user'                => 'Users' ,
                'third_session'            => 'ThirdSession' ,
                'place'            => 'Place' ,
                'tour'            => 'Tour' ,
            ] ,
        ] ,

        /**
         * -----------------------------------------------------------------------------------------------------------------
         *  Table config
         * -----------------------------------------------------------------------------------------------------------------
         *
         * config your table name
         *
         */

        'table' => [
            'role'                     => 'role' ,
            'permission'               => 'permission' ,
            'user'                     => 'pt_user' ,
            'permission_role'          => 'permission_role' ,
            'mini_user'                => 'gc_users' ,
            'third_session'            => 'gc_third_session' ,
            'place'            => 'gc_place' ,
            'tour'            => 'gc_tour' ,
        ] ,

        /**
         * -----------------------------------------------------------------------------------------------------------------
         *  Menus config
         * -----------------------------------------------------------------------------------------------------------------
         *
         * config your sidebar menu here
         *
         */

        'menus'        => [
            'place'   => [
                'display' => '??????' ,
                'url'     => '/admin/place' ,
            ] ,
            'map'   => [
                'display' => '??????' ,
                'url'     => '/admin/map' ,
            ] ,
        ] ,

        //???????????????????????????icon
        'menu-icons'   => [
            'place' => 'el-icon-coordinate' ,
            'map' => 'el-icon-s-tools' ,
        ] ,
    ];
