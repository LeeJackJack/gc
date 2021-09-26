<?php

    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use Speedy;
    use Illuminate\Support\Facades\Log;
    use Carbon\Carbon;

    class DailyCount extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'daily:count';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = '统计每天用户新增及注册数量';

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
            //每天独立用户
            $uniqueCount = Speedy::getModelInstance( 'mini_user' )->where( 'valid' , '1' )->count();

            //每天注册用户
            $RegisterCount = Speedy::getModelInstance( 'mini_user' )->where( 'valid' , '1' )->where( 'phone' , '<>' ,
                null )->count();

            //存入数据库
            Speedy::getModelInstance( 'register_count' )->create( [
                'count' => $RegisterCount ,
            ] );

            Speedy::getModelInstance( 'user_count' )->create( [
                'count' => $uniqueCount ,
            ] );

        }
    }
