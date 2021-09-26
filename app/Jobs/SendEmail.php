<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Recommend;
use Illuminate\Support\Facades\Mail;
use Speedy;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recommend;
    protected $company_str;

    /**
     * Create a new job instance.
     * @param Recommend $recommend
     * @param string $company_str
     *
     * @return void
     */
    public function __construct(Recommend $recommend , $company_str)
    {
        $this->recommend = $recommend;
        $this->company_str = $company_str;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recommend = $this->recommend;
        $company_str = $this->company_str;

        //发送邮件
        Mail::send( 'vendor.speedy.admin.email.inform_received_resume' , [
            'name'    => $recommend->name ,
            'company' => $company_str ,
        ] , function( $message ) use ($recommend)
        {
            $to      = $recommend->email;
            //$to      = 'lee880919@163.com';
            $subject = '【温馨提醒】博士博士后创新创业中心';
            $message->to( $to )->subject( $subject );
        } );

        //判断邮件发送结果
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
                    'real_send'    => $r->ids == $recommend->ids ? '1' : '0' ,
                ] );
            }

            //更新推荐人表信息，同一推荐人多个推荐信息同时更新
            Speedy::getModelInstance( 'recommend' )->where( 'valid' , '1' )->where( 'user_ids' ,
                $recommend->user_ids )->where( 'phone' , $recommend->phone )->where( 'email' ,
                $recommend->email )->update( [
                'is_send_received_resume_email' => '1' ,
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
                'relevant_ids' => $recommend->ids ,
                'real_send'    => '1' ,
            ] );
        }

    }
}
