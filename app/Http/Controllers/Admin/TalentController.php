<?php

    namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Speedy;
    use Flash;
    use Illuminate\Support\Facades\Storage;

    class TalentController extends BaseController
    {
        /**
         * Display a listing of the resource.
         *
         * @param $request
         *
         * @return \Illuminate\Http\Response
         */
        public function index( Request $request )
        {
            $name   = $request->get( 'name' );
            $major  = $request->get( 'major' );
            $school = $request->get( 'school' );

            $talents = Speedy::getModelInstance( 'talent' )->where( 'valid' , '1' )->where( 'name' , 'like' ,
                    '%' . $name . '%' )->where( 'major' , 'like' , '%' . $major . '%' )->where( 'school' , 'like' ,
                    '%' . $school . '%' )->orderBy( 'created_at' , 'DESC' )->get();

            foreach ( $talents as $t )
            {
                $last_contact = Speedy::getModelInstance( 'contact_info' )->where( 'valid' ,
                    '1' )->where( 'talent_ids' , $t->id )->orderBy( 'created_at' , 'DESC' )->first();
                $t->setAttribute( 'last_contact' , $last_contact );
                if ( $t->job_ids )
                {
                    $jobs = explode( ',' , $t->job_ids );
                    $t->setAttribute( 'job_count' , count( $jobs ) );
                }
                else
                {
                    $t->setAttribute( 'job_count' , 0 );
                }
            }

//            dd($talents);

            return view( 'vendor.speedy.admin.talent.index-vue' , compact( 'talents' , 'name' , 'major' , 'school' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view( 'vendor.speedy.admin.talent.edit' );
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
            //??????????????????????????????
            $validator = $this->mustValidate( 'talent.store' );

            if ( $validator->fails() )
            {
                return redirect()->back()->withErrors( $validator )->withInput();
            }

            $payload = $request->all();

            //????????????
            if (isset($payload['file']))
            {
                $file_url = $this->uploadPic( $payload['file'] );
                $if_resume = 1 ;
            }
            else
            {
                $file_url = null ;
                $if_resume = 0 ;
            }

            /*
             * ????????????
             * */
            $create_data = [
                'name'       => $payload['name'] ,
                'major'      => $payload['major'] ,
                'phone'    => $payload['phone'] ,
                'if_contact'  => $payload['if_contact'] ,
                'if_resume'  => $if_resume ,
                'resume_url'  => $file_url ,
                'if_contact_com'  => $payload['if_contact_com'] ,
                'school'  => $payload['school'] ,
                'email'  => $payload['email'] ,
            ];

            /*
             * ????????????
             */
            $result = Speedy::getModelInstance( 'talent' )->create( $create_data );

            if ( $result )
            {
                Flash::success( '????????????????????????!' );

                return redirect()->route( 'admin.talent.index' );
            }
            else
            {
                Flash::error( '????????????????????????!' );

                return redirect()->back()->withErrors( trans( 'view.admin.talent.create_talent_failed' ) )->withInput();
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
            $talent = Speedy::getModelInstance( 'talent' )->where( 'id' , $id )->first();

            $jobs = $talent->job_ids;
            if ($jobs)
            {
                $temp = [];
                foreach (explode(',',$jobs) as $v)
                {
                    $job = Speedy::getModelInstance('job')->where('ids',$v)->first();
                    $job->belongsToCompany;
                    array_push($temp,$job);
                }
                $talent->setAttribute('wanted_job',$temp);
            }

            $contacts = Speedy::getModelInstance('contact_info')->where('talent_ids',$talent->id)->orderBy('created_at','DESC')->get();
            $talent->setAttribute('contacts',$contacts);

            $show = '1';

            return view( 'vendor.speedy.admin.talent.edit-vue' , compact( 'talent', 'show' ) );
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
            $talent = Speedy::getModelInstance('talent')->where('id',$id)->first();
            $contacts = Speedy::getModelInstance('contact_info')->where('talent_ids',$talent->id)->where('valid','1')
                ->orderBy('created_at','DESC')
                ->get();

            $jobs = $talent->job_ids;
            if ($jobs)
            {
                $temp = [];
                foreach (explode(',',$jobs) as $v)
                {
                    $job = Speedy::getModelInstance('job')->where('ids',$v)->first();
                    $job->belongsToCompany;
                    array_push($temp,$job);
                }
                $talent->setAttribute('wanted_job',$temp);
            }

            $talent->setAttribute('contacts',$contacts);

           $show = '0';

            return view( 'vendor.speedy.admin.talent.edit-vue' , compact('talent','show') );
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
            //??????????????????????????????
            $validator = $this->mustValidate( 'talent.update' );

            if ( $validator->fails() )
            {
                Flash::error( '??????????????????????????????' );

                return redirect()->back();
            }

            $payload = $request->all();

            //????????????
            if (isset($payload['resume_url']))
            {

                //2019-5-22????????????????????????????????????????????????????????????????????????????????????????????????????????????
                $talent = Speedy::getModelInstance('talent')->where('id',$id)->first();
                $recommend = Speedy::getModelInstance('recommend')
                    ->where('email',$talent->email)
                    ->where('phone',$talent->phone)
                    ->where('user_ids',$talent->user_ids)
                    ->first();
                if ($recommend)
                {
                    $recommend->is_send_required_resume_email = '1';
                    $recommend->save();
                }

            }

            /*
             * ????????????
             * */
            $update_data = [
                'name'       => $payload['name'] ,
                'major'      => $payload['major'] ,
                'phone'    => $payload['phone'] ,
                'if_contact'  => $payload['if_contact'] ,
                'if_resume'  => $payload['if_resume'] ,
                'resume_url'  => $payload['resume_url'] ,
                'if_contact_com'  => $payload['if_contact_com'] ,
                'school'  => $payload['school'] ,
                'email'  => $payload['email'] ,
            ];

            //????????????????????????????????????????????????????????? 2019-5-21?????????????????????????????????????????????????????????????????????????????????

            $talent = Speedy::getModelInstance( 'talent' )->where('id',$id)->first();

            Speedy::getModelInstance( 'recommend' )
                ->where('user_ids',$talent->user_ids)
                ->where('phone',$talent->phone)
                ->where('email',$talent->email)
                ->update( [
                    'phone' => $payload['phone'],
                    'email' => $payload['email'],
                ]);

            $result = Speedy::getModelInstance( 'talent' )->where('id',$id)->update( $update_data );

            if ( $result )
            {
                Flash::success( '????????????????????????!' );

                return redirect()->route( 'admin.talent.index' );
            }
            else
            {
                Flash::error( '????????????????????????!' );

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
            $result = Speedy::getModelInstance( 'talent' )->where( 'id' , $id )->update( [
                'valid' => '0' ,
            ] );

            if ( $result )
            {
                Flash::success( '??????????????????!' );

                return redirect()->route( 'admin.talent.index' );
            }
            else
            {
                Flash::error( '??????????????????!' );

                return redirect()->back()->withErrors( trans( 'view.admin.talent.delete_talent_failed' ) )
                    ->withInput();
            }
        }

        /**
         * ????????????...
         *
         * @param $file
         *
         * @return null
         *
         * @author alienware 2019/5/13
         */
        public function uploadPic( $file )
        {
            $file = $file;

            if ( isset( $file ) && $file->isValid() )
            {

                //??????????????????????????? ???????????????

                //$yuanname= $file->getClientOriginalName();

                //????????????????????????

                $kuoname = $file->getClientOriginalExtension();

                //?????????????????????

                //$type=$file->getClientMimeType();

                //?????????????????????????????????????????????????????????????????????

                $path = $file->getRealPath();

                //????????????????????? ??????+?????????

                $filename = 'resume/' . date( 'Y-m-d' ) . '/' . uniqid() . '.' . $kuoname;

                //?????????????? ?? ?? ?? ?? ??????????????????????????????????? ?????????????????????

                $bool = Storage::disk( 'oss' )->put( $filename , file_get_contents( $path ) );

                if ( $bool )
                {
                    $file_url = Storage::url( $filename ); // get the file url
                    //array_set( $return_data , $type , $pic_url );
                    return $file_url;
                }
                else
                {
                    return null;
                }
            }
        }

    }
