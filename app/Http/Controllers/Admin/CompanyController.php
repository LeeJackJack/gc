<?php

    namespace App\Http\Controllers\Admin;

    use Speedy;
    use Illuminate\Http\Request;
    use Flash;
    use Illuminate\Support\Facades\Storage;

    class CompanyController extends BaseController
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
            $com_name             = $request->get( 'com_name' );

            if ( $com_name )
            {
                $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where( 'name' , 'like' ,
                    '%' . $com_name . '%' )->orderBy( 'name' , 'ASC' )->orderBy( 'created_at' , 'DESC' )->get( );
            }
            else
            {
                $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->orderBy( 'name' , 'ASC' )->orderBy( 'created_at' ,
                    'DESC' )->get();
            }

            return view( 'vendor.speedy.admin.company.index-vue' , compact( 'companies' , 'com_name' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $show = '0';
            return view( 'vendor.speedy.admin.company.edit-vue', compact('show') );
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
            $validator = $this->mustValidate( 'company.store' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            /*
             * 处理字段
             * */
            $create_data = [
                'name'        => $payload['name'] ,
                'property'     => $payload['property'] ,
                'scale'         => $payload['scale'] ,
                'type'     => $payload['type'] ,
                'is_ipo' => $payload['is_ipo'] ,
                'email' => $payload['email'] ,
                'contact'      => $payload['contact'] ,
                'phone'      => $payload['phone'] ,
                'cellPhone'      => $payload['cellPhone'] ,
                'position'      => $payload['position'] ,
                'com_intro'      => $payload['com_intro'] ,
            ];

            /*
             * 创建数据
             */
            $result  = Speedy::getModelInstance( 'company' )->create( $create_data );

            if ( $result )
            {
                Flash::success( '创建企业信息成功!' );
                return redirect()->route( 'admin.company.index' );
            }
            else
            {
                Flash::error( '创建企业失败!' );

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
            $company = Speedy::getModelInstance( 'company' )->where( 'ids' , $id )->first();

            $show = '1';

            return view( 'vendor.speedy.admin.company.edit-vue' , compact( 'company' , 'show' ) );
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
            $company = Speedy::getModelInstance( 'company' )->where( 'ids' , $id )->first();

            $show = '0';

            return view( 'vendor.speedy.admin.company.edit-vue' , compact( 'company' , 'show') );
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
            $validator = $this->mustValidate( 'company.update' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            $detail=trim($payload['com_intro']); // 取得字串同时去掉头尾空格和空回车
//            $detail=str_replace("\r\n","<br>",$detail); // 用p标签取代换行符

            /*
             * 处理字段
             * */
            $update_data = [
                'name'        => $payload['name'] ,
                'property'     => $payload['property'] ,
                'scale'         => $payload['scale'] ,
                'type'     => $payload['type'] ,
                'is_ipo' => $payload['is_ipo'] ,
                'email' => $payload['email'] ,
                'com_intro'      => $detail ,
                'contact'      => $payload['contact'] ,
                'phone'      => $payload['phone'] ,
                'cellPhone'      => $payload['cellPhone'] ,
                'position'      => $payload['position'] ,
            ];

            /*
             * 更新数据
             */
            $result = Speedy::getModelInstance( 'company' )->where( 'ids' , $id )->first()->update( $update_data );

            if ( $result )
            {
                Flash::success( '编辑企业信息成功!' );
                return redirect()->route( 'admin.company.index' );
            }
            else
            {
                Flash::error( '编辑企业失败!' );

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
            Speedy::getModelInstance('company')->where('ids',$id)->update([
                'valid' => '0',
            ]);
            Speedy::getModelInstance('job')->where('com_ids',$id)->update([
                'valid' => '0',
            ]);

            Flash::success( '编辑企业成功!' );

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
