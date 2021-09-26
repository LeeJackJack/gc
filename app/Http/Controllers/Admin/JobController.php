<?php

    namespace App\Http\Controllers\Admin;

    use App\Exports\JobReport;
    use App\Models\Job;
    use function Couchbase\defaultDecoder;
    use Speedy;
    use Illuminate\Http\Request;
    use Flash;
    use Illuminate\Support\Facades\Storage;
    use Maatwebsite\Excel\Facades\Excel;
    use Carbon\Carbon;

    class JobController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function index( Request $request )
        {
            $job_name             = $request->get( 'job_name' ); //查找的职位名或公司名
            $refresh_job_order_id = $request->get( 'refresh_job_order_id' ); //刷新职位排序
            $page                 = $request->get( 'page' );
            if ( ! $page )
            {
                $page = 1;
            }

            //刷新职位排序
            if ( $refresh_job_order_id )
            {
                $orders = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->orderBy(
                    'order_id' , 'ASC' )->limit( 50 )->get();
                foreach ( $orders as $o )
                {
                    $o->order_id = rand( 1 , 100 );
                    $o->save();
                }
                Flash::success( '刷新职位排序成功，请到小程序查看!' );
            }

            //查找职位名称或公司名称
            $jobsName = collect();
            if ( $job_name )
            {
                //搜索职位名称
                $jobs_by_name = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->where(
                    'title' , 'like' , '%' . $job_name . '%' )->orderBy( 'created_at' , 'DESC' )->get();
                foreach ( $jobs_by_name as $j )
                {
                    $jobsName->push( $j );
                }
                $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->where(
                    'name' , 'like' , '%' . $job_name . '%' )->orderBy( 'created_at' , 'DESC' )->get();
                foreach ( $companies as $c )
                {
                    $jobByComName = Speedy::getModelInstance( 'job' )
                        ->where( 'valid' , '1' )
                        ->where( 'com_ids' , $c->ids )
                        ->where( 'sp_jg' , '1' )
                        ->get();
                    foreach ( $jobByComName as $j )
                    {
                        $jobsName->push( $j );
                    }
                }
                $jobs = $jobsName->slice( ( $page - 1 ) * 10 , 10 );
                //                dd($jobs);
                $total = $jobsName->count();
            }
            else
            {
                $jobs  = Speedy::getModelInstance( 'job' )
                    ->where( 'valid' , '1' )
                    ->orderBy( 'title' , 'ASC' )
                    ->orderBy( 'created_at' , 'DESC' )
                    ->offset( ( $page - 1 ) * 10 )
                    ->limit( 10 )
                    ->get();
                $total = Speedy::getModelInstance( 'job' )->where( 'valid' , '1' )->count();
            }

            foreach ( $jobs as $j )
            {
                $j->belongsToCompany;
                $j->belongsToIndustry;
            }

            return view( 'vendor.speedy.admin.job.index-vue' , compact( 'jobs' , 'job_name' , 'page' , 'total' ) );
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

            $industries = Speedy::getModelInstance( 'label' )->where( 'pid' , '002' )->get();

            $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->get();

            return view(
                'vendor.speedy.admin.job.edit-vue' , compact(
                'provinces' , 'industries' , 'companies' ) );
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
            $validator = $this->mustValidate( 'job.store' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();
            //            dd($payload);

            //dd($payload);

            /*
             * 处理字段
             * */
            $create_data = [
                'title'            => $payload['title'] ,
                'salary'           => $payload['salary'] ,
                'hire_count'       => $payload['hire_count'] ,
                'reward'           => $payload['reward'] ,
                'education'        => $payload['education'] ,
                'experience'       => $payload['experience'] ,
                'type'             => $payload['type'] ,
                'city_code'        => $payload['city'] ,
                'address'    => $payload['address'] ,
                //'detail'     => $payload['detail'] ,
                'detail_rich_text' => '<html><head></head><body>' . $payload['detail_rich_text'] . '</body></html>' ,
                'com_ids'          => $payload['com_name'] ,
                'industry'         => $payload['industry'] ,
            ];

            /*
             * 处理非必填字段
             * */
            //            if ( isset( $payload['address'] ) )
            //            {
            //                array_set( $update_data , 'address' , $payload['address'] );
            //            }

            if ( isset( $payload['order_id'] ) )
            {
                array_set( $create_data , 'order_id' , $payload['order_id'] );
            }

            /*
             * 创建数据
             */
            $result = Speedy::getModelInstance( 'job' )->create( $create_data );

            if ( $result )
            {
                Flash::success( '创建职位成功!' );

                return redirect()->route( 'admin.job.index' );
            }
            else
            {
                Flash::error( '创建职位失败!' );

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
            $provinces = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();
            foreach ( $provinces as $p )
            {
                $city = Speedy::getModelInstance( 'label' )->where( 'pid' , $p->code )->get();
                $p->setAttribute( 'city' , $city );
            }

            $industries = Speedy::getModelInstance( 'label' )->where( 'pid' , '002' )->get();
            $job        = Speedy::getModelInstance( 'job' )->where( 'ids' , $id )->first();

            return view( 'vendor.speedy.admin.job.show' , compact( 'job' , 'provinces' , 'industries' ) );
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  string $id
         * @param Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function edit( Request $request , $id )
        {
            $searchName = $request->get('searchName');
            $provinces = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();
            foreach ( $provinces as $p )
            {
                $city = Speedy::getModelInstance( 'label' )->where( 'pid' , $p->code )->get();
                $p->setAttribute( 'city' , $city );
            }

            $industries = Speedy::getModelInstance( 'label' )->where( 'pid' , '002' )->get();

            $job = Speedy::getModelInstance( 'job' )->where( 'ids' , $id )->first();

            $companies = Speedy::getModelInstance( 'company' )->where( 'valid' , '1' )->get();

            return view( 'vendor.speedy.admin.job.edit-vue' , compact( 'provinces' , 'job' , 'industries' , 'companies' , 'searchName' ) );
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
            $validator = $this->mustValidate( 'job.update' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            /*
             * 处理字段
             * */

            $job_name = $payload['search_name'];

            $update_data = [
                'title'            => $payload['title'] ,
                'salary'           => $payload['salary'] ,
                'hire_count'       => $payload['hire_count'] ,
                'reward'           => $payload['reward'] ,
                //'education' => $payload['education'] ,
                //'experience'      => $payload['experience'] ,
                //'type' => $payload['type'] ,
                //'city_code'     => json_decode( $payload['city'] ) ,
                //'detail'     => $payload['detail'] ,
                'detail_rich_text' => '<html><head></head><body>' . $payload['detail_rich_text'] . '</body></html>' ,
                //'com_ids'    => $payload['com_name'] ,
                'industry'         => $payload['industry'] ,
            ];

            //处理非必填字段
            if ( isset( $payload['address'] ) )
            {
                array_set( $update_data , 'address' , $payload['address'] );
            }

            if ( isset( $payload['city'] ) )
            {
                array_set( $update_data , 'city_code' , $payload['city'] );
            }

            if ( isset( $payload['com_name'] ) )
            {
                array_set( $update_data , 'com_ids' , $payload['com_name'] );
            }

            if ( isset( $payload['education'] ) )
            {
                array_set( $update_data , 'education' , $payload['education'] );
            }

            if ( isset( $payload['experience'] ) )
            {
                array_set( $update_data , 'experience' , $payload['experience'] );
            }

            if ( isset( $payload['type'] ) )
            {
                array_set( $update_data , 'type' , $payload['type'] );
            }
            if ( isset( $payload['order_id'] ) )
            {
                array_set( $update_data , 'order_id' , $payload['order_id'] );
            }

            /*
             * 更新数据
             */
            $result = Speedy::getModelInstance( 'job' )->where( 'ids' , $id )->first()->update( $update_data );

            if ( $result )
            {
                Flash::success( '编辑职位成功!' );
                return redirect()->route( 'admin.job.index' , compact('job_name'));
            }
            else
            {
                Flash::error( '编辑职位失败!' );

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
            $result = Speedy::getModelInstance( 'job' )->where( 'ids' , $id )->first()->update(
                [
                    'valid' => '0' ,
                ] );

            if ( $result )
            {
                Flash::success( '删除职位成功!' );

                return redirect()->route( 'admin.job.index' );
            }
            else
            {
                Flash::error( '删除职位失败!' );

                return redirect()->back()->withErrors( trans( 'view.admin.job.delete_job_failed' ) )->withInput();
            }
        }

        public function exportData( Request $request)
        {
            $start = $request->get('start');
            $end = $request->get('end');
            return Excel::download( new JobReport($start,$end) , '应聘信息表' . Carbon::now() . '.xlsx' );
        }
    }
