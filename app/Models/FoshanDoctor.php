<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoshanDoctor extends Model
{
    protected $table = 'bch_foshan_doctors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'school' ,
        'major',
        'education',
        'experience',
        'paper',
        'expertise',
        'honor',
        'valid',
        'phone',
        'email',
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
