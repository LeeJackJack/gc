<?php

    namespace App\Http\Controllers\Excel;

    use Illuminate\Http\Request;
    use App\Imports\HaiZhuReport;
    use App\Http\Controllers\Controller;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Exports\HaiZhuExport;
    use Speedy;

    class DataController extends Controller
    {
        public function import()
        {
            $dir  = 'C:\Users\alienware\Desktop\demoFile';
            $file = scandir( $dir );
            Speedy::getModelInstance( 'haizhu' )->first()->delete();
            Speedy::getModelInstance( 'haizhu' )->create();

//            Excel::import( new HaiZhuReport() , 'C:\Users\alienware\Desktop\demo.xls' );

            foreach ( $file as $f )
            {
                if ( $f != '.' && $f != '..' )
                {
                    Excel::import( new HaiZhuReport , $dir . '\\' . $f );
                }
            }

            $data = Speedy::getModelInstance( 'haizhu' )->first();

            return view('haiZhu' ,compact('data'));
        }
    }
