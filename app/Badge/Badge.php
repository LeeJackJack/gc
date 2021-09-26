<?php

    namespace App\Badge;

    use function MongoDB\BSON\toJSON;
    use Speedy;
    use Auth;

    class Badge
    {
        public function __construct()
        {
            //
        }

        public static function getBadge()
        {
            $badges = [];
            if (Auth::user())
            {
                //新推荐提示
                $acts = Speedy::getModelInstance('recommend')->where('valid','1')->where('is_handle','0')->count();
                if ($acts>0)
                {
                    array_set($temp,'name','推荐博士');
                    array_set($temp,'count',$acts);
                    array_push($badges,$temp);
                }

                //新活动报名提示
                $signs = Speedy::getModelInstance('sign_up')->where('valid','1')->where('is_handle','0')->count();
                if ($signs>0)
                {
                    array_set($temp,'name','活动发布');
                    array_set($temp,'count',$signs);
                    array_push($badges,$temp);
                }

                //新项目感兴趣提示
                $likes = Speedy::getModelInstance('like_project')->where('valid','1')->where('is_handle','0')->count();
                if ($likes>0)
                {
                    array_set($temp,'name','项目感兴趣者');
                    array_set($temp,'count',$likes);
                    array_push($badges,$temp);
                }
            }
            return json_encode($badges);
        }
    }
