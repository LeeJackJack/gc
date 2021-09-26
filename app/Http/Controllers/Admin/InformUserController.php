<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CcpRestSms;
use Speedy;

class InformUserController extends Controller
{
    protected $sms;

    private $accountSid; //主帐号,对应开官网发者主账号下的 ACCOUNT SID
    private $accountToken = '';//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    private $fappid; //主帐号对应的appid
    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    private $appId = '';
    //请求地址
    //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
    //生产环境（用户应用上线使用）：app.cloopen.com
    private $serverIP = '';
    //请求端口，生产环境和沙盒环境一致
    private $serverPort = '';
    //REST版本号，在官网文档REST介绍中获得。
    private $softVersion = '';
    //模板ID
    private $tempId = '';

    /**
     * 初始化短信发送对象
     *
     * @author Lee 2019/04/08
     */
    public function initCcpRestSms()
    {
        $this->accountSid   = config( 'yuntongxun.account' );
        $this->accountToken = config( 'yuntongxun.accountToken' );
        $this->fappid       = config( 'yuntongxun.fappid' );
        $this->appId        = config( 'yuntongxun.bch_appid' );
        $this->serverIP     = config( 'yuntongxun.ip' );
        $this->serverPort   = config( 'yuntongxun.port' );
        $this->softVersion  = config( 'yuntongxun.version' );
        $this->tempId = config('yuntongxun.admin_inform');
        $this->sms          = new CcpRestSms( $this->serverIP , $this->serverPort , $this->softVersion );
    }

    public function sendSms($sendList)
    {
        $this->initCcpRestSms();

        $phone = $sendList;
        //发送模板id
        $templateId = $this->tempId;
        $sendList   = $phone;
        $result = $this->sendTemplateSMS( $sendList , [] , $templateId );
        if ( $result == null )
        {
            Speedy::getModelInstance( 'sms_log' )->create( [
                'template_id' => $templateId ,
                'send_list' => $sendList , 'status' => '0' ,
                'operator_ids' => 'admin' ,
            ] );
            return '000' ;
        }
        else if ( $result->statusCode != 0 )
        {
            Speedy::getModelInstance( 'sms_log' )->create( [
                'template_id' => $templateId ,
                'sendList' => $sendList ,
                'status' => '0' ,
                'operator_ids' => 'admin' ,
                'error_code' => $result->statusCode ,
                'error_msg' => $result->statusMsg ,
            ] );
            return '000' ;
        }
        else
        {
            Speedy::getModelInstance( 'sms_log' )->create( [
                'template_id' => $templateId ,
                'send_list' => $sendList ,
                'status' => '1' ,
                'operator_ids' => 'admin' ,
            ] );
            return '888' ;
        }
    }

    /**
     * 发送模板短信
     *
     * @param array $to 手机号码集合,用英文逗号分开
     * @param array $datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
     * @param string $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
     *
     * @return string
     */
    function sendTemplateSMS( $to , $datas = [ '' , '' ] , $tempId )
    {
        // 初始化REST SDK
        $this->sms->setAccount( $this->accountSid , $this->accountToken );
        $this->sms->setAppId( $this->appId );
        $tId = $tempId;
        // 发送模板短信
        //echo "Sending TemplateSMS to $to <br/>";
        $result = $this->sms->sendTemplateSMS( $to , $datas , $tId );

        return $result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
