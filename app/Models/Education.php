<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'bch_education';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time' ,
        'end_time' ,
        'school',
        'degree',
        'personal_ids',
        'valid',
        'major',
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
