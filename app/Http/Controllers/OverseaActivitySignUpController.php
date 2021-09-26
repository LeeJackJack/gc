<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Speedy;

    class OverseaActivitySignUpController extends Controller
    {

        public function saveForm(Request $request)
        {
            $data = json_decode($request->get('form'));

            //查找是否重复提交
            $record = Speedy::getModelInstance( 'oversea_activity_sign_up' )
                ->where( 'foreignPhone', $data->foreignPhone)
                ->orWhere('name',$data->name)
                ->orWhere('idCardNum',$data->idCardNum)
                ->first();
            
            if ($record)
            {
                return response()->json([
                    'result' => 'success',
                    'code' => '555',
                ]);
            }else
            {
                /*
             * 处理字段
             * */
                $create_data = [
                    'organization'      => $data->organization ,
                    'name'     => $data->name ,
                    'gender' => $data->gender ,
                    'birthday'     => $data->birthday ,
                    'region'  => $data->region ,
                    'country' => $data->country ,
                    'province'       => $data->province ,
                    'settleCountry'  => $data->settleCountry ,
                    'settleCity'    => $data->settleCity ,
                    'idCard'    => $data->idCard ,
                    'idCardNum'    => $data->idCardNum ,
                    'school'    => $data->school ,
                    'major'    => $data->major ,
                    'edu'    => $data->edu ,
                    'foreignPhone'    => $data->foreignPhone,
                    'email'    => $data->email ,
                ];

                /*
                * 处理非必填字段
                * */
                if ( isset( $data->corporation ) )
                {
                    array_set( $create_data , 'corporation' , $data->corporation );
                }

                if ( isset( $data->job ) )
                {
                    array_set( $create_data , 'job' , $data->job );
                }

                if ( isset( $data->phone ) )
                {
                    array_set( $create_data , 'phone' , $data->phone );
                }

                if ( isset( $data->wechat ) )
                {
                    array_set( $create_data , 'wechat' , $data->wechat );
                }

                if ( isset( $data->project ) )
                {
                    array_set( $create_data , 'project' , $data->project );
                }

                /*
                 * 创建数据
                 */
                $result = Speedy::getModelInstance( 'oversea_activity_sign_up' )->create( $create_data );

                if ( $result )
                {
                    return response()->json([
                        'result' => 'success',
                        'code' => '888',
                    ]);

                }
                else
                {
                    return response()->json([
                        'result' => 'fail',
                        'code' => '000',
                    ]);
                }
            }

        }

        public  function success(){
            return view("success");
        }
        public function getSignUpForm()
        {
            $provinces = Speedy::getModelInstance('label')->where('pid','001')->get();
            return view( 'test' , compact('provinces') );
        }
    }
