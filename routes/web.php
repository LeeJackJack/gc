<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get( '/' , function()
    {
        return view( 'auth/login' );
    } );

    //小程序接口
    Route::group( [ 'prefix' => 'gc/api/wx/' ] , function()
    {
        $namespace = 'Wechat\\';

        //获取微信小程序接口返回的用户信息...
        Route::get( 'jscode2session' , $namespace . 'WechatController@getWechatSession' );

        //获取微信小程序二维码...
        Route::get( 'getQrCode' , $namespace . 'WechatController@getQrCode' );

        //获取首页数据
        Route::get( 'getHomePage' , $namespace . 'WechatController@getHomePage' );

        //获取地图标点数据
        Route::get( 'getMarkers' , $namespace . 'WechatController@getMarkers' );

        //获取景点详情
        Route::get( 'getPlace' , $namespace . 'WechatController@getPlace' );

        //获取路线详情
        Route::get( 'getTours' , $namespace . 'WechatController@getTours' );

    } );

    //发送验证码接口
    Route::group( [ 'prefix' => 'gc/api/wx/' ] , function()
    {
        $namespace = 'Sms\\';

        Route::get( 'sendSms' , $namespace . 'SendSmsController@sendSms' );

    } );


    //管理后台
    Route::group( [ 'middleware' => 'auth' , 'prefix' => 'admin' ] , function()
    {
        $namespace = 'Admin\\';
        Route::resource( 'admin_user' , $namespace . 'UserController' , [
            'names' => [
                'index'   => 'admin.user.index' ,
                'create'  => 'admin.user.create' ,
                'store'   => 'admin.user.store' ,
                'edit'    => 'admin.user.edit' ,
                'update'  => 'admin.user.update' ,
                'destroy' => 'admin.user.destroy' ,
            ] ,
        ] );
        Route::resource( 'role' , $namespace . 'RoleController' , [
            'names' => [
                'index'   => 'admin.role.index' ,
                'create'  => 'admin.role.create' ,
                'store'   => 'admin.role.store' ,
                'edit'    => 'admin.role.edit' ,
                'update'  => 'admin.role.update' ,
                'destroy' => 'admin.role.destroy' ,
            ] ,
        ] );
        Route::resource( 'company' , $namespace . 'CompanyController' , [
            'names' => [
                'index'   => 'admin.company.index' ,
                'create'  => 'admin.company.create' ,
                'store'   => 'admin.company.store' ,
                'edit'    => 'admin.company.edit' ,
                'update'  => 'admin.company.update' ,
                'show'    => 'admin.company.show' ,
                'destroy' => 'admin.company.destroy' ,
            ] ,
        ] );
        Route::get( '/job/download' ,
            $namespace . 'JobController@exportData' )->name( 'admin.job.download' );
        Route::resource( 'job' , $namespace . 'JobController' , [
            'names' => [
                'index'   => 'admin.job.index' ,
                'create'  => 'admin.job.create' ,
                'store'   => 'admin.job.store' ,
                'edit'    => 'admin.job.edit' ,
                'show'    => 'admin.job.show' ,
                'update'  => 'admin.job.update' ,
                'destroy' => 'admin.job.destroy' ,
            ] ,
        ] );
        Route::get( '/activity/download' ,
            $namespace . 'ActivityController@exportData' )->name( 'admin.activity.download' );
        Route::resource( 'activity' , $namespace . 'ActivityController' , [
            'names' => [
                'index'   => 'admin.activity.index' ,
                'show'    => 'admin.activity.show' ,
                'create'  => 'admin.activity.create' ,
                'store'   => 'admin.activity.store' ,
                'edit'    => 'admin.activity.edit' ,
                'update'  => 'admin.activity.update' ,
                'destroy' => 'admin.activity.destroy' ,
            ] ,
        ] );
        Route::resource( 'like_doctor' , $namespace . 'LikeDoctorController' , [
            'names' => [
                'index'   => 'admin.like_doctor.index' ,
                'show'    => 'admin.like_doctor.show' ,
                'create'  => 'admin.like_doctor.create' ,
                'store'   => 'admin.like_doctor.store' ,
                'edit'    => 'admin.like_doctor.edit' ,
                'update'  => 'admin.like_doctor.update' ,
                'destroy' => 'admin.like_doctor.destroy' ,
            ] ,
        ] );
        Route::get( '/recommend/download' ,
            $namespace . 'RecommendController@exportData' )->name( 'admin.recommend.download' );
        Route::resource( 'recommend' , $namespace . 'RecommendController' , [
            'names' => [
                'index'   => 'admin.recommend.index' ,
                'create'  => 'admin.recommend.create' ,
                'store'   => 'admin.recommend.store' ,
                'edit'    => 'admin.recommend.edit' ,
                'update'  => 'admin.recommend.update' ,
                'destroy' => 'admin.recommend.destroy' ,
            ] ,
        ] );
        Route::resource( 'like_project' , $namespace . 'LikeProjectController' , [
            'names' => [
                'index'   => 'admin.like_project.index' ,
                'create'  => 'admin.like_project.create' ,
                'store'   => 'admin.like_project.store' ,
                'edit'    => 'admin.like_project.edit' ,
                'update'  => 'admin.like_project.update' ,
                'destroy' => 'admin.like_project.destroy' ,
            ] ,
        ] );
        Route::resource( 'project' , $namespace . 'ProjectController' , [
            'names' => [
                'index'   => 'admin.project.index' ,
                'create'  => 'admin.project.create' ,
                'store'   => 'admin.project.store' ,
                'edit'    => 'admin.project.edit' ,
                'update'  => 'admin.project.update' ,
                'destroy' => 'admin.project.destroy' ,
                'show'    => 'admin.project.show' ,
            ] ,
        ] );
        Route::resource( 'requirement' , $namespace . 'RequirementController' , [
            'names' => [
                'index'   => 'admin.requirement.index' ,
                'create'  => 'admin.requirement.create' ,
                'store'   => 'admin.requirement.store' ,
                'edit'    => 'admin.requirement.edit' ,
                'update'  => 'admin.requirement.update' ,
                'destroy' => 'admin.requirement.destroy' ,
                'show'    => 'admin.requirement.show' ,
            ] ,
        ] );
        Route::resource( 'sign_up' , $namespace . 'SignUpController' , [
            'names' => [
                'index'   => 'admin.sign_up.index' ,
                'create'  => 'admin.sign_up.create' ,
                'store'   => 'admin.sign_up.store' ,
                'edit'    => 'admin.sign_up.edit' ,
                'update'  => 'admin.sign_up.update' ,
                'destroy' => 'admin.sign_up.destroy' ,
            ] ,
        ] );
        Route::get( '/oversea_activity/download' ,
            $namespace . 'AdminOverseaActivitySignUpController@exportData' )->name( 'admin.oversea_activity.download' );
        Route::resource( 'oversea_activity' , $namespace . 'AdminOverseaActivitySignUpController' , [
            'names' => [
                'index'   => 'admin.oversea_activity.index' ,
                'create'  => 'admin.oversea_activity.create' ,
                'store'   => 'admin.oversea_activity.store' ,
                'edit'    => 'admin.oversea_activity.edit' ,
                'update'  => 'admin.oversea_activity.update' ,
                'destroy' => 'admin.oversea_activity.destroy' ,
            ] ,
        ] );
        Route::resource( 'sp' , $namespace . 'SpController' , [
            'names' => [
                'index'   => 'admin.sp.index' ,
                'create'  => 'admin.sp.create' ,
                'store'   => 'admin.sp.store' ,
                'edit'    => 'admin.sp.edit' ,
                'update'  => 'admin.sp.update' ,
                'destroy' => 'admin.sp.destroy' ,
            ] ,
        ] );
        Route::resource( 'tag' , $namespace . 'TagController' , [
            'names' => [
                'index'   => 'admin.tag.index' ,
                'create'  => 'admin.tag.create' ,
                'store'   => 'admin.tag.store' ,
                'edit'    => 'admin.tag.edit' ,
                'update'  => 'admin.tag.update' ,
                'destroy' => 'admin.tag.destroy' ,
            ] ,
        ] );
        Route::resource( 'talent' , $namespace . 'TalentController' , [
            'names' => [
                'index'   => 'admin.talent.index' ,
                'create'  => 'admin.talent.create' ,
                'store'   => 'admin.talent.store' ,
                'edit'    => 'admin.talent.edit' ,
                'update'  => 'admin.talent.update' ,
                'destroy' => 'admin.talent.destroy' ,
                'show'    => 'admin.talent.show' ,
            ] ,
        ] );
        Route::resource( 'weekly_report' , $namespace . 'WeeklyReportController' , [
            'names' => [
                'index' => 'admin.weekly_report.index' ,
            ] ,
        ] );
        Route::resource( 'update_log' , $namespace . 'UpdateLogController' , [
            'names' => [
                'index'   => 'admin.update_log.index' ,
                'create'  => 'admin.update_log.create' ,
                'store'   => 'admin.update_log.store' ,
                'edit'    => 'admin.update_log.edit' ,
                'update'  => 'admin.update_log.update' ,
                'destroy' => 'admin.update_log.destroy' ,
            ] ,
        ] );
        Route::resource( 'government' , $namespace . 'GovernmentController' , [
            'names' => [
                'index'   => 'admin.government.index' ,
                'create'  => 'admin.government.create' ,
                'store'   => 'admin.government.store' ,
                'edit'    => 'admin.government.edit' ,
                'update'  => 'admin.government.update' ,
                'destroy' => 'admin.government.destroy' ,
            ] ,
        ] );
        Route::resource( 'phd' , $namespace . 'PhdController' , [
            'names' => [
                'index'   => 'admin.phd.index' ,
                'create'  => 'admin.phd.create' ,
                'store'   => 'admin.phd.store' ,
                'edit'    => 'admin.phd.edit' ,
                'update'  => 'admin.phd.update' ,
                'destroy' => 'admin.phd.destroy' ,
            ] ,
        ] );
        Route::resource( 'map' , $namespace . 'MapController' , [
            'names' => [
                'index'   => 'admin.map.index' ,
                'create'  => 'admin.map.create' ,
                'store'   => 'admin.map.store' ,
                'edit'    => 'admin.map.edit' ,
                'update'  => 'admin.map.update' ,
                'destroy' => 'admin.map.destroy' ,
            ] ,
        ] );
    } );

    //登录
    Route::group( [ 'middleware' => 'auth' , 'prefix' => 'admin' ] , function()
    {
        $namespace = 'Admin\\';
        Route::get( '/home' , $namespace . 'HomeController@index' )->name( 'admin.admin.home' );
    } );

    Route::group( [ 'middleware' => 'auth' , 'prefix' => 'admin' ] , function()
    {
        $namespace = 'Admin\\';
        Route::get( '/' , $namespace . 'UpdateLogController@index' );
    } );

    //管理后台接口
    Route::group( [ 'middleware' => [ 'auth' , 'api' ] ] , function()
    {
        $namespace = 'Api\\';
        Route::get( '/com_search' , $namespace . 'AdminController@comSearch' );
        //发送邮件接口
        Route::get( '/informSendResume' , $namespace . 'SendEmailController@informSendResume' );
        Route::get( '/informReceivedResume' , $namespace . 'SendEmailController@informReceivedResume' );
        Route::get( '/informCompanyEmail' , $namespace . 'SendEmailController@informCompanyEmail' );
        Route::get( '/testEmail' , $namespace . 'SendEmailController@testEmail' );
    } );

    Route::group( [ 'middleware' => [ 'auth' , 'api/' ] ] , function()
    {
        $namespace = 'Api\\';
        Route::get( '/create_qr_code' , $namespace . 'AdminController@createQrCode' );
    } );

    Route::group( [ 'middleware' => 'auth' , 'prefix' => 'api/' ] , function()
    {
        $namespace = 'Api\\';
        Route::get( 'delContactInfo' , $namespace . 'AdminController@delContactInfo' );
        Route::get( 'createContact' , $namespace . 'AdminController@createContact' );

        //2019-9-24添加 上传封面接口
        Route::any( 'upLoadCoverPic' , $namespace . 'AdminController@upLoadCoverPic' );
        //2019-9-27添加 上传文件接口
        Route::any( 'upLoadResume' , $namespace . 'AdminController@upLoadResume' );

        //2020-3-10添加查询政府联系人接口
        Route::get( 'searchGovernment' , $namespace . 'AdminController@searchGovernment' );
        //2020-3-10删除政府联系人接口
        Route::get( 'delGovernment' , $namespace . 'AdminController@delGovernment' );
        //2020-3-10修改政府联系人接口
        Route::get( 'editGovernment' , $namespace . 'AdminController@editGovernment' );
        //2020-3-11获取热门应聘企业排行
        Route::get( 'getCompanyData' , $namespace . 'AdminController@getCompanyData' );
        //2020-3-11获取热门职位排行
        Route::get( 'getJobData' , $namespace . 'AdminController@getJobData' );
        //2020-3-16获取区域高校
        Route::get( 'searchSchool' , $namespace . 'AdminController@searchSchool' );
        //2020-3-16获取高校在读博士
        Route::get( 'searchSchoolPhd' , $namespace . 'AdminController@searchSchoolPhd' );
        //2020-3-17获取高校在读博士
        Route::get( 'editPhd' , $namespace . 'AdminController@editPhd' );

    } );


    Auth::routes();


Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function(){
    $namespace = '\\Hanson\\Speedy\\Http\\Controllers\\';
    Route::get('/', $namespace.'HomeController@index');
    Route::resource('user', $namespace.'UserController', ['names' => [
        'index' => 'admin.user.index',
        'create' => 'admin.user.create',
        'store' => 'admin.user.store',
        'edit' => 'admin.user.edit',
        'update' => 'admin.user.update',
        'destroy' => 'admin.user.destroy'
    ]]);
    Route::resource('role', $namespace.'RoleController', ['names' => [
        'index' => 'admin.role.index',
        'create' => 'admin.role.create',
        'store' => 'admin.role.store',
        'edit' => 'admin.role.edit',
        'update' => 'admin.role.update',
        'destroy' => 'admin.role.destroy'
    ]]);
});
