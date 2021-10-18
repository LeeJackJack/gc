<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Speedy;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;

class MapController extends BaseController
{
    public function index()
    {
        $tours = Speedy::getModelInstance( 'tour' )->where( 'valid' , '1' )->get();
        foreach ($tours as $t)
        {
            $arr = [];
            $arrId = [];
            foreach ( json_decode( $t->route ) as $p )
            {
                $v = Speedy::getModelInstance( 'place' )->where( 'id' , $p )->first();
                array_push( $arr , $v );
            }
            $t->setAttribute( 'place' , $arr );
            //            $t->setAttribute('placeId', json_decode( $t->route ));
            $t->route = json_decode( $t->route );
            $t->polyline = json_decode( $t->polyline );
        }
        $places = Speedy::getModelInstance( 'place' )->where( 'valid' , '1' )->get();
        return view( 'vendor.speedy.admin.map.index-vue' , compact('tours','places')  );
    }
}
