<?php

    namespace App\Http\Controllers\Api;

    use Illuminate\Http\Request;
    use Speedy;
    use App\Http\Controllers\Controller;

    class LedController extends Controller
    {

        /**
         * 获取LED单页企业列表...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \Exception
         *
         * @author Lee 2019/10/25
         */
        public function getCompany( Request $request )
        {
            //获取当前已展示进度
            $row = Speedy::getModelInstance( 'led' )->first()->job_row;

            //获取要展示行业
            $industries = Speedy::getModelInstance( 'label' )->where( 'pid' , '002' )->orderBy( 'code' , 'ASC' )->get( [ 'label' ] );

            $rData = new \Illuminate\Support\Collection();

            foreach ( $industries as $i )
            {
                $company = new \Illuminate\Support\Collection();
                $counts  = Speedy::getModelInstance( 'company' )->where( 'type' , 'like' , '%' . $i->label . '%' )->where( 'special_subject_id' , '1' )->where( 'valid' , '1' )->count();
                if ($counts > 0)
                {
                    if ($counts > 4)
                    {
                        while ( $company->count() < 4 )
                        {
                            $item = Speedy::getModelInstance( 'company' )->where('valid','1')->where( 'type' , 'like', '%' . $i->label . '%' )->where( 'special_subject_id' , '1' )
                                ->offset( random_int( 0 ,  $counts - 1  ) )->first();
                            if ($company->contains($item))
                            {
                                $item = Speedy::getModelInstance( 'company' )->where('valid','1')->where( 'type' , 'like', '%' . $i->label . '%' )->where( 'special_subject_id' , '1' )
                                    ->offset( random_int( 0 ,  $counts - 1  ) )->first();
                            }else
                            {
                                $company->push( $item);
                            }
                        }
                    }else
                    {
                        $company = Speedy::getModelInstance( 'company' )->where( 'type' , 'like' , '%' . $i->label . '%' )->where('valid','1')->where( 'special_subject_id' , '1' )->get();
                    }
                    foreach ( $company as $c )
                    {
                        $jobCounts = Speedy::getModelInstance( 'job' )->where( 'com_ids' , $c->ids )->where( 'valid' , '1' )->where( 'special_subject_id' , '1' )->count();
                        $c->setAttribute( 'jobCounts' , $jobCounts );
                    }
                    $i->setAttribute( 'companies' , $company );
                    $rData->push($i);
                }
            }

            //行业数量
            $industryCounts = $rData->count();

            $data = $rData->slice($row*4,4);

            //更新当前已展示进度
            Speedy::getModelInstance( 'led' )->first()->update(
                [
                    'job_row' => $row + 1 >= $industryCounts / 4 ? '0' : $row + 1 ,
                ] );

            return response()->json(
                [
                    'result' => 'success' ,
                    'data'   => $data ,
                ] );
        }

        public function getProject( Request $request )
        {
            //获取当前已展示进度
            $row = Speedy::getModelInstance( 'led' )->first()->project_row;

            $projects = Speedy::getModelInstance('project')->where('valid','1')->groupBy('industry')->where('special_subject_id','2')
                ->get(['industry'])->toArray();

            //行业数量
            $industryCounts = count($projects);

            $industryArr = [];
            foreach ($projects as $p)
            {
                array_push($industryArr, $p['industry']);
            }

            //获取要展示行业
            $industries = Speedy::getModelInstance( 'label' )->whereIn('code',$industryArr)->orderBy(
                'code' , 'ASC' )->offset( $row * 2 )->limit( 2 )->get( [ 'label' , 'code' ] );

            foreach ( $industries as $i )
            {
                $project = new \Illuminate\Support\Collection();
                $counts  = Speedy::getModelInstance( 'project' )->where(
                    'industry' , $i->code )->where(
                    'special_subject_id' , '2' )->where(
                    'valid' , '1' )->count();
                if ($counts>2)
                {
                    for ( $j = 0 ; $j < 2 ; $j++ )
                    {
                        $item = Speedy::getModelInstance( 'project' )->where( 'industry' , $i->code )->where( 'special_subject_id' , '2' )->offset(
                            random_int( 0 ,  $counts - 1  ) )->first( [ 'ids' , 'title' , 'industry' , 'maturity' , 'cooperation' , 'description' ] );
                        foreach ($project as $p)
                        {
                            while($p->ids == $item->ids)
                            {
                                $item = Speedy::getModelInstance( 'project' )->where( 'industry' , $i->code )->where( 'special_subject_id' , '2' )->offset(
                                    random_int( 0 ,  $counts - 1  ) )->first( [ 'ids' , 'title' , 'industry' , 'maturity' , 'cooperation' , 'description' ] );
                            }
                        }
                        $project->push($item);
                    }
                }
                else
                {
                    $project = Speedy::getModelInstance( 'project' )->where(
                        'industry' , $i->code )->where(
                        'special_subject_id' , '2' )->get(
                        [ 'ids' , 'title' , 'industry' , 'maturity' , 'cooperation' , 'description' ] ) ;
                }


                foreach ( $project as $p )
                {
                    if ( $p )
                    {
                        $industryLabel    = Speedy::getModelInstance( 'label' )
                            ->where( 'code' , $p->industry )
                            ->first()->label;
                        $maturityLabel    = Speedy::getModelInstance( 'label' )
                            ->where( 'code' , $p->maturity )
                            ->first()->label;
                        $cooperationLabel = Speedy::getModelInstance( 'label' )
                            ->where( 'code' , $p->cooperation )
                            ->first()->label;
                        $p->setAttribute( 'industryLabel' , $industryLabel );
                        $p->setAttribute( 'maturityLabel' , $maturityLabel );
                        $p->setAttribute( 'cooperationLabel' , $cooperationLabel );
                    }
                }

                $i->setAttribute( 'projects' , $project );
            }

            //更新当前已展示进度
            Speedy::getModelInstance( 'led' )->first()->update(
                [
                    'project_row' => $row + 1 >= $industryCounts / 2 ? '0' : $row + 1 ,
                ] );

            return response()->json(
                [
                    'result' => 'success' ,
                    'data'   => $industries ,
                ] );
        }

        /**
         * 上传图片...
         *
         * @param $path
         *
         * @return null
         *
         * @author Lee 2019/1/25
         */
        public function uploadPic( $path )
        {
            $file = $path;

            if ( isset( $file ) )
            {
                //要保存的文件名 时间+扩展名

                $filename = 'qr_code/' . date( 'Y-m-d' ) . '/' . uniqid() . '.png';

                //保存文件          配置文件存放文件的名字  ，文件名，路径

                $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $file ) );

                if ( $bool )
                {
                    $pic_url = Storage::url( $filename ); // get the file url

                    return $pic_url;
                }
                else
                {
                    return null;
                }
            }
        }
    }
