<?php

    namespace App\Http\Controllers\Admin;

    use Speedy;
    use Illuminate\Http\Request;
    use Flash;
    use Illuminate\Support\Facades\Storage;

    class PlaceController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @param  Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            $places = Speedy::getModelInstance( 'place' )->where( 'valid' ,'1')->get();

            return view( 'vendor.speedy.admin.place.index-vue' , compact( 'places' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view( 'vendor.speedy.admin.place.edit-vue');
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
            $payload = $request->all();

            /*
             * 处理字段
             * */
            $create_data = [
                'name'        => $payload['name'] ,
                'ticket'     => $payload['ticket'] ,
                'level'         => $payload['level'] ,
                'tag_first'     => $payload['tag_first'] ,
                'tag_second' => $payload['tag_second'] ,
                'pic' => $payload['pic'] ,
                'illustrator'      => $payload['illustrator'] ,
                'icon'      => $payload['icon'] ,
                'icon_select'      => $payload['icon_select'] ,
                'longitude'      => $payload['longitude'] ,
                'latitude'      => $payload['latitude'] ,
                'business_hour'      => $payload['business_hour'] ,
                'introduction'      => $payload['introduction'] ,
                'address'      => $payload['address'] ,
                'valid'      => '1' ,
            ];

            /*
             * 创建数据
             */
            $result  = Speedy::getModelInstance( 'place' )->create( $create_data );

            if ( $result )
            {
                Flash::success( '创建景点信息成功!' );
                return redirect()->route( 'admin.place.index' );
            }
            else
            {
                Flash::error( '创建景点信息失败!' );

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
            $place = Speedy::getModelInstance( 'place' )->where( 'id' , $id )->first();

            return view( 'vendor.speedy.admin.place.edit-vue' , compact( 'place' ));
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

            /*
             * 处理字段
             * */
            $update_data = [
                'name'        => $payload['name'] ,
                'ticket'     => $payload['ticket'] ,
                'level'         => $payload['level'] ,
                'tag_first'     => $payload['tag_first'] ,
                'tag_second' => $payload['tag_second'] ,
                'pic' => $payload['pic'] ,
                'illustrator'      => $payload['illustrator'] ,
                'icon'      => $payload['icon'] ,
                'icon_select'      => $payload['icon_select'] ,
                'longitude'      => $payload['longitude'] ,
                'latitude'      => $payload['latitude'] ,
                'business_hour'      => $payload['business_hour'] ,
                'introduction'      => $payload['introduction'] ,
                'address'      => $payload['address'] ,
            ];

            /*
             * 更新数据
             */
            $result = Speedy::getModelInstance( 'place' )->where( 'id' , $id )->first()->update( $update_data );

            if ( $result )
            {
                Flash::success( '编辑景点信息成功!' );
                return redirect()->route( 'admin.place.index' );
            }
            else
            {
                Flash::error( '编辑景点信息失败!' );

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
            Speedy::getModelInstance('place')->where('id',$id)->update([
                'valid' => '0',
            ]);

            Flash::success( '删除景点成功!' );

            return redirect()->back();
        }


        /**
         * 判断字符串是否json串
         *
         * @param string $data
         * @param bool $assoc
         *
         * @return bool|mixed|string
         *
         * @author alienware 2018/12/2
         */
        public function isJson( $data = '' , $assoc = false )
        {
            $data = json_decode( $data , $assoc );
            if ( $data && ( is_object( $data ) ) || ( is_array( $data ) && ! empty( current( $data ) ) ) )
            {
                return $data;
            }

            return false;
        }


        /**
         * 上传图片...
         *
         * @param $pic
         *
         * @return null
         *
         * @author alienware 2019/3/20
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
    }
