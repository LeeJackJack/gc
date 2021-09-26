<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\Sp;
    use Carbon\Carbon;
    use function Couchbase\defaultDecoder;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Speedy;
    use Auth;
    use Flash;

    class SpController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $sps = Speedy::getModelInstance( 'sp' )->where( 'valid' , '1' )->where( 'sp_zt' ,
                null )->orderBy( 'created_at' , 'DESC' )->get();

            return view( 'vendor.speedy.admin.sp.index-vue' , compact( 'sps' ) );
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
         * @param  int $id
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
         * @param  int $id
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
            $user    = Auth::user();
            $result  = explode( '.' , $id );
            $sp_jg = $result[2] == 'reject' ? '0' : '1';
            $sp      = Speedy::getModelInstance( 'sp' )->where( 'ids' , $result[0] )->first();

            //dd($sp);

            if ($sp->from_kind == '1')
            {
                //审批职位
                Speedy::getModelInstance( 'job' )->where( 'ids' , $sp->from_id )->update([
                    'sp_jg' => $sp_jg,
                ]);
            }else
            {
                //审批活动
                Speedy::getModelInstance( 'activity' )->where( 'ids' , $sp->from_id )->update([
                    'sp_jg' => $sp_jg,
                ]);
            }

            //更新审批表
            $sp->sp_zt   = '1';
            $sp->sp_jg   = $result[2] == 'reject' ? '0' : '1';
            $sp->spr_id  = $user->id;
            $sp->sp_time = Carbon::now();
            $sp->save();

            Flash::success( '提交审批结果成功!' );

            return redirect()->route( 'admin.sp.index' );
        }
    }
