<?php

    namespace App\Http\Controllers\Admin;

    use Carbon\Carbon;
    use function Couchbase\defaultDecoder;
    use Speedy;
    use Illuminate\Http\Request;
    use Flash;
    use Illuminate\Support\Facades\Storage;
    use App\Exports\ActivityReport;
    use Maatwebsite\Excel\Facades\Excel;

    class ActivityController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $activities = Speedy::getModelInstance( 'activity' )->where( 'valid' , '1' )->orderBy( 'created_at' ,
                'DESC' )->get();

            foreach ($activities as $a)
            {
                $sign_ups = Speedy::getModelInstance( 'sign_up' )
                    ->where('valid','1')
                    ->where('activity_ids',$a->ids)
                    ->where('is_handle','0')
                    ->count();
                $a->setAttribute('handle_count',$sign_ups);
            }

            return view( 'vendor.speedy.admin.activity.index-vue' , compact( 'activities' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $provinces = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();
            foreach ( $provinces as $p )
            {
                $city = Speedy::getModelInstance( 'label' )->where( 'pid' , $p->code )->get();
                $p->setAttribute( 'city' , $city );
            }

            return view( 'vendor.speedy.admin.activity.edit-vue' , compact( 'provinces' ) );
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
            //校验表单内容是否齐全
            $validator = $this->mustValidate( 'activity.store' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            //转换时间
            $start_time = Carbon::createFromTimeString( $payload['start_time'] )->toDateTimeString();
            $end_time   = Carbon::createFromTimeString( $payload['end_time'] )->toDateTimeString();
            $sign_up_end_time   = Carbon::createFromTimeString( $payload['sign_up_end_time'] )->toDateTimeString();

            /*
             * 处理字段
             * */
            $create_data = [
                'name'       => $payload['name'] ,
                'start_time' => $start_time ,
                'end_time'   => $end_time ,
                'sign_up_end_time'   => $sign_up_end_time ,
                'price'      => $payload['price'] ,
                'address'    => $payload['address'] ,
                'city_code'  => $payload['city'] ,
                'pic'        => $payload['pic'] ,
                //'detail'     => $payload['detail'] ,
                'detail_rich_text'     => '<html><head></head><body>' . $payload['detail_rich_text'] . '</body></html>' ,
                'form_field'     => $payload['forms'] ,
            ];

            /*
             * 创建数据
             */
            $result = Speedy::getModelInstance( 'activity' )->create( $create_data );

            if ( $result )
            {
                Flash::success( '创建活动成功!' );

                return redirect()->route( 'admin.activity.index' );
            }
            else
            {
                Flash::error( '创建活动失败!' );

                return redirect()->back();
            }

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
            $activity = Speedy::getModelInstance( 'activity' )->where( 'ids' , $id )->first();
            $sign_ups = Speedy::getModelInstance( 'sign_up' )->where( 'activity_ids' , $activity->ids )->orderBy
            ('created_at','DESC')->get();

            $start_time = str_replace( ' ' , 'T' , $activity->start_time );
            $end_time   = str_replace( ' ' , 'T' , $activity->end_time );
            $sign_up_end_time   = str_replace( ' ' , 'T' , $activity->sign_up_end_time );

            return view( 'vendor.speedy.admin.activity.show' ,
                compact( 'activity' , 'sign_ups' , 'start_time' , 'end_time' , 'sign_up_end_time' ) );
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
            $provinces = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();
            foreach ( $provinces as $p )
            {
                $city = Speedy::getModelInstance( 'label' )->where( 'pid' , $p->code )->get();
                $p->setAttribute( 'city' , $city );
            }

            $activity = Speedy::getModelInstance( 'activity' )->where( 'ids' , $id )->first();

            $signs = Speedy::getModelInstance('sign_up')->where('activity_ids',$id)->where('valid','1')->orderBy('created_at','DESC')->get();
            foreach ($signs as $s)
            {
                $s->belongsToUser;
            }

            $start_time = str_replace( ' ' , 'T' , $activity->start_time );
            $end_time   = str_replace( ' ' , 'T' , $activity->end_time );
            $sign_up_end_time   = str_replace( ' ' , 'T' , $activity->sign_up_end_time );

            return view( 'vendor.speedy.admin.activity.edit-vue' ,
                compact( 'provinces' , 'activity' , 'start_time' , 'end_time' , 'sign_up_end_time','signs') );
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
            $payload = $request->all();
//            dd($payload);

            //校验表单内容是否齐全
            $validator = $this->mustValidate( 'activity.update' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            //转换时间
            $start_time = Carbon::createFromTimeString( $payload['start_time'] )->toDateTimeString();
            $end_time   = Carbon::createFromTimeString( $payload['end_time'] )->toDateTimeString();
            $sign_up_end_time   = Carbon::createFromTimeString( $payload['sign_up_end_time'] )->toDateTimeString();

            /*
             * 处理必填字段
             * */
            $update_data = [
                'name'       => $payload['name'] ,
                'start_time' => $start_time ,
                'end_time'   => $end_time ,
                'sign_up_end_time'   => $sign_up_end_time ,
                'price'      => $payload['price'] ,
                'address'    => $payload['address'] ,
                //'detail'     => $payload['detail'] ,
                'form_field'     => $payload['forms'] ,
                'detail_rich_text'     => '<html><head></head><body>' . $payload['detail_rich_text'] . '</body></html>' ,
            ];

            //处理非必填字段
            if ( isset( $payload['city'] ) )
            {
                array_set( $update_data , 'city_code' , $payload['city'] );
            }

            if ( isset( $payload['pic'] ) )
            {
                array_set( $update_data , 'pic' , $payload['pic'] );
            }

            /*
             * 更新数据
             */
            $result = Speedy::getModelInstance( 'activity' )->where( 'ids' , $id )->first()->update( $update_data );

            if ( $result )
            {
                Flash::success( '编辑活动成功!' );

                return redirect()->route( 'admin.activity.index' );
            }
            else
            {
                Flash::error( '编辑活动失败!' );

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
            $result = Speedy::getModelInstance( 'activity' )->where( 'ids' , $id )->update( [
                'valid' => '0' ,
            ] );

            if ( $result )
            {
                Flash::success( '删除活动成功!' );

                return redirect()->route( 'admin.activity.index' );
            }
            else
            {
                Flash::error( '删除活动失败!' );

                return redirect()->back()->withErrors( trans( 'view.admin.activity.delete_activity_failed' ) )->withInput();
            }
        }

        /**
         * 上传图片...
         *
         * @param $pic
         *
         * @return null
         *
         * @author alienware 2019/3/22
         */
        public function uploadPic( $pic )
        {
            $file = $pic;

            if ( isset( $file ) && $file->isValid() )
            {

                //获取文件的原文件名 包括扩展名

                //$yuanname= $file->getClientOriginalName();

                //获取文件的扩展名

                $kuoname = $file->getClientOriginalExtension();

                //获取文件的类型

                //$type=$file->getClientMimeType();

                //获取文件的绝对路径，但是获取到的在本地不能打开

                $path = $file->getRealPath();

                //要保存的文件名 时间+扩展名

                $filename = 'avatars/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . $kuoname;

                //保存文件          配置文件存放文件的名字  ，文件名，路径

                $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $path ) );

                if ( $bool )
                {
                    $pic_url = Storage::url( $filename ); // get the file url
                    //array_set( $return_data , $type , $pic_url );
                    return $pic_url;
                }
                else
                {
                    return null;
                }
            }
        }

        public function exportData (Request $request)
        {
            $ids = $request->get('ids');
            return Excel::download( new ActivityReport($ids) , '活动报名人' . Carbon::now() . '.xlsx' );
        }
    }
