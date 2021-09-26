<?php

    namespace App\Http\Controllers\Wechat;

    use App\Http\Controllers\Admin\InformUserController;
    use App\Http\Controllers\Controller;
    use App\Models\Activity;
    use App\Models\Company;
    use App\Models\Job;
    use App\Models\Recommend;
    use App\Models\RecommendData;
    use App\Models\SignUp;
    use Carbon\Carbon;
    use EasyWeChat\Factory;
    use EasyWeChat\Kernel\Http\StreamResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Storage;
    use Speedy;
    use App\Models\Place;
    use App\Models\tour;

    class WechatController extends Controller
    {

        /**
         * @var \EasyWeChat\MiniProgram\Application
         */
        protected $mini;

        /**
         * 实例化小程序
         */
        public function __construct()
        {
            $config = config( 'wechat.mini_program.default' );
            $this->mini = Factory::miniProgram( $config );
        }

        /**
         * 获取微信小程序session...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
         *
         * @author alienware 2019/1/25
         */
        public function getWechatSession( Request $request )
        {
            $code = $request->get( 'code' );
            $iv = $request->get( 'iv' );
            $encryptData = $request->get( 'authorization_code' );

            $session = $this->mini->auth->session( $code );

            $session_key = $session['session_key'];
            $openId = $session['openid'];
            $en_data = $this->mini->encryptor->decryptData( $session_key , $iv , $encryptData );

            $thirdSession = Speedy::getModelInstance( 'third_session' )->where( 'valid' , '1' )->where( 'openid' , $openId )->first();
            if ( $thirdSession )
            {
                Speedy::getModelInstance( 'third_session' )->where( 'valid' , '1' )->where( 'openid' , $openId )->delete();
            }

            Speedy::getModelInstance( 'third_session' )->create(
                [
                    'openid' => $openId , 'session_key' => $session_key ,
                ] );

            return response()->json(
                [
                    'data' => $en_data ,
                ] );
        }

        public function getMarkers( Request $request )
        {
            $places = Speedy::getModelInstance( 'place' )->where( 'valid' , '1' )->get();

            return response()->json(
                [
                    'data' => $places ,
                ] );
        }

        public function getPlace( Request  $request)
        {
            $id = $request->id;
            $place = Speedy::getModelInstance( 'place' )->where( 'id' , $id)->first();

            return response()->json(
                [
                    'data' => $place ,
                ] );
        }

        public function getTours( Request  $request)
        {
//            $id = $request->id;
            $tours = Speedy::getModelInstance( 'tour' )->where( 'valid' , '1')->get();
            foreach ( $tours as $r )
            {
                $arr = [];
                foreach ( json_decode($r->route) as $p )
                {
                    $place = Speedy::getModelInstance( 'place' )->where( 'id' , $p)->first();
                    array_push($arr,$place);
                }
                $r->setAttribute( 'tour_detail' , $arr );
            }

            return response()->json(
                [
                    'data' => $tours ,
                ] );
        }

        /**
         * 获取职位二维码图...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
         * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
         *
         * @author alienware 2019/3/13
         */
        public function getQrCode( Request $request )
        {
            $upload_result = '';
            $scene = $request->get( 'scene' );
            $page = 'pages/home/positiondetail/positiondetail';

            //判断是否已有生成过二维码
            $job = Job::where( 'ids' , $scene )->first();
            if ( $job && $job->qr_code != null )
            {
                //有，直接返回二维码地址
                return response()->json(
                    [
                        'url' => $job->qr_code ,
                    ] );
            }
            else
            {
                //无，生成二维码再返回
                $response = $this->mini->app_code->getUnlimit(
                    $scene , [
                    'page' => $page ,
                ] );

                if ( $response instanceof StreamResponse )
                {
                    $result = $response->saveAs( storage_path( 'app' ) , $scene . '.png' );
                    //存储到服务器本地
                    $path = storage_path( 'app/' ) . $result;
                    //存储到oss
                    $upload_result = $this->uploadPic( $path );
                    if ( $upload_result )
                    {
                        //删除服务器本地文件
                        unlink( $path );
                        //存储到oss地址存储到服务器
                        $job->qr_code = $upload_result;
                        $job->save();
                    }
                }

                return response()->json(
                    [
                        'url' => $upload_result ,
                    ] );
            }
        }

        /**
         * 获取企业二维码图...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
         * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
         *
         * @author alienware 2019/3/13
         *
         * @todo 需与生成职位二维码接口进行整合
         */
        public function getComQrCode( Request $request )
        {
            $upload_result = '';
            $scene = $request->get( 'scene' );
            $page = 'pages/home/companydetail/companydetail';

            //判断是否已有生成过二维码app
            $com = Company::where( 'ids' , $scene )->first();
            if ( $com && $com->qr_code != null )
            {
                //有，直接返回二维码地址
                return response()->json(
                    [
                        'url' => $com->qr_code ,
                    ] );
            }
            else
            {
                //无，生成二维码再返回
                $response = $this->mini->app_code->getUnlimit(
                    $scene , [
                    'page' => $page ,
                ] );

                if ( $response instanceof StreamResponse )
                {
                    $result = $response->saveAs( storage_path( 'app' ) , $scene . '.png' );
                    $path = storage_path( 'app/' ) . $result;
                    $upload_result = $this->uploadPic( $path );
                    if ( $upload_result )
                    {
                        unlink( $path );
                        $com->qr_code = $upload_result;
                        $com->save();
                    }
                }

                return response()->json(
                    [
                        'url' => $upload_result ,
                    ] );
            }
        }

        /**
         * 获取微信小程序用户信息
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
         *
         * @author alienware 2019/1/9
         */
        public function getUserInfo( Request $request )
        {
            $openid = $request->get( 'openid' );
            $iv = $request->get( 'iv' );
            $encryptData = $request->get( 'authorization_code' );


            $session_key = Speedy::getModelInstance( 'third_session' )->where( 'openid' , $openid )->where( 'valid' , '1' )->first()->session_key;

            $decryptData = $this->mini->encryptor->decryptData( $session_key , $iv , $encryptData );

            $user = Speedy::getModelInstance( 'mini_user' )->where( 'openid' , $openid )->where( 'valid' , '1' )->first();

            if ( $user )
            {
                //更新数据库用户信息
                Speedy::getModelInstance( 'mini_user' )->where( 'openid' , $openid )->where( 'valid' , '1' )->update(
                    [
                        'name' => $decryptData['nickName'] , 'icon' => $decryptData['avatarUrl'] , 'sex' => $decryptData['gender'] , 'language' => $decryptData['language'] , 'country' => $decryptData['country'] , 'province' => $decryptData['province'] , 'city' => $decryptData['city'] ,
                        //'unionId'  => $decryptData['unionId'] ,
                    ] );
            }
            else
            {
                //如数据库没有微信用户信息，则创建新的用户信息
                Speedy::getModelInstance( 'mini_user' )->create(
                    [
                        'openid' => $decryptData['openId'] , 'name' => $decryptData['nickName'] , 'icon' => $decryptData['avatarUrl'] , 'sex' => $decryptData['gender'] , 'language' => $decryptData['language'] , 'country' => $decryptData['country'] , 'province' => $decryptData['province'] , 'city' => $decryptData['city'] ,
                        //'unionId'  => $decryptData['unionId'] ,
                    ] );

            }

            $user = Speedy::getModelInstance( 'mini_user' )->where( 'openid' , $openid )->where( 'valid' , '1' )->first();
            //Speedy::getModelInstance( 'third_session' )->where( 'openid' , $openid )->update( [
            //'unionId' => $decryptData['unionId'] ,
            //] );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user->ids );

            return response()->json(
                [
                    'ids' => $user->ids , 'openid' => $decryptData['openId'] , 'name' => $decryptData['nickName'] , 'icon' => $decryptData['avatarUrl'] , 'sex' => $decryptData['gender'] , 'language' => $decryptData['language'] , 'country' => $decryptData['country'] , 'province' => $decryptData['province'] , 'city' => $decryptData['city'] , 'phone' => $user->phone ,
                    //'unionId'  => $decryptData['unionId'] ,
                ] );
        }

        /**
         * 兼容旧版本，每次登陆小程序判断用户是否已创建新的用户个人信息，无则进行创建...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/4/17
         */
        public function ifOldUser( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );
            if ( $user_ids )
            {
                $this->CreatePersonalInfo( $user_ids );
            }

            return response()->json(
                [
                    'result' => 'success' , 'code' => '888' ,
                ] );
        }

        /**
         * 兼容旧版本，每次登陆小程序判断用户是否已创建新的用户个人信息，无则进行创建...
         *
         * @param string $user_ids
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/4/17
         */
        public function CreatePersonalInfo( $user_ids )
        {
            if ( $user_ids )
            {
                $user = Speedy::getModelInstance( 'mini_user' )->where( 'ids' , $user_ids )->where( 'valid' , '1' )->first();
                $personal_info = Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $user_ids )->where( 'valid' , '1' )->first();
                if ( ! $personal_info )
                {
                    Speedy::getModelInstance( 'personal_info' )->create(
                        [
                            'name' => $user->name , 'icon' => $user->icon , 'user_ids' => $user->ids , 'phone' => $user->phone ,
                        ] );
                }

                return response()->json(
                    [
                        'result' => 'success' , 'code' => '888' ,
                    ] );
            }
            else
            {
                return response()->json(
                    [
                        'result' => 'fail' , 'code' => '000' ,
                    ] );
            }

        }

        /**
         * 获取首页数据...
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @update 2019/3/26 职位列表返回增加筛选项‘行业’
         *
         * @author alienware 2019/3/14
         */
        public function getHomePage( Request $request )
        {
            $city_code = $request->get( 'city_code' );
            $page = $request->get( 'page' );
            $industry = $request->get( 'industry' );
            $user_ids = $request->get( 'user_ids' );

            if ( $user_ids )
            {
                $this->CreatePersonalInfo( $user_ids );
            }

            $banners = Speedy::getModelInstance( 'banner' )->orderBy( 'order_id' , 'DESC' )->get();

            if ( $city_code == 'all' )
            {
                if ( $industry == 'all' )
                {
                    $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'sp_jg' , '1' )->orderBy( 'order_id' , 'ASC' )->offset( $page * 10 )->limit( 10 )->get();
                }
                else
                {
                    $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'sp_jg' , '1' )->where( 'industry' , $industry ? '=' : 'like' , $industry ? $industry : '%%' )->orderBy( 'order_id' , 'ASC' )->offset( $page * 10 )->limit( 10 )->get();

                    /**
                     * 记录用户选择行业记录
                     *
                     * @author alienware 2019/3/13
                     */
                    if ( $user_ids )
                    {
                        Speedy::getModelInstance( 'industry_log' )->create(
                            [
                                'user_ids' => $user_ids , 'industry_code' => $industry ,
                            ] );
                    }
                }
            }
            else
            {
                if ( $industry == 'all' )
                {
                    $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'city_code' , $city_code )->where( 'sp_jg' , '1' )->orderBy( 'order_id' , 'ASC' )->offset( $page * 10 )->limit( 10 )->get();

                    /**
                     * 记录用户选择城市记录
                     *
                     * @author alienware 2019/3/13
                     */
                    if ( $user_ids )
                    {
                        Speedy::getModelInstance( 'city_log' )->create(
                            [
                                'user_ids' => $user_ids , 'city_code' => $city_code ,
                            ] );
                    }
                }
                else
                {
                    $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'city_code' , $city_code )->where( 'industry' , $industry ? '=' : 'like' , $industry ? $industry : '%%' )->where( 'sp_jg' , '1' )->orderBy( 'order_id' , 'ASC' )->offset( $page * 10 )->limit( 10 )->get();

                    /**
                     * 记录用户选择城市记录
                     *
                     * @author alienware 2019/3/13
                     */
                    if ( $user_ids )
                    {
                        Speedy::getModelInstance( 'city_log' )->create(
                            [
                                'user_ids' => $user_ids , 'city_code' => $city_code ,
                            ] );
                    }

                    /**
                     * 记录用户选择行业记录
                     *
                     * @author alienware 2019/3/13
                     */
                    if ( $user_ids )
                    {
                        Speedy::getModelInstance( 'industry_log' )->create(
                            [
                                'user_ids' => $user_ids , 'industry_code' => $industry ,
                            ] );
                    }
                }
            }

            foreach ( $jobs as $j )
            {
                $j->belongsToCompany;
            }

            return response()->json(
                [
                    'banners' => $banners , 'jobs' => $jobs ,
                ] );
        }

        /**
         * 返回职位的行业类别...
         *
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/26
         */
        public function getIndustry()
        {
            $industry = [];

            //添加‘全部’选项
            $all = [];
            array_set( $all , 'label' , '全部' );
            array_set( $all , 'code' , 'all' );
            array_set( $all , 'order_id' , null );

            array_push( $industry , $all );

            //添加其他选项
            $other = Speedy::getModelInstance( 'label' )->where( 'pid' , '002' )->orderBy( 'label' , 'DESC' )->get(
                [
                    'label' , 'code' , 'order_id' ,
                ] )->sortBy(
                function( $item , $key )
                {
                    return strlen( $item['label'] );
                } )->values();

            foreach ( $other as $o )
            {
                array_push( $industry , $o );
            }

            return response()->json(
                [
                    'industry' => $industry ,
                ] );
        }

        /**
         * 返回项目的技术领域...
         *
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/26
         */
        public function getProjectIndustry()
        {
            $industry = [];
            $projects = Speedy::getModelInstance( 'project' )->where( 'valid' , '1' )->get( [ 'industry' ] )->unique( 'industry' );

            //添加‘全部’选项
            $all = [];
            array_set( $all , 'label' , '全部' );
            array_set( $all , 'code' , 'all' );
            array_push( $industry , $all );

            //添加其他选项
            foreach ( $projects as $p )
            {
                $data = [];
                $label = Speedy::getModelInstance( 'label' )->where( 'code' , $p->industry )->where( 'valid' , 1 )->first();
                array_set( $data , 'label' , $label->label );
                array_set( $data , 'code' , $label->code );
                array_push( $industry , $data );
            }

            return response()->json(
                [
                    'industry' => $industry ,
                ] );
        }

        /**
         * 返回技术成熟度类别...
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/04/11
         */
        public function getMaturity( Request $request )
        {
            $type = $request->get( 'type' );
            $maturity = [];
            if ( $type == '1' )
            {
                $projects = Speedy::getModelInstance( 'project' )->where( 'valid' , '1' )->get( [ 'maturity' ] )->unique( 'maturity' );

                //添加‘全部’选项
                $all = [];
                array_set( $all , 'label' , '全部' );
                array_set( $all , 'code' , 'all' );
                array_push( $maturity , $all );

                //添加其他选项
                foreach ( $projects as $p )
                {
                    $data = [];
                    $label = Speedy::getModelInstance( 'label' )->where( 'code' , $p->maturity )->where( 'valid' , 1 )->first();
                    array_set( $data , 'label' , $label->label );
                    array_set( $data , 'code' , $label->code );
                    array_push( $maturity , $data );
                }
            }
            else
            {
                //添加‘全部’选项
                $all = [];
                array_set( $all , 'label' , '全部' );
                array_set( $all , 'code' , 'all' );
                array_push( $maturity , $all );

                $labels = Speedy::getModelInstance( 'label' )->where( 'pid' , '004' )->where( 'valid' , 1 )->get();
                foreach ( $labels as $l )
                {
                    array_set( $data , 'label' , $l->label );
                    array_set( $data , 'code' , $l->code );
                    array_push( $maturity , $data );
                }
            }

            return response()->json(
                [
                    'maturity' => $maturity ,
                ] );
        }

        /**
         * 返回合作方式类别...
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/04/11
         */
        public function getCooperation( Request $request )
        {
            $type = $request->get( 'type' );
            $cooperation = [];

            if ( $type == '1' )
            {
                $projects = Speedy::getModelInstance( 'project' )->where( 'valid' , '1' )->get( [ 'cooperation' ] )->unique( 'cooperation' );

                //添加‘全部’选项
                $all = [];
                array_set( $all , 'label' , '全部' );
                array_set( $all , 'code' , 'all' );
                array_push( $cooperation , $all );

                //添加其他选项
                foreach ( $projects as $p )
                {
                    $data = [];
                    $label = Speedy::getModelInstance( 'label' )->where( 'code' , $p->cooperation )->where( 'valid' , 1 )->first();
                    array_set( $data , 'label' , $label->label );
                    array_set( $data , 'code' , $label->code );
                    array_push( $cooperation , $data );
                }
            }
            else
            {
                //添加‘全部’选项
                $all = [];
                array_set( $all , 'label' , '全部' );
                array_set( $all , 'code' , 'all' );
                array_push( $cooperation , $all );

                $labels = Speedy::getModelInstance( 'label' )->where( 'pid' , '003' )->where( 'valid' , 1 )->get();
                foreach ( $labels as $l )
                {
                    array_set( $data , 'label' , $l->label );
                    array_set( $data , 'code' , $l->code );
                    array_push( $cooperation , $data );
                }
            }

            return response()->json(
                [
                    'cooperation' => $cooperation ,
                ] );
        }

        /**
         * 获取有职位的城市...
         *
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/19
         */
        public function getJobCity()
        {
            $city = [];
            $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->get( [ 'city_code' ] )->unique( 'city_code' );

            //添加‘全部’选项
            $all = [];
            array_set( $all , 'name' , '全部' );
            array_set( $all , 'code' , 'all' );
            array_push( $city , $all );

            //添加其他城市
            foreach ( $jobs as $j )
            {
                $data = [];
                $label = Speedy::getModelInstance( 'label' )->where( 'code' , $j->city_code )->where( 'valid' , 1 )->first();
                array_set( $data , 'name' , $label->label );
                array_set( $data , 'code' , $label->code );
                array_push( $city , $data );
            }

            return response()->json(
                [
                    'city' => $city ,
                ] );
        }

        /**
         * 获取banner列表
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/1/9
         */
        public function getBannerList()
        {
            $banners = Speedy::getModelInstance( 'banner' )->get();

            return response()->json(
                [
                    'banner' => $banners ,
                ] );
        }

        /**
         * 获取职位列表
         *
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/1/9
         */
        public function getJobList()
        {
            $jobs = Job::where( 'valid' , '1' )->get();

            foreach ( $jobs as $j )
            {
                $j->belongsToCompany;
            }

            return response()->json(
                [
                    'jobs' => $jobs ,
                ] );
        }

        /**
         * 根据职位ID查找职位...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/13
         */
        public function getJobById( Request $request )
        {
            $job_ids = $request->get( 'job_ids' );
            $user_ids = $request->get( 'user_ids' );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user_ids );

            $job = Job::where( 'ids' , $job_ids )->where( 'valid' , '1' )->first();
            $job->belongsToCompany;

            $recommend_data = RecommendData::where( 'valid' , '1' )->first();

            /**
             * 记录用户浏览记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'view_log' )->create(
                [
                    'user_ids' => $user_ids , 'type' => '1' , 'target_ids' => $job_ids ,
                ] );

            return response()->json(
                [
                    'job' => $job , 'recommend_data' => $recommend_data ,
                ] );
        }


        /**
         * 获取推荐职位...
         *
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/19
         */
        public function getRecommendJobs()
        {
            $recommend_jobs = Job::where( 'valid' , '1' )->inRandomOrder()->limit( '3' )->get();

            foreach ( $recommend_jobs as $r )
            {
                $r->belongsToCompany;
            }

            return response()->json(
                [
                    'recommend_jobs' => $recommend_jobs ,
                ] );
        }


        /**
         * 根据企业id获取企业信息...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/14
         */
        public function getCompanyById( Request $request )
        {
            $id = $request->get( 'ids' );
            $user_ids = $request->get( 'user_ids' );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user_ids );

            $company = Company::where( 'ids' , $id )->first();
            if ( $company )
            {
                $company->hasManyJobs;
            }

            /**
             * 记录用户浏览记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'view_log' )->create(
                [
                    'user_ids' => $user_ids , 'type' => '3' , 'target_ids' => $id ,
                ] );

            return response()->json(
                [
                    'company' => $company ,
                ] );
        }

        /**
         * 获取活动列表
         *
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/1/9
         */
        public function getActivityList()
        {
            setlocale( LC_TIME , 'Chinese' );
            $Carbon = new Carbon();

            $now = $Carbon->now();

            $under_way = Activity::where( 'valid' , '1' )->where( 'sign_up_end_time' , '>' , $now )->where( 'sp_jg' , '1' )->get();


            foreach ( $under_way as $u )
            {
                $time = $Carbon->setTimeFromTimeString( $u->start_time )->formatLocalized( '%b%dd %A' );
                $time = iconv( 'GBK' , 'UTF-8' , $time );
                $time = str_replace( [ 'y' , 'd' ] , [ '年' , '日' ] , $time );

                $u->setAttribute( 'show_time' , $time );
                $u->setAttribute(
                    'label' , Speedy::getModelInstance( 'label' )->where( 'code' , $u->city_code )->first()->label );
            }

            $finish = Activity::where( 'valid' , '1' )->where( 'sign_up_end_time' , '<=' , $now )->where( 'sp_jg' , '1' )->orderBy( 'created_at' , 'DESC' )->get();
            foreach ( $finish as $f )
            {
                $time = $Carbon->setTimeFromTimeString( $f->start_time )->formatLocalized( '%b%dd %A' );
                $time = iconv( 'GBK' , 'UTF-8' , $time );
                $time = str_replace( [ 'y' , 'd' ] , [ '年' , '日' ] , $time );

                $f->setAttribute( 'show_time' , $time );
                $f->setAttribute(
                    'label' , Speedy::getModelInstance( 'label' )->where( 'code' , $f->city_code )->first()->label );
            }

            return response()->json(
                [
                    'under_way' => $under_way , 'finish' => $finish ,
                ] );
        }


        /**
         * 根据活动id获取活动信息...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/14
         */
        public function getActivityById( Request $request )
        {
            $id = $request->get( 'activity_ids' );
            $uid = $request->get( 'user_ids' );
            $activity = Activity::where( 'ids' , $id )->first();

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $uid );

            $is_end = Carbon::createFromTimeString( $activity->sign_up_end_time )->lessThanOrEqualTo( Carbon::now() ) ? '1' : '0';
            $sign_up = SignUp::where( 'user_ids' , $uid )->where( 'activity_ids' , $id )->first();

            $same_day = Carbon::createFromTimeString( $activity->start_time )->isSameDay( Carbon::createFromTimeString( $activity->end_time ) );

            if ( $same_day )
            {
                $show_time = substr(
                        Carbon::createFromTimeString( $activity->start_time )->toDateString() , 5 , 6 ) . ' ' . substr(
                        Carbon::createFromTimeString( $activity->start_time )->toTimeString() , 0 , 5 ) . ' - ' . substr(
                        Carbon::createFromTimeString( $activity->end_time )->toTimeString() , 0 , 5 );
            }
            else
            {
                $show_time = substr(
                        Carbon::createFromTimeString( $activity->start_time )->toDateTimeString() , 5 , 11 ) . ' - ' . substr(
                        Carbon::createFromTimeString( $activity->end_time )->toDateTimeString() , 5 , 11 );
            }

            /**
             * 记录用户浏览记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'view_log' )->create(
                [
                    'user_ids' => $uid , 'type' => '2' , 'target_ids' => $id ,
                ] );

            return response()->json(
                [
                    'activity' => $activity , 'sign_up' => $sign_up ? '1' : '0' , 'is_end' => $is_end , 'show_time' => $show_time ,
                ] );
        }

        /**
         * 提交活动报名信息...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/14
         */
        public function signUp( Request $request )
        {
            $phone = $request->get( 'phone' );
            $activity_ids = $request->get( 'activity_ids' );
            $user_ids = $request->get( 'user_ids' );
            $field = $request->get( 'field' );

            $sign_up = SignUp::where( 'user_ids' , $user_ids )->where( 'activity_ids' , $activity_ids )->first();

            if ( ! $sign_up )
            {
                Speedy::getModelInstance( 'sign_up' )->create(
                    [
                        'phone' => $phone , 'activity_ids' => $activity_ids , 'user_ids' => $user_ids , 'field' => $field ,
                    ] );

                $inform = new InformUserController();
                $sendList = [];
                $sends = Speedy::getModelInstance( 'inform' )->where( 'type' , '2' )->where( 'valid' , '1' )->get( [ 'phone' ] );
                foreach ( $sends as $s )
                {
                    array_push( $sendList , $s->phone );
                }

                $inform->sendSms( implode( ',' , $sendList ) );

            }

            return response()->json(
                [
                    'result' => 'success' , 'code' => '888' ,
                ] );
        }


        /**
         * 获取我的推荐名单...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/14
         */
        public function getMyRecommend( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );

            $under_way = Speedy::getModelInstance( 'recommend' )->where( 'user_ids' , $user_ids )->where( 'status' , '<=' , '2' )->get();
            foreach ( $under_way as $u )
            {
                $job = Job::where( 'ids' , $u->job_ids )->first();
                $job->belongsToCompany;
                $u->setAttribute( 'job' , $job );
            }

            $finish = Recommend::where( 'user_ids' , $user_ids )->where( 'status' , '>' , '2' )->get();
            foreach ( $finish as $f )
            {
                $job = Job::where( 'ids' , $f->job_ids )->first();
                $job->belongsToCompany;
                $f->setAttribute( 'job' , $job );
            }

            return response()->json(
                [
                    'under_way' => $under_way , 'finish' => $finish ,
                ] );
        }


        /**
         * 根据推荐ID获取详情...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/19
         */
        public function getRecommendById( Request $request )
        {
            $ids = $request->get( 'ids' );
            $recommend = Speedy::getModelInstance( 'recommend' )->where( 'ids' , $ids )->first();
            $job = Job::where( 'ids' , $recommend->job_ids )->first();
            $job->belongsToCompany;
            $recommend->setAttribute( 'job' , $job );

            return response()->json(
                [
                    'recommend' => $recommend ,
                ] );
        }

        /**
         * 获取我参与过的活动...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/14
         */
        public function getMyActivity( Request $request )
        {

            $user_ids = $request->get( 'user_ids' );
            $sign_ups = SignUp::where( 'user_ids' , $user_ids )->get();

            setlocale( LC_TIME , 'Chinese' );
            $Carbon = new Carbon();

            foreach ( $sign_ups as $s )
            {
                $time = $Carbon->setTimeFromTimeString( $s->belongsToActivity->start_time )->formatLocalized( '%b%dd %A' );
                $time = iconv( 'GBK' , 'UTF-8' , $time );
                $time = str_replace( [ 'y' , 'd' ] , [ '年' , '日' ] , $time );
                $s->setAttribute( 'show_time' , $time );
                $s->setAttribute(
                    'label' , Speedy::getModelInstance( 'label' )->where( 'code' , $s->belongsToActivity->city_code )->first()->label );
            }

            return response()->json(
                [
                    'activity' => $sign_ups ,
                ] );
        }

        /**
         * 用户绑定手机...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/15
         */
        public function bindingPhone( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );
            $phone = $request->get( 'phone' );
            $code = $request->get( 'code' );

            $sms = Speedy::getModelInstance( 'sms' )->where( 'verify_code' , $code )->where( 'phone' , $phone )->first();
            if ( $sms )
            {
                $dif = Carbon::now()->diffInMinutes( $sms->created_at );
                if ( $dif > 5 )
                {
                    return response()->json(
                        [
                            'result' => 'overtime' , 'code' => '555' ,
                        ] );
                }
                else
                {
                    Speedy::getModelInstance( 'mini_user' )->where( 'ids' , $user_ids )->update(
                        [
                            'phone' => $phone ,
                        ] );
                    Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $user_ids )->update(
                        [
                            'phone' => $phone ,
                        ] );

                    return response()->json(
                        [
                            'result' => 'success' , 'code' => '888' ,
                        ] );
                }
            }
            else
            {
                return response()->json(
                    [
                        'result' => 'fail' , 'code' => '000' ,
                    ] );
            }
        }


        /**
         * 提交推荐信息...
         *
         * @param object $data
         *
         * @return string
         *
         * @author alienware 2019/3/19
         * @update Lee 2020/4/4 更新提交简历字段
         * @update Lee 2020/4/29 更新提交过程需要上传简历附件，同时取消接口直接调用
         */
        public function submitRecommend( $data )
        {
            $user_ids = $data['user_ids'];
            $job_ids = $data['job_ids'];
            $type = $data['type'];
            $name = $data['name'];
            $phone = $data['phone'];
            $email = $data['email'];
            $education = $data['education'];
            $work = $data['work'];
            $honor = $data['honor'];
            $skill = $data['skill'];
            $intro = $data['intro'];
            $resume = $data['resume'];

            $recommend = Speedy::getModelInstance( 'recommend' )->where( 'phone' , $phone )->where( 'user_ids' , $user_ids )->where( 'job_ids' , $job_ids )->first();
            if ( $recommend )
            {
                return 'committed';
            }
            else
            {
                $result = Speedy::getModelInstance( 'recommend' )->create(
                    [
                        'name'  => $name ,
                        'phone' => $phone ,
                        'eduBg' => $education ,
                        'user_ids' => $user_ids ,
                        'job_ids' => $job_ids ,
                        'email' => $email ,
                        'type' => $type ,
                        'skill' => $skill ,
                        'experience' => $work ,
                        'honor' => $honor ,
                        'intro' => $intro ,
                        'resume_url' => $resume ,
                    ] );
                if ( $result )
                {
                    $inform = new InformUserController();
                    $sendList = [];
                    $sends = Speedy::getModelInstance( 'inform' )->where( 'type' , '1' )->where( 'valid' , '1' )->get( [ 'phone' ] );
                    foreach ( $sends as $s )
                    {
                        array_push( $sendList , $s->phone );
                    }

                    $inform->sendSms( implode( ',' , $sendList ) );

                    /**
                     * 更新用户填写的简历信息到档案中，下次提交简历可直接使用
                     *
                     * @author Lee 2020/4/7
                     */
                    //删除旧有教育背景
                    Speedy::getModelInstance( 'education' )->where( 'personal_ids' , $user_ids )->update(
                        [
                            'valid' => '0' ,
                        ] );
                    //更新教育背景
                    foreach ( json_decode( $education ) as $e )
                    {
                        //更新本次教育背景信息
                        Speedy::getModelInstance( 'education' )->create(
                            [
                                'start_time' => $e->start_time , 'end_time' => $e->end_time , 'school' => $e->school , 'major' => $e->major , 'degree' => $e->degree , 'personal_ids' => $user_ids ,
                            ] );
                    }

                    //删除旧有工作经历
                    Speedy::getModelInstance( 'working' )->where( 'personal_ids' , $user_ids )->update(
                        [
                            'valid' => '0' ,
                        ] );
                    //更新本次教育背景信息
                    foreach ( json_decode( $work ) as $w )
                    {
                        Speedy::getModelInstance( 'working' )->create(
                            [
                                'start_time' => $w->start_time , 'end_time' => $w->end_time , 'company' => $w->company , 'job' => $w->job , 'content' => $w->content , 'personal_ids' => $user_ids ,
                            ] );
                    }

                    //删除旧有荣誉
                    Speedy::getModelInstance( 'honor' )->where( 'personal_ids' , $user_ids )->update(
                        [
                            'valid' => '0' ,
                        ] );
                    foreach ( json_decode( $honor ) as $h )
                    {
                        Speedy::getModelInstance( 'honor' )->create(
                            [
                                'time' => $h->time , 'title' => $h->title , 'personal_ids' => $user_ids ,
                            ] );
                    }

                    //更新个人简历中的个人介绍及技能特长，简历地址
                    Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $user_ids )->update(
                        [
                            'skill' => $skill , 'intro' => $intro , 'email' => $email , 'real_name' => $name , 'resume_url' => $resume ,
                        ] );

                    /**
                     * 更新推荐信息到人才库，如用户提交的推荐信息中手机号码在数据库中已存在，则在原人才记录上增加
                     * 推荐职位，否则新增一条新的人才记录到数据库...
                     *
                     * @author Lee 2019/5/21
                     */
                    $talent = Speedy::getModelInstance( 'talent' )->where( 'phone' , $phone )->where( 'user_ids' , $user_ids )->where( 'valid' , '1' )->first();
                    if ( $talent )
                    {
                        $jobs = explode( ',' , $talent->job_ids );
                        array_push( $jobs , $job_ids );
                        $str = join( "," , array_values( $jobs ) );
                        $talent->job_ids = $str;
                        $talent->if_resume = '1';
                        $talent->resume_url = $resume;
                        $talent->save();
                    }
                    else
                    {
                        Speedy::getModelInstance( 'talent' )->create(
                            [
                                'name'     => $name ,
                                'phone'    => $phone ,
                                'job_ids' => $job_ids ,
                                'user_ids' => $user_ids ,
                                'email' => $email ,
                                'if_resume' => '1' ,
                                'resume_url' => $resume ,
                            ] );
                    }

                    return 'success';
                }
                else
                {
                    return 'error';
                }
            }
        }

        /**
         * 提交用户反馈...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/20
         */
        public function submitFeedback( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );
            $content = $request->get( 'content' );

            $result = Speedy::getModelInstance( 'feedback' )->create(
                [
                    'user_ids' => $user_ids , 'content' => $content ,
                ] );

            if ( $result )
            {
                return response()->json(
                    [
                        'result' => 'success' , 'code' => '888' ,
                    ] );
            }
            else
            {
                return response()->json(
                    [
                        'result' => 'fail' , 'code' => '000' ,
                    ] );
            }
        }


        /**
         * 根据职位名称搜索职位...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/3/24
         */
        public function searchJobs( Request $request )
        {
            $name = $request->get( 'name' );
            $user_ids = $request->get( 'user_ids' );

            $jobs = [];

            $jobByJobName = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'title' , 'like' , '%' . $name . '%' )->where( 'sp_jg' , '1' )->get();
            foreach ( $jobByJobName as $v )
            {
                $v->belongsToCompany;
                array_push( $jobs , $v );
            }


            //根据职位专业搜索，2019-8-26新增
            $jobByMajorName = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'type' , 'like' , '%' . $name . '%' )->where( 'sp_jg' , '1' )->get();
            foreach ( $jobByMajorName as $v )
            {
                $v->belongsToCompany;
                array_push( $jobs , $v );
            }

            $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where( 'name' , 'like' , '%' . $name . '%' )->get();
            foreach ( $companies as $c )
            {
                $jobByComName = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'com_ids' , $c->ids )->where( 'sp_jg' , '1' )->get();
                foreach ( $jobByComName as $v )
                {
                    $v->belongsToCompany;
                    array_push( $jobs , $v );
                }
            }

            /**
             * 记录用户搜索记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'search_log' )->create(
                [
                    'user_ids' => $user_ids , 'keyword' => $name , 'count_result' => count( $jobs ) ,
                ] );

            return response()->json(
                [
                    'jobs' => $jobs ,
                ] );
        }

        /**
         * 获取用户个人信息...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/4/11
         */
        public function getPersonalInfo( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user_ids );

            $info = Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $user_ids )->first();
            $learning_label = Speedy::getModelInstance( 'label' )->where( 'code' , $info->learning )->first();
            $info->setAttribute( 'learning_label' , $learning_label );
            $info->hasManyEducation;
            $info->hasManyWorking;
            $info->hasManyHonor;

            $project = Speedy::getModelInstance( 'project' )->where( 'user_ids' , $user_ids )->where( 'valid' , '1' )->first();
            if ( $project )
            {
                $project->belongsToUserList;
                $industry_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->industry )->first( [ 'label' , 'code' ] );
                $maturity_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->maturity )->first( [ 'label' , 'code' ] );
                $cooperation_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->cooperation )->first( [ 'label' , 'code' ] );
                $project->setAttribute( 'industry_label' , $industry_label );
                $project->setAttribute( 'maturity_label' , $maturity_label );
                $project->setAttribute( 'cooperation_label' , $cooperation_label );
            }
            else
            {
                $project = collect();
            }

            return response()->json(
                [
                    'info' => $info , 'project' => $project ,
                ] );
        }

        /**
         * 查询教育经历，荣誉情况，工作情况接口...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/4/12
         */
        public function getExperienceList( Request $request )
        {
            $type = $request->get( 'type' );
            $ids = $request->get( 'ids' );

            if ( $type == 'education' )
            {
                $list = Speedy::getModelInstance( 'education' )->where( 'ids' , $ids )->where( 'valid' , '1' )->first();
            }
            else if ( $type == 'working' )
            {
                $list = Speedy::getModelInstance( 'wording' )->where( 'ids' , $ids )->where( 'valid' , '1' )->first();

            }
            else
            {
                $list = Speedy::getModelInstance( 'honor' )->where( 'ids' , $ids )->where( 'valid' , '1' )->first();
            }

            return response()->json(
                [
                    'list' => $list ,
                ] );
        }

        /**
         * 获取项目列表...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/4/11
         */
        public function getProjectsList( Request $request )
        {
            $page = $request->get( 'page' );
            $industry = $request->get( 'industry' );
            $maturity = $request->get( 'maturity' );
            $cooperation = $request->get( 'cooperation' );

            $projects = Speedy::getModelInstance( 'project' )->where( 'valid' , '1' )->where( 'industry' , 'like' , $industry == 'all' ? '%%' : '%' . $industry . '%' )//技术领域
            ->where( 'maturity' , 'like' , $maturity == 'all' ? '%%' : '%' . $maturity . '%' )//技术成熟度
            ->where( 'cooperation' , 'like' , $cooperation == 'all' ? '%%' : '%' . $cooperation . '%' )//合作方式
            ->orderBy( 'updated_at' , 'DESC' )->offset( $page * 10 )->limit( 10 )->get();

            foreach ( $projects as $p )
            {
                $p->belongsToUserList;
                $industry_label = Speedy::getModelInstance( 'label' )->where( 'code' , $p->industry )->first();
                $maturity_label = Speedy::getModelInstance( 'label' )->where( 'code' , $p->maturity )->first();
                $cooperation_label = Speedy::getModelInstance( 'label' )->where( 'code' , $p->cooperation )->first();
                $p->setAttribute( 'industry_label' , $industry_label );
                $p->setAttribute( 'maturity_label' , $maturity_label );
                $p->setAttribute( 'cooperation_label' , $cooperation_label );
            }

            return response()->json(
                [
                    'project' => $projects ,
                ] );
        }

        /**
         * 获取项目详情...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/4/11
         */
        public function getProjectById( Request $request )
        {
            $id = $request->get( 'ids' );
            $user_ids = $request->get( 'user_ids' );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user_ids );

            $project = Speedy::getModelInstance( 'project' )->where( 'ids' , $id )->first();
            $project->view_count += 1;
            $project->save();
            if ( $project )
            {
                $industry_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->industry )->first()->label;
                $maturity_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->maturity )->first()->label;
                $cooperation_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->cooperation )->first()->label;
                $is_like = Speedy::getModelInstance( 'like_project' )->where( 'user_ids' , $user_ids )->where( 'project_ids' , $id )->where( 'valid' , '1' )->first();
                if ( $is_like )
                {
                    $project->setAttribute( 'is_like' , '1' );
                }
                else
                {
                    $project->setAttribute( 'is_like' , '0' );
                }
                $project->setAttribute( 'industry_label' , $industry_label );
                $project->setAttribute( 'maturity_label' , $maturity_label );
                $project->setAttribute( 'cooperation_label' , $cooperation_label );
                if ( $project->belongsToUser->learning )
                {
                    $learning_label = Speedy::getModelInstance( 'label' )->where( 'code' , $project->belongsToUser->learning )->first()->label;
                    $project->belongsToUser->setAttribute( 'learning_label' , $learning_label );

                }
                $project->belongsToUser->hasManyEducation;
                $project->belongsToUser->hasManyWorking;
                $project->belongsToUser->hasManyHonor;

            }
            /**
             * 记录用户浏览记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'view_log' )->create(
                [
                    'user_ids' => $user_ids , 'type' => '4' , 'target_ids' => $id ,
                ] );

            return response()->json(
                [
                    'project' => $project ,
                ] );
        }

        /**
         * 提交感兴趣项目...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/4/23
         */
        public function likeProject( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );
            $company = $request->get( 'company' );
            $project_ids = $request->get( 'project_ids' );
            $name = $request->get( 'name' );
            $job = $request->get( 'job' );

            $like = Speedy::getModelInstance( 'like_project' )->where( 'user_ids' , $user_ids )->where( 'project_ids' , $project_ids )->where( 'valid' , '1' )->first();
            $project = Speedy::getModelInstance( 'project' )->where( 'ids' , $project_ids )->where( 'valid' , '1' )->first();
            if ( $like )
            {
                return response()->json(
                    [
                        'result' => 'success' , 'code' => '888' ,
                    ] );
            }
            else
            {
                $project->like_count += 1;
                $project->save();
                $result = Speedy::getModelInstance( 'like_project' )->create(
                    [
                        'user_ids' => $user_ids , 'company' => $company , 'project_ids' => $project_ids , 'name' => $name , 'job' => $job ,
                    ] );
                if ( $result )
                {
                    return response()->json(
                        [
                            'result' => 'success' , 'code' => '888' ,
                        ] );
                }
                else
                {
                    return response()->json(
                        [
                            'result' => 'fail' , 'code' => '000' ,
                        ] );
                }
            }

        }

        /**
         * 用户创建项目...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/4/11
         */
        public function createProject( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );

            $title = $request->get( 'title' );
            $industry = $request->get( 'industry' );
            $maturity = $request->get( 'maturity' );
            $cooperation = $request->get( 'cooperation' );
            $requirement = $request->get( 'requirement' );
            $description = $request->get( 'description' );

            $result = Speedy::getModelInstance( 'project' )->create(
                [
                    'title' => $title , 'industry' => $industry , 'maturity' => $maturity , 'cooperation' => $cooperation , 'requirement' => $requirement , 'description' => $description , 'user_ids' => $user_ids ,
                ] );

            if ( $result )
            {
                return response()->json(
                    [
                        'result' => 'success' , 'code' => '888' ,
                    ] );
            }
            else
            {
                return response()->json(
                    [
                        'result' => 'fail' , 'code' => '000' ,
                    ] );
            }

        }

        /**
         * 修改项目内容...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/4/11
         */
        public function editProject( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );
            $id = $request->get( 'id' );

            $title = $request->get( 'title' );
            $industry = $request->get( 'industry' );
            $maturity = $request->get( 'maturity' );
            $cooperation = $request->get( 'cooperation' );
            $requirement = $request->get( 'requirement' );
            $description = $request->get( 'description' );
            $handle = $request->get( 'handle' );

            if ( $handle == null )
            {
                $project = Speedy::getModelInstance( 'project' )->where( 'ids' , $id )->where( 'user_ids' , $user_ids )->where( 'valid' , '1' )->first();
                if ( $project )
                {
                    $project->title = $title;
                    $project->industry = $industry;
                    $project->maturity = $maturity;
                    $project->cooperation = $cooperation;
                    if ( isset( $requirement ) )
                    {
                        $project->requirement = $requirement;
                    }
                    $project->description = $description;
                    $project->save();

                    return response()->json(
                        [
                            'result' => 'success' , 'code' => '888' ,
                        ] );
                }
                else
                {
                    return response()->json(
                        [
                            'result' => 'fail' , 'code' => '000' ,
                        ] );
                }
            }
            else
            {
                $project = Speedy::getModelInstance( 'project' )->where( 'ids' , $id )->where( 'user_ids' , $user_ids )->first();
                $project->valid = '0';
                $project->save();

                return response()->json(
                    [
                        'result' => 'success' , 'code' => '888' ,
                    ] );
            }

        }

        /**
         * 修改个人信息...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/4/11
         */
        public function editPersonalInfo( Request $request )
        {
            $user_ids = $request->get( 'user_ids' );

            $name = $request->get( 'name' );
            $icon = $request->get( 'icon' );

            $company = $request->get( 'company' );
            $email = $request->get( 'email' );

            $learning = $request->get( 'learning' );
            $education = $request->get( 'education' );
            $working = $request->get( 'working' );
            $honor = $request->get( 'honor' );

            /**
             * 保存用户上传个人信息
             *
             * @author Lee 2019/04/11
             */
            $personal_info = Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $user_ids )->where( 'valid' , '1' )->first();
            //名称
            $name ? $personal_info->name = $name : $name = null;
            //头像
            $icon ? $personal_info->icon = $icon : $icon = null;
            //单位
            $company ? $personal_info->company = $company : $company = null;
            //邮箱
            $email ? $personal_info->email = $email : $email = null;
            //学术领域
            $learning ? $personal_info->learning = $learning : $learning = null;

            $personal_info->save();

            //教育经历
            if ( $education )
            {
                if ( isset( json_decode( $education )->id ) )
                {
                    if ( isset( json_decode( $education )->handle ) )
                    {
                        $education_item = Speedy::getModelInstance( 'education' )->where( 'id' , json_decode( $education )->id )->first();
                        $education_item->valid = '0';
                        $education_item->save();
                    }
                    else
                    {
                        $education_item = Speedy::getModelInstance( 'education' )->where( 'id' , json_decode( $education )->id )->first();
                        $education_item->start_time = json_decode( $education )->start_time;
                        $education_item->end_time = json_decode( $education )->end_time;
                        $education_item->school = json_decode( $education )->school;
                        $education_item->degree = json_decode( $education )->degree;
                        $education_item->major = json_decode( $education )->major;
                        $education_item->save();
                    }

                }
                else
                {
                    Speedy::getModelInstance( 'education' )->create(
                        [
                            'start_time' => json_decode( $education )->start_time , 'end_time' => json_decode( $education )->end_time , 'school' => json_decode( $education )->school , 'degree' => json_decode( $education )->degree , 'personal_ids' => $user_ids , 'major' => json_decode( $education )->major ,
                        ] );
                }
            }

            //工作经历
            if ( $working )
            {
                if ( isset( json_decode( $working )->id ) )
                {
                    if ( isset( json_decode( $working )->handle ) )
                    {
                        $working_item = Speedy::getModelInstance( 'working' )->where( 'id' , json_decode( $working )->id )->first();
                        $working_item->valid = '0';
                        $working_item->save();
                    }
                    else
                    {
                        $working_item = Speedy::getModelInstance( 'working' )->where( 'id' , json_decode( $working )->id )->first();
                        $working_item->start_time = json_decode( $working )->start_time;
                        $working_item->end_time = json_decode( $working )->end_time;
                        $working_item->company = json_decode( $working )->company;
                        $working_item->job = json_decode( $working )->job;
                        $working_item->content = json_decode( $working )->content;
                        $working_item->save();
                    }
                }
                else
                {
                    Speedy::getModelInstance( 'working' )->create(
                        [
                            'start_time' => json_decode( $working )->start_time , 'end_time' => json_decode( $working )->end_time , 'company' => json_decode( $working )->company , 'job' => json_decode( $working )->job , 'personal_ids' => $user_ids , 'content' => json_decode( $working )->content ,
                        ] );
                }
            }

            //荣誉
            if ( $honor )
            {
                if ( isset( json_decode( $honor )->id ) )
                {
                    if ( isset( json_decode( $honor )->handle ) )
                    {
                        $honor_item = Speedy::getModelInstance( 'honor' )->where( 'id' , json_decode( $honor )->id )->first();
                        $honor_item->valid = '0';
                        $honor_item->save();
                    }
                    else
                    {
                        $honor_item = Speedy::getModelInstance( 'honor' )->where( 'id' , json_decode( $honor )->id )->first();
                        $honor_item->time = json_decode( $honor )->time;
                        $honor_item->title = json_decode( $honor )->title;
                        $honor_item->save();
                    }
                }
                else
                {
                    Speedy::getModelInstance( 'honor' )->create(
                        [
                            'time' => json_decode( $honor )->time , 'title' => json_decode( $honor )->title , 'personal_ids' => $user_ids ,
                        ] );
                }
            }

            return response()->json(
                [
                    'result' => 'success' , 'code' => '888' ,
                ] );
        }

        public function uploadMiniProgramPic( Request $request )
        {
            $payload = $request->all();
            $file = $payload['file'];
            $upload_result = $this->uploadMiniPic( $file );

            return response()->json(
                [
                    'pic' => $upload_result ,
                ] );
        }

        /**
         * 上传图片...
         *
         * @param $path
         *
         * @return null
         *
         * @author alienware 2019/1/25
         */
        public function uploadPic( $path )
        {
            $file = $path;

            if ( isset( $file ) )
            {
                //要保存的文件名 时间+扩展名

                $filename = 'qr_code/' . date( 'Y-m-d' ) . '/' . uniqid() . '.png';

                //保存文件          配置文件存放文件的名字  ，文件名，路径

                $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $file ) );

                if ( $bool )
                {
                    $pic_url = Storage::url( $filename ); // get the file url

                    return $pic_url;
                }
                else
                {
                    return null;
                }
            }
        }

        /**
         * 上传图片...
         *
         * @param $path
         *
         * @return null
         *
         * @author alienware 2019/1/25
         *
         * @todo 需与上传用户图片接口整合
         *
         */
        public function uploadMiniPic( $path )
        {
            $file = $path;

            if ( isset( $file ) )
            {
                //要保存的文件名 时间+扩展名

                $filename = 'avatar/' . date( 'Y-m-d' ) . '/' . uniqid() . '.png';

                //保存文件          配置文件存放文件的名字  ，文件名，路径

                $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $file ) );

                if ( $bool )
                {
                    $pic_url = Storage::url( $filename ); // get the file url

                    return $pic_url;
                }
                else
                {
                    return null;
                }
            }
        }

        /**
         * 保存远程文件到阿里云oss...
         *
         * @param $path
         *
         * @return null
         *
         * @author alienware 2019/4/11
         */
        public function putRemoteFile( $path )
        {
            //要保存的文件名 时间+扩展名
            $filename = 'icon/' . date( 'Y-m-d' ) . '/' . uniqid() . '.png';

            //upload remote file to storage by remote url
            $bool = Storage::putRemoteFile( $filename , $path );
            if ( $bool )
            {
                $pic_url = Storage::url( $filename ); // get the file url

                return $pic_url;
            }
            else
            {
                return null;
            }
        }

        /**
         * 专题公司搜索接口，可根据职位名称或公司名称、行业对公司进行搜索，可作为搜索结果页或原始列表页...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/9/30
         *
         * @updated_at 2019/10/14
         */
        public function searchSubjectCompany( Request $request )
        {
            //获取参数
            $name = $request->get( 'name' ); //公司名称或职位名称
            $subjectId = $request->get( 'subjectId' ); //专题ID
            $page = $request->get( 'page' ) ? $request->get( 'page' ) : 0; //页码
            $industry = $request->get( 'industry' ); //行业

            //根据职位名称及行业搜索
            $comArr = [];
            $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'title' , 'like' , '%' . $name . '%' )//职位名称
            ->where( 'type' , 'like' , '%' . $industry . '%' )//行业
            ->where( 'special_subject_id' , $subjectId )//专题ID
            ->groupBy( 'com_ids' )->get( [ 'com_ids' ] )->toArray();
            foreach ( $jobs as $j )
            {
                array_push( $comArr , $j['com_ids'] );
            }

            //根据企业名称及行业搜索
            $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where( 'name' , 'like' , '%' . $name . '%' )//企业名称
            ->where( 'type' , 'like' , '%' . $industry . '%' )//行业
            ->where( 'special_subject_id' , $subjectId )//专题ID
            ->orWhereIn( 'ids' , $comArr )//与根据职位名称搜索出的企业名单进行整合
            ->orderBy( 'updated_at' , 'DESC' )//按更新时间降序排列
            ->offset( $page * 10 )//分页
            ->limit( 10 )//每页10个
            ->get( [ 'ids' , 'name' , 'property' , 'scale' , 'type' ] );//返回字段名称

            foreach ( $companies as $c )
            {
                //在招岗位数及在招岗位名称
                $jobs = Speedy::getModelInstance( 'job' )->where( 'com_ids' , $c->ids )->where( 'valid' , '1' )->where( 'special_subject_id' , $subjectId )->get( [ 'title' ] );
                $counts = $jobs->count();
                $c->setAttribute( 'jobCounts' , $counts );
                $c->setAttribute( 'jobs' , $jobs );
            }

            return response()->json(
                [
                    'result' => 'success' , 'data' => $companies ,
                ] );
        }

        /**
         * 获取招聘专题页面推荐的企业列表接口
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/10/24
         *
         * @update Lee 2019/11/7 修改返回数据排序
         *
         */
        public function getSubjectCompany( Request $request )
        {
            $subjectId = $request->get( 'subjectId' );

            //自定义排序
            $sortArr = [ '002010' , '002013' , '002009' , '002007' , '002002' ];

            $data = new Collection();

            foreach ( $sortArr as $s )
            {
                $data->push( Speedy::getModelInstance( 'label' )->where( 'code' , $s )->first( [ 'label' , 'code' ] ) );
            }

            $labels = Speedy::getModelInstance( 'label' )->where( 'pid' , '002' )->whereNotIn( 'code' , $sortArr )->get(
                [
                    'label' , 'code' ,
                ] );

            foreach ( $labels as $l )
            {
                $data->push( $l );
            }

            foreach ( $data as $d )
            {
                $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where( 'special_subject_id' , $subjectId )->where( 'type' , 'like' , '%' . $d->label . '%' )->where( 'recommend' , '1' )->limit( 6 )->get( [ 'ids' , 'name' , 'property' , 'scale' , 'type' ] );
                $d->setAttribute( 'companies' , $companies );
            }

            return response()->json(
                [
                    'result' => 'success' , 'data' => $data ,
                ] );
        }

        /**
         * 获取招聘专题页面推荐的科技成果及项目需求列表接口
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/10/24
         *
         */
        public function getSubjectProject( Request $request )
        {
            $subjectId = $request->get( 'subjectId' );

            $data = new \Illuminate\Support\Collection();

            //科技成果
            $projects = Speedy::getModelInstance( 'project' )->where( 'special_subject_id' , $subjectId )->where( 'recommend' , '1' )->where( 'valid' , '1' )->limit( 5 )->get( [ 'ids' , 'industry' , 'maturity' , 'cooperation' , 'title' , 'description' ] );

            foreach ( $projects as $p )
            {
                $industryLabel = Speedy::getModelInstance( 'label' )->where( 'code' , $p->industry )->first()->label;
                $maturityLabel = Speedy::getModelInstance( 'label' )->where( 'code' , $p->maturity )->first()->label;
                $cooperationLabel = Speedy::getModelInstance( 'label' )->where( 'code' , $p->cooperation )->first()->label;
                $p->setAttribute( 'industryLabel' , $industryLabel );
                $p->setAttribute( 'maturityLabel' , $maturityLabel );
                $p->setAttribute( 'cooperationLabel' , $cooperationLabel );
            }

            $data->put( 'projects' , $projects );

            //项目需求
            $requirements = Speedy::getModelInstance( 'requirement' )->where( 'recommend' , '1' )->limit( 5 )->get(
                [
                    'id' , 'company_name' , 'industry' , 'location' , 'property' , 'cooperate' , 'entrust' , 'transfer' , 'stockshare' , 'institutions' , 'budget' , 'detail' ,
                ] );

            $data->put( 'requirements' , $requirements );

            return response()->json(
                [
                    'result' => 'success' , 'data' => $data ,
                ] );
        }

        /**
         * 根据筛选条件搜索项目需求，筛选条件由需求类型、类别、专利及鉴定，可作为搜索结果页或原始列表页...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/10/15
         *
         */
        public function searchRequirements( Request $request )
        {
            //获取参数
            //            $type        = $request->get( 'type' ); //需求类型 科技项目需求或技术难题
            $classification = $request->get( 'classification' ); //类别
            //            $patent   = $request->get( 'patent' ); //专利
            //            $appraise   = $request->get( 'appraise' ); //鉴定
            $page = $request->get( 'page' ) ? $request->get( 'page' ) : 0; //页码

            //获取所有类别
            $classificationArr = [ '全部' ];
            $classifications = Speedy::getModelInstance( 'requirement' )->where( 'valid' , '1' )->distinct( 'classification' )->get( [ 'classification' ] );
            foreach ( $classifications as $c )
            {
                $str = str_replace( "\n" , "" , str_replace( "\r\n" , "" , $c->classification ) );
                array_push( $classificationArr , $str );
            }

            //根据筛选条件进行搜索
            $requirements = Speedy::getModelInstance( 'requirement' )->where( 'valid' , '1' )//                                ->where( 'type' , $type != null ? '=' : 'like'  , $type != null ? $type:'%%' )//需求类型
            ->where( 'classification' , 'like' , $classification != null ? '%' . $classification . '%' : '%%' )//类别
            //                                ->where( 'patent' , $patent != null ? '=' : 'like'  , $patent != null ? $patent:'%%' )//专利
            //                                ->where( 'appraise' , $appraise != null ? '=' : 'like'  , $appraise != null ? $appraise:'%%' )//鉴定
            ->orderBy( 'updated_at' , 'DESC' )//按更新时间降序排列
            ->offset( $page * 10 )//分页
            ->limit( 10 )//每页10个
            ->get();

            foreach ( $requirements as $r )
            {
                $count = 0;
                if ( $r->cooperate )
                    $count++;
                if ( $r->entrust )
                    $count++;
                if ( $r->transfer )
                    $count++;
                if ( $r->stockshare )
                    $count++;
                if ( $r->institutions )
                    $count++;
                if ( $r->other )
                    $count++;
                $r->setAttribute( 'labelCount' , $count );
            }

            return response()->json(
                [
                    'result' => 'success' , 'data' => $requirements , 'classification' => $classificationArr ,
                ] );
        }


        /**
         * 根据id获取项目需求详情...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/10/15
         */
        public function getRequirementById( Request $request )
        {
            $id = $request->get( 'id' );
            $requirement = Speedy::getModelInstance( 'requirement' )->where( 'valid' , '1' )->where( 'id' , $id )->first();

            return response()->json(
                [
                    'result' => 'success' , 'data' => $requirement ,
                ] );
        }

        /**
         * 获取需求二维码图
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
         * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
         *
         * @author Lee 2019/10/15
         */
        public function getRequirementQrCode( Request $request )
        {
            $upload_result = '';
            $scene = $request->get( 'scene' );
            $page = 'pages/projectrequirements/detail/detail';

            //判断是否已有生成过二维码
            $requirement = Speedy::getModelInstance( 'requirement' )->where( 'id' , $scene )->first();
            if ( $requirement && $requirement->qr_code != null )
            {
                //有，直接返回二维码地址
                return response()->json(
                    [
                        'url' => $requirement->qr_code ,
                    ] );
            }
            else
            {
                //无，生成二维码再返回
                $response = $this->mini->app_code->getUnlimit(
                    $scene , [
                    'page' => $page ,
                ] );

                if ( $response instanceof StreamResponse )
                {
                    $result = $response->saveAs( storage_path( 'app' ) , $scene . '.png' );
                    //存储到服务器本地
                    $path = storage_path( 'app/' ) . $result;
                    //存储到oss
                    $upload_result = $this->uploadPic( $path );
                    if ( $upload_result )
                    {
                        //删除服务器本地文件
                        unlink( $path );
                        //存储到oss地址存储到服务器
                        $requirement->qr_code = $upload_result;
                        $requirement->save();
                    }
                    else
                    {
                        return response()->json(
                            [
                                'result' => 'error' ,
                            ] );
                    }
                }

                return response()->json(
                    [
                        'url' => $upload_result ,
                    ] );
            }
        }

        /**
         * 获取科技成果二维码图
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
         * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
         *
         * @author Lee 2019/11/1
         */
        public function getProjectQrCode( Request $request )
        {
            $upload_result = '';
            $scene = $request->get( 'scene' );
            $page = 'pages/project/detail/detail';

            //判断是否已有生成过二维码
            $project = Speedy::getModelInstance( 'project' )->where( 'ids' , $scene )->first();
            if ( $project && $project->qr_code != null )
            {
                //有，直接返回二维码地址
                return response()->json(
                    [
                        'url' => $project->qr_code ,
                    ] );
            }
            else
            {
                //无，生成二维码再返回
                $response = $this->mini->app_code->getUnlimit(
                    $scene , [
                    'page' => $page ,
                ] );

                if ( $response instanceof StreamResponse )
                {
                    $result = $response->saveAs( storage_path( 'app' ) , $scene . '.png' );
                    //存储到服务器本地
                    $path = storage_path( 'app/' ) . $result;
                    //存储到oss
                    $upload_result = $this->uploadPic( $path );
                    if ( $upload_result )
                    {
                        //删除服务器本地文件
                        unlink( $path );
                        //存储到oss地址存储到服务器
                        $project->qr_code = $upload_result;
                        $project->save();
                    }
                    else
                    {
                        return response()->json(
                            [
                                'result' => 'error' ,
                            ] );
                    }
                }

                return response()->json(
                    [
                        'url' => $upload_result ,
                    ] );
            }
        }

        /**
         * 获取科技成果专题页面二维吗
         *
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
         * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
         *
         * @author Lee 2019/11/7
         */
        public function getProjectSubjectQrCode()
        {
            $upload_result = '';
            $page = 'pages/special/projectdocking/index/index';

            //无，生成二维码再返回
            $response = $this->mini->app_code->getUnlimit(
                '2' , [
                'page' => $page ,
            ] );

            if ( $response instanceof StreamResponse )
            {
                $result = $response->saveAs( storage_path( 'app' ) , '2' . '.png' );
                //存储到服务器本地
                $path = storage_path( 'app/' ) . $result;
                //存储到oss
                $upload_result = $this->uploadPic( $path );
                if ( $upload_result )
                {
                    //删除服务器本地文件
                    unlink( $path );
                }
                else
                {
                    return response()->json(
                        [
                            'result' => 'error' ,
                        ] );
                }
            }

            return response()->json(
                [
                    'url' => $upload_result ,
                ] );
        }

        /**
         * 根据专题企业id获取专题企业信息...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2019/11/12
         */
        public function getSubjectCompanyById( Request $request )
        {
            $id = $request->get( 'ids' );
            $user_ids = $request->get( 'user_ids' );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user_ids );

            $company = Company::where( 'ids' , $id )->first();
            if ( $company )
            {
                $company->hasManySubjectJobs;
            }

            /**
             * 记录用户浏览记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'view_log' )->create(
                [
                    'user_ids' => $user_ids , 'type' => '3' , 'target_ids' => $id ,
                ] );

            return response()->json(
                [
                    'company' => $company ,
                ] );
        }

        /**
         * 获取人才招聘专题页面二维吗
         *
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
         * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
         *
         * @author Lee 2019/11/7
         */
        public function getJobSubjectQrCode()
        {
            $upload_result = '';
            $page = 'pages/special/foshanhuodong/index/index';

            //无，生成二维码再返回
            $response = $this->mini->app_code->getUnlimit(
                '1' , [
                'page' => $page ,
            ] );

            if ( $response instanceof StreamResponse )
            {
                $result = $response->saveAs( storage_path( 'app' ) , '1' . '.png' );
                //存储到服务器本地
                $path = storage_path( 'app/' ) . $result;
                //存储到oss
                $upload_result = $this->uploadPic( $path );
                if ( $upload_result )
                {
                    //删除服务器本地文件
                    unlink( $path );
                }
                else
                {
                    return response()->json(
                        [
                            'result' => 'error' ,
                        ] );
                }
            }

            return response()->json(
                [
                    'url' => $upload_result ,
                ] );
        }

        public function createSubjectCompanyQrCode()
        {
            $scene = '';
            $page = 'pages/special/foshanhuodong/companydetail/companydetail';

            //判断是否已有生成过二维码
            $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where( 'special_subject_id' , '1' )->get();
            foreach ( $companies as $c )
            {
                if ( $c->qr_code_subject == null )
                {
                    $response = $this->mini->app_code->getUnlimit(
                        $c->ids , [
                        'page' => $page ,
                    ] );

                    if ( $response instanceof StreamResponse )
                    {
                        $result = $response->saveAs( storage_path( 'app' ) , $scene . '.png' );
                        //存储到服务器本地
                        $path = storage_path( 'app/' ) . $result;
                        //存储到oss
                        $upload_result = $this->uploadPic( $path );
                        if ( $upload_result )
                        {
                            //删除服务器本地文件
                            unlink( $path );
                            //存储到oss地址存储到服务器
                            $c->qr_code_subject = $upload_result;
                            $c->save();
                        }
                    }
                }
            }
        }

        public function getPillDoctorCompany( Request $request )
        {
            $subjectId = $request->get( 'subjectId' );

            //自定义排序
            $sortArr = [ '002002' ];

            $data = new Collection();

            //            foreach ($sortArr as $s)
            //            {
            //                $data->push(Speedy::getModelInstance( 'label' )->where( 'code' , $s )->first( [ 'label' , 'code' ] ));
            //            }

            $data->push( Speedy::getModelInstance( 'label' )->get( [ 'label' , 'code' ] ) );

            foreach ( $data as $d )
            {
                $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where( 'special_subject_id' , $subjectId )->where( 'recommend' , '1' )->limit( 10 )->orderBy( 'order_id' , 'DESC' )->get( [ 'ids' , 'name' , 'property' , 'scale' , 'type' ] );
                $d->setAttribute( 'companies' , $companies );
            }

            return response()->json(
                [
                    'result' => 'success' , 'data' => $data ,
                ] );
        }

        public function getPillDoctorCompanyById( Request $request )
        {
            $id = $request->get( 'ids' );
            $user_ids = $request->get( 'user_ids' );

            //检查用户是否创建了个人信息表
            $this->CreatePersonalInfo( $user_ids );

            $company = Company::where( 'ids' , $id )->first();
            if ( $company )
            {
                $company->hasManyPillDoctorJobs;
            }

            /**
             * 记录用户浏览记录
             *
             * @author alienware 2019/3/13
             */
            Speedy::getModelInstance( 'view_log' )->create(
                [
                    'user_ids' => $user_ids , 'type' => '3' , 'target_ids' => $id ,
                ] );

            return response()->json(
                [
                    'company' => $company ,
                ] );
        }

        public function searchSubjectJob( Request $request )
        {
            //获取参数
            $name = $request->get( 'name' ); //公司名称或职位名称
            $subjectId = $request->get( 'subjectId' ); //专题ID
            $page = $request->get( 'page' ) ? $request->get( 'page' ) : 0; //页码
            $industry = $request->get( 'industry' ); //行业

            $jobs = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where( 'title' , 'like' , '%' . $name . '%' )->where( 'sp_jg' , '1' )->where( 'special_subject_id' , $subjectId )->orderBy( 'order_id' , 'ASC' )->offset( $page * 10 )->limit( 10 )->get();

            foreach ( $jobs as $j )
            {
                $j->belongsToCompany;
            }

            return response()->json(
                [
                    'result' => 'success' , 'data' => $jobs ,
                ] );
        }

        public function getResumeInfo( Request $request )
        {
            $uid = $request->get( 'user_ids' );

            $resume = Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $uid )->where( 'valid' , '1' )->first();
            $education = Speedy::getModelInstance( 'education' )->where( 'personal_ids' , $uid )->where( 'valid' , '1' )->get();
            $resume->setAttribute( 'education' , $education );

            return response()->json(
                [
                    'result' => 'success' , 'data' => $resume ,
                ] );
        }

        public function getResumeInfoPlus( Request $request )
        {
            $uid = $request->get( 'user_ids' );

            $resume = Speedy::getModelInstance( 'personal_info' )->where( 'user_ids' , $uid )->where( 'valid' , '1' )->first();
            $work = Speedy::getModelInstance( 'working' )->where( 'personal_ids' , $uid )->where( 'valid' , '1' )->get();
            $honor = Speedy::getModelInstance( 'honor' )->where( 'personal_ids' , $uid )->where( 'valid' , '1' )->get();
            $resume->setAttribute( 'work' , $work );
            $resume->setAttribute( 'honor' , $honor );

            return response()->json(
                [
                    'result' => 'success' , 'data' => $resume ,
                ] );

        }

        public function upLoadResumeFile(Request $request)
        {
            $url = $request->get('resume_url');

            $data = new Collection();
            $data->put('name',$request->get('name'));
            $data->put('phone',$request->get('phone'));
            $data->put('email',$request->get('email'));
            $data->put('education',$request->get('education'));
            $data->put('work',$request->get('work'));
            $data->put('honor',$request->get('honor'));
            $data->put('skill',$request->get('skill'));
            $data->put('intro',$request->get('intro'));
            $data->put('user_ids',$request->get('user_ids'));
            $data->put('job_ids',$request->get('job_ids'));
            $data->put('type',$request->get('type'));

            if ($url)
            {
                    $data->put('resume',$url);
            }else
            {
                $path = $request->file('file');
                $file = $this->uploadFile( $path );
                if ($file)
                {
                    $data->put('resume',$file);
                }else
                {
                    return response()->json(
                        [
                            'result' => 'error' ,
                            'msg' => '提交资料失败，请稍后再尝试',
                        ] );
                }
            }

            $result = $this->submitRecommend($data);

            if ($result == 'success')
            {
                return response()->json(
                    [
                        'result' => 'success' ,
                        'msg' => '提交资料成功',
                    ] );
            }elseif ($result == 'committed')
            {
                return response()->json(
                    [
                        'result' => 'error' ,
                        'msg' => '您已提交过该岗位申请，请勿重复提交',
                    ] );
            }else
            {
                return response()->json(
                    [
                        'result' => 'error' ,
                        'msg' => '提交资料失败，请稍后再尝试',
                    ] );
            }

        }

        //存储到云服务器
        public function uploadFile( $data )
        {
            $file = $data;

            //获取文件的扩展名

            $kuoname = $file->getClientOriginalExtension();

            //获取文件的类型

            //$type=$file->getClientMimeType();

            //获取文件的绝对路径，但是获取到的在本地不能打开

//            $path = $file->path;

            //要保存的文件名 时间+扩展名

            $filename = 'resumes/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . $kuoname;
//            $filename = 'resumes/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . 'pdf';


            //保存文件          配置文件存放文件的名字  ，文件名，路径

//            $bool = Storage::disk('oss')->get($path);
//            $bool = Storage::disk('oss')->;
                        $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $file ) );

            if ( $bool )
            {
                $file_url = Storage::url( $filename ); // get the file url
                //array_set( $return_data , $type , $pic_url );
                return $file_url;
            }
            else
            {
                return null;
            }
        }
    }
