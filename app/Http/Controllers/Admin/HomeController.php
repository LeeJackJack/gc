<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\Sp;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Charts\Sample;
    use Speedy;


    class HomeController extends BaseController
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware( 'auth' );
            $this->middleware( 'speedy.role' );
        }

        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {

            return view( 'vendor.speedy.admin.home' );

        }
    }
