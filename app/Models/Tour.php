<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'gc_tour';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'hour' ,
        'spots',
        'distance',
        'route',
        'valid',
        'polyline',
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
        {} );
    }
}
