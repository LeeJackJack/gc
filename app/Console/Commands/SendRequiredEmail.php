<?php

    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use Speedy;
    use Carbon\Carbon;
    use App\Jobs\SendEmail;

    class SendRequiredEmail extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'email:resume';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = '对投递应聘者发送邮件通知其简历已收到';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            $tos = Speedy::getModelInstance( 'recommend' )->groupBy( 'email' )->where( 'valid' ,
                '1' )->where( 'is_send_received_resume_email' , '0' )->where( 'email' , '<>' , null )->get();

            //查找是否有历史发送提醒邮件记录
            foreach ( $tos as $key => $value )
            {
                $history = Speedy::getModelInstance( 'email_log' )->where( 'relevant_ids' , $value->ids )->where( 'to' ,
                    $value->email )->where( 'type' , '1' )->where( 'result' , '1' )->first();
                if ( $history )
                {
                    $tos->pull( $key );
                }
            }

            //查找已经把推荐人简历上传
//            foreach ( $tos as $key => $value )
//            {
//                $talent = Speedy::getModelInstance( 'talent' )->where( 'user_ids' , $value->user_ids )->where( 'email' ,
//                    $value->email )->where( 'phone' , $value->phone )->where( 'valid' , '1' )->where( 'if_resume' ,
//                    '1' )->first();
//                if ( $talent )
//                {
//                    //更新发送状态
//                    $value->is_send_required_resume_email = '1';
//                    $value->save();
//                    $tos->pull( $key );
//                }
//            }

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
                dispatch( new SendEmail( $t , $company_str ) );
            }
        }
    }
