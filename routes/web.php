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
        Route::resource( 'place' , $namespace . 'PlaceController' , [
            'names' => [
                'index'   => 'admin.place.index' ,
                'create'  => 'admin.place.create' ,
                'store'   => 'admin.place.store' ,
                'edit'    => 'admin.place.edit' ,
                'update'  => 'admin.place.update' ,
                'destroy' => 'admin.place.destroy' ,
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

    Route::group( [ 'middleware' => 'auth' , 'prefix' => 'api/' ] , function()
    {
        $namespace = 'Api\\';

        Route::any( 'upLoadPlacePic' , $namespace . 'AdminController@upLoadPlacePic' );
        Route::any( 'upLoadPlaceIcon' , $namespace . 'AdminController@upLoadPlaceIcon' );
        Route::any( 'upLoadPlaceIconSelect' , $namespace . 'AdminController@upLoadPlaceIconSelect' );
        Route::any( 'upLoadPlaceIllustrator' , $namespace . 'AdminController@upLoadPlaceIllustrator' );


    } );

    Auth::routes();

