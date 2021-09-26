<?php

    namespace App\Http\Controllers\Admin;

    use Speedy;
    use Illuminate\Http\Request;
    use Flash;
    use Illuminate\Support\Facades\Storage;
    use App\Exports\RecommendReport;
    use Maatwebsite\Excel\Facades\Excel;
    use Carbon\Carbon;

    class RecommendController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $recommends = Speedy::getModelInstance( 'recommend' )->where( 'valid' , '1' )->orderBy( 'is_handle' ,
                'ASC' )->orderBy( 'status' , 'ASC' )->orderBy( 'created_at' , 'DESC' )->get();

            //获取可发送邮件事件的数量
            foreach ( $recommends as $v )
            {
                $count = 0;
                if ( $v->is_send_required_resume_email == 0 )
                {
                    $count++;
                }
                if ( $v->is_send_received_resume_email == 0 )
                {
                    $count++;
                }
                if ( $v->is_send_inform_company_email == 0 )
                {
                    $count++;
                }
                $v->setAttribute( 'email_handle' , $count );
                $v->belongsToJob->belongsToCompany;
                $v->belongsToUser;
            }

            return view( 'vendor.speedy.admin.recommend.index-vue' , compact( 'recommends' ) );
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
            $recommend = Speedy::getModelInstance( 'recommend' )->where( 'ids' , $id )->first();

            //获取可发送邮件事件的数量
            $count = 0;
//            if ( $recommend->is_send_required_resume_email == 0 )
//            {
//                $count++;
//            }
            if ( $recommend->is_send_received_resume_email == 0 )
            {
                $count++;
            }
//            if ( $recommend->is_send_inform_company_email == 0 )
//            {
//                $count++;
//            }
            $recommend->setAttribute( 'email_handle' , $count );

            $recommend->belongsToUser;
            $recommend->belongsToJob->belongsToCompany;

            //dd($recommend);

            return view( 'vendor.speedy.admin.recommend.edit-vue' , compact( 'recommend' ) );
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
            //校验表单内容是否齐全
            $validator = $this->mustValidate( 'recommend.update' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            /*
             * 处理字段
             * */
            $update_data = [
                'is_handle' => $payload['is_handle'] ,
                'status'    => $payload['status'] ,
                'is_pay'    => $payload['is_pay'] ,
            ];

            /*
             * 更新数据
             */
            $result = Speedy::getModelInstance( 'recommend' )->where( 'ids' , $id )->first()->update( $update_data );

            if ( $result )
            {
                Flash::success( '修改推荐状态成功!' );

                return redirect()->route( 'admin.recommend.index' );
            }
            else
            {
                Flash::error( '修改推荐状态失败!' );

                return redirect()->back();
            }
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

        public function exportData( Request $request)
        {
            $start = $request->get('start');
            $end = $request->get('end');
            return Excel::download( new RecommendReport($start,$end) , '应聘信息表' . Carbon::now() . '.xlsx' );
        }
    }
