<?php

    namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Speedy;
    use App\Exports\Report;
    use Maatwebsite\Excel\Facades\Excel;
    use Illuminate\Support\Carbon;

    class AdminOverseaActivitySignUpController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $signUps = Speedy::getModelInstance( 'oversea_activity_sign_up' )->where( 'valid' ,
                '1' )->orderBy( 'created_at' , 'DESC' )->get();

            return view( 'vendor.speedy.admin.oversea_activity.index' , compact( 'signUps' ) );
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
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store( Request $request )
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show( $id )
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  string $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit( $id )
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  string $id
         *
         *
         * @return \Illuminate\Http\Response
         */
        public function update( Request $request , $id )
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy( $id )
        {
            //
        }

        public function exportData( Request $request )
        {
            return Excel::download( new Report() , 'oversea_activity_' . Carbon::now() . '.xlsx' );
        }
    }
