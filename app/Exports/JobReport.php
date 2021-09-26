<?php

    namespace App\Exports;

    use function Couchbase\defaultDecoder;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Speedy;
    use Carbon\Carbon;

    class JobReport implements FromCollection
    {
        private $start;
        private $end;

        public function __construct($start,$end)
        {
            $this->start = $start;
            $this->end = $end;
        }

        public function collection()
        {
            $jobs = Speedy::getModelInstance('job')
                ->whereBetween('created_at',[$this->start,$this->end])
                ->where('valid','1')
                ->get();
            $data = collect();
            //设置第一行
            $title = ['comName'=> '企业名称','property'=> '属性','scale'=> '资质',
                      'type'=> '行业','jobName'=> '职位','detail'=>'岗位详情',
                      'salary'=> '薪资','hireCount'=> '招聘人数','degree'=> '学历','experience'=> '经验','major'=> '专业',
                      'address'=> '地址', 'contact'=> '联系人','position'=> '联系人职位','phone'=> '联系人座机','cellPhone'=> '联系手机' ,
                        'email'=>'邮箱','created_at' => 'created_at','updated_at' => 'updated_at'];
            $data->push($title);

            //导入数据行
            foreach ($jobs as $j)
            {
                $temp= [];
                array_set($temp,'comName',$j->belongsToCompany->name);
                array_set($temp,'property',$j->belongsToCompany->property);
                array_set($temp,'scale',$j->belongsToCompany->scale);
                array_set($temp,'type',$j->belongsToCompany->type);
                array_set($temp,'jobName',$j->title);

                $tempStr = $j->detail_rich_text;
                $txt = '';
                if ($tempStr)
                {
                    $txt = str_replace('<html>','',$tempStr);
                    $txt = str_replace('</html>','',$txt);
                    $txt = str_replace('<body>','',$txt);
                    $txt = str_replace('</body>','',$txt);
                    $txt = str_replace('<head>','',$txt);
                    $txt = str_replace('</head>','',$txt);
                    $txt = str_replace('<p>','',$txt);
                    $txt = str_replace('</p>','',$txt);
                    $txt = str_replace('<br>',"\r\n",$txt);
                    $txt = str_replace('<br/>',"\r\n",$txt);
                    $txt = str_replace('&nbsp;',"\r\n",$txt);
                }else
                {
                    $txt = $j->detail;
                }

                array_set($temp,'detail',$txt);

                array_set($temp,'salary',$j->salary);
                array_set($temp,'hireCount',$j->hire_count);
                array_set($temp,'degree',$j->education);
                array_set($temp,'experience',$j->experience);
                array_set($temp,'major',$j->type);
                array_set($temp,'address',$j->address);
                array_set($temp,'contact',$j->belongsToCompany->contact);
                array_set($temp,'position',$j->belongsToCompany->position);
                array_set($temp,'phone',$j->belongsToCompany->phone);
                array_set($temp,'cellPhone',$j->belongsToCompany->cellPhone);
                array_set($temp,'email',$j->belongsToCompany->email);
                array_set($temp,'created_at',$j->created_at);
                array_set($temp,'updated_at',$j->updated_at);

                $data->push($temp);
            }

            return $data;
        }
    }
