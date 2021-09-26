<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Led extends Model
{
    protected $table = 'bch_led';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_row' ,
        'project_row' ,
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
