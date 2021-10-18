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
//                'label'                    => 'Label' ,
//                'sp'                       => 'Sp' ,
                'mini_user'                => 'Users' ,
                'third_session'            => 'ThirdSession' ,
                'place'            => 'Place' ,
                'tour'            => 'Tour' ,
                //                'banner'                   => 'Banner' ,
//                'sign_up'                  => 'SignUp' ,
//                'job'                      => 'Job' ,
//                'company'                  => 'Company' ,
//                'feedback'                 => 'Feedback' ,
//                'recommend'                => 'Recommend' ,
//                'sms'                      => 'Sms' ,
//                'sms_log'                  => 'SmsLog' ,
//                'recommend_data'           => 'RecommendData' ,
//                'activity'                 => 'Activity' ,
//                'project'                  => 'Projects' ,
//                'personal_info'            => 'PersonalInfo' ,
//                'education'                => 'Education' ,
//                'working'                  => 'Working' ,
//                'honor'                    => 'Honor' ,
//                'like_project'             => 'LikeProject' ,
//                'talent'                   => 'Talents' ,
//                'contact_info'             => 'ContactInfo' ,
//                'special_subject'          => 'SpecialSubject' ,
//                'requirement'          => 'Requirements',
//                'led'          => 'Led' ,
//                'foshan_doctor'          => 'FoshanDoctor' ,
//                'foshan_doctor_like'          => 'FoshanDoctorLike' ,
//                'government' => 'Government' ,
//                'phd' => 'PhdCandidate',
//                'map' => 'Map',

//                //用户数量统计
//                'user_count'               => 'UniqueUsersCount' ,
//                'register_count'           => 'RegisterCount' ,
//
//                //记录用户行为
//                'view_log'                 => 'Logs\\ViewLog' ,
//                'search_log'               => 'Logs\\SearchLog' ,
//                'city_log'                 => 'Logs\\SelectCityLog' ,
//                'industry_log'             => 'Logs\\SelectIndustryLog' ,
//
//                //记录邮件发送信息
//                'email_log'                => 'Logs\\EmailLog' ,
//
//                //更新日志
//                'update_log'               => 'Logs\\UpdateLog' ,
//
//                //短信通知管理员
//                'inform'                   => 'InformUser' ,
//
//                //海外活动报名
//                'oversea_activity_sign_up' => 'OverseaActivitySignUp' ,
//
//                //其他
//                'haizhu'             => 'excel\\Haizhu' ,
//                'group_qr_code' => 'GroupQrCode',
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
//            'label'                    => 'bch_label' ,
//            'sp'                       => 'bch_sp' ,
//            'banner'                   => 'bch_banner' ,
            'mini_user'                => 'gc_users' ,
            'third_session'            => 'gc_third_session' ,
            'place'            => 'gc_place' ,
            'tour'            => 'gc_tour' ,

            //            'sign_up'                  => 'bch_sign_up' ,
//            'job'                      => 'bch_job' ,
//            'company'                  => 'bch_company' ,
//            'feedback'                 => 'bch_feedback' ,
//            'recommend'                => 'bch_recommend' ,
//            'sms'                      => 'bch_sms' ,
//            'sms_log'                  => 'bch_sms_log' ,
//            'recommend_data'           => 'bch_recommend_data' ,
//            'activity'                 => 'bch_activity' ,
//            'project'                  => 'bch_projects' ,
//            'personal_info'            => 'bch_personal_info' ,
//            'working'                  => 'bch_workings' ,
//            'education'                => 'bch_education' ,
//            'honor'                    => 'bch_honors' ,
//            'like_project'             => 'bch_like_projects' ,
//            'talent'                   => 'bch_talents' ,
//            'contact_info'             => 'bch_contact_info' ,
//            'special_subject'          => 'bch_special_subject' ,
//            'requirement'          => 'bch_requirement' ,
//            'led'          => 'bch_led' ,
//            'foshan_doctor'          => 'bch_foshan_doctors' ,
//            'foshan_doctor_like'          => 'bch_foshan_doctor_likes' ,
//            'government' => 'Government' ,
//            'phd' => 'bch_phd_candidates' ,

