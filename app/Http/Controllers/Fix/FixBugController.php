<?php

    namespace App\Http\Controllers\Fix;

    use Illuminate\Http\Request;
    use Speedy;
    use App\Http\Controllers\Controller;

    class FixBugController extends Controller
    {
        //
        public function fixIdsTooLong()
        {
            $jobs = Speedy::getModelInstance('job')->where('valid','1')->get();
            foreach ($jobs as $j)
            {
                if (strlen($j->ids)>30)
                {
                    $oldIds = $j->ids;
                    $newIds = substr($j->ids,0,23);

                    //修改职位表ids长度
                    $j->ids = $newIds;
                    $j->save();

                    //修改推荐表职位ids长度
                    $result = Speedy::getModelInstance('recommend')->where('job_ids',$oldIds)->update([
                        'job_ids' => $newIds,
                    ]);
                    var_dump('修改推荐表职位ids长度处理结果:'.$result.'<br>');

                    //修改人才库表职位ids长度
                    $talents = Speedy::getModelInstance('talent')->where('valid','1')->get();
                    foreach ($talents as $t)
                    {
                        $jobArr = explode(',',$t->job_ids);
                        foreach ($jobArr as $a)
                        {
                            if ($a == $oldIds )
                            {
                                $a = $newIds;
                            }
                        }
                        $t->job_ids = implode(',',$jobArr);
                        $t->save();
                    }
                    var_dump('修改人才库表职位ids长度结果:1'.'<br>');

                    //修改浏览日志表职位ids长度
                    $result = Speedy::getModelInstance('view_log')->where('target_ids',$oldIds)->update([
                        'target_ids' => $newIds,
                    ]);
                    var_dump('修改浏览日志表职位ids长度处理结果:'.$result.'<br>');
                }
            }
        }
    }
