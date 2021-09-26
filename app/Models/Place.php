<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'gc_place';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'pic' ,
        'icon',
        'icon_select',
        'longitude: ',
        'latitude: ',
        'business_hour',
        'introduction',
        'address',
        'valid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public static function boot()
    {
        parent::boot();

        static::creating( function( $model )
        {
//            $model->ids = uniqid() . str_random( 10 );
        } );
    }
}
