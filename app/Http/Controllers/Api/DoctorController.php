<?php

    namespace App\Http\Controllers\Api;

    use Illuminate\Http\Request;
    use Speedy;
    use App\Http\Controllers\Controller;

    class DoctorController extends Controller
    {
        public function getDetail( Request $request )
        {
            $id     = $request->get( 'id' );
            $doctor = Speedy::getModelInstance( 'foshan_doctor' )->where( 'id' , $id )->first();

            return response()->json(
                [
                    'result' => 'success' ,
                    'data'   => $doctor ,
                ] );
        }

        public function getList()
        {
            $doctors = Speedy::getModelInstance( 'foshan_doctor' )
                ->where( 'valid' , '1' )
                ->orderBy( 'name' , 'ASC' )
                ->get();
            foreach ( $doctors as $d )
            {
                $likes = Speedy::getModelInstance( 'foshan_doctor_like' )
                    ->where( 'valid' , '1' )
                    ->where( 'likeId' , $d->id )
                    ->get()->count();
                $d->setAttribute( 'likeCount' , $likes );
            }

            return response()->json(
                [
                    'result' => 'success' ,
                    'data'   => $doctors ,
                ] );
        }

        public function submitLike( Request $request )
        {
            $id   = $request->get( 'id' );
            $data = json_decode( $request->get( 'form' ) );

            if ( $id && $data )
            {
                //判断是否有重复提交
                $like = Speedy::getModelInstance( 'foshan_doctor_like' )->where( 'valid' , '1' )->where(
                    'phone' , $data->phone )->where( 'likeId' , $id )->first();
                if ( $like )
                {
                    return response()->json(
                        [
                            'result' => 'error' ,
                            'msg'    => '您已提交过信息，请勿重复尝试。',
                        ] );
                }
                else
                {
                    $result = Speedy::getModelInstance( 'foshan_doctor_like' )->create(
                        [
                            'name'    => $data->name ,
                            'phone'   => $data->phone ,
                            'company' => $data->company ,
                            'likeId' => $id,
                        ] );

                    if ( $result )
                    {
                        return response()->json(
                            [
                                'result' => 'success' ,
                                'msg'    => '您的信息已提交成功，博士会尽快与您取得联系。',
                            ] );
                    }
                    else
                    {
                        return response()->json(
                            [
                                'result' => 'error' ,
                                'msg'    => '网络异常或信息有误，请稍后尝试。',
                            ] );
                    }
                }
            }
            else
            {
                return response()->json(
                    [
                        'result' => 'error' ,
                        'msg'    => '页面参数错误，请稍后再尝试。',
                    ] );
            }
        }

        public function submitDoctor( Request $request )
        {
            $data = json_decode( $request->get( 'form' ) );
            $name = $data->name;

            $doctor = Speedy::getModelInstance( 'foshan_doctor' )
                ->where( 'name' , $name )
                ->where( 'valid' , '1' )
                ->first();

            if ( $doctor )
            {
                return response()->json(
                    [
                        'result' => 'error' ,
                        'msg'    => '已有相同履历提交的记录，请勿重复提交。' ,
                    ] );
            }
            else
            {
                $result = Speedy::getModelInstance( 'foshan_doctor' )->create(
                    [
                        'name'       => $data->name ,
                        'school'     => $data->school ,
                        'major'      => $data->major ,
                        'phone'      => $data->phone ,
                        'email'      => $data->email ,
                        'education'  => implode( ',' , $data->education ) ,
                        'experience' => $data->experience ,
                        'expertise'  => $data->expertise ,
                        'honor'      => $data->honor ,
                    ] );

                if ( $result )
                {
                    return response()->json(
                        [
                            'result' => 'success' ,
                            'msg'    => '您的履历已经提交成功。' ,
                        ] );
                }
                else
                {
                    return response()->json(
                        [
                            'result' => 'error' ,
                            'msg'    => '提交履历出错，请稍后再重新尝试。' ,
                        ] );
                }
            }
        }

    }
