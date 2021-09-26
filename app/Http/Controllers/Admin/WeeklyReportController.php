<?php

    namespace App\Http\Controllers\Admin;

    use Carbon\Carbon;
    use Speedy;
    use Illuminate\Http\Request;
    use Flash;
    use App\Charts\Sample;

    class WeeklyReportController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @param  Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function index( Request $request )
        {
            $date = $request->get( 'date' );

            if ( $date )
            {
                //计算用户数据
                $user_data = $this->getUsersCount( $date );

                //计算注册用户数据
                $register_user_data = $this->getRegisterUsersCount( $date );

                //计算职位数据
                $jobs_data = $this->getJobsCount( $date );

                //计算活动数据
                $activities_data = $this->getActivitiesCount( $date );

                return view( 'vendor.speedy.admin.weekly_report.index' ,
                    compact( 'date' , 'user_data' , 'register_user_data' , 'jobs_data' , 'activities_data' ) );
            }
            else
            {
                return view( 'vendor.speedy.admin.weekly_report.index' );
            }

        }

        /**
         * 返回周报所需用户数据...
         *
         * @param $date
         *
         * @return array
         *
         * @author alienware 2019/4/23
         */
        public function getUsersCount( $date )
        {
            $choose_date = Carbon::parse( $date );

            $users_data = [];

            //总用户数据
            $total_users_count = Speedy::getModelInstance( 'mini_user' )->where( 'valid' , '1' )->count();
            array_set( $users_data , 'total_users_count' , $total_users_count );

            $this_week_users_count_per_day     = [];
            $users_count_labels                = [];
            $last_week_users_count_per_day     = [];
            $last_two_week_users_count_per_day = [];

            //获取数据
            for ( $i = 0 ; $i <= 20 ; $i++ )
            {
                $search_date = $choose_date->addDay( -1 );
                $count       = Speedy::getModelInstance( 'third_session' )->where( 'valid' ,
                    '1' )->where( 'created_at' , '<=' , $search_date->toDateString() )->count();

                if ( $i < 7 )
                {
                    //设置本周每日数据
                    array_unshift( $this_week_users_count_per_day , $count );
                    array_push( $users_count_labels , '第 ' . ( $i + 1 ) . ' 天' );
                }
                else if ( $i < 14 )
                {
                    //设置上一周周每日数据
                    array_unshift( $last_week_users_count_per_day , $count );
                }
                else
                {
                    //设置上两周周每日数据
                    array_unshift( $last_two_week_users_count_per_day , $count );
                }

            }
            $users_chart = new Sample();
            $users_chart->labels( $users_count_labels );
            $users_chart->dataset( '本周每日累计用户数量' , 'line' ,
                $this_week_users_count_per_day )->color( '#F25F5C' )->backgroundColor( 'rgba(255,255,255,0)' );
            $users_chart->dataset( '上周周每日累计用户数量' , 'line' ,
                $last_week_users_count_per_day )->color( '#247BA0' )->backgroundColor( 'rgba(255,255,255,0)' );
            array_set( $users_data , 'chart' , $users_chart );

            //返回本周一周增长用户数
            $this_week_increase_users_count = array_last( $this_week_users_count_per_day ) - array_last( $last_week_users_count_per_day );
            array_set( $users_data , 'this_week_increase_users_count' , $this_week_increase_users_count );

            //返回本周增长用户数与上周环比
            $users_week_on_week_basis = round( $this_week_increase_users_count / array_last( $last_week_users_count_per_day ) ,
                    4 ) * 100;
            array_set( $users_data , 'users_week_on_week_basis' , $users_week_on_week_basis );

            return $users_data;
        }

        /**
         * 返回注册用户数据...
         *
         * @param $date
         *
         * @return array
         *
         * @author alienware 2019/4/23
         */
        public function getRegisterUsersCount( $date )
        {
            $choose_date         = Carbon::parse( $date );
            $register_users_data = [];

            //总注册用户数
            $total_register_users_count = Speedy::getModelInstance( 'mini_user' )->where( 'valid' ,
                '1' )->where( 'phone' , '<>' , '' )->count();
            array_set( $register_users_data , 'total_register_users_count' , $total_register_users_count );

            $this_week_register_users_count_per_day     = [];
            $register_users_count_labels                = [];
            $last_week_register_users_count_per_day     = [];
            $last_two_week_register_users_count_per_day = [];

            //获取数据
            for ( $i = 0 ; $i <= 21 ; $i++ )
            {
                $search_date = $choose_date->addDay( -1 );
                $count       = Speedy::getModelInstance( 'mini_user' )->where( 'valid' , '1' )->where( 'phone' , '<>' ,
                    '' )->where( 'create_time' , '<=' , $search_date->toDateString() )->count();

                if ( $i < 7 )
                {
                    //设置本周每日数据
                    array_unshift( $this_week_register_users_count_per_day , $count );
                    array_push( $register_users_count_labels , '第 ' . ( $i + 1 ) . ' 天' );
                }
                else if ( $i < 14 )
                {
                    //设置上一周周每日数据
                    array_unshift( $last_week_register_users_count_per_day , $count );
                }
                else
                {
                    //设置上两周周每日数据
                    array_unshift( $last_two_week_register_users_count_per_day , $count );
                }
            }
            $register_users_chart = new Sample();
            $register_users_chart->labels( $register_users_count_labels );
            $register_users_chart->dataset( '本周每日累计注册用户数量' , 'line' ,
                $this_week_register_users_count_per_day )->color( '#F25F5C' )->backgroundColor( 'rgba(255,255,255,0)' );
            $register_users_chart->dataset( '上周每日累计注册用户数量' , 'line' ,
                $last_week_register_users_count_per_day )->color( '#247BA0' )->backgroundColor( 'rgba(255,255,255,0)' );
            array_set( $register_users_data , 'chart' , $register_users_chart );

            //返回本周一周增长注册用户数
            $this_week_increase_register_users_count = array_last( $this_week_register_users_count_per_day ) - array_last( $last_week_register_users_count_per_day );
            array_set( $register_users_data , 'this_week_increase_register_users_count' ,
                $this_week_increase_register_users_count );

            //返回本周增长注册用户数与上周环比
            $register_users_week_on_week_basis = round( $this_week_increase_register_users_count / array_last( $last_week_register_users_count_per_day ) ,
                    4 ) * 100;
            array_set( $register_users_data , 'register_users_week_on_week_basis' ,
                $register_users_week_on_week_basis );

            return $register_users_data;
        }

        /**
         * 返回周报所需职位数据...
         *
         * @param $date
         *
         * @return array
         *
         * @author alienware 2019/4/23
         */
        public function getJobsCount( $date )
        {
            $choose_date = Carbon::parse( $date );
            $jobs_data   = [];

            //总职位浏览量
            //$total_jobs_view_count = Speedy::getModelInstance( 'view_log' )->where( 'type' , '1' )->where( 'valid' ,
            //'1' )->count();

            $this_week_jobs_count_per_day     = [];
            $jobs_count_labels                = [];
            $last_week_jobs_count_per_day     = [];
            $last_two_week_jobs_count_per_day = [];

            //获取数据
            for ( $i = 0 ; $i <= 21 ; $i++ )
            {
                $search_date = $choose_date->addDay( -1 );
                $count       = Speedy::getModelInstance( 'view_log' )->where( 'valid' , '1' )->where( 'type' ,
                    '1' )->where( 'created_at' , '>=' ,
                    $search_date->startOfDay()->toDateTimeString() )->where( 'created_at' , '<=' ,
                    $search_date->endOfDay()->toDateTimeString() )->count();
                if ( $i < 7 )
                {
                    //设置本周每日数据
                    array_unshift( $this_week_jobs_count_per_day , $count );
                    array_push( $jobs_count_labels , '第 ' . ( $i + 1 ) . ' 天' );
                }
                else if ( $i < 14 )
                {
                    //设置上一周周每日数据
                    array_unshift( $last_week_jobs_count_per_day , $count );
                }
                else
                {
                    //设置上两周周每日数据
                    array_unshift( $last_two_week_jobs_count_per_day , $count );
                }
            }
            $jobs_chart = new Sample();
            $jobs_chart->labels( $jobs_count_labels );
            $jobs_chart->dataset( '本周每日职位浏览数量' , 'line' ,
                $this_week_jobs_count_per_day )->color( '#F25F5C' )->backgroundColor( 'rgba(255,255,255,0)' );
            $jobs_chart->dataset( '上周每日职位浏览数量' , 'line' ,
                $last_week_jobs_count_per_day )->color( '#247BA0' )->backgroundColor( 'rgba(255,255,255,0)' );
            array_set( $jobs_data , 'chart' , $jobs_chart );

            //本周职位浏览数
            array_set( $jobs_data , 'jobs_view_count' , array_sum( $this_week_jobs_count_per_day ) );

            //返回本周一周增长职位浏览数
            $this_week_increase_jobs_count = array_sum( $this_week_jobs_count_per_day ) - array_sum( $last_week_jobs_count_per_day );
            array_set( $jobs_data , 'this_week_increase_jobs_count' , $this_week_increase_jobs_count );

            //返回本周增长职位浏览数与上周环比
            $jobs_week_on_week_basis = array_sum( $last_week_jobs_count_per_day ) == 0 ? 0: round( $this_week_increase_jobs_count / array_sum( $last_week_jobs_count_per_day ) ,
                    4 ) * 100;
            array_set( $jobs_data , 'jobs_week_on_week_basis' , $jobs_week_on_week_basis );

            //返回本周新增职位数
            $choose_date    = Carbon::parse( $date );
            $new_jobs       = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'created_at' , '>=' ,
                $choose_date->addDay( -7 )->startOfDay()->toDateString() )->get( [ 'ids' ] );
            $new_jobs_count = $new_jobs->count();
            array_set( $jobs_data , 'new_jobs_count' , $new_jobs_count );

            //新增职位带来的浏览数及推荐量
            $choose_date = Carbon::parse( $date );
            $search_date = $choose_date->addDay( -1 );

            $new_jobs_view_count      = 0;
            $new_jobs_recommend_count = 0;
            foreach ( $new_jobs as $n )
            {
                $new_jobs_view_count      += Speedy::getModelInstance( 'view_log' )->where( 'target_ids' , $n->ids )->where( 'created_at' , '<=' ,
                    $search_date->endOfDay()->toDateTimeString() )->count();
                $new_jobs_recommend_count += Speedy::getModelInstance( 'recommend' )->where( 'created_at' , '<=' ,
                    $search_date->endOfDay()->toDateTimeString() )->where( 'job_ids' , $n->ids )->count();
            }
            array_set( $jobs_data , 'new_jobs_view_count' , $new_jobs_view_count );
            array_set( $jobs_data , 'new_jobs_recommend_count' , $new_jobs_recommend_count );

            //本周新推荐数量
            $choose_date          = Carbon::parse( $date );
            $new_recommends       = Speedy::getModelInstance( 'recommend' )->where( 'valid' ,
                '1' )->where( 'created_at' , '>=' ,
                $choose_date->addDay( -7 )->startOfDay()->toDateString() )->get( [ 'ids' ] );
            $new_recommends_count = $new_recommends->count();
            array_set( $jobs_data , 'new_recommends_count' , $new_recommends_count );

            //平台累计发布职位数量及推荐数量
            $total_jobs_count      = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->count();
            $total_recommend_count = Speedy::getModelInstance( 'recommend' )->where( 'valid' , '1' )->count();
            array_set( $jobs_data , 'total_jobs_count' , $total_jobs_count );
            array_set( $jobs_data , 'total_recommend_count' , $total_recommend_count );

            return $jobs_data;
        }

        /**
         * 返回周报所需活动数据...
         *
         * @param $date
         *
         * @return array
         *
         * @author alienware 2019/4/23
         */
        public function getActivitiesCount( $date )
        {
            $choose_date     = Carbon::parse( $date );
            $activities_data = [];

            $total_activities_count = Speedy::getModelInstance( 'activity' )->where( 'valid' , '1' )->count();
            array_set( $activities_data , 'total_activities_count' , $total_activities_count );

            $this_week_activities_count_per_day     = [];
            $activities_count_labels                = [];
            $last_week_activities_count_per_day     = [];
            $last_two_week_activities_count_per_day = [];

            //获取数据
            for ( $i = 0 ; $i <= 21 ; $i++ )
            {
                $search_date = $choose_date->addDay( -1 );
                $count       = Speedy::getModelInstance( 'view_log' )->where( 'valid' , '1' )->where( 'type' ,
                    '2' )->where( 'created_at' , '>=' ,
                    $search_date->startOfDay()->toDateTimeString() )->where( 'created_at' , '<=' ,
                    $search_date->endOfDay()->toDateTimeString() )->count();
                if ( $i < 7 )
                {
                    //设置本周每日数据
                    array_unshift( $this_week_activities_count_per_day , $count );
                    array_push( $activities_count_labels , '第 ' . ( $i + 1 ) . ' 天' );
                }
                else if ( $i < 14 )
                {
                    //设置上一周周每日数据
                    array_unshift( $last_week_activities_count_per_day , $count );
                }
                else
                {
                    //设置上两周周每日数据
                    array_unshift( $last_two_week_activities_count_per_day , $count );
                }
            }
            $activities_chart = new Sample();
            $activities_chart->labels( $activities_count_labels );
            $activities_chart->dataset( '本周每日活动浏览数量' , 'line' ,
                $this_week_activities_count_per_day )->color( '#F25F5C' )->backgroundColor( 'rgba(255,255,255,0)' );
            $activities_chart->dataset( '上周每日活动浏览数量' , 'line' ,
                $last_week_activities_count_per_day )->color( '#247BA0' )->backgroundColor( 'rgba(255,255,255,0)' );
            array_set( $activities_data , 'chart' , $activities_chart );

            //返回本周活动浏览数
            $this_week_activities_count = array_sum( $this_week_activities_count_per_day );
            array_set( $activities_data , 'this_week_activities_count' , $this_week_activities_count );

            //返回本周一周增长活动浏览数
            $this_week_increase_activities_count = array_sum( $this_week_activities_count_per_day ) - array_sum( $last_week_activities_count_per_day );
            array_set( $activities_data , 'this_week_increase_activities_count' ,
                $this_week_increase_activities_count );

            //返回本周增长活动浏览数与上周环比
            $activities_week_on_week_basis = array_sum( $last_week_activities_count_per_day ) == 0 ? 0 : round( $this_week_increase_activities_count / array_sum( $last_week_activities_count_per_day ) ,
                    4 ) * 100;
            array_set( $activities_data , 'activities_week_on_week_basis' , $activities_week_on_week_basis );

            //本周活动报名数
            $choose_date  = Carbon::parse( $date );
            $new_sigh_ups = Speedy::getModelInstance( 'sign_up' )->where( 'valid' , '1' )->where( 'created_at' , '>=' ,
                $choose_date->addDay( -7 )->startOfDay()->toDateString() )->count();
            array_set( $activities_data , 'new_sigh_ups' , $new_sigh_ups );

            //返回本周新增活动数
            $choose_date          = Carbon::parse( $date );
            $new_activities       = Speedy::getModelInstance( 'activity' )->where( 'valid' ,
                '1' )->where( 'created_at' , '>=' ,
                $choose_date->addDay( -7 )->startOfDay()->toDateString() )->get( [ 'ids' ] );
            $new_activities_count = $new_activities->count();
            array_set( $activities_data , 'new_activities_count' , $new_activities_count );

            //新增活动带来的浏览数及报名量
            $choose_date                  = Carbon::parse( $date );
            $search_date                  = $choose_date->addDay( -1 );
            $new_activities_view_count    = 0;
            $new_activities_sign_up_count = 0;
            foreach ( $new_activities as $n )
            {
                $new_activities_view_count    += Speedy::getModelInstance( 'view_log' )->where( 'target_ids' ,
                    $n->ids )->where( 'type' , '2' )->where( 'created_at' , '<=' ,
                    $search_date->endOfDay()->toDateTimeString() )->count();
                $new_activities_sign_up_count += Speedy::getModelInstance( 'sign_up' )->where( 'activity_ids' ,
                    $n->ids )->where( 'created_at' , '<=' , $search_date->endOfDay()->toDateTimeString() )->count();
            }
            array_set( $activities_data , 'new_activities_view_count' , $new_activities_view_count );
            array_set( $activities_data , 'new_activities_sign_up_count' , $new_activities_sign_up_count );

            return $activities_data;
        }
    }
