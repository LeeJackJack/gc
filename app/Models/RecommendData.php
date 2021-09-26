<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendData extends Model
{
    protected $table = 'bch_recommend_data';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'count' ,
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
            $model->ids = uniqid() . str_random( 19 );
        } );
    }
}
