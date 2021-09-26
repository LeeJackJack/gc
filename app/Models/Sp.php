<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sp extends Model
{
    protected $table = 'bch_sp';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_id' ,
        'from_kind' ,
        'sp_zt' ,
        'sp_jg' ,
        'spr_id' ,
        'sp_time' ,
        'sp_title' ,
        'valid' ,
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