//            //用户数量统计
//            'user_count'               => 'bch_unique_users_counts' ,
//            'register_count'           => 'bch_register_counts' ,
//
//            //用户行为表
//            'view_log'                 => 'bch_view_logs' ,
//            'search_log'               => 'bch_search_logs' ,
//            'city_log'                 => 'bch_select_city_logs' ,
//            'industry_log'             => 'bch_select_industry_logs' ,
//
//            //记录邮件发送信息
//            'email_log'                => 'bch_email_logs' ,
//
//            //更新日志
//            'update_log'               => 'bch_update_logs' ,
//
//            //短信通知管理员
//            'inform'                   => 'bch_inform_users' ,
//
//            //海外活动报名
//            'oversea_activity_sign_up' => 'bch_oversea_activity_sign_up' ,
//
//            //其他
//            'haizhu'             => 'haizhu' ,
//            'group_qr_code' => 'bch_group_qr_code',
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
//            'position'     => [
//                'display' => '职位相关' ,
//                'sub'     => [
//                    'company'   => [
//                        'display' => '企业信息' ,
//                        'url'     => '/admin/company' ,
//                        'type'    => '信息 & 发布' ,
//                    ] ,
//                    'job'       => [
//                        'display' => '职位信息' ,
//                        'url'     => '/admin/job' ,
//                        'type'    => '信息 & 发布' ,
//                    ] ,
//                    'recommend' => [
//                        'display' => '应聘/推荐' ,
//                        'url'     => '/admin/recommend' ,
//                        'type'    => '处理' ,
//                    ] ,
//                ] ,
//            ] ,
//            'event'        => [
//                'display' => '活动相关' ,
//                'sub'     => [
//                    'activity'         => [
//                        'display' => '活动发布' ,
//                        'url'     => '/admin/activity' ,
//                        'type'    => '信息 & 发布' ,
//                    ] ,
//                    'oversea_activity' => [
//                        'display' => '博士后南粤行' ,
//                        'url'     => '/admin/oversea_activity' ,
//                        'type'    => '数据' ,
//                    ] ,
//                    'like_doctor' => [
//                        'display' => '博交会博士' ,
//                        'url'     => '/admin/like_doctor' ,
//                        'type'    => '数据' ,
//                    ] ,
//                ] ,
//            ] ,
//            'achievements' => [
//                'display' => '科技成果相关' ,
//                'sub'     => [
//                    'project'      => [
//                        'display' => '科技成果信息' ,
//                        'url'     => '/admin/project' ,
//                        'type'    => '信息 & 发布' ,
//                    ] ,
//                    'like_project' => [
//                        'display' => '感兴趣' ,
//                        'url'     => '/admin/like_project' ,
//                        'type'    => '数据' ,
//                    ] ,
//                ] ,
//            ] ,
//            'requirement' => [
//                'display' => '项目需求相关' ,
//                'sub'     => [
//                    'project'      => [
//                        'display' => '项目需求信息' ,
//                        'url'     => '/admin/requirement' ,
//                        'type'    => '信息 & 发布' ,
//                    ] ,
//                ] ,
//            ] ,
//            'data'         => [
//                'display' => '数据' ,
//                'sub'     => [
//                    'report' => [
//                        'display' => '周报' ,
//                        'url'     => '/admin/weekly_report' ,
//                        'type'    => '数据汇总' ,
//                    ] ,
//                    'talent' => [
//                        'display' => '人才库' ,
//                        'url'     => '/admin/talent' ,
//                        'type'    => '信息' ,
//                    ] ,
//                    'government' => [
//                        'display' => '政府库' ,
//                        'url'     => '/admin/government' ,
//                        'type'    => '信息' ,
//                    ],
//                    'phd' => [
//                        'display' => '高校库' ,
//                        'url'     => '/admin/phd' ,
//                        'type'    => '信息' ,
//                    ],
//                ] ,
//            ] ,
//            'sp'           => [
//                'display' => '内容审批' ,
//                'url'     => '/admin/sp' ,
//            ] ,
//            'sets'         => [
//                'display' => '设置' ,
//                'sub'     => [
//                    'admin_user' => [
//                        'display' => '账号' ,
//                        'url'     => '/admin/admin_user' ,
//                        'type'    => '个人' ,
//                    ] ,
//                    'role'       => [
//                        'display' => '权限设置' ,
//                        'url'     => '/admin/role' ,
//                        'type'    => '系统' ,
//                    ] ,
//                ] ,
//            ] ,
//            'update_log'   => [
//                'display' => '更新日志' ,
//                'url'     => '/admin/update_log' ,
//            ] ,
            'place'   => [
                'display' => '景点' ,
                'url'     => '/admin/place' ,
            ] ,
            'map'   => [
                'display' => '地图' ,
                'url'     => '/admin/map' ,
            ] ,

            //            'admin_user' => [
            ////                'display' => '用户' ,
            ////                'url'     => '/admin/admin_user' ,
            ////                'icon' => 'el-icon-location' ,
            ////            ] ,
            ////            'role'       => [
            ////                'display' => '权限控制' ,
            ////                'url'     => '/admin/role' ,
            ////                'icon' => 'el-icon-location' ,
            ////            ] ,
            ////            'company'    => [
            ////                'display' => '公司发布' ,
            ////                'url'     => '/admin/company' ,
            ////            ] ,
            ////            'job'    => [
            ////                'display' => '职位发布' ,
            ////                'url'     => '/admin/job' ,
            ////            ] ,
            //            'activity'    => [
            //                'display' => '活动发布' ,
            //                'url'     => '/admin/activity' ,
            //            ] ,
            //            'recommend'    => [
            //                'display' => '推荐博士' ,
            //                'url'     => '/admin/recommend' ,
            //            ] ,
            //            'project'    => [
            //                'display' => '项目' ,
            //                'url'     => '/admin/project' ,
            //            ] ,
            //            'like_project'    => [
            //                'display' => '项目感兴趣者' ,
            //                'url'     => '/admin/like_project' ,
            //            ] ,
            //            'sp'         => [
            //                'display' => '审批' ,
            //                'url'     => '/admin/sp' ,
            //            ] ,
            //            'report'         => [
            //                'display' => '周报' ,
            //                'url'     => '/admin/weekly_report' ,
            //            ] ,
            //            'talent'         => [
            //                'display' => '人才库' ,
            //                'url'     => '/admin/talent' ,
            //            ] ,
            //            'oversea_activity'         => [
            //                'display' => '博士后南粤行' ,
            //                'url'     => '/admin/oversea_activity' ,
            //            ] ,
            //            'update_log'         => [
            //                'display' => '更新日志' ,
            //                'url'     => '/admin/update_log' ,
            //            ] ,
        ] ,

        //菜单栏一级菜单对应icon
        'menu-icons'   => [
//            'sets'         => 'el-icon-s-tools' ,
//            'position'     => 'el-icon-s-custom' ,
//            'event'        => 'el-icon-coordinate' ,
//            'achievements' => 'el-icon-s-opportunity' ,
//            'data'         => 'el-icon-data-line' ,
//            'sp'           => 'el-icon-document-checked' ,
//            'update_log'   => 'el-icon-finished' ,
//            'requirement' => 'el-icon-s-help' ,
            'place' => 'el-icon-coordinate' ,
            'map' => 'el-icon-s-tools' ,
        ] ,

        // 菜单栏二级菜单分组
//        'menu-divides' => [
//            'personal' => [
//                'title' => '个人' ,
//                'subs'  => [ 'admin_user' , ] ,
//            ] ,
//            'system'   => [
//                'title' => '系统' ,
//                'subs'  => [ 'role' , ] ,
//            ] ,
//            'public'   => [
//                'title' => '发布' ,
//                'subs'  => [ 'company' , 'job' , 'activity' , 'project' ] ,
//            ] ,
//            'handle'   => [
//                'title' => '处理' ,
//                'subs'  => [ 'recommend' , 'like_project' ] ,
//            ] ,
//            'data'     => [
//                'title' => '数据' ,
//                'subs'  => [ 'oversea_activity' , 'like_doctor' ] ,
//            ] ,
//            'etc'      => [
//                'title' => '其他' ,
//                'subs'  => [ 'report' , 'talent' , 'government' ] ,
//            ] ,
//
//        ] ,

    ];
