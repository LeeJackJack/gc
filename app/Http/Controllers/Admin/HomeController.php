<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\Sp;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Charts\Sample;
    use Speedy;


    class HomeController extends BaseController
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware( 'auth' );
            $this->middleware( 'speedy.role' );
        }

        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            /**
             * 近4天每天推荐人数
             *
             * @author Lee 2019/4/3
             */
            $recommends = [];
            $r_labels = [];
            for ($i=6;$i>=0;$i--)
            {
                $count = Speedy::getModelInstance('recommend')
                    ->where('valid','1')
                    ->where('created_at','>=',Carbon::parse('-'.$i.' days')->toDateString())
                    ->where('created_at','<',Carbon::parse('-'.($i-1).' days')->toDateString())
                    ->count();
                array_push($recommends,$count);
                array_push($r_labels,Carbon::parse('-'.$i.' days')->toDateString());
            }
            $recommends_chart   = new Sample();
            $recommends_chart->labels( $r_labels );
            $recommends_chart->dataset( '每日推荐人数' , 'line' , $recommends )
                ->color('#50514F')
                ->backgroundColor('rgba(80,81,79,0.8)');

            /**
             * 近4天职位详情浏览数
             *
             * @author Lee 2019/4/3
             */
            $jobs = [];
            $j_labels = [];
            for ($i=6;$i>=0;$i--)
            {
                $count = Speedy::getModelInstance('view_log')
                    ->where('valid','1')
                    ->where('type','1')
                    ->where('created_at','>=',Carbon::parse('-'.$i.' days')->toDateString())
                    ->where('created_at','<',Carbon::parse('-'.($i-1).' days')->toDateString())
                    ->count();
                array_push($jobs,$count);
                array_push($j_labels,Carbon::parse('-'.$i.' days')->toDateString());
            }
            $jobs_chart   = new Sample();
            $jobs_chart->labels( $j_labels );
            $jobs_chart->dataset( '每日职位详情浏览数' , 'line' , $jobs )
                ->color('#F25F5C')
                ->backgroundColor('rgba(242,95,92,0.8)');

            /**
             * 近4天活动详情浏览数
             *
             * @author Lee 2019/4/3
             */
            $acts = [];
            $a_labels = [];
            for ($i=6;$i>=0;$i--)
            {
                $count = Speedy::getModelInstance('view_log')
                    ->where('valid','1')
                    ->where('type','2')
                    ->where('created_at','>=',Carbon::parse('-'.$i.' days')->toDateString())
                    ->where('created_at','<',Carbon::parse('-'.($i-1).' days')->toDateString())
                    ->count();
                array_push($acts,$count);
                array_push($a_labels,Carbon::parse('-'.$i.' days')->toDateString());
            }
            $acts_chart   = new Sample();
            $acts_chart->labels( $a_labels );
            $acts_chart->dataset( '每日活动详情浏览数' , 'line' , $acts )
                ->color('#FFE066')
                ->backgroundColor('rgba(255,224,102,0.8)');

            /**
             * 近4天企业详情浏览数
             *
             * @author Lee 2019/4/3
             */
            $companies = [];
            $c_labels = [];
            for ($i=6;$i>=0;$i--)
            {
                $count = Speedy::getModelInstance('view_log')
                    ->where('valid','1')
                    ->where('type','3')
                    ->where('created_at','>=',Carbon::parse('-'.$i.' days')->toDateString())
                    ->where('created_at','<',Carbon::parse('-'.($i-1).' days')->toDateString())
                    ->count();
                array_push($companies,$count);
                array_push($c_labels,Carbon::parse('-'.$i.' days')->toDateString());
            }
            $companies_chart   = new Sample();
            $companies_chart->labels( $c_labels );
            $companies_chart->dataset( '每日企业详情浏览数' , 'line' , $companies )
                ->color('#247BA0')
                ->backgroundColor('rgba(36,123,160,0.8)');

            /**
             * 热门搜索关键词
             *
             * @author Lee 2019/4/3
             */
            $keyword_count = [];
            $k_labels = [];
            $keyword = Speedy::getModelInstance( 'search_log' )->get()->groupBy('keyword')
                ->sortByDesc(function($key,$v)
            {
                return count($key);
            });
            foreach ($keyword as $k => $v)
            {
                array_push($keyword_count,count($v));
                array_push($k_labels,$k);
            }
            $keywords_bar   = new Sample();
            $keywords_bar->labels(array_slice($k_labels,0,7));
            $keywords_bar->dataset( '热门关键词' , 'bar' , array_slice($keyword_count,0,7) )
                ->color(['rgb(255,61,103)',
                    'rgb(255,145,36)',
                    'rgb(255,194,51)',
                    'rgb(34,206,206)',
                    'rgb(75,183,225)',
                    'rgb(164,119,225)',
                    'rgb(198,201,208)'])
                ->backgroundColor(['rgba(255,61,103,0.1)',
                    'rgba(255,145,36,0.1)',
                    'rgba(255,194,51,0.1)',
                    'rgba(34,206,206,0.1)
                ','rgba(75,183,225,0.1)',
                    'rgba(164,119,225,0.1)',
                    'rgba(198,201,208,0.1)']);
            $keywords_bar->barWidth(0.7);

            /**
             * 热门职位地区
             *
             * @author Lee 2019/4/3
             */
            $area_count = [];
            $area_labels = [];
            $area = Speedy::getModelInstance( 'city_log' )->get()->groupBy('city_code')
                ->sortByDesc(function($key,$v)

                {
                    return count($key);
                });
            foreach ($area as $k => $v)
            {
                array_push($area_count,count($v));
                $label = Speedy::getModelInstance('label')->where('code',$k)->first()->label;
                array_push($area_labels,$label);
            }
            $areas_bar   = new Sample();
            $areas_bar->labels(array_slice($area_labels,0,5));
            $areas_bar->dataset( '热门地区' , 'polarArea' , array_slice($area_count,0,5) )
                ->color(['rgb(36,123,160)','rgb(242,95,92)','rgb(75,192,192)','rgb(255,205,86)','rgb(201,203,207)','rgb(54,162,235)'])
                ->backgroundColor(['rgba(36,123,160,0.8)','rgba(242,95,92,0.8)','rgba(75,192,192,0.8)','rgba(255,205,86,0.8)
                ','rgba(201,203,207,0.8)','rgba(54,162,235,0.8)']);

            /**
             * 所有地区职位
             *
             * @author Lee 2019/4/4
             */
            $area_jobs_array = [];
            $jobs_total = 0;
            $area_jobs_collection = Speedy::getModelInstance('job')->where('valid','1')->get()->groupBy('city_code');
            foreach ($area_jobs_collection as $key=>$value)
            {
                $city = Speedy::getModelInstance('label')->where('code',$key)->first()->label;
                array_set($temp,'city',$city);
                array_set($temp,'count',count($value));
                array_push($area_jobs_array,$temp);
                $jobs_total += count($value);
            }
            array_set($temp,'city','合计');
            array_set($temp,'count',$jobs_total);
            array_push($area_jobs_array,$temp);

            /**
             * 热门行业
             *
             * @author Lee 2019/4/3
             */
            $industry_count = [];
            $industry_labels = [];
            $industry = Speedy::getModelInstance( 'industry_log' )->get()->groupBy('industry_code')
                ->sortByDesc(function($key,$v)
                {
                    return count($key);
                });
            foreach ($industry as $k => $v)
            {
                array_push($industry_count,count($v));
                $label = Speedy::getModelInstance('label')->where('code',$k)->first()->label;
                array_push($industry_labels,$label);
            }
            $industries_bar   = new Sample();
            $industries_bar->labels(array_slice($industry_labels,0,5));
            $industries_bar->dataset( '热门行业' , 'polarArea' , array_slice($industry_count,0,5) )
                ->color(['rgb(36,123,160)','rgb(242,95,92)','rgb(75,192,192)','rgb(255,205,86)','rgb(201,203,207)','rgb(54,162,235)'])
                ->backgroundColor(['rgba(36,123,160,0.8)','rgba(242,95,92,0.8)','rgba(75,192,192,0.8)','rgba(255,205,86,0.8)
                ','rgba(201,203,207,0.8)','rgba(54,162,235,0.8)']);

            /**
             * 所有行业职位
             *
             * @author Lee 2019/4/4
             */
            $industry_jobs_array = [];
            $industry_jobs_total = 0;
            $industry_jobs_collection = Speedy::getModelInstance('job')->where('valid','1')->get()->groupBy('industry');
            foreach ($industry_jobs_collection as $key=>$value)
            {
                $industry = Speedy::getModelInstance('label')->where('code',$key)->first()->label;
                array_set($temp,'industry',$industry);
                array_set($temp,'count',count($value));
                array_push($industry_jobs_array,$temp);
                $industry_jobs_total += count($value);
            }
            array_set($temp,'industry','合计');
            array_set($temp,'count',$industry_jobs_total);
            array_push($industry_jobs_array,$temp);

            /**
             * 热门职位
             *
             * @author Lee 2019/4/3
             */
            $hot_jobs_count = [];
            $hot_jobs_labels = [];
            $hot_jobs = Speedy::getModelInstance( 'view_log' )->where('type','1')->get()->groupBy('target_ids')
                ->sortByDesc(function($key,$v)
                {
                    return count($key);
                });
            foreach ($hot_jobs as $k => $v)
            {
                array_push($hot_jobs_count,count($v));
                $title = Speedy::getModelInstance('job')->where('ids',$k)->first()->title;
                array_push($hot_jobs_labels,$title);
            }
            $hot_jobs_bar   = new Sample();
            $hot_jobs_bar->labels(array_slice($hot_jobs_labels,0,7));
            $hot_jobs_bar->dataset( '热门职位' , 'bar' , array_slice($hot_jobs_count,0,7) )
                ->color(['rgb(255,61,103)','rgb(255,145,36)','rgb(255,194,51)','rgb(34,206,206)','rgb(255,61,103)','rgb(54,162,235)'])
                ->backgroundColor(['rgba(255,61,103,0.1)','rgba(255,145,36,0.1)','rgba(255,194,51,0.1)','rgba(34,206,206,0.1)
                ','rgba(255,61,103,0.1)','rgba(54,162,235,0.1)']);
            $hot_jobs_bar->barWidth(0.4);

            return view( 'vendor.speedy.admin.home' , compact( 'recommends_chart' , 'jobs_chart' , 'acts_chart' , 'companies_chart' ,
                'keywords_bar' , 'areas_bar' ,'industries_bar' ,'hot_jobs_bar' , 'area_jobs_array' , 'industry_jobs_array'
            ) );

        }
    }
