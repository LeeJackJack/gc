<?php

    namespace App\Http\Controllers\Api;

    use function Composer\Autoload\includeFile;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Mail;
    use Speedy;
    use App\Http\Controllers\Admin\BaseController;
    use App\Jobs\SendEmail;

    class SendEmailController extends BaseController
    {
        public function __construct()
        {
            //
        }

        public function index()
        {
            //
        }

        public function informSendResume( Request $request )
        {
            $ids = $request->get( 'ids' );

            $company_str = '';
            $recommend   = Speedy::getModelInstance( 'recommend' )->where( 'ids' , $ids )->first();

            //查看此邮箱是否已经有历史发送记录，如有则不发送，如无则继续
            $history = Speedy::getModelInstance( 'email_log' )->where( 'to' , $recommend->email )->where( 'result' ,
                '1' )->where( 'type' , '0' )->first();
            if ( $history )
            {
                //已有发送记录，告知用户已发送，同时更新本条推荐记录的发送状态
                $recommend->is_send_required_resume_email = '1';
                $recommend->save();

                return response()->json( [
                    'result' => 'warning' ,
                    'code'   => '555' ,
                    'msg'    => '邮件已经发送，无需重复操作' ,
                ] );
            }

            //如用户已经上传过简历，无需再次邮箱提醒
            $talent = Speedy::getModelInstance( 'talent' )->where( 'user_ids' , $recommend->user_ids )->where( 'phone' ,
                $recommend->phone )->first();
            if ( $talent && $talent->resume_url )
            {
                $recommend->is_send_required_resume_email = '1';
                $recommend->save();

                return response()->json( [
                    'result' => 'warning' ,
                    'code'   => '666' ,
                    'msg'    => '该人才已经上传简历，无需邮件提醒' ,
                ] );
            }

            //获取同一推荐人多个推荐岗位
            if ( $talent->job_ids )
            {
                $temp = [];
                foreach ( explode( ',' , $talent->job_ids ) as $v )
                {
                    $job = Speedy::getModelInstance( 'job' )->where( 'ids' , $v )->first();
                    $company = Speedy::getModelInstance( 'company' )->where( 'ids' , $job->com_ids )->first();
                    array_push( $temp , $company->name );
                }
                $company_str = implode( ',' , array_unique( $temp ) );
            }

            //发送邮件
            Mail::send( 'vendor.speedy.admin.email.inform_send_resume' , [
                'name'    => $recommend->name ,
                'company' => $company_str ,
            ] , function( $message ) use ($recommend)
            {
                $to      = $recommend->email;
                $subject = $recommend->name .'博士岗位应聘进度通知--博士博士后创新创业中心';
                $message->to( $to )->cc('phdinno@163.com')->subject( $subject );
            } );

            //判断邮件发送结果
            if ( count( Mail::failures() ) == 0 )
            {
                //同一个人在不同的推荐岗位中，只发送一封邮件，其他无需发送邮件的推荐记录为未真实发送
                $recommends = Speedy::getModelInstance( 'recommend' )->where( 'phone' ,
                    $recommend->phone )->where( 'email' , $recommend->email )->where( 'user_ids' ,
                    $recommend->user_ids )->where( 'valid' , '1' )->where( 'is_send_required_resume_email' ,
                    '0' )->get();
                foreach ( $recommends as $r )
                {
                    //记录邮件发送信息
                    Speedy::getModelInstance( 'email_log' )->create( [
                        'to'           => $r->email ,
                        'operator'     => 'admin' ,
                        'result'       => '1' ,
                        'type'         => '0' ,
                        'relevant_ids' => $r->ids ,
                        'real_send'    => $r->ids == $ids ? '1' : '0' ,
                    ] );
                }

                //更新推荐人表信息，同一推荐人多个推荐信息同时更新
                Speedy::getModelInstance( 'recommend' )->where( 'valid' , '1' )->where( 'user_ids' ,
                    $recommend->user_ids )->where( 'phone' , $recommend->phone )->where( 'email' ,
                    $recommend->email )->update( [
                    'is_send_required_resume_email' => '1' ,
                ] );

                //邮件发送时间，返回前端显示
                $created_at = Speedy::getModelInstance( 'email_log' )->where( 'type' , '0' )->where( 'relevant_ids' ,
                    $ids )->orderBy( 'created_at' , 'Desc' )->where( 'real_send' , '1' )->first()->created_at;

                return response()->json( [
                    'result'     => 'success' ,
                    'code'       => '888' ,
                    'msg'        => '邮件发送成功' ,
                    'created_at' => $created_at ,
                ] );
            }
            else
            {
                //邮件发送存在错误，记录邮件发送信息
                Speedy::getModelInstance( 'email_log' )->create( [
                    'to'           => $recommend->email ,
                    'operator'     => 'admin' ,
                    'result'       => '0' ,
                    'type'         => '0' ,
                    'error_msg'    => Mail::failures() ,
                    'relevant_ids' => $ids ,
                    'real_send'    => '1' ,
                ] );

                return response()->json( [
                    'result' => 'error' ,
                    'code'   => '000' ,
                    'msg'    => '邮件发送失败' ,
                ] );
            }
        }

        public function informReceivedResume( Request $request )
        {
            $recommend_ids = $request->get( 'ids' );

            $recommend = Speedy::getModelInstance( 'recommend' )->where( 'ids' , $recommend_ids )->where( 'valid' ,
                '1' )->first();

            //查看此邮箱是否已经有历史发送记录，如有则不发送，如无则继续
            $history = Speedy::getModelInstance( 'email_log' )->where( 'to' , $recommend->email )->where( 'result' ,
                '1' )->where( 'type' , '1' )->first();
            if ( $history )
            {
                //已有发送记录，告知用户已发送，同时更新本条推荐记录的发送状态
                $recommend->is_send_received_resume_email = '1';
                $recommend->save();

                return response()->json( [
                    'result' => 'warning' ,
                    'code'   => '555' ,
                    'msg'    => '邮件已经发送，无需重复操作' ,
                ] );
            }

            //发送邮件
            Mail::send( 'vendor.speedy.admin.email.inform_received_resume' , [
                'name' => $recommend->name ,
            ] , function( $message ) use ($recommend)
            {
                $to      = $recommend->email;
                //$to      = 'lee880919@163.com';
                $subject = $recommend->name . '博士简历已收到';
                $message->to( $to )->cc('phdinno@163.com')->subject( $subject );
            } );

            //判断发送结果，记录数据
            if ( count( Mail::failures() ) == 0 )
            {
                //同一个人在不同的推荐岗位中，只发送一封邮件，其他无需发送邮件的推荐记录为未真实发送
                $recommends = Speedy::getModelInstance( 'recommend' )->where( 'phone' ,
                    $recommend->phone )->where( 'email' , $recommend->email )->where( 'user_ids' ,
                    $recommend->user_ids )->where( 'valid' , '1' )->where( 'is_send_received_resume_email' ,
                    '0' )->get();
                foreach ( $recommends as $r )
                {
                    //记录邮件发送信息
                    Speedy::getModelInstance( 'email_log' )->create( [
                        'to'           => $r->email ,
                        'operator'     => 'admin' ,
                        'result'       => '1' ,
                        'type'         => '1' ,
                        'relevant_ids' => $r->ids ,
                        'real_send'    => $r->ids == $recommend_ids ? '1' : '0' ,
                    ] );
                }

                //更新推荐人表信息，同一推荐人多个推荐信息同时更新
                Speedy::getModelInstance( 'recommend' )->where( 'valid' , '1' )->where( 'user_ids' ,
                    $recommend->user_ids )->where( 'phone' , $recommend->phone )->where( 'email' ,
                    $recommend->email )->update( [
                    'is_send_received_resume_email' => '1' ,
                ] );

                //邮件发送时间，返回前端显示
                $created_at = Speedy::getModelInstance( 'email_log' )->where( 'type' , '1' )->where( 'relevant_ids' ,
                    $recommend_ids )->orderBy( 'created_at' , 'Desc' )->where( 'real_send' , '1' )->first()->created_at;

                return response()->json( [
                    'result'     => 'success' ,
                    'code'       => '888' ,
                    'msg'        => '邮件发送成功' ,
                    'created_at' => $created_at ,
                ] );
            }
            else
            {
                //邮件发送存在错误，记录邮件发送信息
                Speedy::getModelInstance( 'email_log' )->create( [
                    'to'           => $recommend->email ,
                    'operator'     => 'admin' ,
                    'result'       => '0' ,
                    'type'         => '1' ,
                    'error_msg'    => Mail::failures() ,
                    'relevant_ids' => $recommend_ids ,
                    'real_send'    => '1' ,
                ] );

                return response()->json( [
                    'result' => 'error' ,
                    'code'   => '000' ,
                    'msg'    => '邮件发送失败' ,
                ] );
            }
        }

        public function informCompanyEmail( Request $request )
        {
            $recommend_ids = $request->get( 'ids' );

            $recommend = Speedy::getModelInstance( 'recommend' )->where( 'ids' , $recommend_ids )->where( 'valid' ,
                '1' )->first();

            $talent = Speedy::getModelInstance( 'talent' )->where( 'user_ids' , $recommend->user_ids )->where( 'phone' ,
                $recommend->phone )->where( 'email' , $recommend->email )->first();

            $job = Speedy::getModelInstance( 'job' )->where( 'ids' , $recommend->job_ids )->first();

            $company = Speedy::getModelInstance( 'company' )->where( 'ids' , $job->com_ids )->first();

            if ( $company->email )
            {
                //查看企业邮箱是否已经有对应推荐历史发送记录，如有则不发送，如无则继续
                $history = Speedy::getModelInstance( 'email_log' )->where( 'to' , $company->email )->where( 'result' ,
                    '1' )->where( 'type' , '2' )->where( 'relevant_ids' , $recommend_ids )->first();
                if ( $history )
                {
                    //已有发送记录，告知用户已发送，同时更新本条推荐记录的发送状态
                    if ($recommend->is_send_inform_company_email == '0')
                    {
                        $recommend->is_send_inform_company_email  = '1';
                        $recommend->save();
                    }

                    return response()->json( [
                        'result' => 'warning' ,
                        'code'   => '555' ,
                        'msg'    => '邮件已经发送，无需重复操作' ,
                    ] );
                }

                //发送邮件
                Mail::send( $talent->resume_url ? 'vendor.speedy.admin.email.inform_company_resume' : 'vendor.speedy.admin.email.inform_company_recommend' ,
                    $talent->resume_url ? [
                        'name' => $talent->name ,
                        'job'  => $job->title ,
                    ] : [
                        'name'   => $talent->name ,
                        'job'    => $job->title ,
                        'major'  => $talent->major ,
                        'school' => $talent->school ,
                        'phone'  => $talent->phone ,
                        'email'  => $talent->email ,
                    ] , function( $message ) use ( $recommend , $talent , $job , $company )
                    {
                        $to      = $company->email;
                        //$to      = 'lee880919@163.com';
                        $subject = '博士博士后岗位招聘消息通知--博士博士后创新创业中心';
                        $message->to( $to )->cc('phdinno@163.com')->subject( $subject );
                        if ( $talent->resume_url )
                        {
                            $message->attach( $talent->resume_url );
                        }
                    } );

                //判断发送结果，记录数据
                if ( count( Mail::failures() ) == 0 )
                {
                    //更新推荐人表信息
                    $talent->resume_url ? $recommend->is_send_inform_company_email = '1' :
                        $recommend->is_send_inform_company_email = '2' ;
                    $recommend->save();

                    //记录邮件发送信息
                    $result = Speedy::getModelInstance( 'email_log' )->create( [
                        'to'           => $company->email ,
                        'operator'     => 'admin' ,
                        'result'       => '1' ,
                        'type'         => '2' ,
                        'relevant_ids' => $recommend_ids ,
                        'real_send'    => '1' ,
                    ] );

                    //发送时间，前端显示
                    $created_at = Speedy::getModelInstance( 'email_log' )->where( 'type' ,
                        '2' )->where( 'relevant_ids' , $recommend_ids )->orderBy( 'created_at' ,
                        'DESC' )->first()->created_at;

                    return response()->json( [
                        'result'     => 'success' ,
                        'code'       => '888' ,
                        'msg'        => '邮件发送成功' ,
                        'created_at' => $created_at ,
                    ] );
                }
                else
                {
                    //发送失败，记录邮件发送信息
                    Speedy::getModelInstance( 'email_log' )->create( [
                        'to'           => $company->email ,
                        'operator'     => 'admin' ,
                        'result'       => '0' ,
                        'type'         => '2' ,
                        'error_msg'    => Mail::failures() ,
                        'relevant_ids' => $recommend_ids ,
                    ] );

                    return response()->json( [
                        'result' => 'error' ,
                        'code'   => '000' ,
                        'msg'    => '邮件发送失败' ,
                    ] );
                }
            }
            else
            {
                return response()->json( [
                    'result' => 'error' ,
                    'code'   => '222' ,
                    'msg'    => '企业无设置邮箱，无法发送' ,
                ] );
            }
        }

        public function testEmail()
        {
            $tos = Speedy::getModelInstance( 'recommend' )->groupBy( 'email' )->where( 'valid' ,
                    '1' )->where( 'is_send_required_resume_email' , '0' )->where( 'email' , '<>' , null )->get();

            //查找是否有历史发送提醒邮件记录
            foreach ( $tos as $key => $value )
            {
                $history = Speedy::getModelInstance( 'email_log' )->where( 'relevant_ids' , $value->ids )->where( 'to' ,
                        $value->email )->where( 'type' , '0' )->where( 'result' , '1' )->first();
                if ( $history )
                {
                    $tos->pull( $key );
                }
            }

            //查找已经把推荐人简历上传
            foreach ( $tos as $key => $value )
            {
                $talent = Speedy::getModelInstance( 'talent' )->where( 'user_ids' , $value->user_ids )->where( 'email' ,
                        $value->email )->where( 'phone' , $value->phone )->where( 'valid' , '1' )->where( 'if_resume' ,
                        '1' )->first();
                if ( $talent )
                {
                    //更新发送状态
                    $value->is_send_required_resume_email = '1';
                    $value->save();
                    $tos->pull( $key );
                }
            }

            foreach ( $tos as $t )
            {
                $company_str = '';
                $talent      = Speedy::getModelInstance( 'talent' )->where( 'phone' , $t->phone )->where( 'email' ,
                        $t->email )->where( 'user_ids' , $t->user_ids )->first();
                //获取同一推荐人多个推荐岗位
                if ( $talent->job_ids )
                {
                    $temp = [];
                    foreach ( explode( ',' , $talent->job_ids ) as $v )
                    {
                        $job = Speedy::getModelInstance( 'job' )->where( 'ids' , $v )->first();
                        $company = Speedy::getModelInstance( 'company' )->where( 'ids' , $job->com_ids )->first();
                        array_push( $temp , $company->name );
                    }
                    $company_str = implode( ',' , array_unique( $temp ) );
                }
                $this->dispatch( new SendEmail( $t , $company_str ) );
            }
        }
    }
