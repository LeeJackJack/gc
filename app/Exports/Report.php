<?php

    namespace App\Exports;

    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Speedy;
    use Carbon\Carbon;

    class Report implements FromCollection
    {

        public function __construct()
        {
            //
        }

        public function collection()
        {
            //获取所有报名信息
            $signUps = Speedy::getModelInstance( 'oversea_activity_sign_up' )->where( 'valid' ,
                '1' )->orderBy( 'created_at' , 'DESC' )->get();

            $data = collect();
            //设置第一行
            $title = ['id'=> 'id','organization'=> 'organization','name'=> 'name','gender'=> 'gender','birthday'=> 'birthday',
                      'region'=> 'region','country'=> 'country','province'=> 'province','settleCountry'=> 'settleCountry','idCard'=> 'idCard',
                      'idCardNum'=> 'idCardNum', 'school'=> 'school','major'=> 'major','edu'=> 'edu','corporation'=> 'corporation',
                      'job'=> 'job','phone'=> 'phone','foreignPhone'=> 'foreignPhone', 'email'=> 'email','wechat'=> 'wechat' ,
                      'project'=> 'project','valid'=> 'valid','created_at'=> 'created_at','updated_at'=> 'updated_at' ,'settleCity'=> 'settleCity'];
            $data->push($title);

            //导入数据行
            foreach ($signUps as $s)
            {
                $temp= [];
                //id
                array_set($temp,'id',$s->id);
                //organization
                array_set($temp,'organization',$s->organization);
                //name
                array_set($temp,'name',$s->name);
                //gender
                array_set($temp,'gender',$s->gender == '0' ? '男' : '女');
                //birthday
                array_set($temp,'birthday',$s->birthday);
                //region
                array_set($temp,'region',$s->region == '0' ? '中国' : '国外');
                //country
                array_set($temp,'country',$s->country);
                //province
                array_set($temp,'province',$s->province);
                //settleCountry
                array_set($temp,'settleCountry',$s->settleCountry);
                //idCard
                array_set($temp,'idCard',$s->idCard == '0'? '护照':'身份证');
                //idCardNum
                array_set($temp,'idCardNum',"'".$s->idCardNum);
                //school
                array_set($temp,'school',$s->school);
                //major
                array_set($temp,'major',$s->major);
                //edu
                array_set($temp,'edu',$s->edu);
                //corporation
                array_set($temp,'corporation',$s->corporation);
                //job
                array_set($temp,'job',$s->job);
                //phone
                array_set($temp,'phone',$s->phone);
                //foreignPhone
                array_set($temp,'foreignPhone',$s->foreignPhone);
                //email
                array_set($temp,'email',$s->email);
                //wechat
                array_set($temp,'wechat',$s->wechat);
                //created_at
                array_set($temp,'created_at',$s->created_at);
                //updated_at
                array_set($temp,'updated_at',$s->updated_at);
                //settleCity
                array_set($temp,'settleCity',$s->settleCity);
                //project
                array_set($temp,'project',$s->project);
                $data->push($temp);
            }

            return $data;
        }
    }
