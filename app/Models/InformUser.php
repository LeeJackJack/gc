<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformUser extends Model
{
    protected $table = 'bch_inform_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone' ,
        'name' ,
        'valid' ,
        'type' ,
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
