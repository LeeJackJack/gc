<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Admin\BaseController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Speedy;
    use Illuminate\Support\Facades\Storage;

    class AdminController extends BaseController
    {

        public function saveTour( Request $request)
        {
            $data = json_decode($request->get( 'data' ));
            $hasId = isset($data->id) ? '1' : '0';
            $params = [
                'name'       => $data->name ,
                'hour'       => $data->hour ,
                'spots'       => $data->spots ,
                'distance'       => $data->distance ,
                'route'       => $data->route ,
                'polyline'       => $data->polyline ,
                'valid' => '1',
            ];

            $tours = [];
            if ($hasId)
            {
                $result = Speedy::getModelInstance( 'tour' )->where( 'id' , $data->id )->first()->update( $params );
            }else
            {
                $result = Speedy::getModelInstance( 'tour' )->create( $params );
            }

            if ($result)
            {
                $tours = Speedy::getModelInstance( 'tour' )->where( 'valid' , '1' )->get();
                foreach ($tours as $t)
                {
                    $arr = [];
                    foreach ( json_decode( $t->route ) as $p )
                    {
                        $v = Speedy::getModelInstance( 'place' )->where( 'id' , $p )->first();
                        array_push( $arr , $v );
                    }
                    $t->setAttribute( 'place' , $arr );
                    $t->route = json_decode( $t->route );
                    $t->polyline = json_decode( $t->polyline );
                }
            }

            return response()->json( [
                'return' => $tours ,
                'msg' => '信息更新成功',
                'result' => 'success',
            ] );
        }

        public function deleteTour( Request $request)
        {
            $id = $request->get( 'id' );
            Speedy::getModelInstance( 'tour' )->where( 'id' , $id )->first()->update( [
                'valid' => '0',
            ]);
            $tours = Speedy::getModelInstance( 'tour' )->where( 'valid' , '1' )->get();
            foreach ($tours as $t)
            {
                $arr = [];
                foreach ( json_decode( $t->route ) as $p )
                {
                    $v = Speedy::getModelInstance( 'place' )->where( 'id' , $p )->first();
                    array_push( $arr , $v );
                }
                $t->setAttribute( 'place' , $arr );
                $t->route = json_decode( $t->route );
                $t->polyline = json_decode( $t->polyline );
            }

            return response()->json( [
                'return' => $tours ,
                'msg' => '信息删除成功',
                'result' => 'success',
            ] );
        }

        /**
         * 根据用户输入公司名称查找公司...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author alienware 2018/12/19
         */
        public function comSearch( Request $request )
        {

        }

        /**
         * 删除用户联系记录或备注...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/9/29
         */
        public function delContactInfo( Request $request )
        {
            $id        = $request->get( 'id' );
            $talentIds = Speedy::getModelInstance( 'contact_info' )->where( 'id' , $id )->first()->talent_ids;
            $result    = Speedy::getModelInstance( 'contact_info' )->where( 'id' , $id )->update( [
                'valid' => '0' ,
            ] );
            $contacts  = Speedy::getModelInstance( 'contact_info' )->where( 'valid' , '1' )->where( 'talent_ids' ,
                $talentIds )->orderBy( 'created_at' , 'DESC' )->get();
            if ( $result )
            {
                return response()->json( [
                    'result'   => 'success' ,
                    'code'     => '888' ,
                    'msg'      => '删除记录成功' ,
                    'contacts' => $contacts ,
                ] );
            }
            else
            {
                return response()->json( [
                    'result'   => 'error' ,
                    'code'     => '000' ,
                    'msg'      => '删除记录失败' ,
                    'contacts' => $contacts ,
                ] );
            }
        }

        /**
         * 增加用户联系记录或备注...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/9/29
         */
        public function createContact( Request $request )
        {
            $id      = $request->get( 'id' );
            $name    = $request->get( 'name' );
            $content = $request->get( 'content' );

            $str = trim( $content ); // 取得字串同时去掉头尾空格和空回车
            $str = str_replace( "\n" , "<br>" , $str ); // 用p标签取代换行符

            $result   = Speedy::getModelInstance( 'contact_info' )->create( [
                'talent_ids' => $id ,
                'name'       => $name ,
                'content'    => $str ,
            ] );
            $contacts = Speedy::getModelInstance( 'contact_info' )->where( 'talent_ids' , $id )->where( 'valid' ,
                '1' )->orderBy( 'created_at' , 'DESC' )->get();
            if ( $result )
            {
                return response()->json( [
                    'result'   => 'success' ,
                    'code'     => '888' ,
                    'msg'      => '创建记录成功' ,
                    'contacts' => $contacts ,
                ] );
            }
            else
            {
                return response()->json( [
                    'result'   => 'error' ,
                    'code'     => '000' ,
                    'msg'      => '创建记录失败' ,
                    'contacts' => $contacts ,
                ] );
            }
        }

        /**
         * 上传人才简历...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/9/29
         *
         * @todo 需与图片上传接口整合为统一接口
         */
        public function upLoadResume( Request $request )
        {
            $file    = '';
            $payload = $request->all();
            foreach ( $payload as $key => $value )
            {
                if ( $key == 'file' )
                {
                    $file = $this->uploadPic( $value );
                }
            }

            return response()->json( [
                'result' => $file ,
            ] );
        }

        /**
         * 上传活动封面...
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         *
         * @author Lee 2019/9/29
         *
         * @todo 需与文件上传接口整合为统一接口
         */
        public function upLoadPlacePic( Request $request )
        {
            $file    = '';
            $payload = $request->all();
            foreach ( $payload as $key => $value )
            {
                if ( $key == 'file' )
                {
                    $file = $this->uploadFile( $value );
                }
            }

            return response()->json( [
                'result' => $file ,
            ] );
        }

        public function upLoadPlaceIcon( Request $request )
        {
            $file    = '';
            $payload = $request->all();
            foreach ( $payload as $key => $value )
            {
                if ( $key == 'file' )
                {
                    $file = $this->uploadFile( $value );
                }
            }

            return response()->json( [
                'result' => $file ,
            ] );
        }

        public function upLoadPlaceIconSelect( Request $request )
        {
            $file    = '';
            $payload = $request->all();
            foreach ( $payload as $key => $value )
            {
                if ( $key == 'file' )
                {
                    $file = $this->uploadFile( $value );
                }
            }

            return response()->json( [
                'result' => $file ,
            ] );
        }

        public function upLoadPlaceIllustrator( Request $request )
        {
            $file    = '';
            $payload = $request->all();
            foreach ( $payload as $key => $value )
            {
                if ( $key == 'file' )
                {
                    $file = $this->uploadFile( $value );
                }
            }

            return response()->json( [
                'result' => $file ,
            ] );
        }

        //存储到云服务器
        //todo 此接口需合并到统一的上传文件接口
        public function uploadPic( $pic )
        {
            $file = $pic;

            if ( isset( $file ) )
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

                $filename = 'covers/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . $kuoname;

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

        //存储文件到云服务器
        //todo 此接口需合并到统一的上传文件接口
        public function uploadFile( $pic )
        {
            $file = $pic;

            if ( isset( $file ) )
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

                $filename = 'files/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . $kuoname;

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


        /**
         * 存储文件到阿里云...
         *
         * @param $file object 文件
         * @param $catalogue string 需要存储到的目录
         *
         * @return string $returnUrl 返回存储地址
         *
         * @author Lee 2019/9/29
         */
        public function storageFileToOss( $file , $catalogue )
        {
            //如没设置存储路径，则自动保存到temp目录
            if ( ! $catalogue )
            {
                $catalogue = 'temp';
            }

            //获取文件的原文件名 包括扩展名

            //$originalName= $file->getClientOriginalName();

            //获取文件的扩展名

            $extensionName = $file->getClientOriginalExtension();

            //获取文件的类型

            //$type=$file->getClientMimeType();

            //获取文件的绝对路径，但是获取到的在本地不能打开

            $path = $file->getRealPath();

            //要保存的文件名 时间+扩展名

            $filename = $catalogue . '/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . $extensionName;

            //保存文件          配置文件存放文件的名字  ，文件名，路径

            $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $path ) );

            if ( $bool )
            {
                $returnUrl = Storage::url( $filename ); // get the file url
            }
            else
            {
                $returnUrl = null;
            }

            return $returnUrl;
        }

        public function searchGovernment(Request $request)
        {
            $office = $request->get('office');
            if ($office)
            {
                $governments = Speedy::getModelInstance('government')->where('office','like','%'.$office.'%')->where('valid','1')->get();
                if (count($governments) > 0)
                {
                    return response()->json([
                        'result' => 'success',
                        'data' => $governments,
                        'msg' => '查询成功，共查询到'.count($governments).'条记录',
                    ]);
                }else
                {
                    return response()->json([
                        'result' => 'success',
                        'data' => $governments,
                        'msg' => '查询成功，暂没有符合要求的记录存在',
                    ]);
                }
            }else
            {
                return response()->json([
                    'result' => 'error',
                    'msg' => '请先输入查询内容再进行搜索',
                ]);
            }
        }

        public function delGovernment(Request $request)
        {
            $id = $request->get('id');
            $office = $request->get('office');
            $result = Speedy::getModelInstance('government')->where('id',$id)->update([
                'valid' => '0',
            ]);
            if ($result)
            {
                $governments = Speedy::getModelInstance('government')->where('office','like','%'.$office.'%')->where('valid','1')->get();
                return response()->json([
                    'result' => 'success',
                    'data' => $governments,
                    'msg' => '删除成功，已更新页面信息',
                ]);
            }else
            {
                return response()->json([
                    'result' => 'error',
                    'msg' => '删除失败，请稍后再试',
                ]);
            }
        }

        public function editGovernment(Request $request)
        {
            $id = $request->get('id');
            $form = json_decode($request->get('form'));
            if ($id)
            {
                $result = Speedy::getModelInstance('government')->where('id',$id)->update([
                    'name' => $form->name,
                    'gender' => isset($form->gender) ? $form->gender : null,
                    'governmentName' => isset($form->governmentName) ? $form->governmentName : null,
                    'office' => isset($form->office) ? $form->office : null,
                    'post' => isset($form->post) ? $form->post : null,
                    'phone' => isset($form->phone) ? $form->phone : null,
                    'cellPhone' => isset($form->cellPhone) ? $form->cellPhone : null,
                    'email' => isset($form->email) ? $form->email : null,
                    'region' => isset($form->region) ? $form->region : null,
                ]);
                if ($result)
                {
                    return response()->json([
                        'result' => 'success',
                        'msg' => '修改信息成功，已更新页面信息',
                    ]);
                }else
                {
                    return response()->json([
                        'result' => 'error',
                        'msg' => '修改失败，请刷新页面稍后再试',
                    ]);
                }
            }else
            {
                $result = Speedy::getModelInstance('government')->create([
                    'name' => $form->name,
                    'gender' => isset($form->gender) ? $form->gender : null,
                    'governmentName' => isset($form->governmentName) ? $form->governmentName : null,
                    'office' => isset($form->office) ? $form->office : null,
                    'post' => isset($form->post) ? $form->post : null,
                    'phone' => isset($form->phone) ? $form->phone : null,
                    'cellPhone' => isset($form->cellPhone) ? $form->cellPhone : null,
                    'email' => isset($form->email) ? $form->email : null,
                    'region' => isset($form->region) ? $form->region : null,
                ]);
                if ($result)
                {
                    return response()->json([
                        'result' => 'success',
                        'msg' => '增加信息成功，已更新页面信息',
                    ]);
                }else
                {
                    return response()->json([
                        'result' => 'error',
                        'msg' => '增加信息失败，请刷新页面稍后再试',
                    ]);
                }
            }
        }

        public function getCompanyData()
        {
            $recommends = Speedy::getModelInstance('recommend')->where('valid','1')->get()->groupBy('job_ids')->toArray();
            $companies = [];
            $arr = [];
            foreach ( $recommends as $k=>$v)
            {
                $temp = new Collection();
                $j = Speedy::getModelInstance('job')->where('ids',$k)->first();
                $j->setAttribute('count',count($v));
                $temp->push($j);
                $c = Speedy::getModelInstance('company')->where('ids',$j->com_ids)->first();
                if (in_array($c->ids,$arr))
                {
                    $index = array_search($c->ids,$arr);
                    $companies[$index]->job->push($j);
                    $companies[$index]->count += count($v);
                }else
                {
                    array_push( $arr,$c->ids);
                    $c->setAttribute('job',$temp);
                    $c->setAttribute('count',count($v));
                    array_push($companies,$c);
                }
            }

            $com = [];
            foreach ($companies as $c)
            {
                $com[] = $c['count'];
            }
            array_multisort($com, SORT_DESC, $companies);

            return response()->json([
                'result' => 'success',
                'data' => $companies,
                'msg' => '获取数据成功'
            ]);
        }

        public function getJobData()
        {
            $recommends = Speedy::getModelInstance('recommend')->where('valid','1')->get()->groupBy('job_ids')->toArray();

            $jobs = [];
            foreach ($recommends as $k=>$v)
            {
                $j = Speedy::getModelInstance('job')->where('ids',$k)->first();
                $j->belongsToCompany;
                $j->setAttribute('count',count($v));
                $j->setAttribute('recommend',$v);
                array_push($jobs,$j);
            }

            $job = [];
            foreach ($jobs as $c)
            {
                $job[] = $c['count'];
            }
            array_multisort($job, SORT_DESC, $jobs);

            return response()->json([
                'result' => 'success',
                'data' => $jobs,
                'msg' => '获取数据成功'
            ]);
        }

        public function searchSchool(Request $request)
        {
            $code = $request->get('code');
            $cities = Speedy::getModelInstance('label')->where('pid',$code)->get();
            foreach ($cities as $c)
            {
                $school = Speedy::getModelInstance('phd')->where('city_code',$c->code)->get()->groupBy('now_institution')->toArray();
                $c->setAttribute('school',$school);
            }
            return response()->json([
                'result' => 'success',
                'data' => $cities,
                'msg' => '查询数据成功',
            ]);
        }

        public function searchSchoolPhd(Request $request)
        {
            $school = $request->get('school');
            $m = Speedy::getModelInstance('phd')->where('now_institution',$school)->get()->groupBy('major');
            $majors = [];
            foreach ($m as $key=>$value)
            {
                $temp = [];
                array_set($temp,$key,count($value));
                array_push($majors,$temp);
            }
            $students = Speedy::getModelInstance('phd')->where('now_institution',$school)->get();

            return response()->json([
               'result' => 'success',
               'data' =>  $students,
                'major' => $majors,
                'msg' => '加载学生数据成功',
            ]);
        }

        public function editPhd( Request $request )
        {
            $phd = json_decode($request->get('form'));
            if (isset($phd->id))
            {
                $result = Speedy::getModelInstance('phd')->where('id',$phd->id)->update([
                    'city_code' =>  $phd->city_code,
                    'name' =>  $phd->name,
                    'gender' =>  $phd->gender,
                    'fore_institution' =>  $phd->fore_institution,
                    'now_institution' =>  $phd->now_institution,
                    'department' =>  $phd->department,
                    'major' =>  $phd->major,
                    'enter_time' =>  $phd->enter_time,
                    'educational_system' =>  $phd->educational_system,
                    'phone' =>  $phd->phone,
                    'email' =>  $phd->email,
                    'department_contact' =>  $phd->department_contact,
                    'department_contact_position' =>  $phd->department_contact_position,
                    'department_contact_phone' =>  $phd->department_contact_phone,
                    'department_contact_email' =>  $phd->department_contact_email,
                    'department_contact_link' =>  $phd->department_contact_link,
                    'remark' =>  $phd->remark,
                    'information_from' =>  $phd->information_from,
                ]);
            }else
            {
                $result = Speedy::getModelInstance('phd')->create([

                    'city_code' =>  $phd->city_code,
                    'name' =>  $phd->name,
                    'gender' =>  isset($phd->gender) ? $phd->gender : '',
                    'fore_institution' =>  isset($phd->fore_institution) ? $phd->fore_institution : '',
                    'now_institution' =>  isset($phd->now_institution) ? $phd->now_institution : '',
                    'department' =>  isset($phd->department) ? $phd->department : '',
                    'major' =>  isset($phd->major) ? $phd->major : '',
                    'enter_time' =>  isset($phd->enter_time) ? $phd->enter_time : '',
                    'educational_system' =>  isset($phd->educational_system) ? $phd->educational_system : '',
                    'phone' =>  isset($phd->phone) ? $phd->phone : '',
                    'email' =>  isset($phd->email) ? $phd->email : '',
                    'department_contact' =>  isset($phd->department_contact) ? $phd->department_contact : '',
                    'department_contact_position' =>  isset($phd->department_contact_position) ? $phd->department_contact_position : '',
                    'department_contact_phone' =>  isset($phd->department_contact_phone) ? $phd->department_contact_phone : '',
                    'department_contact_email' =>  isset($phd->department_contact_email) ? $phd->department_contact_email : '',
                    'department_contact_link' =>  isset($phd->department_contact_link) ? $phd->department_contact_link : '',
                    'remark' =>  isset($phd->remark) ? $phd->remark : '',
                    'information_from' =>  isset($phd->information_from) ? $phd->information_from : '',
                    ]);
            }

            if ($result)
            {
                return response()->json([
                    'result' => 'success',
                    'msg' => '修改/增加博士信息成功'
                ]);
            }else
            {
                return response()->json([
                    'result' => 'error',
                    'msg' => '修改/增加博士信息失败，请稍后再试'
                ]);
            }
        }

    }
