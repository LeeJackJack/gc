<?php

    namespace App\Exports;

    use function Couchbase\defaultDecoder;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Speedy;
    use Carbon\Carbon;

    class RecommendReport implements FromCollection
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
            $recommend = Speedy::getModelInstance('recommend')
                ->whereBetween('created_at',[$this->start,$this->end])
                ->where('valid','1')
                ->get();

            $data = collect();
            //设置第一行
            $title = ['name'=> '姓名','highestSchool'=> '最高学历学校','highestMajor'=> '专业',
                      'highestDegree'=> '学历','jobName'=> '意向职位',
                      'comName'=> '意向企业','phone'=> '手机','email'=> 'Email','created_at'=> '录入时间','type'=> '推荐类型',
                      'exp'=> '具备工作经验', 'skill'=> '掌握技术/技能','honor'=> '获得荣誉','edu'=> '教育背景','intro'=> '个人介绍'];
            $data->push($title);

            //导入数据行
            foreach ($recommend as $r)
            {
                $temp= [];

                array_set($temp,'name',$r->name);

                if ($r->school)
                {
                    array_set($temp,'highestSchool',$r->school);
                    array_set($temp,'highestMajor',$r->major);
                    array_set($temp,'highestDegree',$r->education);
                }else
                {
                    $eduTime = '';
                    $eduDegree = '';
                    $eduSchool = '';
                    $eduMajor = '';
                    if ($r->eduBg != null && count(json_decode($r->eduBg)) > 0)
                    {
                        $edu = json_decode($r->eduBg);
                        foreach ($edu as $e)
                        {
                            $start = Carbon::parse($e->start_time);
                            if ($eduTime < $start)
                            {
                                $eduTime = $start;
                                $eduDegree = $e->degree;
                                $eduSchool = $e->school;
                                $eduMajor = $e->major;
                            }
                        }
                    }
                    array_set($temp,'highestSchool',$eduSchool);
                    array_set($temp,'highestMajor',$eduMajor);
                    array_set($temp,'highestDegree',$eduDegree);
                }

                array_set($temp,'jobName',$r->belongsToJob->title);

                array_set($temp,'comName',$r->belongsToJob->belongsToCompany->name);

                array_set($temp,'phone',$r->phone);

                array_set($temp,'email',$r->email);

                array_set($temp,'created_at',$r->created_at);

                array_set($temp,'type',$r->type == '1' ? '推荐他人':'自荐');

                $exp = '';
                if ( $r->experience != null && is_array(json_decode($r->experience)))
                {
                    foreach (json_decode($r->experience) as $x)
                    {
                        if ($exp)
                        {
                            $exp .= "\r\n" . $x->start_time.'-'.$x->end_time . ' ' .$x->company . ' ' . $x->job . ' ' . $x->content;
                        }else
                        {
                            $exp .= $x->start_time.'-'.$x->end_time . ' ' .$x->company . ' ' . $x->job . ' ' . $x->content;
                        }
                    }
                    array_set($temp,'experience',$exp);
                }else
                {
                    $exp = $r->experience;
                }

                array_set($temp,'skill',$r->skill);

                $honor = '';
                if ($r->honor != null && is_array(json_decode($r->honor)))
                {
                    foreach (json_decode($r->honor) as $h)
                    {
                        if ($honor)
                        {
                            $honor .= "\r\n" . $h->time.' '.$h->title;
                        }else
                        {
                            $honor .= $h->time.' '.$h->title;
                        }
                    }
                }
                array_set($temp,'honor',$honor);

                $eduBg = '';
                if ($r->eduBg != null && is_array(json_decode($r->eduBg)))
                {
                    foreach (json_decode($r->eduBg) as $b)
                    {
                        if ($eduBg)
                        {
                            $eduBg .="\r\n" . $b->start_time.'-'.$b->end_time . ' ' . $b->school . ' ' . $b->degree . ' ' . $b->major;
                        }else
                        {
                            $eduBg .= $b->start_time.'-'.$b->end_time . ' ' . $b->school . ' ' . $b->degree . ' ' . $b->major ;
                        }
                    }
                }
                array_set($temp,'eduBg',$eduBg);

                array_set($temp,'intro',$r->intro);

                $data->push($temp);
            }

            return $data;
        }
    }
