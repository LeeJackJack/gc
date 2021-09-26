<?php

    namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Speedy;
    use Illuminate\Support\Carbon;
    use Flash;

    class UpdateLogController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $logs = Speedy::getModelInstance('update_log')->where('valid','1')->orderBy('created_at','DESC')->get();
            return view( 'vendor.speedy.admin.update_log.index-vue' , compact( 'logs' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view( 'vendor.speedy.admin.update_log.edit-vue'  );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            //校验表单内容是否齐全
            $validator = $this->mustValidate( 'update_log.store' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();
            $str=trim($payload['content']); // 取得字串同时去掉头尾空格和空回车
            $str=str_replace("\r\n","<br>",$str); // 用p标签取代换行符

            $result = Speedy::getModelInstance('update_log')->create([
                'author' => $payload['author'] ,
                'content' => $str ,
            ]);

            if ($result)
            {
                Flash::success( '创建成功!' );
                return redirect()->route( 'admin.update_log.index' );
            }
            else
            {
                Flash::error( '创建失败!' );
                return redirect()->back();
            }

        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            //
        }
    }
