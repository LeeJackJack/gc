<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Working extends Model
{
    protected $table = 'bch_workings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time' ,
        'end_time' ,
        'personal_ids',
        'valid',
        'company' ,
        'job',
        'content',
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
