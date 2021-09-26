<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterCount extends Model
{
    protected $table = 'bch_register_counts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'count' ,
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
            //
        } );
    }
}
