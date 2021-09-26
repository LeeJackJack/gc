<?php

    namespace App\Exports;

    use function Couchbase\defaultDecoder;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Speedy;
    use Carbon\Carbon;

    class ActivityReport implements FromCollection
    {
        private $ids;

        public function __construct($ids)
        {
            $this->ids = $ids;
        }

        public function collection()
        {
            $signs = Speedy::getModelInstance('sign_up')
                ->where('activity_ids',$this->ids)
                ->where('valid','1')
                ->get();
            $data = collect();
            //设置第一行
            $title = ['weName'=> '微信昵称','actName'=> '活动名称',
                      'created_at'=> '报名时间','phone'=> '电话'];
//            $data->push($title);

            //导入数据行
            $temp= [];
            foreach ($signs as $s)
            {
                $signData = json_decode($s->field);
                if (is_array( $signData ) || $signData instanceof Traversable)
                {
                    foreach ($signData as $v)
                    {
                        array_set($title,$v->formTitleEn,$v->formTitleEn);
                    }
                }

            }
            $data->push($title);
            foreach ($signs as $s)
            {
                array_set($temp,'微信昵称',$s->belongsToUser->name);
                array_set($temp,'活动名称',$s->belongsToActivity->name);
                array_set($temp,'报名时间',$s->created_at);
                array_set($temp,'电话号码',$s->phone);
                $signData = json_decode($s->field);
                if (is_array( $signData ) || $signData instanceof Traversable)
                {
                    foreach ($signData as $v)
                    {
                        array_set($temp,$v->formTitleEn,$v->content);
                    }
                }

                $data->push($temp);
                $temp= [];
            }
            return $data;
        }
    }
